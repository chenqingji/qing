<?php

/**
 * 验证密码是否为弱密码
 */
class PasswordWeakValidator extends CValidator {

	/**
	 *
	 * @var array 特殊弱密码数组
	 */
	public $weakPwdArr = array ('abc123', '123abc', 'abc+123', 'test123', 'temp123', 'mypc123', 'admin123' );

	/**
	 *
	 * @var string 用于配合验证弱密码的正则表达式
	 */
	public $weakReg = '/^([A-Z]+|[a-z]+|[0-9]+|[`~\!@#\$%\^&\*\(\)_\+\-=\{\}\|\[\]\\\:";\'<>\?\,\.\/]+)$/';

	/**
	 *
	 * @var string 配合验证密码键盘按键连续程度的字符串
	 */
	public $checkString = "abcdefghijklmnopqrstuvwxyz zyxwvutsrqponmlkjihgfedcba 1234567890 qwertyuiop asdfghjkl; zxcvbnm,./ 1qaz 2wsx 3edc 4rfv 5tgb 6yhn 7ujm 8ik, 9ol. 0p;/ /;p0 .lo9 ,ki8 mju7 nhy6 bgt5 vfr4 cde3 xsw2 zaq1 /.,mnbvcxz ;lkjhgfdsa poiuytrewq 0987654321";

	/**
	 *
	 * @var string 要验证的邮箱地址
	 */
	
	public $mailbox;

	/**
	 * 验证单一属性
	 * 
	 * @param $object object 需要验证的数据对象
	 * @param $attribute string 被验证的属性的名称
	 */
	public function validateAttribute($object, $attribute) {
		$value = $object->$attribute;
		if ($this->isWeakPassword( $value, $this->mailbox )) {
			$message = $this->message !== null ? $this->message : Yii::t( 'yii', '{attribute} is weak password.' );
			$this->addError( $object, $attribute, $message );
		}
	}

	/**
	 * 验证是否是弱密码
	 * 
	 * @param $password string
	 * @param $mailbox string
	 */
	private function isWeakPassword($password, $mailbox) {
		list ( $username ) = explode( '@', $mailbox );
		if (preg_match( $this->weakReg, $password ) || $password === $username || $password === $mailbox || in_array( $password, $this->weakPwdArr ) || $this->checkDifWordNum( $password ) || $this->checkKeybord( $password ) || stripos( $password, $username ) !== false) {
			return true;
		}
		return false;
	}

	private function checkDifWordNum($pwd) {
		$pwArray = str_split( $pwd );
		$count = 1;
		$temString = $pwArray [0];
		for($i = 0; $i < count( $pwArray ); $i ++) {
			if (strpos( $temString, $pwArray [$i] ) !== false) {
				continue;
			} else {
				$count = $count + 1;
				$temString = $temString . $pwArray [$i];
			}
		}
		if ($count < 4) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 密码中键盘连续的字符串出现比例验证
	 * 
	 * @param $pwd string
	 */
	private function checkKeybord($pwd) {
		$pwArray = str_split( $pwd );
		$lowLength = ceil( (count( $pwArray )) * 45 / 100 );
		$checkString = $this->checkString;
		$subStr = "";
		$flag = false;
		$newPassword = $this->replayShiftWord( strtolower( $pwd ) );
		for($i = 0; $i <= (strlen( $newPassword ) - $lowLength); $i ++) {
			$subStr = substr( $newPassword, $i, $lowLength );
			if (stripos( $checkString, $subStr ) !== false) {
				$flag = true;
				break;
			}
		}
		return $flag;
	}

	/**
	 * 确认经过shift转义的字符在键盘上的位置
	 * 
	 * @param $pwd string
	 * @return mixed
	 */
	private function replayShiftWord($pwd) {
		$pwd = str_replace( '!', '1', $pwd );
		$pwd = str_replace( '@', '2', $pwd );
		$pwd = str_replace( '#', '3', $pwd );
		$pwd = str_replace( '$', '4', $pwd );
		$pwd = str_replace( '%', '5', $pwd );
		$pwd = str_replace( '^', '6', $pwd );
		$pwd = str_replace( '&', '7', $pwd );
		$pwd = str_replace( '*', '8', $pwd );
		$pwd = str_replace( '(', '9', $pwd );
		$pwd = str_replace( ')', '0', $pwd );
		$pwd = str_replace( '_', '-', $pwd );
		$pwd = str_replace( '+', '=', $pwd );
		$pwd = str_replace( '|', '\\', $pwd );
		$pwd = str_replace( '<', ',', $pwd );
		$pwd = str_replace( '>', '\.', $pwd );
		$pwd = str_replace( '?', '/', $pwd );
		$pwd = str_replace( ':', ';', $pwd );
		return $pwd;
	}

}