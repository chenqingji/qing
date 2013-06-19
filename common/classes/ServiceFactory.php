<?php

/**
 * Service工厂类
 * 
 * @author cqy
 */
class ServiceFactory {

	/**
	 * 获得ActiveUserService
	 * 
	 * @return ActiveUserService
	 */
	public static function getActiveUserService() {
		return self::getServiceInstance( 'ActiveUserService' );
	}

	/**
	 * 获得AdminService
	 * 
	 * @return AdminService
	 */
	public static function getAdminService() {
		return self::getServiceInstance( 'AdminService' );
	}

	/**
	 * 获得AdvertisementService
	 * 
	 * @return AdvertisementService
	 */
	public static function getAdvertisementService() {
		return self::getServiceInstance( 'AdvertisementService' );
	}

	/**
	 * 获得BWListService
	 * 
	 * @return BWListService
	 */
	public static function getBWListService() {
		return self::getServiceInstance( 'BWListService' );
	}

	/**
	 * 获得DomainService
	 * 
	 * @return DomainService
	 */
	public static function getDomainService() {
		return self::getServiceInstance( 'DomainService' );
	}

	/**
	 * 获取DomainSettingService
	 * 
	 * @return DomainSettingService
	 */
	public static function getDomainSettingService() {
		return self::getServiceInstance( 'DomainSettingService' );
	}

	/**
	 * 获得FrequencyService
	 * 
	 * @return FrequencyService
	 */
	public static function getFrequencyService() {
		return self::getServiceInstance( 'FrequencyService' );
	}

	/**
	 * 获得KeywordFilterService
	 * 
	 * @return KeywordFilterService
	 */
	public static function getKeywordFilterService() {
		return self::getServiceInstance( 'KeywordFilterService' );
	}

	/**
	 * 获得MailAliasService
	 * 
	 * @return MailAliasService
	 */
	public static function getMailAliasService() {
		return self::getServiceInstance( 'MailAliasService' );
	}

	/**
	 * 获得MailboxService
	 * 
	 * @return MailboxService
	 */
	public static function getMailboxService() {
		return self::getServiceInstance( 'MailboxService' );
	}

	/**
	 * 获得MailboxSettingService
	 * 
	 * @return MailboxSettingService
	 */
	public static function getMailboxSettingService() {
		return self::getServiceInstance( 'MailboxSettingService' );
	}

	/**
	 * 获得NetdiskService
	 * 
	 * @return NetdiskService
	 */
	public static function getNetdiskService() {
		return self::getServiceInstance( 'NetdiskService' );
	}

	/**
	 * 获得OperlogService
	 * 
	 * @return OperlogService
	 */
	public static function getOperlogService() {
		return self::getServiceInstance( 'OperlogService' );
	}

	/**
	 * 获得PageStyleService
	 * 
	 * @return PageStyleService
	 */
	public static function getPageStyleService() {
		return self::getServiceInstance( 'PageStyleService' );
	}

	/**
	 * 获得PoPushmailService
	 * 
	 * @return PoPushmailService
	 */
	public static function getPoPushmailService() {
		return self::getServiceInstance( 'PoPushmailService' );
	}

	/**
	 * 获得RsyncDataService
	 * 
	 * @return RsyncDataService
	 */
	public static function getRsyncDataService() {
		return self::getServiceInstance( 'RsyncDataServiceProxy' );
	}

	/**
	 * 获得SendReceiveStatService
	 * 
	 * @return SendReceiveStatService
	 */
	public static function getSendReceiveStatService() {
		return self::getServiceInstance( 'SendReceiveStatService' );
	}

	/**
	 * 获得StatisticsService
	 * 
	 * @return StatisticsService
	 */
	public static function getStatisticsService() {
		return self::getServiceInstance( 'StatisticsService' );
	}

	/**
	 * 获得StyleService
	 * 
	 * @return StyleService
	 */
	public static function getStyleService() {
		return self::getServiceInstance( 'StyleService' );
	}

