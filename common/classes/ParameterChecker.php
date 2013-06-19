<?php
/**
 * 参数检测类,校验参数合法性
 * 
 * @author jm
 */
class ParameterChecker {



	/**
	 * 验证邮箱
	 * 
	 * @param $email string
	 * @param $min int
	 * @param $max int
	 */
	public static function checkIsEmail($email, $min = "", $max = "") {
		$length = strlen( $email );
		if ($min && $length < $min) {
			return false;
		}
		if ($max && $length > $max) {
			return false;
		}
		if (! eregi( "^[0-9a-z]+[_\\.0-9a-z\\-]*@([0-9a-z]([-]*[0-9a-z])*\\.){1,}([0-9a-z]([0-9a-z-])+)$", $email )) {
			return false;
		}
		return true;
	}

	/**
	 * 是否是数字
	 * 
	 * @param $str string
	 */
	public static function checkIsNumber($value) {
		return !(intval( $value ) < 0 || ! is_numeric( $value ) || ! preg_match( '/^[1-9]\\d*$|^0$/', $value ));
	}

	/**
	 * 检查是否是日期格式
	 * 
	 * @param $date string
	 * @return boolean
	 */
	public static function checkIsDate($date) {
		$pattern = '/^((\\d{2}(([02468][048])|([13579][26]))[\\-\\/\\s]?((((0?[13578])|(1[02]))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])))))|(\\d{2}(([02468][1235679])|([13579][01345789]))[\\-\\/\\s]?((((0?[13578])|(1[02]))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\\-\\/\\s]?((0?[1-9])|(1[0-9])|(2[0-8]))))))(\\s((([0-1][0-9])|(2?[0-3]))\\:([0-5]?[0-9])((\\s)|(\\:([0-5]?[0-9])))))?$/';
		$date = trim( $date );
		if (! preg_match( $pattern, $date )) {
			return false;
		}
		return true;
	}

	/**
	 * 判断电话号码
	 */
	public static function checkTelephone($telephone) {
		if (preg_match( '/^0(([1-9]\d)|([3-9]\d{2}))\d{8}$/', $telephone )) {
			return true;
		}
		if (preg_match( '/^1[3,4,5,8]\d{9}$/', $telephone )) {
			return true;
		}
		return false;
	}

}
