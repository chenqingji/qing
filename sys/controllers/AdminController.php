<?php

/**
 * 管理员管理控制器
 * 
 * @author zny
 */
class AdminController extends SysController {

	/**
	 * 默认权限id
	 */
	const DEFAULT_RIGHTS = "00000000000000000000";

	/**
	 * 管理员名称
	 */
	private $_admin_name = "";

	/**
	 * 备注
	 */
	private $_note = "";

	/**
	 * 密码
	 */
	private $_password = "";

	/**
	 * 密码确认
	 */
	private $_password2 = "";

	/**
	 * 选择管理员ids
	 */
	private $_checkboxID = "";

	/**
	 * 管理员id
	 */
	private $_admin_id = "";

	/**
	 * 密码强度
	 */
	private $_strong = "";

	/**
	 * 管理员service
	 */
	private $_adminService = "";

	/**
	 * 错误信息
	 */
	private $_error_msg = "";

	/**
	 * 显示列表
	 */
	public function index() {
//		$adminList = ServiceFactory::getAdminService()->getAdminList();
		
		$template = new TemplateEngine();
//		$template->assign( "adminList", $adminList );
		$template->display( "admin_list.tpl" );
	}

	/**
	 * 转到修改编辑页面
	 */
	public function toEdit() {
		$this->initParams();
		$template = new TemplateEngine();
		if ($this->_checkboxID && $this->_checkboxID [0]) {
			$id = $this->_checkboxID [0];
			$admin = ServiceFactory::getAdminService()->getAdminById( $id );
			if (! $admin) {
				$this->showErrorMessage( $this->getText( "admin_not_exit" ), $this->createUrl( "index" ) );
			}
			$this->_password = $admin->pwd;
			$this->_password2 = $admin->pwd;
			$this->_admin_id = $admin->id;
			$this->_admin_name = $admin->name;
			$this->_note = $admin->note;
			$template->assign( "password", $admin->pwd );
			$template->assign( "password2", $admin->pwd );
			$template->assign( "admin_id", $id );
		}
		$lang = SysSessionUtil::getLanguageType();
		$template->assign( "isEdit", $this->_admin_id ? true : '' );
		$template->assign( "admin", $this->_admin_name );
		$template->assign( "note", $this->_note );
		$template->assign( "lang", $lang == I18nHelper::LANGUAGE_CN ? "zh" : $lang );
		$template->display( "admin_edit.tpl" );
	}

	/**
	 * 错误跳转
	 */
	public function backToEdit() {
		$this->initParams();
		$template = new TemplateEngine();
		$id = "";
		if ($this->_checkboxID && $this->_checkboxID [0]) {
			$id = $this->_checkboxID [0];
		}
		$lang = SysSessionUtil::getLanguageType();
		$template->assign( "password", $this->_password );
		$template->assign( "password2", $this->_password2 );
		$template->assign( "admin_id", $id );
		$template->assign( "isEdit", $id ? true : '' );
		$template->assign( 'isBack', 1 );
		$template->assign( "admin", $this->_admin_name );
		$template->assign( "note", $this->_note );
		$template->assign( "lang", $lang == I18nHelper::LANGUAGE_CN ? "zh" : $lang );
		$template->display( "admin_edit.tpl" );
	}

	/**
	 * 提交编辑信息
	 */
	public function edit() {
		$this->initService();
		$this->initParams();
		$this->checkPassword();
		
		if ($this->_admin_id) {
			$admin = $this->_adminService->getAdminById( $this->_admin_id );
			if (! $admin) {
				$this->showErrorMessage( $this->getText( "admin_not_exit" ), $this->createUrl( "index" ) );
			}
		} else {
			if ($this->_adminService->getAdminByName( $this->_admin_name )) {
				$this->showErrorMessage( $this->getText( "admin_exit" ), $this->createErrorUrl( "backToEdit" ) );
			}
			$admin = new Admin();
			$admin->name = $this->_admin_name;
			$admin->right_id = self::DEFAULT_RIGHTS;
		}
		
		$admin->pwd = $this->_password;
		$admin->note = $this->_note;
		
		if ($this->_admin_id !== "") {
			$msg = $this->getText( "admin_edit_success" );
		} else {
			$msg = $this->getText( "admin_add_administrator" ) . " $this->_admin_name";
		}
		if ($this->_strong == 1) {
			$msg .= "\n" . $this->getText( "admin_strong_password" );
		} else {
			$msg .= "\n" . $this->getText( "admin_middle_password" );
		}
		
		if ($this->_adminService->saveAdmin( $admin )) {
			SysLogger::log( ($this->_admin_id !== "" ? "修改管理员" : "增加管理员") . " $admin->name" );
			$this->showErrorMessage( $msg, $this->createUrl( "index" ) );
		} else {
			$msg = $this->_admin_id !== "" ? $this->getText( "admin_edit_fail" ) : $this->getText( "admin_add_administrator" ) . " $this->_admin_name" . $this->getText( "admin_fail" );
			$this->showErrorMessage( $msg, $this->createErrorUrl( "backToEdit" ) );
		}
	}

