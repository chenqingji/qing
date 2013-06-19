<?php
/**
 * 邮局管理controller
 * 
 * @author zwm
 */
class PostController extends SysController {

	/**
	 * 邮局状态：正常
	 */
	const POST_STATUS_NOMAL = 1;

	/**
	 * 邮局状态：暂停
	 */
	const POST_STATUS_STOP = 0;

	/**
	 * 页面提交邮局id
	 * 
	 * @var array
	 */
	private $_Ids = "";

	/**
	 * 错误消息
	 * 
	 * @var string
	 */
	private $_error_msgs;

	/**
	 * 显示列表页
	 */
	public function index() {
            /**
		$listPage = $this->getQueryPage();
		ServiceFactory::getDomainService()->getDomainListPage( $listPage );
		
		$template = new TemplateEngine();
		$template->assign( "sysSetting", ServiceFactory::getSysSettingService()->getSysSetting() );
		$template->assign( 'listPage', $listPage );
		$template->assign( 'result', $listPage->getResult() );
		$template->assign( 'status', $this->getPostStatus() );
             * 
             */
                $listPage = $this->getQueryPage();
                $template = new TemplateEngine();
		$template->assign( 'listPage', $listPage );
                
		$template->display( 'post_index.tpl' );
	}

	/**
	 * 跳转增加页面权限校验
	 */
	public function toAdd() {
		$this->toEdit();
	}

	/**
	 * 跳转编辑页面权限校验
	 */
	public function toUpdate() {
		$this->toEdit();
	}

	/**
	 * 增加权限校验
	 */
	public function add() {
		$this->edit();
	}

	/**
	 * 修改权限校验
	 */
	public function update() {
		$this->edit();
	}

	/**
	 * 错误返回增加页面
	 */
	public function backToAdd() {
		$this->backToEdit();
	}

	/**
	 * 错误返回修改页面
	 */
	public function backToUpdate() {
		$this->backToEdit();
	}

	/**
	 * 跳转编辑增加页面
	 */
	private function toEdit() {
		$template = new TemplateEngine();
		/**
		$this->_Ids = StringUtils::fromArrayToString( $this->getParamFromRequest( "ids" ) );
		if (strpos( $this->_Ids, "," ) !== false) {
			$this->showErrorMessage( $this->getText( 'post_edit_only_one' ), $this->createBackUrl( "index" ) );
		}
		
		$isEdit = false;
		$poPushmail = null;
		$sysSetting = ServiceFactory::getSysSettingService()->getSysSetting();
		
		if ($this->_Ids) {
			$domain = ServiceFactory::getDomainService()->getDomainByPoId( $this->_Ids );
			if (! $domain) {
				$this->showErrorMessage( $this->getText( 'post_not_exist' ), $this->createBackUrl( "index" ) );
			}
			
			$usedNetDisk = ServiceFactory::getNetdiskService()->getUsedDiskOfPost( $this->_Ids );
			$usedPushmail = ServiceFactory::getMailboxSettingService()->getUsedPushmailCount( $this->_Ids );
			
			$isEdit = true;
			
			$poPushmail = ServiceFactory::getPoPushmailService()->getPoPushMail( $domain->po_id );
			$mailAliases = ServiceFactory::getMailAliasService()->findMailAliasesByDomainName( $domain->domain );
			$template->assign( "mailAliases", $mailAliases );
			$template->assign( 'id', $domain->po_id );
			$template->assign( 'usedNetDisk', round( $usedNetDisk / 1024 / 1024, 2 ) );
			$template->assign( 'usedPushmail', $usedPushmail );
		
		} else {
			$domain = new Domain();
			$functions = $this->initNeedCheckedFunctionsArray();
			$allFunctions = $this->getFunctionsArray();
			foreach ( $allFunctions as $key => $function ) {
				if ($key != "is_pushmail") {
					$domain->$key = in_array( $key, $functions ) ? 1 : 0;
				}
			}
			if (! $sysSetting->is_quota) {
				$domain->po_quota = 1024 * 1024;
			} else {
				$domain->po_quota = 0;
			}
		}
		
		$lang = SysSessionUtil::getLanguageType();
		$template->assign( "poPushmail", $poPushmail );
		$template->assign( "ipOptions", $this->transferLongToIps( $domain->ip_list ) );
		$template->assign( "domain", $domain );
		$template->assign( "funtions", $this->getFunctionsArray() );
		$template->assign( "sysSetting", $sysSetting );
		$template->assign( 'isEdit', $isEdit );
		$template->assign( 'lang', $lang == I18nHelper::LANGUAGE_CN ? "zh" : $lang );
                 * 
                 */
		$template->display( 'post_edit.tpl' );
	}

