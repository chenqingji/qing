<?php
/**
 * 管理员密码修改控制器
 * 
 * @author linfb
 */
class PasswordController extends SysController {

	/**
	 * 默认显示方法
	 */
	public function index() {
		$this->toModify();
	}

	/**
	 * 显示修改页面
	 */
	public function toModify() {
		$model = new PasswordForm();
		$this->showAddPage( $model );
	}

	/**
	 * 提交修改
	 */
	public function modify() {
		$model = new PasswordForm();
		$pass_info = array (
				'oldpass' => $this->getParamFromRequest( "oldpass" ), 
				'newpass' => $this->getParamFromRequest( "newpass" ), 
				'newpass2' => $this->getParamFromRequest( "newpass2" ) );
		
		$model->attributes = $pass_info;
		if (! $model->validate()) {
			$errors = $model->getErrors();
			$error_msg = null;
			foreach ( $errors as $error ) { // 只获取第一个显示
				$error_msg = $error;
				break;
			}
			$this->showErrorMessage( $error_msg, $this->createUrl( "index" ) );
		}
		
		if (preg_match( "/[\x7f-\xff]/", $pass_info ["newpass"] ) || preg_match( "/[\x7f-\xff]/", $pass_info ["newpass2"] )) {
			$this->showErrorMessage( $this->getText( "password_can_not_contain_chinese" ), $this->createUrl( "index" ) );
		}
		
		$adminService = ServiceFactory::getAdminService();
		$admin = $adminService->getAdminById( SysSessionUtil::getSysLoginUser()->getId() );
		if ($admin == null || $admin->pwd != $pass_info ["oldpass"]) { // 判断旧密码是否正确
			$this->showErrorMessage( $this->getText( "password_sys_old_psw_wrong" ), $this->createUrl( "index" ) );
		}
		
		$admin->pwd = $pass_info ["newpass"];
		if ($adminService->saveAdmin( $admin )) {
			SysLogger::log( "修改密码" );
			if ($this->getParamFromRequest( "strong" ) == '1') {
				$err_msg = $this->getText( "password_sys_save_ok" ) . $this->getText( "password_sys_comma" ) . $this->getText( "password_sys_is_strong_psw" );
				$this->showErrorMessage( $err_msg, $this->createUrl( "index" ) );
			} else {
				$err_msg = $this->getText( "password_sys_save_ok" ) . $this->getText( "password_sys_comma" ) . $this->getText( "password_sys_is_normal_psw" );
				$this->showErrorMessage( $err_msg, $this->createUrl( "index" ) );
			}
		} else {
			$this->showErrorMessage( $this->getText( "password_sys_save_failed" ), $this->createUrl( "index" ) );
		}
	}

	/**
	 * 显示修改页面模板设置
	 */
	private function showAddPage() {
		$template = new TemplateEngine();
		$template->assign( "username", SysSessionUtil::getSysLoginUser()->getUsername() );
		$template->display( "password_modify.tpl" );
	}

}