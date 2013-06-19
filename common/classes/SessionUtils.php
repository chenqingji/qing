<?php
/**
 * session统一管理类
 * 
 * @author jm
 */
class SessionUtils {

	/**
	 * 维护sesison对象单态
	 */
	private static $_httpSession = null;
	
	// /////////////////////////////////////////////////////////////
	/**
	 * 设置错误返回信息保存数据
	 * 
	 * @param $data array
	 */
	public static function setBackData($data) {
		self::setSessionByKey( self::generateSessionBackData(), serialize( $data ) );
	}

	/**
	 * 获取错误返回信息保存数据
	 */
	public static function getBackData() {
		$data = self::getSessionByKey( self::generateSessionBackData() );
		if ($data !== null) {
			return unserialize( $data );
		}
		return $data;
	}

	/**
	 * 删除错误返回信息保存数据
	 */
	public static function removeBackData() {
		self::removeSessionByKey( self::generateSessionBackData() );
	}
	
	// /////////////////////////////////////////////////////////////
	/**
	 * 保存系统分页查询条件信息至session
	 * 
	 * @param array 查询数据
	 */
	public static function setPageQueryInfo($pageQueryInfo) {
		self::setSessionByKey( self::generateSessionQueryinfoKey(), serialize( $pageQueryInfo ) );
	}

	/**
	 * 获取session中用户查询信息
	 */
	public static function getPageQueryInfo() {
		$pageQueryInfo = self::getSessionByKey( self::generateSessionQueryinfoKey() );
		if ($pageQueryInfo !== null) {
			return unserialize( $pageQueryInfo );
		}
		return $pageQueryInfo;
	}

	/**
	 * 清除session中系统用户查询信息
	 */
	public static function removePageQueryInfo() {
		self::removeSessionByKey( self::generateSessionQueryinfoKey() );
	}
	
	// /////////////////////////////////////////////////////////////
	/**
	 * 获取session中语言类型
	 */
	public static function getLanguageType() {
		return self::getSessionByKey( self::generateSessionLanguageKey() );
	}

	/**
	 * 设置session中语言类型
	 * 
	 * @param $languageType string
	 */
	public static function setLanguageType($languageType) {
		self::setSessionByKey( self::generateSessionLanguageKey(), $languageType );
	}

	/**
	 * 删除session中语言类型
	 */
	public static function removeLanguageType() {
		self::removeSessionByKey( self::generateSessionLanguageKey() );
	}
	
	// /////////////////////////////////////////////////////////////
	
	/**
	 * 初始化
	 */
	private static function instance() {
		if (self::$_httpSession === null) {
			self::$_httpSession = new CHttpSession();
			self::$_httpSession->open();
		}
		return self::$_httpSession;
	}

	/**
	 * 设置session
	 * 
	 * @param $key string 查询session所属key
	 */
	protected static function setSessionByKey($key, $value) {
		self::instance()->add( $key, $value );
	}

	/**
	 * 获取session
	 * 
	 * @param $key string 查询session所属key
	 */
	protected static function getSessionByKey($key) {
		return self::instance()->get( $key, null );
	}

	/**
	 * 清除session
	 * 
	 * @param $key string 需删除session所属key
	 */
	protected static function removeSessionByKey($key) {
		self::instance()->remove( $key );
	}

	/**
	 * 生成语言sessonkey
	 */
	private static function generateSessionQueryinfoKey() {
		return FrameworkUtils::getAppId() . "_query_info";
	}

	/**
	 * 生成语言sessonkey
	 */
	private static function generateSessionLanguageKey() {
		return FrameworkUtils::getAppId() . "_language_type";
	}

	/**
	 * 返回数据sessionKey
	 */
	private static function generateSessionBackData() {
		return FrameworkUtils::getCurrentControllerId() . "_back_data";
	}
}