	/**
	 * 错误跳转返回至增加、修改页面
	 */
	private function backToEdit() {
		$template = new TemplateEngine();
		$sysSetting = ServiceFactory::getSysSettingService()->getSysSetting();
		$data = SessionUtils::getBackData();
		$domain = $data ['domain'];
		$poPushmail = $data ['poPushmail'];
		$mailAliases = $data ['mailAlias'];
		$list = array ();
		if ($mailAliases) {
			foreach ( $mailAliases as $mailAlias ) {
				$alias = new MailAlias();
				$alias->address = '@' . $mailAlias;
				$list [] = $alias;
			}
		}
		$isEdit = $domain->po_id ? true : false;
		if ($isEdit) {
			$oldDomain = ServiceFactory::getDomainService()->getDomainByPoId( $domain->po_id );
			$usedNetDisk = ServiceFactory::getNetdiskService()->getUsedDiskOfPost( $domain->po_id );
			$usedPushmail = ServiceFactory::getMailboxSettingService()->getUsedPushmailCount( $domain->po_id );
			$template->assign( 'usedNetDisk', round( $usedNetDisk / 1024 / 1024, 2 ) );
			$template->assign( 'usedPushmail', $usedPushmail );
			$template->assign( 'id', $domain->po_id );
			$template->assign( 'oldDomain', $oldDomain );
			$template->assign( 'oldPoPushmail', $poPushmail = ServiceFactory::getPoPushmailService()->getPoPushMail( $domain->po_id ) );
		}
		$template->assign( "poPushmail", $poPushmail );
		$template->assign( "mailAliases", $list );
		$lang = SysSessionUtil::getLanguageType();
		$template->assign( "ipOptions", $this->transferLongToIps( $domain->ip_list ) );
		$template->assign( "domain", $domain );
		$template->assign( "funtions", $this->getFunctionsArray() );
		$template->assign( "sysSetting", $sysSetting );
		$template->assign( 'back', true );
		$template->assign( 'isEdit', $isEdit );
		$template->assign( 'lang', $lang == I18nHelper::LANGUAGE_CN ? "zh" : $lang );
		$template->display( 'post_edit.tpl' );
	}