	/**
	 * 获得SysSettingService
	 * 
	 * @return SysSettingService
	 */
	public static function getSysSettingService() {
		return self::getServiceInstance( 'SysSettingService' );
	}

	/**
	 * 获得VisitorInfoStatService
	 * 
	 * @return VisitorInfoStatService
	 */
	public static function getVisitorInfoStatService() {
		return self::getServiceInstance( 'VisitorInfoStatService' );
	}

	/**
	 * 获取DomainInfoService
	 * 
	 * @return DomainInfoService
	 */
	public static function getDomainInfoService() {
		return self::getServiceInstance( 'DomainInfoService' );
	}

	/**
	 * 获取ManagerService
	 * 
	 * @return ManagerService
	 */
	public static function getManagerService() {
		return self::getServiceInstance( 'ManagerService' );
	}

	/**
	 * 获取DepartmentService
	 * 
	 * @return DepartmentService
	 */
	public static function getDepartmentService() {
		return self::getServiceInstance( 'DepartmentService' );
	}

	/**
	 * 获取SmsLogService
	 * 
	 * @return SmsLogService
	 */
	public static function getSmsLogService() {
		return self::getServiceInstance( 'SmsLogService' );
	}

	/**
	 * 获取RetransService
	 * 
	 * @return RetransService
	 */
	public static function getRetransService() {
		return self::getServiceInstance( 'RetransService' );
	}

	/**
	 * 获取FaxGeneralService
	 * 
	 * @return FaxGeneralService
	 */
	public static function getFaxGeneralService() {
		return self::getServiceInstance( 'FaxGeneralService' );
	}

	/**
	 * 获取FaxDetailService
	 * 
	 * @return FaxDetailService
	 */
	public static function getFaxDetailService() {
		return self::getServiceInstance( 'FaxDetailService' );
	}

	/**
	 * 获取FaxLogIndexService
	 * 
	 * @return FaxLogIndexService
	 */
	public static function getFaxLogIndexService() {
		return self::getServiceInstance( 'FaxLogIndexService' );
	}

	/**
	 * 获取FaxNoticeService
	 * 
	 * @return FaxNoticeService
	 */
	public static function getFaxNoticeService() {
		return self::getServiceInstance( 'FaxNoticeService' );
	}

	/**
	 * 获取FaxSendService
	 * 
	 * @return FaxSendService
	 */
	public static function getFaxSendService() {
		return self::getServiceInstance( 'FaxSendService' );
	}

	/**
	 * 获取FaxAddressService
	 * 
	 * @return FaxAddressService
	 */
	public static function getFaxAddressService() {
		return self::getServiceInstance( 'FaxAddressService' );
	}

	/**
	 * 获取SmsBuyService
	 * 
	 * @return SmsBuyService
	 */
	public static function getSmsBuyService() {
		return self::getServiceInstance( 'SmsBuyService' );
	}

	/**
	 * 获取SmsLogIndexService
	 * 
	 * @return SmsLogIndexService
	 */
	public static function getSmsLogIndexService() {
		return self::getServiceInstance( 'SmsLogIndexService' );
	}

	/**
	 * 获取DomainWBListService
	 * 
	 * @return DomainWBListService
	 */
	public static function getDomainWBListService() {
		return self::getServiceInstance( 'DomainWBListService' );
	}

	/**
	 * 获取DepartmentNoticeService
	 * 
	 * @return DepartmentNoticeService
	 */
	public static function getDepartmentNoticeService() {
		return self::getServiceInstance( 'DepartmentNoticeService' );
	}

	/**
	 * 获取BossmailUserDepService
	 * 
	 * @return BossmailUserDepService
	 */
	public static function getBossmailUserDepService() {
		return self::getServiceInstance( 'BossmailUserDepService' );
	}

	/**
	 * 获取BqLoginRestrictService
	 * 
	 * @return BqLoginRestrictService
	 */
	public static function getBqLoginRestrictService() {
		return self::getServiceInstance( 'BqLoginRestrictService' );
	}

