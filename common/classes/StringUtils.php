<?php

/**
 * 字符串方法应用类
 * 
 * @author jm
 */
class StringUtils {

	/**
	 * 私有构造方法限制该类的实例化
	 */
	private function __construct() {
	
	}

	/**
	 * 将传入数值转化为K、M、G可读格式
	 * 
	 * @param $size number
	 */
	public static function transUnit($size) {
		if ($size == 0) {
			return "0 B";
		}
		$t_size = 1024 * 1024 * 1024 * 1024;
		if ($size >= $t_size) {
			return round( $size / $t_size, 2 ) . " T";
		}
		$g_size = 1024 * 1024 * 1024;
		if ($size >= $g_size) {
			return round( $size / $g_size, 2 ) . " G";
		}
		$m_size = 1024 * 1024;
		if ($size >= $m_size) {
			return round( $size / $m_size, 2 ) . " M";
		}
		$k_size = 1024;
		if ($size >= $k_size) {
			return round( $size / $k_size, 2 ) . " K";
		}
		return round( $size, 2 ) . " B";
	}

	/**
	 * mb_pwd endcode方式
	 * 
	 * @param $txt string
	 * @return type
	 */
	public static function passwordEncode($txt) {
		for($i = 0; $i < strlen( $txt ); $i ++) {
			$txt [$i] = chr( ord( $txt [$i] ) + 12 );
		}
		return $txt = urlencode( base64_encode( urlencode( $txt ) ) );
	}

	/**
	 * mb_pwd decode方式
	 * 
	 * @param $txt string
	 * @return type
	 */
	public static function passwordDecode($txt) {
		$txt = urldecode( base64_decode( urldecode( $txt ) ) );
		for($i = 0; $i < strlen( $txt ); $i ++) {
			$txt [$i] = chr( ord( $txt [$i] ) - 12 );
		}
		return $txt;
	}

	/**
	 * 拼接ids字符串
	 * 将数组转化为1,2,...,n格式
	 * 
	 * @param $array array
	 */
	public static function fromArrayToString($array = array()) {
		$str = "";
		if (! $array) {
			return $str;
		}
		foreach ( $array as $value ) {
			$str .= trim( $value ) . ",";
		}
		return substr( $str, 0, strlen( $str ) - 1 );
	}

	/**
	 * 删除字符串头部不用0
	 * 
	 * @param $str string
	 */
	public static function clearZeroBeforeString($str) {
		if (strpos( $str, '0' ) === 0 && (strlen( $str ) > 1)) {
			$str = self::clearZeroBeforeString( substr( $str, 1 ) );
		}
		return $str;
	}

	/**
	 * 生成随机字符串函数,包括所有数字、大小写字母、符号(符号排除单引号双引号)
	 * 可根据$start,$end自行分段截取，1~0为[0,9];a~z[10,35];A~Z[36,61];符号[62,90]
	 * 
	 * @param $length int
	 * @param $start int
	 * @param $end int
	 * @return string $output
	 */
	public static function randomkeys($length, $start, $end) {
		$key = "";
		$pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.,;?~!@#$%^&*_+|`-=\/()[]{}><'; // 字符池
		for($i = 0; $i < $length; $i ++) {
			$key .= $pattern {mt_rand( $start, $end )}; // 生成php随机数
		}
		return $key;
	}

	/**
	 * 验证是否含有中文
	 * 
	 * @param $val string 待验证字符串
	 */
	public static function containChinese($val) {
		return preg_match( "/[\\x80-\\xff]/", $val );
	}

	/**
	 * 生成存储queryinfo的sessionkey
	 */
	public static function createPageQueryinfoSessionKey() {
		return FrameworkUtils::getCurrentControllerId() . "_" . FrameworkUtils::getCurrentActionId();
	}

	/**
	 * 处理空间大小显示
	 * 
	 * @param $sum integer
	 */
	public static function sizeRound($sum) {
		if ($sum < 1024) {
			$sum = $sum . 'Bit';
		} else if ($sum < 1048576) {
			$sum = round( $sum / 1024, 2 ) . 'KB';
		} else {
			$sum = round( $sum / (1048576), 2 ) . 'MB';
		}
		return $sum;
	}

	/**
	 * 计算字符串长度
	 * 
	 * @param $str string
	 * @return int
	 */
	public static function Utf8Strlen($str) {
		$i = 0;
		$count = 0;
		$len = strlen( $str );
		while ( $i < $len ) {
			$chr = ord( $str [$i] );
			$count ++;
			$i ++;
			if ($i >= $len)
				break;
			if ($chr & 0x80) {
				$chr <<= 1;
				while ( $chr & 0x80 ) {
					$i ++;
					$chr <<= 1;
				}
			}
		}
		return $count;
	}

	/**
	 * 如果给定值为null类型，则转换为空字符串
	 */
	public static function convertNullIntoEmptyChar($value) {
		if ($value == null) {
			return "";
		}
		return $value;
	}

	/**
	 * 将int类型的null转换成0
	 */
	public static function convertNullIntoZero($num) {
		if ($num == null) {
			$num = 0;
		}
		return $num;
	}
	
	/**
	 * 检测字符串是否为0或1
	 */
	public static function checkStringIsBoolean( $value ){
		if (! preg_match( '/^1$|^0$/', $value )) {
			return false;
		}
		return true;
	}
}