	/**
	 * domain数据填充
	 * 
	 * @param $domain Domain
	 * @param $sysSetting SysSetting
	 * @param $isEdit boolean 是否编辑
	 * @return Domain 返回参数填充对象
	 */
	private function initDomainParams(&$domain, $sysSetting, $isEdit) {
		$functions = $this->getFunctionsArray();
		foreach ( $functions as $key => $value ) {
			if ($key != "is_pushmail") {
				$domain->$key = $this->getParamFromRequest( $key ) ? 1 : 0;
			}
		}
		if ($domain->is_sms) {
			$domain->sms_avail = $isEdit ? ($domain->sms_avail + abs( $this->getParamFromRequest( 'sms_buy' ) )) : abs( $this->getParamFromRequest( 'sms_buy' ) );
		}
		if ($domain->is_fax) {
			$fax_amount = abs( $this->getParamFromRequest( 'fax_amount' ) );
			$domain->fax_amount = $isEdit ? ($domain->fax_amount + $fax_amount) : $fax_amount;
		}
		if (! $isEdit) {
			$domainName = $this->getParamFromRequest( "domain" );
			if (strpos( $domainName, '--' ) !== false) {
				$this->_error_msgs .= $this->getText( 'post_domain_invalid' ) . "\n";
			}
			$domainName = $this->getParamFromRequest( "domain" );
			
			if (! ParameterChecker::checkIsDomain( $domainName )) {
				$this->_error_msgs .= $this->getText( "post_office_name" ) . $this->getText( 'post_input_error' ) . "\n";
			}
			if (ServiceFactory::getDomainService()->checkDomainNameIsExist( $domainName )) {
				$this->_error_msgs .= $this->getText( 'post_controller_exist' ) . "\n";
			}
			if (ServiceFactory::getMailAliasService()->checkMailAliasExist( $domainName )) {
				$this->_error_msgs .= $this->getText( 'post_exist_in_alias' ) . "\n";
			}
			$domain->domain = strtolower($domainName);
		}
		$domain->po_status = $this->getParamFromRequest( 'status', 1 );
		$domain->reason = $this->getParamFromRequest( 'reason', '' );
		$po_quota = abs( $this->getParamFromRequest( "po_quota", 1 ) );
		$domain->po_quota = ($sysSetting->is_quota ? ($domain->is_quota ? 0 : $po_quota) : $po_quota) * 1024 * 1024;
		$domain->po_maxuser = $this->getParamFromRequest( "po_maxuser" );
		$domain->net_quota = abs( $this->getParamFromRequest( "net_quota", 0 ) );
		$this->checkPassword( $this->getParamFromRequest( "po_pwd1" ), $this->getParamFromRequest( "po_pwd2" ) );
		$domain->po_pwd = trim( $this->getParamFromRequest( "po_pwd1", 0 ) );
		$domain->cr_time = $this->getParamFromRequest( "year1" ) . "-" . $this->getParamFromRequest( "month1" ) . '-' . $this->getParamFromRequest( "date1" );
		$domain->ex_time = $this->getParamFromRequest( "year2" ) . "-" . $this->getParamFromRequest( "month2" ) . '-' . $this->getParamFromRequest( "date2" );
		if ($isEdit) {
			if (! $domain->is_quota) {
				$sumMbquota = ServiceFactory::getMailboxService()->getSumOfMailboxQuota( $domain->po_id );
				if ($domain->po_quota < $sumMbquota) {
					$this->_error_msgs .= $this->getText( 'post_moidfy_poquota_error' ) . "\n";
				}
			} else {
				$domain->po_quota = 0;
			}
			$countMailbox = ServiceFactory::getMailboxService()->getMailboxCountByPoId( $domain->po_id );
			if ($countMailbox > $domain->po_maxuser) {
				$this->_error_msgs .= $this->getText( 'post_postemail_error' ) . "\n";
			}
			$domain->fax_avail = $domain->fax_avail + abs( $this->getParamFromRequest( 'fax_amount' ) );
			$domain->check_key = $domain->is_api && $domain->check_key ? $domain->check_key : StringUtils::randomkeys( '10', '0', '35' );
		} else {
			$domain->fax_avail = $domain->fax_amount;
			$domain->check_key = $domain->is_api ? StringUtils::randomkeys( '10', '0', '35' ) : 0;
		}
		if (! checkdate( $this->getParamFromRequest( "month1" ), $this->getParamFromRequest( "date1" ), $this->getParamFromRequest( "year1" ) )) {
			$this->_error_msgs .= $this->getText( 'post_createtime_not_exist' ) . "\n";
		}
		if (! checkdate( $this->getParamFromRequest( "month2" ), $this->getParamFromRequest( "date2" ), $this->getParamFromRequest( "year2" ) )) {
			$this->_error_msgs .= $this->getText( 'post_endtime_not_exist' ) . "\n";
		}
		$domain->po_bak_period = StringUtils::clearZeroBeforeString( trim( $this->getParamFromRequest( "po_bak_period" ) ) );
		
		if (! ParameterChecker::checkIsNumber( $domain->po_maxuser )) {
			$this->_error_msgs .= $this->getText( 'post_input' ) . $this->getText( 'post_controller_mailbox_num' ) . $this->getText( 'post_input_error' ) . "\n";
		}
		if (! ParameterChecker::checkIsNumber( $domain->po_bak_period )) {
			$this->_error_msgs .= $this->getText( 'post_input' ) . $this->getText( 'post_controller_back_time' ) . $this->getText( 'post_input_error' ) . "\n";
		}
		if (! ParameterChecker::checkIsNumber( $domain->net_quota )) {
			$this->_error_msgs .= $this->getText( 'post_input' ) . $this->getText( 'post_controller_net_disk' ) . $this->getText( 'post_input_error' ) . "\n";
		}
		if (! ParameterChecker::checkIsNumber( $domain->sms_avail )) {
			$this->_error_msgs .= $this->getText( 'post_input' ) . $this->getText( 'post_controller_sms' ) . $this->getText( 'post_input_error' ) . "\n";
		}
		
		return $domain;
	}

	/**
	 * 密码校验
	 */
	private function checkPassword($password, $password2) {
		if ($password != $password2) {
			$this->_error_msgs .= $this->getText( 'post_password_confirm_error' ) . "\n";
		}
		if (preg_match( "/[\x7f-\xff]/", $password )) {
			$this->_error_msgs .= $this->getText( 'post_password_contain_chinese' ) . "\n";
		}
		if (strlen( $password ) < 6 || strlen( $password ) > 25) {
			$this->_error_msgs .= $this->getText( 'post_password_length' ) . "\n";
		}
	}

