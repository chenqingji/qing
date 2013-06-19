<?php
/**
 * 客户端信息获取
 * 
 * @author jm
 */
class ClientUtils {

	/**
	 * 获取访客用户ip
	 * 
	 * @return string
	 */
	public static function getClientIP() {
		if (getenv( 'HTTP_CLIENT_IP' )) {
			$ip = getenv( 'HTTP_CLIENT_IP' );
		} else if (getenv( 'HTTP_X_FORWARDED_FOR' )) {
			$ip = getenv( 'HTTP_X_FORWARDED_FOR' );
		} else if (getenv( 'REMOTE_ADDR' )) {
			$ip = getenv( 'REMOTE_ADDR' );
		} else {
			$ip = $_SERVER ['REMOTE_ADDR'];
		}
		return $ip;
	}

	/**
	 * 获取访客用户浏览器版本信息
	 * 
	 * @return Ambigous <string, unknown>
	 */
	public static function getClientBrowser() {
		$browser = "";
		if (isset( $_SERVER ["HTTP_USER_AGENT"] )) {
			$user_agent = $_SERVER ["HTTP_USER_AGENT"];
			if (strpos( $user_agent, "MSIE 9" )) {
				$browser = "IE 9";
			} else if (strpos( $user_agent, "MSIE 8" )) {
				$browser = "IE 8";
			} else if (strpos( $user_agent, "MSIE 7" )) {
				$browser = "IE 7";
			} else if (strpos( $user_agent, "MSIE 6" )) {
				$browser = "IE 6";
			} else if (strpos( $user_agent, "Firefox" )) {
				$browser = "Firefox";
			} else if (strpos( $user_agent, "Chrome" )) {
				$browser = "Google Chrome";
			} else if (strpos( $user_agent, "Safari" )) {
				$browser = "Safari";
			} else if (strpos( $user_agent, "Opera" )) {
				$browser = "Opera";
			} else {
				$browser = $user_agent;
			}
		}
		return $browser;
	}

	/**
	 * 获取访客用户操作系统
	 * 
	 * @return string
	 */
	public static function getClientOS() {
		$os = "";
		if (isset( $_SERVER ["HTTP_USER_AGENT"] )) {
			$user_agent = $_SERVER ["HTTP_USER_AGENT"];
			if (eregi( "win", $user_agent ) && eregi( "nt 6.1", $user_agent )) {
				$os = "Windows 7";
			} elseif (eregi( 'win', $user_agent ) && eregi( 'nt 6.0', $user_agent )) {
				$os = "Windows Vista";
			} else if (eregi( "win", $user_agent ) && strpos( $user_agent, "95" )) {
				$os = "Windows 95";
			} else if (eregi( "win 9x", $user_agent ) && strpos( $user_agent, "4.90" )) {
				$os = "Windows ME";
			} else if (eregi( "win", $user_agent ) && ereg( "98", $user_agent )) {
				$os = "Windows 98";
			} else if (eregi( "win", $user_agent ) && eregi( "nt 5.1", $user_agent )) {
				$os = "Windows XP";
			} else if (eregi( "win", $user_agent ) && eregi( "nt 5", $user_agent )) {
				$os = "Windows 2000";
			} else if (eregi( "win", $user_agent ) && eregi( "nt", $user_agent )) {
				$os = "Windows NT";
			} else if (eregi( "win", $user_agent ) && ereg( "32", $user_agent )) {
				$os = "Windows 32";
			} else if (eregi( "unix", $user_agent )) {
				$os = "Unix";
			} else if (eregi( "linux", $user_agent )) {
				$os = "Linux";
			} else if (eregi( "sun", $user_agent ) && eregi( "os", $user_agent )) {
				$os = "SunOS";
			} else if (eregi( "ibm", $user_agent ) && eregi( "os", $user_agent )) {
				$os = "IBM OS/2";
			} else if (eregi( "Mac", $user_agent ) && eregi( "PC", $user_agent )) {
				$os = "Macintosh";
			} else if (eregi( "PowerPC", $user_agent )) {
				$os = "PowserPC";
			} else if (eregi( "AIX", $user_agent )) {
				$os = "AIX";
			} else if (eregi( "HPUX", $user_agent )) {
				$os = "HPUX";
			} else if (eregi( "BSD", $user_agent )) {
				$os = "BSD";
			} else if (eregi( "OSF1", $user_agent )) {
				$os = "OSF1";
			} else if (eregi( "IRIX", $user_agent )) {
				$os = "IRIX";
			} else if (eregi( "FreeBSD", $user_agent )) {
				$os = "FressBSD";
			} else if (eregi( "teleport", $user_agent )) {
				$os = "teleport";
			} else if (eregi( "flashget", $user_agent )) {
				$os = "flashget";
			} else if (eregi( "webzip", $user_agent )) {
				$os = "webzip";
			} else if (eregi( "offline", $user_agent )) {
				$os = "offline";
			} else {
				$os = "Unknown";
			}
		}
		return $os;
	}

	/**
	 * 获取访客用户语言版本
	 * 
	 * @return Ambigous <string, unknown>
	 */
	public static function getClientLang() {
		$language = "";
		if (isset( $_SERVER ["HTTP_ACCEPT_LANGUAGE"] )) {
			$lang = substr( $_SERVER ['HTTP_ACCEPT_LANGUAGE'], 0, 4 ); // 只取前4位，这样只判断最优先的语言。如果取前5位，可能出现en,zh的情况，影响判断。
			if (preg_match( "/zh-c/i", $lang )) {
				$language = "简体中文";
			} else if (preg_match( "/zh/i", $lang )) {
				$language = "繁體中文";
			} else if (preg_match( "/en/i", $lang )) {
				$language = "English";
			} else if (preg_match( "/fr/i", $lang )) {
				$language = "French";
			} else if (preg_match( "/de/i", $lang )) {
				$language = "German";
			} else if (preg_match( "/jp/i", $lang )) {
				$language = "Japanese";
			} else if (preg_match( "/ko/i", $lang )) {
				$language = "Korean";
			} else if (preg_match( "/es/i", $lang )) {
				$language = "Spanish";
			} else if (preg_match( "/sv/i", $lang )) {
				$language = "Swedish";
			} else {
				$language = $_SERVER ["HTTP_ACCEPT_LANGUAGE"];
			}
		}
		return $language;
	}
}

?>