<?php
/**
 * sys端登录控制器
 * 
 * @author jm
 */
class SiteController extends SysController {

	/**
	 * 跳转登录页面
	 */
	public function index() {
		$language = $this->getParamFromRequest( "language" );
		if (! $language) { // 不为下拉框选择语言版本
			$language = SessionUtils::getLanguageType();
			if (! $language) { // session无语言版本信息、从cookie获取
				$language = SysCookieUtil::getLanguageCookie();
				if (! $language) { // cookie中无语言版本信息，直接获取用户浏览器语言版本
					$language = I18nHelper::getLanguageByBrowser();
				}
			}
		}
		
		SessionUtils::setLanguageType( $language );
		SysCookieUtil::setLanguageCookie( $language );
		
		$template = new TemplateEngine();
		$template->assign( "language", $language );
		$template->assign( "username", $this->getParamFromRequest( "username", "" ) );
		$template->assign( "options", I18nHelper::$LANGUAGE_ARRAY );
		$template->assign( "show_authcode", $this->IsShowAuthcode() );
		$template->display( "sys_login.tpl" );
	}

	/**
	 * 修改语言版本
	 */
	public function changeLanguage() {
		$language = $this->getParamFromRequest( "language", I18nHelper::DEFALUT_LANGUAGE );
		SessionUtils::setLanguageType( $language );
		SysCookieUtil::setLanguageCookie( $language );
		$this->redirect( array ("main" ) );
	}

	/**
	 * 登录操作
	 */
	public function login() {
		$username = strtolower( trim( $this->getParamFromRequest( "username", "" ) ) );
		$password = $this->getParamFromRequest( "secretkey" );
		$authcode = $this->getParamFromRequest( "authcode" );
		
		if ($this->IsShowAuthcode() && ! SysAuthCode::checkAuthCode( $authcode )) {
			$this->showErrorMessage( $this->getText( "site_error_authcode" ), $this->createUrl( "index", array (
					"username" => $username ) ) );
		}
		
		$admin = ServiceFactory::getAdminService()->getAdminByName( $username );
		if ($admin && strcmp( $password, $admin->pwd ) == 0) {
			SysSessionUtil::setSysLoginUser( $this->initUserInfo( $admin ) );
			SysSessionUtil::removeSysLoginNum();
			Yii::log( "用户：" . $username . "登录成功" );
			$this->redirect( array ("main" ) );
		} else {
			$this->addSysLoginNum();
			$this->showErrorMessage( $this->getText( "site_error_userpsw" ), $this->createUrl( "index", array (
					"username" => $username ) ) );
		}
	}

	/**
	 * 跳转至主页面
	 */
	public function main() {
            print_r(SysSessionUtil::getSysLoginUser());exit;
		$template = new TemplateEngine( null, true );
		$template->assign( "username", SysSessionUtil::getSysLoginUser()->getUsername() );
		$template->assign( "language", SysSessionUtil::getLanguageType() );
		$template->assign( "options", I18nHelper::$LANGUAGE_ARRAY );
		$template->display( "sys_main.tpl" );
	}

	/**
	 * 登出
	 */
	public function logout() {
		SysSessionUtil::removeSysLoginUser();
		SessionUtils::removePageQueryInfo();
		$this->redirect( $this->createUrl( "index" ) );
	}

	/**
	 * 获取验证码
	 */
	public function getAuthCode() {
		echo SysAuthCode::drawAuthCode();
	}

	/**
	 * 初始化用户信息
	 * 
	 * @param $admin model
	 */
	private function initUserInfo($admin) {
		$userinfo = new SysLoginUser();
		$userinfo->setId( $admin ['id'] );
		$userinfo->setUsername( $admin ['name'] );
		$userinfo->setRights( str_split( $admin ["right_id"] ) );
		return $userinfo;
	}

	/**
	 * 是否显示验证码
	 */
	private function IsShowAuthcode() {
		return SysSessionUtil::getSysLoginNum() && SysSessionUtil::getSysLoginNum() >= Constants::SHOW_AUTHCODE_NUM ? 1 : 0;
	}

	/**
	 * 增加session缓存中登录次数
	 */
	private function addSysLoginNum() {
		$num = SysSessionUtil::getSysLoginNum();
		if ($num === null) {
			$num = 0;
		}
		SysSessionUtil::setSysLoginNum( ++ $num );
	}
}