	/**
	 * 权限未设置，还原字段数据
	 * 
	 * @param $sysSetting SysSetting
	 * @param $domain Domain
	 * @param $oldDomain Domain
	 */
	private function resetFiledsData($sysSetting, $domain, $oldDomain) {
		$functions = $this->getFunctionsArray();
		foreach ( $functions as $key => $value ) {
			if ($sysSetting->$key != 1 && $key != 'is_pushmail' && $key != 'is_quota') {
				$domain->$key = $oldDomain->$key;
				switch ($key) {
					case 'is_sms' :
						$domain->sms_avail = $oldDomain->sms_avail;
						break;
					case 'is_fax' :
						$domain->fax_amount = $oldDomain->fax_amount;
						break;
					case 'is_api' :
						$domain->check_key = $oldDomain->check_key;
						$domain->ip_list = $oldDomain->ip_list;
						break;
				}
			}
		}
		if ($sysSetting->is_ndisk != 1) {
			$domain->net_quota = $oldDomain->net_quota;
		}
	}

	/**
	 * 邮局别名数据填充
	 * 
	 * @param $domain Domain
	 * @param $isEdit boolean 是否编辑状态
	 */
	private function initDomainAliases($domain, $isEdit) {
		$aliases = array ();
		for($i = 1; $i < 5; $i ++) {
			$tmpAlias = trim( strtolower( $this->getParamFromRequest( "domain_alias$i" ) ) );
			if ($tmpAlias) {
				$aliases [$i] = $tmpAlias;
			}
		}
		$beforeCount = count( $aliases );
		$afterCount = count( array_unique( $aliases ) );
		if ($beforeCount != $afterCount) {
			$this->_error_msgs .= $this->getText( 'post_alias_repeat' ) . "\n";
		}
		// 域别名检查
		foreach ( $aliases as $key => $alias ) {
			if ($domain->domain == $alias) {
				$this->_error_msgs .= $this->getText( 'post_controller_alias' ) . $key . $this->getText( 'post_controller_not_repeat' ) . "\n";
			} else {
				if (! ParameterChecker::checkIsDomain( $alias )) {
					$this->_error_msgs .= $this->getText( 'post_controller_alias' ) . "$key" . $this->getText( 'post_input_error' ) . "\n";
				}
			}
			if (StringUtils::containChinese( $alias )) {
				$this->_error_msgs .= $this->getText( 'post_controller_alias' ) . "$key" . $this->getText( 'post_alias_contain_chinese' ) . "\n";
			}
			if (ServiceFactory::getMailAliasService()->checkMailAliasExist( $alias, $isEdit ? $domain->domain : '' )) {
				$this->_error_msgs .= $this->getText( 'post_controller_alias' ) . "$key" . $this->getText( 'post_exist_alias' ) . "\n";
			}
			if (ServiceFactory::getDomainService()->checkDomainNameIsExist( $alias )) {
				$this->_error_msgs .= $this->getText( 'post_controller_alias' ) . "$key" . $this->getText( 'post_controller_domain_name_exist' ) . "\n";
			}
		}
		
		return $aliases;
	}

	/**
	 * 邮局pushmail数据填充
	 * 
	 * @param $poPushmail PoPushmail
	 * @param $sysSetting SysSetting
	 */
	public function initPoPushMail($poPushmail, $sysSetting) {
		$poPushmail->pushmail_nums = $this->getParamFromRequest( 'pushmail_num', $poPushmail->pushmail_nums );
		if (! $sysSetting->is_pushmail) {
			$poPushmail->is_pushmail = $this->getParamFromRequest( 'is_pushmail' ) ? 1 : $poPushmail->is_pushmail;
		} else {
			$poPushmail->is_pushmail = $this->getParamFromRequest( 'is_pushmail' ) ? 1 : 0;
		}
		return $poPushmail;
	}

