<?php

/**
 * 支持验证的表单模型
 */
class BaseFormModel extends CFormModel {

	/**
	 * 表单主体属性，在添加表单整体错误时候有用，内部使用，但要定义成public，以便类的attributeNames方法可以获取到
	 * 
	 * @var type
	 */
	public $_formMain_;

	/**
	 * 构造函数
	 * 
	 * @param $attributes array
	 * @param $scenario string
	 */
	function __construct($attributes = array(), $scenario = '') {
		parent::__construct( $scenario );
		if ($attributes && count( $attributes ) > 0) {
			$this->attributes = $attributes;
		}
		$attributeNames = $this->attributeNames();
		$validateRules = $this->validateRules();
		foreach ( $attributeNames as $attribute ) { // 非内部使用属性，需设置规则
			if ($attribute != "_formMain_" && ! isset( $validateRules [$attribute] )) {
				throw new Exception( "未对属性:{$attribute}设置规则,请设置规则" );
			}
		}
	}

	public function getClientRules() {
		$attributeNames = $this->attributeNames();
		$clientRules = array ();
		foreach ( $attributeNames as $attributeName ) {
			$validators = array ();
			foreach ( $this->getValidators( $attributeName ) as $validator ) {
				if ($validator->enableClientValidation !== false && ($js = $validator->clientValidateAttribute( $this, $attributeName )) != '') {
					$validators [] = $js;
				}
			}
			if ($validators !== array ()) {
				$clientRules [] = array (
						'name' => $attributeName, 
						'clientValidation' => "js:function(value, messages, attribute, extendData) {\n" . implode( "\n", $validators ) . "\n}" );
			}
		}
		return CJavaScript::encode( $clientRules );
	}

	/**
	 * 获取客户端网页初始化的错误信息
	 * 
	 * @return array 客户端网页初始化的错误信息
	 */
	public function getClientInitErrors() {
		$initErrors = array ();
		foreach ( $this->getErrors() as $attributeName => $errors ) {
			$initErrors [] = array ("attributeName" => $attributeName, "errors" => $errors );
		}
		return CJavaScript::encode( $initErrors );
	}

	/**
	 * 获取规则数组
	 * 
	 * @return array
	 */
	public final function rules() {
		$validateRules = $this->validateRules();
		$rules = array ();
		foreach ( $validateRules as $attributeName => $attributeRules ) {
			if (is_array( $attributeRules )) {
				foreach ( $attributeRules as $validatorName => $rule ) {
					if (is_numeric( $validatorName )) {
						throw new Exception( "使用数组格式配置属性的验证规则时，请使用key=>value这样的形式" );
					}
					if (is_array( $rule )) {
						$NumIndexCount = 0;
						foreach ( $rule as $index => $config ) {
							if (is_numeric( $index )) {
								$rules [] = array_merge( array ($attributeName, $validatorName ), $config );
								$NumIndexCount ++;
							}
						}
						if ($NumIndexCount == 0) {
							$rules [] = array_merge( array ($attributeName, $validatorName ), $rule );
						} elseif ($NumIndexCount < count( $rule )) {
							throw new Exception( "校验器配置格式有误" );
						}
					} else {
						if ($rule) {
							$rules [] = array ($attributeName, $validatorName );
						} else {
							throw new Exception( "请正确设置属性的验证器属性，不允许设置属性验证器设置为false 或其他表示空的值" );
						}
					}
				}
			} else {
				$rules [] = array ($attributeName, $attributeRules );
			}
		}
		return $rules;
	}

	public function validateRules() {
		return array ();
	}

	/**
	 * 表单校验方法
	 * 
	 * @param $attributes array list of attributes that should be validated. Defaults to null,
	 *        meaning any attribute listed in the applicable validation rules should be
	 *        validated. If this parameter is given as a list of attributes, only
	 *        the listed attributes will be validated.
	 * @param $clearErrors boolean whether to call {@link clearErrors} before performing validation
	 * @return boolean whether the validation is successful without any error.
	 */
	public function validate($attributes = null, $clearErrors = true) {
		
		if (parent::validate( $attributes, $clearErrors )) {
			$request = Yii::app()->getRequest();
			$checkFormByClientStatus = $request->getParam( "__checkFormByClientStatus__" );
			if ($checkFormByClientStatus != "ok") {
				echo "表单未进行前端js验证，提交不成功";
				yii::app()->end();
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	/**
	 * 添加错误消息
	 * 
	 * @param $attribute 错误的属性，传入null值(不是字符串'null')表示无具体的属性的错误
	 * @param $error string 错误消息
	 */
	public function addError($attribute, $error) {
		if (! $attribute) {
			$attribute = "_formMain_";
		}
		parent::addError( $attribute, $error );
	}

	/**
	 * 获取当前信息在当前语言下的国际化信息
	 */
	protected function getText($msg, $replace = array()) {
		return I18nHelper::getText( $msg, $replace );
	}

}
