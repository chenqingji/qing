<?php

/**
 * 关键字过滤控制器
 * 
 * @author dengr
 */
class KeywordfilterController extends SysController {

	/**
	 * 关键字过滤列表页 、查询
	 */
	public function index() {
		$listPage = $this->getQueryPage();
		$ruleName = $listPage->getQueryParamValue( "search_name", "" );
		$searchCondition = $listPage->getQueryParamValue( "search_condition", "-1" );
		$searchKeyword = $listPage->getQueryParamValue( "search_keyword", "" );
		$searchActive = $listPage->getQueryParamValue( "search_active", "-1" );
		$searchTime = $listPage->getQueryParamValue( "search_time", "" );
		$searchStatus = $listPage->getQueryParamValue( "search_status", "-1" );
		$keywordFilterService = ServiceFactory::getKeywordFilterService();
		$keywordFilterService->getKeywordFilterListPage( $listPage, $ruleName, $searchCondition, $searchKeyword, $searchActive, $searchTime, $searchStatus );
		$template = new TemplateEngine();
		$conditionArray = $this->getConditionArray();
		$statusArray = $this->getStatusArray();
		$actionArray = $this->getActionArray();
		$modeArray = $this->getModeArray();
		$template->assign( "conditionArray", $conditionArray );
		$template->assign( "statusArray", $statusArray );
		$template->assign( "actionArray", $actionArray );
		$template->assign( "modeArray", $modeArray );
		$template->assign( 'listPage', $listPage );
		$template->assign( 'result', $listPage->getResult() );
		$template->assign( 'search_name', CHtml::encode( $ruleName ) );
		$template->assign( 'search_keyword', CHtml::encode( $searchKeyword ) );
		$template->assign( 'search_time', CHtml::encode( $searchTime ) );
		$template->assign( 'search_condition', $searchCondition );
		$template->assign( 'search_active', $searchActive );
		$template->assign( 'search_status', $searchStatus );
		$template->display( 'keywordfilter_list.tpl' );
	}

	/**
	 * 转到添加编辑页面
	 */
	public function toEdit() {
		$checkboxID = $this->getParamFromRequest( "checkboxID", null );
		$template = new TemplateEngine();
		if ($checkboxID != null) {
			$spamRule = $this->checkSpamRuleExist( $checkboxID );
			$template->assign( "isEdit", true );
		} else {
			$spamRule = new SpamRule();
			$template->assign( "isEdit", false );
		}
		$template->assign( "spam_rule", $spamRule );
		$template->display( 'keywordfilter_edit.tpl' );
	}

	/**
	 * 判断关键字过滤是否存在
	 * 
	 * @param $id
	 */
	private function checkSpamRuleExist($id) {
		$keywordFilterService = ServiceFactory::getKeywordFilterService();
		$spamRule = $keywordFilterService->getSpamRuleById( $id );
		if (! $spamRule) {
			$this->showErrorMessage( $this->getText( "keywordfilter_spam_rule_not_exsit" ), $this->createBackUrl( "index" ) );
		}
		return $spamRule;
	}

	/**
	 * 判断是否重名
	 */
	public function checkNameExist() {
		$keywordFilterService = ServiceFactory::getKeywordFilterService();
		$ruleName = $this->getParamFromRequest( "rulename" );
		$id = $this->getParamFromRequest( "id" );
		if (! empty( $id )) {
			if ($keywordFilterService->checkSpamRuleNameExist( $ruleName, $id )) {
				$this->ajaxReturn( "", ($this->getText( "keywordfilter_spam_rule_name_has_exsit" )), 0 );
			}
		} else {
			if ($keywordFilterService->getSpamRuleByName( $ruleName )) {
				$this->ajaxReturn( "", ($this->getText( "keywordfilter_spam_rule_name_has_exsit" )), 0 );
			}
		}
		$this->ajaxReturn( "", "", 1 );
	}

