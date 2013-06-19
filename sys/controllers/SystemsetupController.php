<?php

/**
 * 系统配置控制器
 * 
 * @author linfb
 */
class SystemsetupController extends SysController {

	/**
	 * 默认显示方法
	 */
	public function index() {
		$this->toServerFunctionSetup();
	}

	/**
	 * 获取要设置的功能列表
	 * 
	 * @return array 功能列表
	 */
	private function getSetupFunctionList() {
		
		return array (
				"is_quota" => $this->getText( "systemsetup_is_quota" ), 
				"is_bcc" => $this->getText( "systemsetup_is_bcc" ), 
				"is_foreign" => $this->getText( "systemsetup_is_foreign" ), 
				"is_ndisk" => $this->getText( "systemsetup_is_ndisk" ), 
				"is_session" => $this->getText( "systemsetup_is_session" ), 
				"is_wap" => $this->getText( "systemsetup_is_wap" ), 
				"is_sms" => $this->getText( "systemsetup_is_sms" ), 
				"is_ad" => $this->getText( "systemsetup_is_ad" ), 
				"is_fax" => $this->getText( "systemsetup_is_fax" ), 
				"is_mim" => $this->getText( "systemsetup_is_mim" ), 
				"is_recall" => $this->getText( "systemsetup_is_recall" ), 
				"is_imap" => $this->getText( "systemsetup_is_imap" ), 
				"is_service" => $this->getText( "systemsetup_is_service" ), 
				"is_cdn" => $this->getText( "systemsetup_is_cdn" ), 
				"is_alias" => $this->getText( "systemsetup_is_alias" ), 
				"is_pushmail" => $this->getText( "systemsetup_is_pushmail" ), 
				"is_smtp" => $this->getText( "systemsetup_is_smtp" ), 
				"is_api" => $this->getText( "systemsetup_is_api" ) );
	}

	/**
	 * 显示功能设置页
	 */
	public function toServerFunctionSetup() {
		$setup_function_list = $this->getSetupFunctionList();
		$sys_setting_data = array ();
		$systemSetupService = ServiceFactory::getSysSettingService();
		$sys_setting = $systemSetupService->getSysSetting();
		foreach ( $setup_function_list as $key => $item ) {
			if (isset( $sys_setting [$key] )) {
				$sys_setting_data [$key] = array ("label" => $item, "value" => $sys_setting [$key] );
			}
		}
		$template = new TemplateEngine();
		$template->assign( "sys_setting_data", $sys_setting_data );
		$template->display( "server_function.tpl" );
	}

	/**
	 * 提交功能修改
	 */
	public function serverFunctionSetup() {
		$setup_function_list = $this->getSetupFunctionList();
		$setting_data = array ();
		foreach ( $setup_function_list as $key => $item ) {
			$setting_data [$key] = $this->getParamFromRequest( $key, "0" );
		}
		try {
			if (ServiceFactory::getSysSettingService()->saveSysSetting( $setting_data )) {
				SysLogger::log( "修改系统功能" );
				$this->showErrorMessage( $this->getText( "systemsetup_setup_ok" ), $this->createUrl( "toServerFunctionSetup" ) );
			} else {
				$this->showErrorMessage( $this->getText( "systemsetup_setup_failed" ), $this->createUrl( "toServerFunctionSetup" ) );
			}
		} catch ( Exception $exc ) {
			$this->ShowServiceErrorMessage( $exc, $this->createUrl( "toServerFunctionSetup" ) );
		}
	}

	/**
	 * 显示邮局类型页面修改
	 */
	public function toPostTypeSetup() {
		$post_type_list = array (
				"boss" => $this->getText( "systemsetup_post_type_boss" ), 
				"jinpai" => $this->getText( "systemsetup_post_type_gold" ), 
				"group" => $this->getText( "systemsetup_post_type_group" ), 
				"enterprise" => $this->getText( "systemsetup_post_type_corp" ) );
		$template = new TemplateEngine();
		$sysSettingService = ServiceFactory::getSysSettingService();
		$sys_setting = $sysSettingService->getSysSetting();
		$template->assign( "post_type_list", $post_type_list );
		$template->assign( "current_post_type", $sys_setting ["posttype"] ? $sys_setting ["posttype"] : "boss" );
		$template->assign( "request_time", time() );
		$template->display( "post_type.tpl" );
	}

	/**
	 * 提交邮局类型修改
	 */
	public function postTypeSetup() {
		$post_type = $this->getParamFromRequest( "post_type" );
		if (empty( $post_type )) {
			$this->showErrorMessage( $this->getText( "systemsetup_post_type_empty" ), $this->createUrl( "toPostTypeSetup" ) );
		}
		
		if (ServiceFactory::getSysSettingService()->postTypeSetup( $post_type )) {
			SysLogger::log( "修改邮局类型" );
			$this->showErrorMessage( $this->getText( "systemsetup_setup_ok" ), $this->createUrl( "toPostTypeSetup" ) );
		} else {
			$this->showErrorMessage( $this->getText( "systemsetup_setup_failed" ), $this->createUrl( "toPostTypeSetup" ) );
		}
	}

	/**
	 * 显示服务错误信息
	 * 
	 * @param $exc Exception 异常错误
	 */
	private function ShowServiceErrorMessage($exc, $url) {
		$this->showErrorMessage( $exc->getMessage(), $url );
	}

}