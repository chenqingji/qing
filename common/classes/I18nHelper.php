<?php

/**
 * 国际化管理类
 * 
 * @author jm
 */
class I18nHelper {

	/**
	 * 中文语言标识
	 */
	const LANGUAGE_CN = "cn";

	/**
	 * 英文语言标识
	 */
	const LANGUAGE_EN = "en";

	/**
	 * 繁体语言标识
	 */
	const LANGUAGE_TW = "tw";

	/**
	 * 默认语言类型(中文简体)
	 */
	const DEFALUT_LANGUAGE = self::LANGUAGE_CN;

	/**
	 * 语言选择数组
	 */
	public static $LANGUAGE_ARRAY = array (
			self::LANGUAGE_CN => "简体中文", 
			self::LANGUAGE_TW => "繁體中文", 
			self::LANGUAGE_EN => "English" );

	/**
	 * 国际化字符对应数组
	 */
	private static $_i18nArray = null;

	/**
	 * 获取当前使用语言
	 */
	public static function getCurrentLanguage() {
		$request = Yii::app()->getRequest();
		if ($request->getParam( 'language' ) != null) {
			$language = array_key_exists( $request->getParam( 'language' ), self::$LANGUAGE_ARRAY ) ? $request->getParam( 'language' ) : self::DEFALUT_LANGUAGE;
			SessionUtils::setLanguageType( $language );
		} else {
			if (SessionUtils::getLanguageType()) {
				$language = SessionUtils::getLanguageType();
			} else {
				$language = self::LANGUAGE_CN;
			}
		}
		return $language;
	}

	/**
	 * 通过国际化名称，获取对应的国际化字符
	 */
	public static function getText($key, $replace = array()) {
		if (self::$_i18nArray == null) {
			self::initI18nArray();
		}
		if (array_key_exists( $key, self::$_i18nArray )) {
			$msg = self::$_i18nArray [$key];
			if ($replace) {
				$msg = str_replace( array_keys( $replace ), array_values( $replace ), $msg );
			}
			return $msg;
		} else {
			throw new Exception( "您没有设置国际化文件中对应的key[$key]" );
		}
	}

	/**
	 * 验证国际化信息是否存在
	 */
	public static function checkExists($key) {
		if (self::$_i18nArray == null) {
			self::initI18nArray();
		}
		return array_key_exists( $key, self::$_i18nArray );
	}

	/**
	 * 获取对应的国际化文件 返回一个国际化数组
	 * 
	 * @param $msg 需要解析的名称
	 */
	private static function initI18nArray() {
		$path = self::getCurrentPath();
		$language = self::getCurrentLanguage();
		$controllerId = Yii::app()->getController()->getId();
                $commonLanguageFile = self::getCommonPath() . "common_$language.php";
                $common = file_exists($commonLanguageFile) ? include "$commonLanguageFile" : array();
                $controllerLanguageFile = $path . "{$controllerId}_$language.php";
                $result = file_exists($controllerLanguageFile) ? include  "$controllerLanguageFile" : array();
                if(is_array($result)){
                    $result = $result + $common;
                }else{
                    $result = $common;
                }
		self::$_i18nArray = $result;
	}

	/**
	 * 获取与当前模块对应的国际化文件路径
	 */
	private static function getCurrentPath() {
		$controllerId = Yii::app()->getController()->getId();
		$currentPath = Yii::getPathOfAlias( "application.messages.$controllerId" ) . DIRECTORY_SEPARATOR;
		return $currentPath;
	}

	/**
	 * 获取与公共的国际化文件路径
	 */
	private static function getCommonPath() {
		$commonPath = Yii::getPathOfAlias( "application.messages" ) . DIRECTORY_SEPARATOR;
		return $commonPath;
	}

	/**
	 * 获取浏览器语言版本
	 * 
	 * @return string
	 */
	public static function getLanguageByBrowser() {
		$language = $_SERVER ['HTTP_ACCEPT_LANGUAGE'];
		if (preg_match( "/^en/", $language )) {
			$language = self::LANGUAGE_EN;
		} else if (preg_match( "/^zh-tw/", $language ) || preg_match( "/^zh-hk/", $language )) {
			$language = self::LANGUAGE_TW;
		} else {
			$language = self::DEFALUT_LANGUAGE;
		}
		return $language;
	}
}