	/**
	 * 编辑、增加
	 */
	private function edit() {
		$id = $this->getParamFromRequest( "id" );
		$sysSetting = ServiceFactory::getSysSettingService()->getSysSetting();
		$usedPoPushmailNum = 0;
		$isEdit = false;
		if ($id) {
			$domain = ServiceFactory::getDomainService()->getDomainByPoId( $id );
			$poPushmail = ServiceFactory::getPoPushmailService()->getPoPushMail( $id );
			if (! $poPushmail) {
				$poPushmail = new PoPushmail();
			}
			$usedPoPushmailNum = ServiceFactory::getMailboxSettingService()->getUsedPushmailCount( $id );
			$isEdit = true;
		} else {
			$domain = new Domain();
			$poPushmail = new PoPushmail();
		}
		$po_maxuser = $domain->po_maxuser;
		$this->initDomainParams( $domain, $sysSetting, $isEdit );
		$mailAliases = $this->initDomainAliases( $domain, $isEdit );
		$poPushmail = $this->initPoPushMail( $poPushmail, $sysSetting );
		$domain->ip_list = $this->getIpListStr();
		if ($isEdit) {
			$oldDomain = ServiceFactory::getDomainService()->getDomainByPoId( $id );
			$this->resetFiledsData( $sysSetting, $domain, $oldDomain );
		}
		if ($sysSetting->is_pushmail && $poPushmail->is_pushmail) {
			if (! ParameterChecker::checkIsNumber( $poPushmail->pushmail_nums )) {
				$this->_error_msgs .= $this->getText( 'post_pushmail_bigger_0' ) . "\n";
			} else {
				if ($domain->po_maxuser < $poPushmail->pushmail_nums) {
					$this->_error_msgs .= $this->getText( 'post_pushmail_bigger_mailbox_num' ) . "\n";
				}
				if ($usedPoPushmailNum > $poPushmail->pushmail_nums) {
					$this->_error_msgs .= $this->getText( 'post_pushmail_smaller_used' ) . "\n";
				}
			}
		}
		
		// 集团邮校验
		if (Config::IS_GROUP_MAIL) {
			$allMailboxNum = ServiceFactory::getDomainService()->getSumOfAllDomainMaxMailbox();
			$allowNum = 0;
			$msg = "";
			if (! GroupMailLicenseChecker::checkGroupMailIsAllowed()) {
				if(GroupMailLicenseChecker::$errorCode == GroupMailLicenseChecker::ERROR_CODE_DATE_ERROR) {
					$msg = $this->getText( 'post_group_date_error' );
				} else {
					$msg = $this->getText( 'post_no_allow' );
				}
				SessionUtils::setBackData( array (
						'domain' => $domain, 
						'poPushmail' => $poPushmail, 
						'mailAlias' => $mailAliases ) );
				$this->showErrorMessage( $msg, $this->createBackUrl( $isEdit ? 'backToUpdate' : 'backToAdd' ) );
			}
			$new_maxuser = $this->getParamFromRequest( "po_maxuser" );
			$result = GroupMailLicenseChecker::checkGroupMailMaxNum( $allMailboxNum, $po_maxuser, $new_maxuser );
			if($result !== true) {
				$msg = $this->getText( 'post_leave_max_user_num' ) . $result;
				SessionUtils::setBackData( array (
						'domain' => $domain, 
						'poPushmail' => $poPushmail, 
						'mailAlias' => $mailAliases ) );
				$this->showErrorMessage( $msg, $this->createBackUrl( $isEdit ? 'backToUpdate' : 'backToAdd' ) );
			}
		}
		
		if ($this->_error_msgs) {
			SessionUtils::setBackData( array (
					'domain' => $domain, 
					'poPushmail' => $poPushmail, 
					'mailAlias' => $mailAliases ) );
			$this->showErrorMessage( $this->_error_msgs, $this->createBackUrl( $isEdit ? 'backToUpdate' : 'backToAdd' ) );
		}
		try {
			$result = ServiceFactory::getDomainService()->editDomain( $domain, $poPushmail, $mailAliases );
		} catch ( ServiceException $e ) {
			$this->showErrorMessage( $e->getMessage(), $this->createBackUrl( "index" ) );
		}
		if ($result) {
			if ($isEdit) {
				$msg = $this->getText( "post_update_success" );
				if (! $domain->po_status) {
					SysLogger::log( "暂停邮局 {$domain->domain}" );
				}
				SysLogger::log( "更新邮局 {$domain->domain}" );
			} else {
				$msg = $this->getText( "post_add_success" );
				SysLogger::log( "增加邮局 {$domain->domain}" );
			}
			if ($this->getParamFromRequest( 'strong' ) == 1) {
				$msg .= "\n" . $this->getText( "post_strong_password" );
			} else {
				$msg .= "\n" . $this->getText( "post_middle_password" );
			}
			$this->showErrorMessage( $msg, $this->createBackUrl( 'index' ) );
		} else {
			$this->showErrorMessage( $this->getText( 'post_edit_fail' ), $this->createBackUrl( 'index' ) );
		}
	}

	/**
	 * 删除邮局方法
	 */
	public function delete() {
		$domainIds = StringUtils::fromArrayToString( $this->getParamFromRequest( "ids" ) );
		$domains = ServiceFactory::getDomainService()->findDomainByIds( $domainIds );
		if ($this->checkIsArchiving( $domains )) {
			$this->showErrorMessage( $this->getText( 'post_file_on_archiving' ), $this->createBackUrl( 'index' ) );
		}
		foreach ( $domains as $domain ) {
			try {
				$result = ServiceFactory::getDomainService()->deleteDomain( $domain );
				SysLogger::log( "删除邮局 {$domain->domain}" );
			} catch ( ServiceException $e ) {
				$this->showErrorMessage( $this->getText( 'post_part_delete_suc' ) . "[" . $domain->domain . "]" . "[" . $e->getMessage() . "]", $this->createBackUrl( "index" ) );
			}
		}
		$this->showErrorMessage( $this->getText( 'post_delete_suc' ), $this->createBackUrl( "index" ) );
	}

