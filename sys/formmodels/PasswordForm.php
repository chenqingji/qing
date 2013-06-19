<?php
/**
 * 密码表单模型
 */
class PasswordForm extends CFormModel {

	public $oldpass;

	public $newpass;

	public $newpass2;

	public function rules() {
		return array (
				array ('oldpass,newpass,newpass2', 'required' ), 
				array ('newpass', 'length', "max" => 25, "min" => 6 ), 
				array ('newpass2', 'compare', 'compareAttribute' => 'newpass' ) );
	}
}

?>
