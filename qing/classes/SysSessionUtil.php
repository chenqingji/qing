<?php
/**
 * session统一管理类
 * 
 * @author jm
 */
class SysSessionUtil extends SessionUtils {

	/**
	 * 系统端用户信息session_key
	 */
	const SYS_LOGIN_USER = "sys_login_user_info";

	/**
	 * session缓存登录次数
	 */
	const SYS_LOGIN_NUM = "sys_login_num";

	/**
	 * session 缓存验证码
	 */
	const AUTO_CODE = "sys_auth_code";
	
	// /////////////////////////////////////////////////////////////
	/**
	 * 保存sys端用户信息至session
	 * 
	 * @param model 用户信息
	 */
	public static function setSysLoginUser($sysLoginUser) {
		parent::setSessionByKey( self::SYS_LOGIN_USER, serialize( $sysLoginUser ) );
	}

	/**
	 * 获取session中sys端用户信息
	 */
	public static function getSysLoginUser() {
		$loginUser = parent::getSessionByKey( self::SYS_LOGIN_USER );
		if ($loginUser !== null) {
			return unserialize( $loginUser );
		}
		return $loginUser;
	}

	/**
	 * 清除session中sys端用户信息
	 */
	public static function removeSysLoginUser() {
		parent::removeSessionByKey( self::SYS_LOGIN_USER );
	}
	
	// /////////////////////////////////////////////////////////////
	/**
	 * 获取session中sys端登录次数
	 */
	public static function getSysLoginNum() {
		return parent::getSessionByKey( self::SYS_LOGIN_NUM );
	}

	/**
	 * 设置session中sys端登录次数
	 * 
	 * @param $languageType string
	 */
	public static function setSysLoginNum($login_num) {
		parent::setSessionByKey( self::SYS_LOGIN_NUM, $login_num );
	}

	/**
	 * 删除session中sys端登录次数
	 */
	public static function removeSysLoginNum() {
		parent::removeSessionByKey( self::SYS_LOGIN_NUM );
	}
	// /////////////////////////////////////////////////////////////
	
	/**
	 * 获取session中验证码
	 */
	public static function getAuthCode() {
		return parent::getSessionByKey( self::AUTO_CODE );
	}

	/**
	 * 设置session中验证码
	 * 
	 * @param $languageType string
	 */
	public static function setAuthCode($login_num) {
		parent::setSessionByKey( self::AUTO_CODE, $login_num );
	}

	/**
	 * 删除session中验证码
	 */
	public static function removeAuthCode() {
		parent::removeSessionByKey( self::AUTO_CODE );
	}
}