	/**
	 * 将数据库domain中ip_list字段转化为可显示ip列表
	 */
	private function transferLongToIps($ipList) {
		if ($ipList == 'nolimit' || $ipList == 0) {
			return null;
		}
		$ips = array ();
		$list = explode( ',', $ipList );
		foreach ( $list as $ip ) {
			$ipstr = "";
			if (preg_match( "/^(\\d+)-(\\d+)$/", $ip, $arr1 )) {
				$ipstr = long2ip( $arr1 [1] ) . '-' . long2ip( $arr1 [2] );
			} else if (preg_match( "/^-(\\d+)$/", $ip, $arr2 )) {
				$ipstr = '-' . long2ip( $arr2 [1] );
			} else if (preg_match( "/^\\+(\\d+)$/", $ip, $arr3 )) {
				$ipstr = long2ip( $arr3 [1] );
			}
			$ips [] = $ipstr;
		}
		return $ips;
	}

	/**
	 * 验证是否有邮局在归档
	 * 
	 * @param $domains array 邮局数组
	 */
	private function checkIsArchiving($domains) {
		foreach ( $domains as $domain ) {
			if (PlatformArchiveHandler::isDomainArchiving( $domain->domain )) {
				return true;
			}
		}
		return false;
	}

	/**
	 * 获取邮局状态列表
	 */
	private function getPostStatus() {
		return array (
				self::POST_STATUS_NOMAL => $this->getText( "post_status_nomal" ), 
				self::POST_STATUS_STOP => $this->getText( "post_status_stop" ) );
	}

	/**
	 * 获取数据库字段对应功能名称
	 */
	private function getFunctionsArray() {
		return array (
				'is_bcc' => $this->getText( "post_function_bcc" ), 
				'is_foreign' => $this->getText( "post_function_foreign" ), 
				'is_imap' => $this->getText( "post_function_imap" ), 
				'is_quota' => $this->getText( "post_function_quota" ), 
				'is_wap' => $this->getText( "post_function_wap" ), 
				'is_sms' => $this->getText( "post_function_sms" ), 
				'is_smtp' => $this->getText( "post_function_smtp" ), 
				'is_fax' => $this->getText( "post_function_fax" ), 
				'is_service' => $this->getText( "post_function_service" ), 
				'is_cdn' => $this->getText( "post_function_cdn" ), 
				'is_recall' => $this->getText( "post_function_recall" ), 
				'is_alias' => $this->getText( "post_function_alias" ), 
				'is_pushmail' => $this->getText( "post_function_pushmail" ), 
				'is_api' => $this->getText( "post_function_api" ) );
	}

	/**
	 * 需要初始化选择框的功能
	 */
	private function initNeedCheckedFunctionsArray() {
		return array (
				'is_bcc', 
				'is_foreign', 
				'is_imap', 
				'is_quota', 
				'is_wap', 
				'is_sms', 
				'is_smtp', 
				'is_service', 
				'is_recall', 
				'is_alias' );
	}

