<?php

/**
 * 权限校验配置,所有允许前台调用的public方法,需要在此进行配置后方能正常访问.
 * 
 * @author jm
 */
class SysRightsConfig {

	/**
	 * 用户不需要登录就可访问的功能
	 */
	const NO_ACCESS = - 2;

	/**
	 * 用户登录后不需要赋权限就可以访问的功能
	 */
	const LOGIN_ACCESS = - 1;

	/**
	 * 统计分析功能
	 */
	const STATISTIC_ANALYSIS = 0;

	/**
	 * 邮局增加
	 */
	const POST_ADD = 2;

	/**
	 * 邮局删除
	 */
	const POST_DELETE = 3;

	/**
	 * 邮局修改
	 */
	const POST_EDIT = 4;

	/**
	 * 模拟登录
	 */
	const SIMULANT_LOGIN = 5;

	/**
	 * 服务器管理
	 */
	const SERVER_INFORMATION = 6;

	/**
	 * 登录页面设置
	 */
	const LOGIN_PAGE_SETUP = 7;

	/**
	 * 过滤设置
	 */
	const FILTRATION_SETUP = 8;

	/**
	 * 页面风格设置
	 */
	const PAGES_STYLE_SETTING = 9;

	/**
	 * 用户密码查询
	 */
	const SEARCH_PASSWORD = 10;

	/**
	 * 管理员管理 (该权限为不能在页面上进行分配)
	 */
	const ADMIN_ACCESS_FLAG = 11;

	/**
	 * 日志管理
	 */
	const LOG_MANAGER_ACCESS = 12;

	/**
	 * 广告管理
	 */
	const ADVERTISEMENT_MANAGER_ACCESS = 13;

	/**
	 * 系统配置
	 */
	const SYSTEM_SETUP_ACCESS = 14;

	/**
	 * cdn加速
	 */
	const POST_CDN = 15;

	/**
	 * 邮局参数配置
	 */
	const POST_PARAMETER = 16;

