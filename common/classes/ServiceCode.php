<?php

/**
 * Service类在抛出异常的时候，使用code方式返回，定义的code请在此处定义。
 * 定义的规则如下：
 * 1） 对应于Service类的前缀方式命令，如MailboxService请使用Mailbox前缀,多个单词使用横线分割
 * 2) Service与Service定义之前使用分隔符隔开，并添加注释。
 * 3) Code使用有意义的字符组成，不允许使用数字,避免service抛出code重复的问题.
 * 
 * @author zcs
 */
class ServiceCode {
	// //////////////SysSettigService编码定义/////////////////
	/**
	 * 系统设置刷新缓存失败
	 */
	const RSYNC_SYS_SETTING_CACHE_FRESH_FAILED = "rsync_sys_setting_cache_fresh_failed";

	/**
	 * 修改系统配置数据失败
	 */
	const RSYNC_SYS_SETTING_SETUP_FAILED = "rsync_sys_setting_setup_failed";

	/**
	 * 同步传真配置失败
	 */
	const RSYNC_SYS_SETTING_FAX_RSYNC_FAILED = "rsync_sys_setting_fax_rsync_failed";

	/**
	 * 同步在线服务失败
	 */
	const RSYNC_SYS_SETTING_ONLINE_SERVICE_RSYNC_FAILED = "rsync_sys_setting_online_service_rsync_failed";

	/**
	 * 同步smtp配置失败
	 */
	const RSYNC_SYS_SETTING_SMTP_RSYNC_FAILED = "rsync_sys_setting_smtp_rsync_failed";

	/**
	 * 修改邮局类型失败
	 */
	const RSYNC_SYS_SETTING_POST_TYPE_SETUP_FAILED = "rsync_sys_setting_post_type_modify_failed";

	/**
	 * 修改邮局类型参数失败
	 */
	const RSYNC_SYS_SETTING_POST_TYPE_PARAMETER_IS_EMTPY = "rsync_sys_setting_post_type_parameter_is_emtpy";

	/**
	 * 连接系统设置同步服务器数据库失败
	 */
	const RSYNC_SYS_SETTING_RSYNC_DATABASE_CONNECT_FAILED = "rsync_sys_setting_rsync_database_connect_failed";

	/**
	 * 获取同步服务器数据库的系统配置失败
	 */
	const RSYNC_SYS_SETTING_GET_RSYNC_SYS_SETTING_FAILED = "rsync_sys_setting_get_rsync_sys_setting_failed";

	/**
	 * 添加ironport 队列失败
	 */
	const SET_IRONPORT_FAIL = "set_ironport_fail";

	/**
	 * 通用同步失败提示
	 */
	const RSYNC_FAIL = 'rsync_fail';

	/**
	 * 文件正在归档提示
	 */
	const FILE_ON_ARCHIVING = "file_on_archiving";

	/**
	 * 集团邮日期错误提示
	 */
	const GROUP_MAIL_DATE_ERROR = "group_mail_date_error";

	/**
	 * 邮箱密码修改失败
	 */
	const MAILBOX_PASSWORD_MODIFY_FAILED = "mailbox_password_modify_failed";

	/**
	 * 邮局密码修改失败
	 */
	const POST_PASSWORD_MODIFY_FAILED = "post_password_modify_failed";

	/**
	 * 非配置类异常,非人为抛出的异常
	 */
	const COMMON_UNKNOWN_EXCEPTION = "common_unknown_exception";

	/**
	 * 同步Bossmail消息服务器，socket连接失败
	 */
	const SOCKET_CONNECT_FAILED = "socket_connect_failed";
	
	/**
	 *  要更换的旧域名不存在于同步服务器
	 */
	const OLD_DOMAIN_NOT_EXISTS_ON_RSYNC = "old_domain_not_exists_on_rsync";
	
	/**
	 * 要更换的新域名已存在于同步服务器 
	 */
	const NEW_DOMAIN_IS_EXISTS_ON_RSYNC = "new_domain_is_exists_on_rsync";
	
	/**
	 * 已存在相同名字的文件夹 
	 */
	const NETDISK_FOLDER_ALREADY_EXISTS = "netdisk_folder_already_exists";
	
	/**
	 * 不能删除非空文件夹
	 */
	const CAN_NOT_DELETE_NOT_EMPTY_FOLDER = "can_not_delete_not_empty_folder";
	
	/**
	 * 白名单最大数目为n
	 */
	const MAILBOX_WHITELIST_MAX = "mailbox_whitelist_max_num";
	
	/**
	 * 黑名单最大数目为n
	 */
	const MAILBOX_BLACKLIST_MAX = "mailbox_blacklist_max_num";
	
	/**
	 * 白名单存在该名单 
	 */
	const MAILBOX_WHITELIST_EXISTS = "mailbox_whitelist_exists";
	