	/**
	 * 获取处理后基础apiip规则
	 */
	private function getIpListStr() {
		$ip_type = $this->getParamFromRequest( 'ip_type' );
		if ($ip_type == "nolimit") {
			return "nolimit";
		} else {
			$exp1 = "/^((25[0-5])|(2[0-4]\\d)|(1\\d\\d)|([1-9]\\d)|\\d)(\\.((25[0-5])|(2[0-4]\\d)|(1\\d\\d)|([1-9]\\d)|\\d)){3}-((25[0-5])|(2[0-4]\\d)|(1\\d\\d)|([1-9]\\d)|\\d)(\\.((25[0-5])|(2[0-4]\\d)|(1\\d\\d)|([1-9]\\d)|\\d)){3}$/";
			$exp2 = "/^-((25[0-5])|(2[0-4]\\d)|(1\\d\\d)|([1-9]\\d)|\\d)(\\.((25[0-5])|(2[0-4]\\d)|(1\\d\\d)|([1-9]\\d)|\\d)){3}$/";
			$exp3 = "/^((25[0-5])|(2[0-4]\\d)|(1\\d\\d)|([1-9]\\d)|\\d)(\\.((25[0-5])|(2[0-4]\\d)|(1\\d\\d)|([1-9]\\d)|\\d)){3}$/";
			$ipList = $this->getParamFromRequest( 'ips' );
			$ipArr = explode( ',', $ipList );
			$ip_list = '';
			foreach ( $ipArr as $key => $ip ) {
				if (preg_match( $exp1, $ip )) {
					$tmpArr = explode( '-', $ip );
					$longIp1 = sprintf( "%u", ip2long( $tmpArr [0] ) );
					$longIp2 = sprintf( "%u", ip2long( $tmpArr [1] ) );
					if ($longIp1 >= $longIp2) {
						$this->_error_msgs .= $this->getText( 'post_ip_start_lt_end' ) . "\n";
					}
					$ip_list .= $longIp1 . '-' . $longIp2 . ',';
				} elseif (preg_match( $exp2, $ip )) {
					$ip_list .= '-' . sprintf( "%u", ip2long( substr( $ip, 1 ) ) ) . ',';
				} elseif (preg_match( $exp3, $ip )) {
					$ip_list .= '+' . sprintf( "%u", ip2long( $ip ) ) . ',';
				}
			}
			$ip_list = $ip_list ? trim( $ip_list, ',' ) : '';
		}
		return $ip_list;
	}

	/**
	 * 邮局参数设置页面
	 */
	public function postParameterSet() {
		$this->_Ids = StringUtils::fromArrayToString( $this->getParamFromRequest( "ids" ) );
		if (strpos( $this->_Ids, "," ) !== false) {
			$this->showErrorMessage( $this - gettext( 'post_can_not_set_more' ), $this->createBackUrl( "index" ) );
		}
		$template = new TemplateEngine();
		if ($this->_Ids) {
			$domain = ServiceFactory::getDomainService()->getDomainByPoId( $this->_Ids );
			if (! $domain) {
				$this->showErrorMessage( $this - gettext( 'post_controller_not_exist' ), $this->createBackUrl( "index" ) );
			}
			$sysSetting = ServiceFactory::getSysSettingService()->getSysSetting();
			$template->assign( 'id', $domain->po_id );
			$template->assign( 'sysSetting', $sysSetting );
			$template->assign( 'domain', $domain->domain );
			$template->assign( 'user_number', $domain->po_maxuser );
			$template->assign( 'domain_multiple', Constants::SYS_BASE_MULTIPLE );
			$template->assign( 'single_maillist_foreign_limit_default', Constants::MAX_SINGLE_MAILLIST_FOREIGN_LIMIT );
			$template->assign( 'address_limit_default', Constants::MAX_ADDRESS_LIMIT );
			$template->assign( 'mail_rule_limit_default', Constants::MAX_MAILBOX_FILTER_COUNT );
			$template->assign( 'sms_rule_limit_default', Constants::MAX_SMS_RULE_LIMIT );
			$template->assign( 'pushmail_rule_limit_default', Constants::MAX_PUSHMAIL_RULE_LIMIT );
			$template->assign( 'monitor_rule_limit_default', Constants::MAX_MONITOR_RULE_LIMIT );
			
			$domainSettingService = ServiceFactory::getDomainSettingService();
			
			$template->assign( 'monitor_limit', $domainSettingService->getMonitorLimit( $domain ) );
			$template->assign( 'audit_limit', $domainSettingService->getAuditLimit( $domain ) );
			$template->assign( 'maillist_limit', $domainSettingService->getMaillistLimit( $domain ) );
			
			$template->assign( 'single_maillist_foreign_limit', $domainSettingService->getSingleMaillistForeignLimit( $domain ) );
			$template->assign( 'address_limit', $domainSettingService->getAddressLimit( $domain ) );
			$template->assign( 'mail_rule_limit', $domainSettingService->getMailRuleLimit( $domain ) );
			$template->assign( 'sms_rule_limit', $domainSettingService->getSmsRuleLimit( $domain ) );
			$template->assign( 'pushmail_rule_limit', $domainSettingService->getPushmailRuleLimit( $domain ) );
			$template->assign( 'monitor_rule_limit', $domainSettingService->getMonitorRuleLimit( $domain ) );
		}
		$template->display( 'post_parameter_setting.tpl' );
	}