	/**
	 * 删除管理员
	 */
	public function delete() {
		$this->initService();
		$this->initParams();
		$ids = StringUtils::fromArrayToString( $this->_checkboxID );
		if ($this->checkContainAdmin( $ids )) {
			$this->showErrorMessage( $this->getText( "admin_cannot_delete" ), $this->createErrorUrl( "toEdit" ) );
		}
		$this->writeDeleteLog( $ids );
		$this->_adminService->deleteAdminByIds( $ids );
		$this->showErrorMessage( $this->getText( "admin_delete_success" ), $this->createUrl( "index" ) );
	}

	/**
	 * 转到授权页面
	 * 
	 * @throws Exception
	 */
	public function toAuth() {
		$this->initService();
		$this->initParams();
		$template = new TemplateEngine();
		if (! $this->_checkboxID || ! $this->_checkboxID [0]) {
			$this->showErrorMessage( $this->getText( "admin_not_exit" ), $this->createUrl( "index" ) );
		}
		$admin = $this->_adminService->getAdminById( $this->_checkboxID [0] );
		if (! $admin) {
			$this->showErrorMessage( $this->getText( "admin_not_exit" ), $this->createUrl( "index" ) );
		}
		$sysSetting = ServiceFactory::getSysSettingService()->getSysSetting();
		$template->assign( 'sysSetting', $sysSetting );
		$template->assign( "rights", str_split( $admin ['right_id'] ) );
		$template->assign( "admin_name", $admin ['name'] );
		$template->assign( "admin_id", $admin ['id'] );
		$template->display( "admin_auth.tpl" );
	}

	/**
	 * 授权管理员权限
	 * 
	 * @throws Exception
	 */
	public function auth() {
		$this->initParams();
		$this->initService();
		$admin = $this->_adminService->getAdminById( $this->_admin_id );
		if ($admin ['name'] == "admin") {
			$this->showErrorMessage( $this->getText( "admin_auth_admin_error" ), $this->createUrl( "index" ) );
		}
		$default_right = self::DEFAULT_RIGHTS;
		if (isset( $this->_checkboxID )) {
			for($i = 0; $i < count( $this->_checkboxID ); $i ++) {
				if ($this->_checkboxID [$i] != 0)
					$default_right [$this->_checkboxID [$i] - 1] = '1';
			}
		}
		$default_right [1] = "1";
		$admin->right_id = $default_right;
		if ($this->_adminService->saveAdmin( $admin )) {
			SysLogger::log( "授权管理员 " . $admin ['name'] );
			$this->showErrorMessage( $this->getText( "admin_auth_admin" ) . "[" . $admin ['name'] . "]" . $this->getText( "admin_success" ), $this->createUrl( "index" ) );
		} else {
			$this->showErrorMessage( $this->getText( "admin_auth_admin" ) . "[" . $admin ['name'] . "]" . $this->getText( "admin_fail" ), $this->createErrorUrl( "toAuth" ) );
		}
	}

	/**
	 * 密码校验
	 */
	private function checkPassword() {
		if ($this->_password != $this->_password2) {
			$this->showErrorMessage( $this->getText( "admin_password_confirm_error" ), $this->createErrorUrl( "toEdit" ) );
		}
		if (preg_match( "/[\x7f-\xff]/", $this->_password )) {
			$this->showErrorMessage( $this->getText( "admin_password_contain_chinese" ), $this->createErrorUrl( "toEdit" ) );
		}
	}

	/**
	 * 根据ids查询删除管理员
	 * 
	 * @param $ids string 管理员ids
	 */
	private function writeDeleteLog($ids) {
		$admins = $this->_adminService->findAdminsByIds( $ids );
		foreach ( $admins as $admin ) {
			SysLogger::log( "删除管理员 " . $admin ['name'] );
		}
	}

	/**
	 * 验证ids是否包含管理员id
	 */
	private function checkContainAdmin($ids) {
		$this->initService();
		$admin = $this->_adminService->getAdminByName( "admin" );
		return stripos( "," . $ids . ",", "," . $admin ['id'] . "," ) !== false;
	}

	/**
	 * 初始化service
	 */
	private function initService() {
		if (! $this->_adminService) {
			$this->_adminService = ServiceFactory::getAdminService();
		}
	}

	/**
	 * 初始化参数
	 */
	private function initParams() {
		$this->_admin_id = trim( $this->getParamFromRequest( "admin_id", "" ) );
		$this->_admin_name = trim( $this->getParamFromRequest( "admin", "" ) );
		$this->_password2 = trim( $this->getParamFromRequest( "password2", "" ) );
		$this->_checkboxID = $this->getParamFromRequest( "checkboxID", null );
		$this->_note = trim( $this->getParamFromRequest( "note", "" ) );
		$this->_password = trim( $this->getParamFromRequest( "password", "" ) );
		$this->_strong = trim( $this->getParamFromRequest( "strong", "" ) );
	}

	/**
	 * 获取错误跳转url
	 */
	private function createErrorUrl($toAction) {
		return $this->createUrl( $toAction, array (
				'admin' => $this->_admin_name, 
				"note" => $this->_note, 
				"password" => $this->_password, 
				"password2" => $this->_password2, 
				"admin_id" => $this->_admin_id, 
				"checkboxID" => array ($this->_admin_id ) ) );
	}
}