	/**
	 * 获取CompanyNoticeService
	 * 
	 * @return CompanyNoticeService
	 */
	public static function getCompanyNoticeService() {
		return self::getServiceInstance( 'CompanyNoticeService' );
	}

	/**
	 * 获取PushmailRestrictService
	 * 
	 * @return PushmailRestrictService
	 */
	public static function getPushmailRestrictService() {
		return self::getServiceInstance( 'PushmailRestrictService' );
	}

	/**
	 * 获取AddressService
	 * 
	 * @return AddressService
	 */
	public static function getAddressService() {
		return self::getServiceInstance( 'AddressService' );
	}

	/**
	 * 获取AddressGroupService
	 * 
	 * @return AddressGroupService
	 */
	public static function getAddressGroupService() {
		return self::getServiceInstance( 'AddressGroupService' );
	}

	/**
	 * 获取MboxDeleteService
	 * 
	 * @return MboxDeleteService
	 */
	public static function getMboxDeleteService() {
		return self::getServiceInstance( 'MboxDeleteService' );
	}

	/**
	 * 获取RsyncTimeService
	 * 
	 * @return RsyncTimeService
	 */
	public static function getRsyncTimeService() {
		return self::getServiceInstance( 'RsyncTimeService' );
	}

	/**
	 * 获取DomainSignnService
	 * 
	 * @return DomainSignService
	 */
	public static function getDomainSignService() {
		return self::getServiceInstance( 'DomainSignService' );
	}

	/**
	 * 获取SmsFilterService
	 * 
	 * @return SmsFilterService
	 */
	public static function getSmsFilterService() {
		return self::getServiceInstance( 'SmsFilterService' );
	}

	/**
	 * 获取MailFilterService
	 * 
	 * @return MailFilterService
	 */
	public static function getMailFilterService() {
		return self::getServiceInstance( 'MailFilterService' );
	}

	/**
	 * 获取NewFilterService
	 * 
	 * @return NewFilterService
	 */
	public static function getNewFilterService() {
		return self::getServiceInstance( "NewFilterService" );
	}

	/**
	 * 获取DoaminFilterService
	 * 
	 * @return DomainFilterService
	 */
	public static function getDomainFilterService() {
		return self::getServiceInstance( "DomainFilterService" );
	}

	/**
	 * 获取DomainFilterKeyService
	 * 
	 * @return DomainFilterKeyService
	 */
	public static function getDomainFilerKeyService() {
		return self::getServiceInstance( "DomainFilterKeyService" );
	}

	/**
	 * 获取PolicyService
	 * 
	 * @return PolicyService
	 */
	public static function getPolicyService() {
		return self::getServiceInstance( "PolicyService" );
	}

	/**
	 * 获取LoginRestrictService
	 * 
	 * @return LoginRestrictService
	 */
	public static function getLoginRestrictService() {
		return self::getServiceInstance( "LoginRestrictService" );
	}

	/**
	 * 获取AdRightService
	 * 
	 * @return AdRightService
	 */
	public static function getAdRightService() {
		return self::getServiceInstance( "AdRightService" );
	}

	/**
	 * 获取MigrateIdMapService
	 * 
	 * @return MigrateIdMapService
	 */
	public static function getMigrateIdMapService() {
		return self::getServiceInstance( "MigrateIdMapService" );
	}

	/**
	 * 获取AddressGroupMemberService
	 * 
	 * @return AddressGroupMemberService
	 */
	public static function getAddressGroupMemberService() {
		return self::getServiceInstance( "AddressGroupMemberService" );
	}

	/**
	 * 获取UserWbListService
	 * 
	 * @return UserWbListService
	 */
	public static function getUserWbListService() {
		return self::getServiceInstance( "UserWbListService" );
	}

	/**
	 * 获取SmsMemberService
	 * 
	 * @return SmsMemberService
	 */
	public static function getSmsMemberService() {
		return self::getServiceInstance( "SmsMemberService" );
	}

