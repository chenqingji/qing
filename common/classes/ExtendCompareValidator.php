<?php

/**
 * 该类重写CCompareValidator类的clientValidateAttribute方法，
 * 避免与客户端网页元素id关联。
 */
class ExtendCompareValidator extends CCompareValidator {

	/**
	 * 返回客户端网页需要的js验证脚本
	 * 
	 * @param $object CModel 需要验证的数据对象
	 * @param $attribute string 被验证的属性的名称
	 * @return string 客户端网页js脚本
	 */
	public function clientValidateAttribute($object, $attribute) {
		if ($this->compareValue !== null) {
			$compareTo = $this->compareValue;
			$compareValue = CJSON::encode( $this->compareValue );
		} else {
			$compareAttribute = $this->compareAttribute === null ? $attribute . '_repeat' : $this->compareAttribute;
			$compareValue = "\$(extendData.validator.getTag('$compareAttribute')).val()"; // 这里改写了CCompareValidator类获取比较属性值的方式，使用属性名获取（不使用元素id获取，避免和id关联）
			$compareTo = $object->getAttributeLabel( $compareAttribute );
		}
		
		$message = $this->message;
		switch ($this->operator) {
			case '=' :
			case '==' :
				if ($message === null)
					$message = Yii::t( 'yii', '{attribute} must be repeated exactly.' );
				$condition = 'value!=' . $compareValue;
				break;
			case '!=' :
				if ($message === null)
					$message = Yii::t( 'yii', '{attribute} must not be equal to "{compareValue}".' );
				$condition = 'value==' . $compareValue;
				break;
			case '>' :
				if ($message === null)
					$message = Yii::t( 'yii', '{attribute} must be greater than "{compareValue}".' );
				$condition = 'parseFloat(value)<=parseFloat(' . $compareValue . ')';
				break;
			case '>=' :
				if ($message === null)
					$message = Yii::t( 'yii', '{attribute} must be greater than or equal to "{compareValue}".' );
				$condition = 'parseFloat(value)<parseFloat(' . $compareValue . ')';
				break;
			case '<' :
				if ($message === null)
					$message = Yii::t( 'yii', '{attribute} must be less than "{compareValue}".' );
				$condition = 'parseFloat(value)>=parseFloat(' . $compareValue . ')';
				break;
			case '<=' :
				if ($message === null)
					$message = Yii::t( 'yii', '{attribute} must be less than or equal to "{compareValue}".' );
				$condition = 'parseFloat(value)>parseFloat(' . $compareValue . ')';
				break;
			default :
				throw new CException( Yii::t( 'yii', 'Invalid operator "{operator}".', array (
						'{operator}' => $this->operator ) ) );
		}
		
		$message = strtr( $message, array (
				'{attribute}' => $object->getAttributeLabel( $attribute ), 
				'{compareValue}' => $compareTo ) );
		
		return "
if(" . ($this->allowEmpty ? "$.trim(value)!='' && " : '') . $condition . ") {
	messages.push(" . CJSON::encode( $message ) . ");
}
";
	}

}