	/**
	 * 添加/修改关键字过滤
	 */
	public function edit() {
		$id = $this->getParamFromRequest( "id" );
		$isEdit = $id ? true : false;
		$ruleName = $this->getParamFromRequest( "rulename" );
		$condition = $this->getParamFromRequest( "condition" );
		$keyword = $this->getParamFromRequest( "keyword" );
		$action = $this->getParamFromRequest( "active" );
		$mode = $this->getParamFromRequest( "mode" );
		$remark = $this->getParamFromRequest( "remark" );
		if ($isEdit) {
			$spamRule = $this->checkSpamRuleExist( $id );
		} else {
			$spamRule = new SpamRule();
			$spamRule->active = 1;
		}
		$spamRule->rulename = $ruleName;
		$spamRule->mail_condition = $condition;
		$spamRule->keyword = $keyword;
		$spamRule->action = $action;
		$spamRule->mode = $mode;
		$spamRule->remark = $remark;
		$spamRule->time = date( "Y-n-j H:i:s" );
		
		if ($isEdit) {
			$successMsg = $this->getText( "keywordfilter_spam_rule_modify_success" );
			$failedMsg = $this->getText( "keywordfilter_spam_rule_modify_failed" );
		} else {
			$successMsg = $this->getText( "keywordfilter_spam_rule_add_success" );
			$failedMsg = $this->getText( "keywordfilter_spam_rule_add_failed" );
		}
		if (ServiceFactory::getKeywordFilterService()->saveSpamRule( $spamRule )) {
			SysLogger::log( ($isEdit ? "修改关键字过滤" : "增加关键字过滤") . " $ruleName" );
			$response = PlatformSocketHandler::executeUmcacheCommand();
			$this->showErrorMessage( $successMsg, $this->createBackUrl( "index" ) );
		} else {
			$this->showErrorMessage( $failedMsg, $this->createBackUrl( "index" ) );
		}
	}

	/**
	 * 获取要操作的id串 以逗号分隔
	 */
	private function getCheckedIds() {
		$checkboxID = $this->getParamFromRequest( "checkboxID", null );
		return StringUtils::fromArrayToString( $checkboxID );
	}

	/**
	 * 启用关键字过滤
	 */
	public function enable() {
		ServiceFactory::getKeywordFilterService()->updateActiveByIdsAndType( $this->getCheckedIds(), "enable" );
		$response = PlatformSocketHandler::executeUmcacheCommand();
		$this->showErrorMessage( $this->getText( "keywordfilter_enable_success" ), $this->createBackUrl( "index" ) );
	}

	/**
	 * 禁用关键字过滤
	 */
	public function disable() {
		ServiceFactory::getKeywordFilterService()->updateActiveByIdsAndType( $this->getCheckedIds(), "disable" );
		$response = PlatformSocketHandler::executeUmcacheCommand();
		$this->showErrorMessage( $this->getText( "keywordfilter_disable_success" ), $this->createBackUrl( "index" ) );
	}

	/**
	 * 删除关键字过滤
	 */
	public function delete() {
		ServiceFactory::getKeywordFilterService()->deleteSpamRuleByIds( $this->getCheckedIds() );
		$response = PlatformSocketHandler::executeUmcacheCommand();
		$this->showErrorMessage( $this->getText( "keywordfilter_delete_success" ), $this->createBackUrl( "index" ) );
	}

	/**
	 * 获取条件数组 用于列表显示
	 */
	private function getConditionArray() {
		$condition = array (
				"0" => $this->getText( "keywordfilter_condition_from" ), 
				"1" => $this->getText( "keywordfilter_condition_to" ), 
				"2" => $this->getText( "keywordfilter_condition_cc" ), 
				"3" => $this->getText( "keywordfilter_condition_subject" ), 
				"4" => $this->getText( "keywordfilter_condition_attachment_name" ), 
				"5" => $this->getText( "keywordfilter_condition_bcc" ), 
				"6" => $this->getText( "keywordfilter_condition_text" ), 
				"7" => $this->getText( "keywordfilter_condition_attachment_type" ), 
				"8" => $this->getText( "keywordfilter_condition_attachment_content" ), 
				"9" => $this->getText( "keywordfilter_condition_ip" ) );
		return $condition;
	}

	/**
	 * 获取行为数组 用于列表显示
	 */
	private function getActionArray() {
		$action = array (
				"0" => $this->getText( "keywordfilter_action_deliver" ), 
				"1" => $this->getText( "keywordfilter_action_refuse" ), 
				"2" => $this->getText( "keywordfilter_action_discard" ), 
				"3" => $this->getText( "keywordfilter_action_spam" ) );
		return $action;
	}

	/**
	 * 获取状态数组 用于列表显示
	 */
	private function getStatusArray() {
		$status = array (
				"0" => $this->getText( "keywordfilter_status_invalid" ), 
				"1" => $this->getText( "keywordfilter_status_effective" ) );
		return $status;
	}

	/**
	 * 获取模式数组 用于列表显示 0：模糊（包含）1：精确（是）
	 */
	private function getModeArray() {
		$mode = array (
				"0" => $this->getText( "keywordfilter_spam_rule_mode_fuzz" ), 
				"1" => $this->getText( "keywordfilter_spam_rule_mode_exact" ) );
		return $mode;
	}
}