	/**
	 * 获取AuditService
	 * 
	 * @return AuditService
	 */
	public static function getAuditService() {
		return self::getServiceInstance( "AuditService" );
	}

	/**
	 * 获取MailboxInfoService
	 * 
	 * @return MailboxInfoService
	 */
	public static function getMailboxInfoService() {
		return self::getServiceInstance( "MailboxInfoService" );
	}

	/**
	 * 获取MailMonitorService
	 * 
	 * @return MailMonitorService
	 */
	public static function getMailMonitorService() {
		return self::getServiceInstance( "MailMonitorService" );
	}

	/**
	 * 获取LoginLogService
	 * 
	 * @return LoginLogService
	 */
	public static function getLoginLogService() {
		return self::getServiceInstance( "LoginLogService" );
	}

	/**
	 * 获取SelfLetterService
	 * 
	 * @return SelfLetterService
	 */
	public static function getSelfLetterService() {
		return self::getServiceInstance( "SelfLetterService" );
	}

	/**
	 * 获取PopCollectionService
	 * 
	 * @return PopCollectionService
	 */
	public static function getPopCollectionService() {
		return self::getServiceInstance( "PopCollectionService" );
	}

	/**
	 * 获取PopCollectionLogService
	 * 
	 * @return PopCollectionLogService
	 */
	public static function getPopCollectionLogService() {
		return self::getServiceInstance( "PopCollectionLogService" );
	}

	/**
	 * 获取FilterService
	 * 
	 * @return FilterService
	 */
	public static function getFilterService() {
		return self::getServiceInstance( "FilterService" );
	}

	/**
	 * 获取FilterKeyService
	 * 
	 * @return FilterKeyService
	 */
	public static function getFilterKeyService() {
		return self::getServiceInstance( "FilterKeyService" );
	}

	/**
	 * 获取TransceiverLimitService
	 * 
	 * @return TransceiverLimitService
	 */
	public static function getTransceiverLimitService() {
		return self::getServiceInstance( "TransceiverLimitService" );
	}

	/**
	 * 获取JobArrangementService
	 * 
	 * @return JobArrangementService
	 */
	public static function getJobArrangementService() {
		return self::getServiceInstance( "JobArrangementService" );
	}

	/**
	 * 获取MailboxSignService
	 * 
	 * @return MailboxSignService
	 */
	public static function getMailboxSignService() {
		return self::getServiceInstance( "MailboxSignService" );
	}

	/**
	 * 获取PostofficeSignService
	 * 
	 * @return PostofficeSignService
	 */
	public static function getPostofficeSignService() {
		return self::getServiceInstance( "PostofficeSignService" );
	}

	/**
	 * 获取UsedMailService
	 * 
	 * @return UsedMailService
	 */
	public static function getUsedMailService() {
		return self::getServiceInstance( "UsedMailService" );
	}

	/**
	 * 获取FavoriteService
	 * 
	 * @return FavoriteService
	 */
	public static function getFavoriteService() {
		return self::getServiceInstance( "FavoriteService" );
	}

	/**
	 * 获取OpenApiService
	 * 
	 * @return OpenApiService
	 */
	public static function getOpenApiService() {
		return self::getServiceInstance( "OpenApiService" );
	}

	/**
	 * 获取UserVisitService
	 * 
	 * @return UserVisitService
	 */
	public static function getUserVisitService() {
		return self::getServiceInstance( 'UserVisitService' );
	}

	/**
	 * ******************imapmove邮件搬家系统service start**
	 */
	/**
	 * 获取ImapMoveDomainInfoService
	 * 
	 * @return ImapMoveDomainInfoService
	 */
	public static function getImapMoveDomainInfoService() {
		return self::getServiceInstance( 'ImapMoveDomainInfoService' );
	}

