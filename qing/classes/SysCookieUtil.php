<?php
/**
 * cookie统一处理类
 * 使用时统一为cookie设置静态变量名称，调用时需写改cookie增删查3个方法
 * <br>
 * 如果有特殊属性设置，可在增加cookie时调用setCookieAttr方法设置
 * 
 * @author jm
 */
class SysCookieUtil {

	/**
	 * 测试用cookie key
	 */
	const TEST_COOKIE_KEY = "test_cookie_key";

	/**
	 * 用户选择语言cookie
	 */
	const LANGUAGE_COOKIE = "user_language_cookie";

	/**
	 * 设置测试用cookie
	 * 
	 * @param $value unknown_type
	 */
	public static function setLanguageCookie($value) {
		$cookie = new CHttpCookie( self::LANGUAGE_COOKIE, $value );
		// cookie过期时间设置10年
		self::setCookieAttr( $cookie, time() + 31536000 );
		self::setCookie( $cookie );
	}

	/**
	 * 移除测试用cookie
	 */
	public static function removeLanguageCookie() {
		self::removeCookie( self::LANGUAGE_COOKIE );
	}

	/**
	 * 获取测试用cookie
	 */
	public static function getLanguageCookie() {
		return self::getCookie( self::LANGUAGE_COOKIE );
	}

	/**
	 * 设置cookie其他选填参数
	 * 
	 * @param $cookie CHttpCookie
	 * @param $expire long 有效时间
	 * @param $path string cookie有效的服务器路径
	 * @param $domain string cookie有效的域
	 * @param $secure boolean true：cookie只有在https链接下被设置，其他：任意
	 * @param $httpOnly boolean true：只能通过http访问（js脚本之类不能访问）,其他：任意
	 */
	private static function setCookieAttr(&$cookie, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null) {
		$cookie->expire = $expire;
		$cookie->path = $path;
		$cookie->domain = $domain;
		$cookie->secure = $secure;
		$cookie->httpOnly = $httponly;
	}

	/**
	 * 清除cookie
	 * 
	 * @param $name string
	 */
	private static function removeCookie($name, $path = null) {
		setcookie( $name, '', time() - 3600, $path );
	}

	/**
	 * 查询cookie
	 * 
	 * @param $name string
	 */
	private static function getCookie($name) {
		return isset( $_COOKIE [$name] ) ? $_COOKIE [$name] : null;
	}

	/**
	 * 设置cookie
	 * 
	 * @param $cookie ChttpCookie
	 */
	private static function setCookie($cookie) {
		setcookie( $cookie->name, $cookie->value, $cookie->expire, $cookie->path, $cookie->domain, $cookie->secure, $cookie->httpOnly );
	}
}
