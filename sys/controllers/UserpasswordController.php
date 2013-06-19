<?php

/**
 * 用户密码查询
 * 
 * @author cqj
 */
class UserpasswordController extends SysController {

	/**
	 * 显示查询页面
	 */
	public function index() {
		$tpl = new TemplateEngine();
		$tpl->assign( 'username', '' );
		$tpl->assign( 'password', '' );
		$tpl->display( 'userpassword_index.tpl' );
	}

	/**
	 * 查询用户密码
	 */
	public function query() {
		$origUsername = $this->getParamFromRequest( 'trantext' );
		SysLogger::log( "查询邮箱用户" . $origUsername . "密码" );
		$username = PunyCode::encode( $origUsername );
		$mailboxService = ServiceFactory::getMailboxService();
		$oneRecord = $mailboxService->getMailboxByUsername( $username, 'mb_pwd' );
		if (! $oneRecord) {
			$mailAliasService = ServiceFactory::getMailAliasService();
			$username = $mailAliasService->getMailboxByAlias( $origUsername );
			$oneRecord = $mailboxService->getMailboxByUsername( $username, 'mb_pwd' );
			if (! $oneRecord) {
				$this->showErrorMessage( $this->getText( 'userPassword_search_fail' ), $this->createUrl( 'index' ) );
			}
		}
		$password = StringUtils::passwordDecode( $oneRecord ['mb_pwd'] );
		$tpl = new TemplateEngine();
		$tpl->assign( 'username', $origUsername );
		$tpl->assign( 'password', $password );
		$tpl->display( 'userpassword_index.tpl' );
	}
}
