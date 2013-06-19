<?php

/**
 * sys端白名单
 * 
 * @author dengr
 */
class WhitelistController extends SysController {

	/**
	 * 白名单列表
	 */
	public function index() {
            /**
		$bwListService = ServiceFactory::getBWListService();
		$list = $bwListService->getAllWhitelists();
		
		$template = new TemplateEngine();
		$template->assign( 'infos', $list );
             * 
             */
		$template = new TemplateEngine();
		$template->display( 'whitelist_index.tpl' );
	}

	/**
	 * 转到增加白名单页面
	 */
	public function toAdd() {
		$template = new TemplateEngine();
		$template->display( 'whitelist_add.tpl' );
	}

	/**
	 * 增加白名单
	 */
	public function add() {
		$filterMode = $this->getParamFromRequest( "filtermode", 0 );
		$email = trim( strtolower( $this->getParamFromRequest( "domainname" ) ) );
		
		$forwardUrl = $this->createUrl( 'toAdd', array ('domain' => urlencode( $email ), 'check' => $filterMode ) );
		
		if (! $email) {
			$this->showErrorMessage( $this->getText( 'whitelist_cannot_be_null' ), $forwardUrl );
		}
		if (substr_count( $email, '@' ) > 1) {
			$this->showErrorMessage( $this->getText( 'whitelist_name_invalid' ), $forwardUrl );
		}
		if ($filterMode) {
			if (strpos( $email, '.' ) === 0 || strpos( $email, '.' ) === strlen( $email ) - 1 || (strpos( $email, '@' ) === 0 && strpos( $email, '.' ) === 1)) {
				$this->showErrorMessage( $this->getText( 'whitelist_name_invalid' ), $forwardUrl );
			}
			$emailname = PunyCode::encode( $email );
		} else {
			$emailname = str_replace( '.', '#', $email );
			$emailname = PunyCode::encode( $emailname );
			$emailname = str_replace( '#', '.', $email );
		}
		
		$bwListService = ServiceFactory::getBWListService();
		if ($bwListService->getWhitelist( $emailname )) {
			$this->showErrorMessage( "[$email] " . $this->getText( 'whitelist_exists' ), $forwardUrl );
		}
		if ($bwListService->getBlacklist( $emailname )) {
			$this->showErrorMessage( "[$email] " . $this->getText( 'whitelist_bl_exists' ), $forwardUrl );
		}
		
		try {
			$bwListService->saveWhitelist( $emailname, $filterMode );
			SysLogger::log( "增加过滤白名单 $email" );
			$msg = $this->getText( 'whitelist_add' ) . "[$email]" . $this->getText( 'whitelist_success' ) . "\n" . $this->getText( 'whitelist_add_remark' );
		} catch ( Exception $e ) {
			$msg = $this->getText( 'operate_fail' );
		}
		$this->showErrorMessage( $msg, $this->createUrl( 'index' ) );
	}

	/**
	 * 删除白名单
	 */
	public function delete() {
		$forwardUrl = $this->createUrl( 'index' );
		if (! $this->getParamFromRequest( "checkboxID" )) {
			$this->showErrorMessage( $this->getText( 'whitelist_choose_to_delete' ), $forwardUrl );
		}
		$checkboxID = $this->getParamFromRequest( "checkboxID" );
		if ($checkboxID [0] == - 1) {
			$this->showErrorMessage( $this->getText( 'whitelist_blank' ), $forwardUrl );
		}
		
		$bwListService = ServiceFactory::getBWListService();
		$senders = $bwListService->getSenderAddrByIds( $checkboxID );
		try {
			$bwListService->deleteLists( $checkboxID );
			foreach ( $senders as $sender ) {
				$sender = $sender ['senderaddr'];
				SysLogger::log( "删除过滤白名单 $sender" );
			}
			$msg = $this->getText( 'whitelist_del_success' ) . "\n" . $this->getText( 'whitelist_del_remark' );
		} catch ( Exception $e ) {
			$msg = $this->getText( 'operate_fail' );
		}
		$this->showErrorMessage( $msg, $forwardUrl );
	}
}