	/**
	 * 获取ImapMoveErrorLogService
	 * 
	 * @return ImapMoveErrorLogService
	 */
	public static function getImapMoveErrorLogService() {
		return self::getServiceInstance( 'ImapMoveErrorLogService' );
	}

	/**
	 * 获取ImapMoveMailboxMoveService
	 * 
	 * @return ImapMoveMailboxMoveService
	 */
	public static function getImapMoveMailboxMoveService() {
		return self::getServiceInstance( 'ImapMoveMailboxMoveService' );
	}

	/**
	 * 获取ImapMoveSystemConfigService
	 * 
	 * @return ImapMoveSystemConfigService
	 */
	public static function getImapMoveSystemConfigService() {
		return self::getServiceInstance( 'ImapMoveSystemConfigService' );
	}

	/**
	 * 获取ImapMoveUserService
	 * 
	 * @return ImapMoveUserService
	 */
	public static function getImapMoveUserService() {
		return self::getServiceInstance( 'ImapMoveUserService' );
	}

	/**
	 * 获取SmsSendService
	 * 
	 * @return SmsSendService
	 */
	public static function getSmsSendService() {
		return self::getServiceInstance( 'SmsSendService' );
	}
        
        /**
         * ******************  qing  **********************
         */
        /**
         * Pay service
         * @return PayService
         */
        public static function getPayService(){
                return self::getServiceInstance('PayService');
        }
        
        /**
         * IssueDemo Service
         * @return IssueDemoService
         */
        public static function getIssueDemoService(){
                return self::getServiceInstance('IssueDemoService');
        }
        
        /**
         * ImageDemo Service
         * @return ImageDemoService
         */
        public static function getImageDemoService(){
                return self::getServiceInstance('ImageDemoService');
        }

	
	// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	
	/**
	 * 保存service的静态数组
	 * 
	 * @var array
	 */
	private static $services = array ();

	/**
	 * 获取相应类名的service实例，如果没有实例化，则实例化并保存在静态数组中
	 * 
	 * @param $className string 类名
	 * @return ActionService
	 */
	private static function getServiceInstance($className) {
		if (! isset( self::$services [$className] )) {
			include_once FrameworkUtils::getServicePath() . "/" . $className . ".php";
			if (Config::DATABASE_TRANSACTION_SUPPORT) {
				self::$services [$className] = new BaseAOP( new $className() );
			} else {
				self::$services [$className] = new $className();
			}
		}
		return self::$services [$className];
	}

	/**
	 * 处理数据库连接的事务状态
	 */
	public static function handleConnectionTransactionState($connection) {
		if (BaseAOP::$_isTransactionSupported) {
			TransactionManager::begin( $connection, BaseAOP::getTransactionUID() );
		}
	}
}

/**
 * BaseAOP
 * 
 * @author cqy
 */
class BaseAOP {

	/**
	 * service实例
	 * 
	 * @var ActionService
	 */
	private $_instance;

	/**
	 * 事务配置信息，getTransactionMethods返回的数组
	 * 
	 * @var array
	 */
	private $_config = array ();

	/**
	 * XA事务标识符
	 * 
	 * @var string
	 */
	private static $_transactionUID = 0;

	/**
	 * 主要用于标识嵌套方法的外层，为0表示外层方法
	 * 
	 * @var int
	 */
	private static $_methodStackCount = 0;

	/**
	 * 标识最外层函数是否被调用
	 * 
	 * @var boolean
	 */
	private static $_isOutMethodInvoked = false;

	/**
	 * 是否支持事务
	 * 
	 * @var boolean
	 */
	public static $_isTransactionSupported = false;

	/**
	 * 构造函数
	 * 
	 * @param $instance ActionService
	 */
	public function __construct($instance) {
		$this->_instance = $instance;
	}

	/**
	 * 获取XA事务标识符
	 * 
	 * @return string
	 */
	public static function getTransactionUID() {
		return self::$_transactionUID;
	}

