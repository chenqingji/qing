<?php
/**
 * Smarty I18n 帮助类，page和sort排序组件使用该类进行国际化处理
 * 请不要用作其他功能
 * 
 * @author jm
 */
class SmartyI18nHelper {

	/**
	 * 单例对象
	 */
	private static $_instance = null;

	/**
	 * 私有构造方法支持单例
	 */
	private function __construct() {
	}

	/**
	 * 获得单例对象
	 */
	public static function getInstance() {
		if (self::$_instance == null) {
			self::$_instance = new SmartyI18nHelper();
		}
		return self::$_instance;
	}

	/**
	 * 进行国际化处理
	 */
	public function getText($msg, $replace = array()) {
		return I18nHelper::getText( $msg, $replace );
	}
}
