<?php

/**
 * 日志文件
 */
class LogController extends SysController {

	private $_action = array ('sysLog', 'adminLog', 'mailLog' );

	/**
	 * 系统管理员日志
	 */
	public function sysLog() {
		$this->showLog( Operlog::SYS_LOG_TYPE );
	}

	/**
	 * 邮局管理员日志
	 */
	public function adminLog() {
		$this->showLog( Operlog::ADMIN_LOG_TYPE );
	}

	/**
	 * 邮箱操作日志
	 */
	public function mailLog() {
		$this->showLog( Operlog::MAIL_LOG_TYPE );
	}

	/**
	 * 日志显示具体方法根据type来区分，用于显示
	 */
	private function showLog($type) {
		$listPage = $this->getQueryPage( array ("defaultSortKey" => "created_at", "defaultSortType" => "desc" ) );
		ServiceFactory::getOperlogService()->getOperlogListPage( $listPage, $type );
		
		$template = new TemplateEngine();
		$template->assign( 'listPage', $listPage );
		$template->assign( 'result', $listPage->getResult() );
		$template->assign( 'type', $type );
		$template->assign( 'searchValue', CHtml::encode( $listPage->getQueryParamValue( "search_val" ) ) );
		$template->assign( 'searchKey', CHtml::encode( $listPage->getQueryParamValue( "search_key" ) ) );
		$template->assign( "deleteURL", $this->createUrl( "delete", array ("type" => $type ) ) );
		$template->assign( "viewallURL", $this->createUrl( $this->_action [$type] ) );
		$template->display( 'log_list.tpl' );
	}

	/**
	 * 删除邮箱操作日志
	 */
	public function delete() {
		$type = $this->getParamFromRequest( "type" );
		if (! in_array( $type, array (Operlog::SYS_LOG_TYPE, Operlog::ADMIN_LOG_TYPE, Operlog::MAIL_LOG_TYPE ) )) {
			$this->showErrorMessage( $this->getText( 'log_type_error' ), $this->createUrl( 'sysLog' ) );
		}
		$delNumber = ServiceFactory::getOperlogService()->deleteAll( $type );
		if ($type == Operlog::SYS_LOG_TYPE) {
			$name = "系统管理";
		} else if ($type == Operlog::ADMIN_LOG_TYPE) {
			$name = "邮局管理";
		} else {
			$name = "邮箱操作";
		}
		if ($delNumber) {
			SysLogger::log( "删除所有" . $name . "日志记录" );
		}
		$this->showErrorMessage( $this->getText( 'log_del_success' ), $this->createUrl( $this->_action [$type] ) );
	}
}