	/**
	 * 邮局参数设置保存
	 */
	public function postParamaterSave() {
		
		$id = $this->getParamFromRequest( "id" );
		if (! $id || ! ParameterChecker::checkIsNumber( $id )) {
			$this->showErrorMessage( $this - gettext( 'post_error_parameter' ), $this->createBackUrl( 'index' ) );
		}
		$domainparameter = ServiceFactory::getDomainSettingService()->getDomainSettingByPoId( $id );
		if (! $domainparameter) {
			$domainparameter = new DomainSetting();
		}
		$domainparameter->po_id = $id;
		$domain = ServiceFactory::getDomainService()->getDomainByPoId( $id );
		$this->initDomainParameterParams( $domainparameter, $domain );
		if ($this->_error_msgs) {
			$this->showErrorMessage( $this->_error_msgs, $this->createBackUrl( 'index' ) );
		}
		$result = ServiceFactory::getDomainSettingService()->PostParameterSave( $domainparameter );
		if ($result) {
			SysLogger::log( "修改邮局参数配置 {$domain->domain}" );
			$this->showErrorMessage( $this->getText( 'post_parameter_suc' ), $this->createBackUrl( 'index' ) );
		} else {
			$this->showErrorMessage( $this - gettext( 'post_save_parameter_error' ), $this->createBackUrl( 'index' ) );
		}
	}

	/**
	 * domainparameter邮箱配置参数数据获取
	 */
	private function initDomainParameterParams(&$domainparameter, $domain) {
		
		$dbarray = ServiceFactory::getDomainSettingService()->getDomainSetingField();
		foreach ( $dbarray as $dbkey => $dbvalue ) {
			if (strcasecmp( trim( $this->getParamFromRequest( $dbvalue ) ), '' ) != 0) {
				$domainparameter->$dbvalue = trim( $this->getParamFromRequest( $dbvalue ) );
				if (! ParameterChecker::checkIsNumber( $domainparameter->$dbvalue )) {
					$this->_error_msgs .= $this->getText( "post_" . $dbvalue ) . $this->getText( "post_error_tip" ) . "</br>";
				}
			} else {
				$function = '';
				$function_part = explode( '_', $dbvalue );
				foreach ( $function_part as $key => $value ) {
					$function .= ucwords( $function_part [$key] );
				}
				$function = 'get' . $function;
				$domainparameter->$dbvalue = ServiceFactory::getDomainSettingService()->$function( $domain );
			}
		}
		return $domainparameter;
	}

	/**
	 * CDN加速设置显示页面
	 */
	public function cdnAccelerateSetting() {
		
		$domains = ServiceFactory::getDomainService()->getAllDomains();
		$template = new TemplateEngine();
		$template->assign( 'domains', $domains );
		$template->display( 'post_cdn_accelerate_setting.tpl' );
	}

	/**
	 * CDN加速设置提交
	 */
	public function cdnUpdate() {
		
		$cdnDomains = ServiceFactory::getDomainService()->getCdnDomains();
		$cdnDomainIds = array ();
		foreach ( $cdnDomains as $domain ) {
			$cdnDomainIds [] = $domain ['po_id'];
		}
		$ids = $this->getParamFromRequest( 'ids', array () );
		$disableIds = array_diff( $cdnDomainIds, $ids );
		$enableIds = array_diff( $ids, $cdnDomainIds );
		try {
			ServiceFactory::getDomainService()->updateCDN( $ids, $disableIds, $enableIds );
			$msg = $this->getText( 'modify_success' );
		} catch ( Exception $e ) {
			$msg = $this->getText( 'modify_fail' );
		}
		$this->showErrorMessage( $msg, $this->createUrl( 'cdnAccelerateSetting' ) );
	}

	/**
	 * 模拟登陆
	 */
	public function mockLogin() {
		$name = $this->getParamFromRequest( 'domain' );
		if (isset( $name ) && $this->getParamFromRequest( 'PG_SHOWALL' ) == 0 && $this->getParamFromRequest( 'sort' ) == 0 && $this->getParamFromRequest( 'startMessage' ) == 1) {
			$logDomain = PunyCode::decode( $name );
			SysLogger::log( "模拟登陆 $logDomain" );
			$domainName = PunyCode::encode( $name );
			$domain = ServiceFactory::getDomainService()->getDomainByName( $domainName );
			$_SESSION ['po_id'] = $domain ['po_id'];
			$_SESSION ['domain'] = $domainName;
			$_SESSION ['po_admin'] = "#";
			$_SESSION ['po_maxuser'] = ( int ) $domain ['po_maxuser'];
			$langParam = "?session_lan=" . SessionUtils::getLanguageType();
			$url = "http://" . $_SERVER ["HTTP_HOST"] . "/webmail/post/po_index.php" . $langParam;
			header( "location:$url" );
		} else {
			$this->showErrorMessage( $this->getText( 'post_no_allow' ), $this->createUrl( 'site/index' ), "", true );
		}
	}
}