	/**
	 * 获取权限配置
	 */
	public static function getAccessConfig() {
		return array (
			"site" => array (
				"index" => self::NO_ACCESS, 
				"login" => self::NO_ACCESS, 
				"logout" => self::NO_ACCESS, 
				"main" => self::LOGIN_ACCESS, 
				"changeLanguage" => self::NO_ACCESS, 
				"getAuthCode" => self::NO_ACCESS 
			), 
			"admin" => array (
				"index" => self::ADMIN_ACCESS_FLAG, 
				"toAdd" => self::ADMIN_ACCESS_FLAG, 
				"add" => self::ADMIN_ACCESS_FLAG, 
				"toEdit" => self::ADMIN_ACCESS_FLAG, 
				"edit" => self::ADMIN_ACCESS_FLAG, 
				"backToEdit" => self::ADMIN_ACCESS_FLAG, 
				"delete" => self::ADMIN_ACCESS_FLAG, 
				"toAuth" => self::ADMIN_ACCESS_FLAG, 
				"auth" => self::ADMIN_ACCESS_FLAG 
			), 
			'server' => array (
				'index' => self::SERVER_INFORMATION, 
				'serviceDetail' => self::SERVER_INFORMATION, 
				'info' => self::SERVER_INFORMATION, 
				'disk' => self::SERVER_INFORMATION, 
				'diskViewAll' => self::SERVER_INFORMATION, 
				'exportDiskExcel' => self::SERVER_INFORMATION, 
				'mailQueue' => self::SERVER_INFORMATION 
			), 
			'blacklist' => array (
				'index' => self::FILTRATION_SETUP, 
				'add' => self::FILTRATION_SETUP, 
				'create' => self::FILTRATION_SETUP, 
				'delete' => self::FILTRATION_SETUP 
			), 
			'frequency' => array (
				'index' => self::FILTRATION_SETUP, 
				'set' => self::FILTRATION_SETUP 
			), 
			'active' => array (
				'index' => self::STATISTIC_ANALYSIS 
			), 
			'log' => array (
				'sysLog' => self::LOG_MANAGER_ACCESS, 
				'adminLog' => self::LOG_MANAGER_ACCESS, 
				'mailLog' => self::LOG_MANAGER_ACCESS, 
				'delete' => self::LOG_MANAGER_ACCESS, 
				'viewall' => self::LOG_MANAGER_ACCESS 
			), 
			'password' => array (
				'index' => self::LOGIN_ACCESS, 
				'toModify' => self::LOGIN_ACCESS, 
				'modify' => self::LOGIN_ACCESS 
			), 
			'bossmailnotice' => array (
				'index' => self::LOGIN_ACCESS, 
				'send' => self::LOGIN_ACCESS, 
				'toSend' => self::LOGIN_ACCESS 
			), 
			'loginpage' => array (
				'index' => self::LOGIN_PAGE_SETUP, 
				'toEdit' => self::LOGIN_PAGE_SETUP, 
				'edit' => self::LOGIN_PAGE_SETUP, 
				'delete' => self::LOGIN_PAGE_SETUP, 
				'toShow' => self::LOGIN_PAGE_SETUP 
			), 
			'statistics' => array (
				'index' => self::LOGIN_ACCESS, 
				'sendReceiveStat' => self::STATISTIC_ANALYSIS, 
				'exportSendReceiveReport' => self::STATISTIC_ANALYSIS, 
				'checkMailExist' => self::STATISTIC_ANALYSIS, 
				'visitorInfoStat' => self::STATISTIC_ANALYSIS, 
				'exportVisitorInfoReport' => self::STATISTIC_ANALYSIS, 
				'mailsize' => self::STATISTIC_ANALYSIS 
			), 
			'userpassword' => array (
				'index' => self::SEARCH_PASSWORD, 
				'query' => self::SEARCH_PASSWORD 
			), 
			'whitelist' => array (
				'index' => self::FILTRATION_SETUP, 
				'toAdd' => self::FILTRATION_SETUP, 
				'add' => self::FILTRATION_SETUP, 
				'delete' => self::FILTRATION_SETUP 
			), 
			"post" => array (
				"index" => self::LOGIN_ACCESS, 
				"toAdd" => self::POST_ADD, 
				"add" => self::POST_ADD, 
				"backToAdd" => self::POST_ADD, 
				"toUpdate" => self::POST_EDIT, 
				"update" => self::POST_EDIT, 
				"backToUpdate" => self::POST_EDIT, 
				"delete" => self::POST_DELETE, 
				"cdnAccelerateSetting" => self::POST_CDN, 
				"cdnUpdate" => self::POST_CDN, 
				"postParameterSet" => self::POST_PARAMETER, 
				"postParamaterSave" => self::POST_PARAMETER, 
				"mockLogin" => self::SIMULANT_LOGIN 
			), 
			'advertisement' => array (
				'index' => self::ADVERTISEMENT_MANAGER_ACCESS, 
				'toEdit' => self::ADVERTISEMENT_MANAGER_ACCESS, 
				'edit' => self::ADVERTISEMENT_MANAGER_ACCESS, 
				'delete' => self::ADVERTISEMENT_MANAGER_ACCESS 
			), 
			'keywordfilter' => array (
				'index' => self::FILTRATION_SETUP, 
				'toEdit' => self::FILTRATION_SETUP, 
				'edit' => self::FILTRATION_SETUP, 
				'enable' => self::FILTRATION_SETUP, 
				'disable' => self::FILTRATION_SETUP, 
				'delete' => self::FILTRATION_SETUP, 
				'checkNameExist' => self::FILTRATION_SETUP 
			), 
			'pagestyle' => array (
				'index' => self::PAGES_STYLE_SETTING, 
				'toEdit' => self::PAGES_STYLE_SETTING, 
				'edit' => self::PAGES_STYLE_SETTING, 
				'delete' => self::PAGES_STYLE_SETTING, 
				'toShow' => self::PAGES_STYLE_SETTING 
			), 
			'systemsetup' => array (
				'index' => self::PAGES_STYLE_SETTING, 
				'toServerFunctionSetup' => self::SYSTEM_SETUP_ACCESS, 
				'serverFunctionSetup' => self::SYSTEM_SETUP_ACCESS, 
				'toPostTypeSetup' => self::SYSTEM_SETUP_ACCESS, 
				'postTypeSetup' => self::SYSTEM_SETUP_ACCESS 
			) 
		);
	}
}