	/**
	 * 黑名单存在该名单 
	 */
	const MAILBOX_BLACKLIST_EXISTS = "mailbox_blacklist_exists";
	
	// //////////////国际化配置//////////////////////////////////////
	static $_LANGUAGE_ARRAY = array (
			self::COMMON_UNKNOWN_EXCEPTION => array (
					I18nHelper::LANGUAGE_CN => "操作失败 [{0}]", 
					I18nHelper::LANGUAGE_EN => "operation failed [{0}]", 
					I18nHelper::LANGUAGE_TW => "操作失敗 [{0}]" ), 
			self::RSYNC_SYS_SETTING_CACHE_FRESH_FAILED => array (
					I18nHelper::LANGUAGE_CN => "更新系统配置缓存失败\n系统功能设置失败，请重新设置", 
					I18nHelper::LANGUAGE_EN => "Fresh the system configuration cache failed <br /> System setup failed, please reset", 
					I18nHelper::LANGUAGE_TW => "更新系統配置緩存失敗\n系統功能設置失敗，請重新設置" ), 
			self::RSYNC_SYS_SETTING_SETUP_FAILED => array (
					I18nHelper::LANGUAGE_CN => "设置失败", 
					I18nHelper::LANGUAGE_EN => "Setup failed", 
					I18nHelper::LANGUAGE_TW => "設置失敗" ), 
			self::RSYNC_SYS_SETTING_FAX_RSYNC_FAILED => array (
					I18nHelper::LANGUAGE_CN => "传真设置同步失败\n系统功能设置失败，请重新设置置", 
					I18nHelper::LANGUAGE_EN => "Rsync fax failed \n System setup failed, please reset", 
					I18nHelper::LANGUAGE_TW => "傳真設置同步失敗\n系統功能設置失敗，請重新設置" ), 
			self::RSYNC_SYS_SETTING_ONLINE_SERVICE_RSYNC_FAILED => array (
					I18nHelper::LANGUAGE_CN => "在线客服同步失败\n系统功能设置失败，请重新设置", 
					I18nHelper::LANGUAGE_EN => "Rsync online failed \n System setup failed, please reset", 
					I18nHelper::LANGUAGE_TW => "在線客服同步失敗\n系統功能設置失敗，請重新設置" ), 
			self::RSYNC_SYS_SETTING_SMTP_RSYNC_FAILED => array (
					I18nHelper::LANGUAGE_CN => "smtp设置同步失败\n系统功能设置失败，请重新设置", 
					I18nHelper::LANGUAGE_EN => "Rsync smtp setting failed \n System setup failed, please reset", 
					I18nHelper::LANGUAGE_TW => "smtp設置同步失敗\n系統功能設置失敗，請重新設置" ), 
			self::RSYNC_SYS_SETTING_POST_TYPE_SETUP_FAILED => array (
					I18nHelper::LANGUAGE_CN => "邮局类型设置失败", 
					I18nHelper::LANGUAGE_EN => "Setup post type failed", 
					I18nHelper::LANGUAGE_TW => "郵局類型設置失敗" ), 
			self::RSYNC_SYS_SETTING_POST_TYPE_PARAMETER_IS_EMTPY => array (
					I18nHelper::LANGUAGE_CN => "邮局类型不能为空\n 请重新设置", 
					I18nHelper::LANGUAGE_EN => "Post type can not be empty<br /> Please reset", 
					I18nHelper::LANGUAGE_TW => "郵局類型不能為空\n 請重新設置" ), 
			self::RSYNC_SYS_SETTING_RSYNC_DATABASE_CONNECT_FAILED => array (
					I18nHelper::LANGUAGE_CN => "链接同步服务器数据库失败\n系统功能设置失败，请重新设置", 
					I18nHelper::LANGUAGE_EN => "Connect rsync server database failed \n System setup failed, please reset", 
					I18nHelper::LANGUAGE_TW => "鏈接同步服務器數據庫失敗\n系統功能設置失敗，請重新設置" ), 
			self::RSYNC_SYS_SETTING_GET_RSYNC_SYS_SETTING_FAILED => array (
					I18nHelper::LANGUAGE_CN => "获取同步服务器系统配置失败\n系统功能设置失败，请重新设置", 
					I18nHelper::LANGUAGE_EN => "Get rsync server system setting failed \n System setup failed, please reset", 
					I18nHelper::LANGUAGE_TW => "獲取同步服務器系統配置失敗\n系統功能設置失敗，請重新設置" ), 
			self::SET_IRONPORT_FAIL => array (
					I18nHelper::LANGUAGE_CN => "31", 
					I18nHelper::LANGUAGE_EN => "31", 
					I18nHelper::LANGUAGE_TW => "31" ), 
			self::RSYNC_FAIL => array (
					I18nHelper::LANGUAGE_CN => "数据同步失败，请与管理员联系", 
					I18nHelper::LANGUAGE_EN => "Data synchronization failure, please contact the administrators", 
					I18nHelper::LANGUAGE_TW => "數據同步失敗，請與管理員聯繫" ), 
			self::FILE_ON_ARCHIVING => array (
					I18nHelper::LANGUAGE_CN => "系统正在执行归档，无法删除，请稍侯再试", 
					I18nHelper::LANGUAGE_EN => "You cannot delete the mail for the system is archiving now, please try later", 
					I18nHelper::LANGUAGE_TW => "系統正在執行歸檔，無法刪除，請稍後再試" ), 
			self::GROUP_MAIL_DATE_ERROR => array (
					I18nHelper::LANGUAGE_CN => "非法系统时间或邮件系统已过期", 
					I18nHelper::LANGUAGE_EN => "Invalid system time or your email system is timeout", 
					I18nHelper::LANGUAGE_TW => "非法系統時間或郵件系統已過期" ), 
			self::MAILBOX_PASSWORD_MODIFY_FAILED => array (
					I18nHelper::LANGUAGE_CN => "邮箱密码修改失败", 
					I18nHelper::LANGUAGE_EN => "Mailbox password modify failed", 
					I18nHelper::LANGUAGE_TW => "郵箱密碼修改失敗" ), 
			self::POST_PASSWORD_MODIFY_FAILED => array (
					I18nHelper::LANGUAGE_CN => "邮局密码修改失败", 
					I18nHelper::LANGUAGE_EN => "Post password modify failed", 
					I18nHelper::LANGUAGE_TW => "郵局密碼修改失敗" ), 
			self::SOCKET_CONNECT_FAILED => array (
					I18nHelper::LANGUAGE_CN => "Socket连接失败", 
					I18nHelper::LANGUAGE_EN => "Socket connect failed", 
					I18nHelper::LANGUAGE_TW => "Socket連接失敗" ),
			self::OLD_DOMAIN_NOT_EXISTS_ON_RSYNC=>array(
					I18nHelper::LANGUAGE_CN =>"要更换的旧域名不存在于同步服务器",
					I18nHelper::LANGUAGE_EN =>"old domain is not exists on rsync server",
					I18nHelper::LANGUAGE_TW =>"要更換的舊域名不存在於同步服務器",
				),
			self::NEW_DOMAIN_IS_EXISTS_ON_RSYNC=>array(
					I18nHelper::LANGUAGE_CN=>'要更换的新域名已存在于同步服务器',
					I18nHelper::LANGUAGE_EN=>'new domain is exists on rsync server',
					I18nHelper::LANGUAGE_TW=>'要更換的新域名已存在於同步服務器',
				),
		         self::NETDISK_FOLDER_ALREADY_EXISTS=>array(
					I18nHelper::LANGUAGE_CN=>'已存在相同名字的文件夹',
					I18nHelper::LANGUAGE_EN=>'Already exists the same name folder',
					I18nHelper::LANGUAGE_TW=>'已存在相同名字的文件夾',
				 ),
			  self::CAN_NOT_DELETE_NOT_EMPTY_FOLDER=>array(
					I18nHelper::LANGUAGE_CN=>'不能删除非空文件夹',
					I18nHelper::LANGUAGE_EN=>'Can not delete non-empty folder',
					I18nHelper::LANGUAGE_TW=>'不能刪除非空文件夾',
				 ),
			  self::MAILBOX_WHITELIST_MAX=>array(
					I18nHelper::LANGUAGE_CN=>'白名单最大数目为',
					I18nHelper::LANGUAGE_EN=>'maximum number of whitelist is ',
					I18nHelper::LANGUAGE_TW=>'白名單最大數目為',
				 ),
			  self::MAILBOX_BLACKLIST_MAX=>array(
					I18nHelper::LANGUAGE_CN=>'黑名单最大数目为',
					I18nHelper::LANGUAGE_EN=>'maximum number of blacklist is ',
					I18nHelper::LANGUAGE_TW=>'黑名單最大數目為',
				 ),
			  self::MAILBOX_WHITELIST_EXISTS=>array(
					I18nHelper::LANGUAGE_CN=>'白名单存在该名单',
					I18nHelper::LANGUAGE_EN=>'whitelist has the list',
					I18nHelper::LANGUAGE_TW=>'白名單存在該名單',
				 ),
			  self::MAILBOX_BLACKLIST_EXISTS=>array(
					I18nHelper::LANGUAGE_CN=>'黑名单存在该名单',
					I18nHelper::LANGUAGE_EN=>'blacklist has the list',
					I18nHelper::LANGUAGE_TW=>'黑名單存在該名單',
				 ),
			);
}

