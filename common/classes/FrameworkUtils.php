<?php

/**
 * 用来存放与框架相关的常用的逻辑方法。
 * 
 * @author jm
 */
class FrameworkUtils {

	/**
	 * 登录页控制器id
	 */
	const LOGIN_PAGE_CONTROLLER_ID = "site";

	/**
	 * 登录页actionID
	 */
	const LOGIN_PAGE_ACTION_ID = "index";

	/**
	 * 登出页面actionID
	 */
	const LOGOUT_PAGE_ACITON_ID = "logout";

	/**
	 * 使用私有构造方法，不允许实例化该类
	 */
	private function __construct() {
	
	}

	/**
	 * 获取当前执行的控制器ID
	 * 
	 * @return String 当前控制器的ID
	 */
	public static function getCurrentControllerId() {
		return NewSubYii::app()->getController()->getId();
	}

	/**
	 * 当前当前执行的actionId
	 */
	public static function getCurrentActionId() {
		return NewSubYii::app()->getController()->getAction()->getId();
	}

	/**
	 * 获得当前项目在服务器上的根目录
	 */
	public static function getRootPath() {
		return realpath( dirname( __FILE__ ) . "../.." );
	}

	/**
	 * 获取当前项目控件在服务器上面全目录路径
	 */
	public static function getPluginPath() {
		return realpath( dirname( __FILE__ ) . "/../../plugins" );
	}

	/**
	 * 获取当前项目控件在服务器上面全目录路径
	 */
	public static function getServicePath() {
		return realpath( dirname( __FILE__ ) . "/../services" );
	}

	/**
	 * 终止应用程序
	 */
	public static function endApp() {
		Yii::app()->end();
	}

	/**
	 * 获取底层路径
	 */
	public static function getPlatformPath() {
		return realpath( dirname( __FILE__ ) . "/../../platform" );
	}

	/**
	 * 获取应用名称
	 */
	public static function getAppId() {
		return Yii::app()->getId();
	}
}