	/**
	 * 如果支持事务，则提交事务。重置静态成员数据
	 */
	public function commitTransaction() {
		if (self::$_isOutMethodInvoked && self::isOuterMethod()) {
			if (self::$_isTransactionSupported) {
				foreach ( ConnectionFactory::getUsedConnections() as $connection ) {
					TransactionManager::commit( $connection, self::$_transactionUID );
				}
			}
			$this->resetStaticVar();
		}
	}

	/**
	 * 如果支持事务，则回滚事务。重置静态成员数据
	 */
	public function rollbackTransaction() {
		if (self::$_isOutMethodInvoked && self::isOuterMethod()) {
			if (self::$_isTransactionSupported) {
				foreach ( ConnectionFactory::getUsedConnections() as $connection ) {
					TransactionManager::rollback( $connection, self::$_transactionUID );
				}
			}
			$this->resetStaticVar();
		}
	
	}

	/**
	 * 判断当前方式是否为最外层方法
	 */
	private static function isOuterMethod() {
		return self::$_methodStackCount == 0;
	}

	/**
	 * 重置静态成员数据
	 */
	private function resetStaticVar() {
		self::$_transactionUID = 0;
		self::$_isOutMethodInvoked = false;
		self::$_isTransactionSupported = false;
		
		ConnectionFactory::resetConnectionState();
	}

	/**
	 * 调用不存在方法时，调用service实例的该方法，主要通过这个方法实现AOP功能
	 * 
	 * @param $method string
	 * @param $argument array
	 * @return boolean
	 * @throws Exception
	 */
	function __call($method, $argument) {
		self::$_methodStackCount ++;
		
		if (self::$_isOutMethodInvoked == false) {
			/*
			 * 在service方法调用前，重置所有链接使用状态，防止由于service外方法获取链接导致的事务控制错误问题
			 */
			ConnectionFactory::resetConnectionState();
			
			self::$_isOutMethodInvoked = true;
			$this->_config = call_user_func_array( array ($this->_instance, 'getTransactionMethods' ), array () );
			self::$_isTransactionSupported = in_array( $method, $this->_config );
			if (self::$_isTransactionSupported && ! self::$_transactionUID) {
				self::$_transactionUID = uniqid();
			}
		}
		try {
			$return = call_user_func_array( array ($this->_instance, $method ), $argument );
			self::$_methodStackCount --;
			$this->commitTransaction();
		} catch ( Exception $e ) {
			self::$_methodStackCount --;
			$this->rollbackTransaction();
			if ($e instanceof ServiceException) {
				throw $e;
			} else {
				throw new ServiceException( ServiceCode::COMMON_UNKNOWN_EXCEPTION, array ("{0}" => $e->getMessage() ) );
			}
		}
		return $return;
	}
}

/**
 * 事务管理器, 统一采用分布式事务的方式
 * 
 * @author cqy
 */
class TransactionManager {

	/**
	 * 开始事务
	 * 
	 * @param $connection CDbConnection 连接
	 * @param $uniqueId string XA事务标识符
	 */
	public static function begin($connection, $uniqueId) {
		$connection->createCommand( "XA START '$uniqueId'" )->execute();
	}

	/**
	 * 提交事务
	 * 
	 * @param $connection CDbConnection 连接
	 * @param $uniqueId string XA事务标识符
	 */
	public static function commit($connection, $uniqueId) {
		$connection->createCommand( "XA END '$uniqueId'" )->execute();
		$connection->createCommand( "XA PREPARE '$uniqueId'" )->execute();
		$connection->createCommand( "XA COMMIT '$uniqueId'" )->execute();
	}

	/**
	 * 回滚事务
	 * 
	 * @param $connection CDbConnection 连接
	 * @param $uniqueId string XA事务标识符
	 */
	public static function rollback($connection, $uniqueId) {
		$connection->createCommand( "XA END '$uniqueId'" )->execute();
		$connection->createCommand( "XA PREPARE '$uniqueId'" )->execute();
		$connection->createCommand( "XA ROLLBACK '$uniqueId'" )->execute();
	}
}
