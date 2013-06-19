<?php

/**
 * sys端黑名单
 * 
 * @author jm
 */
class BlacklistController extends SysController {

	/**
	 * 黑名单列表
	 */
	public function index() {
            /**
		$bwListService = ServiceFactory::getBWListService();
		$list = $bwListService->getAllBlacklists();
             * 
             */
		
		$template = new TemplateEngine();
//		$template->assign( 'infos', $list );
		$template->display( 'blacklist_index.tpl' );
	}

	/**
	 * 增加黑名单显示页面
	 */
	public function add() {
		$template = new TemplateEngine();
		$template->display( 'blacklist_add.tpl' );
	}

	/**
	 * 增加黑名单
	 */
	public function create() {
		$blacklistUrl = $this->createUrl( 'index' );
		
		$filterMode = $this->getParamFromRequest( 'filtermode' ) ? 1 : 0;
		$email = trim( strtolower( $this->getParamFromRequest( 'domainname' ) ) );
		
		$forwardUrl = $this->createUrl( 'add', array ('domain' => urlencode( $email ), 'check' => $filterMode ) );
		
		$email or $this->showErrorMessage( $this->getText( 'blacklist_cannot_be_null' ), $forwardUrl );
		substr_count( $email, '@' ) > 1 && $this->showErrorMessage( $this->getText( 'blacklist_name_invalid' ), $forwardUrl );
		if ($filterMode) {
			if (strpos( $email, '.' ) === 0 || strpos( $email, '.' ) === strlen( $email ) - 1 || (strpos( $email, '@' ) === 0 && strpos( $email, '.' ) === 1)) {
				$this->showErrorMessage( $this->getText( 'blacklist_name_invalid' ), $forwardUrl );
			}
			$emailname = PunyCode::encode( $email );
		} else {
			$emailname = str_replace( '.', '#', $email );
			$emailname = PunyCode::encode( $emailname );
			$emailname = str_replace( '#', '.', $email );
		}
		
		$bwListService = ServiceFactory::getBWListService();
		$bwListService->getBlacklist( $emailname ) && $this->showErrorMessage( "[$email] " . $this->getText( 'blacklist_exists' ), $forwardUrl );
		$bwListService->getWhitelist( $emailname ) && $this->showErrorMessage( "[$email] " . $this->getText( 'blacklist_wl_exists' ), $forwardUrl );
		
		try {
			$bwListService->saveBlacklist( $emailname, $filterMode );
			SysLogger::log( "增加过滤黑名单 $email" );
			$msg = $this->getText( 'blacklist_add' ) . "[$email]" . $this->getText( 'blacklist_success' ) . "\n" . $this->getText( 'blacklist_add_remark' );
		} catch ( Exception $e ) {
			$msg = $this->getText( 'operate_fail' );
		}
		$this->showErrorMessage( $msg, $blacklistUrl );
	}

	/**
	 * 删除黑名单
	 */
	public function delete() {
		$forwardUrl = $this->createUrl( 'index' );
		
		$checkboxID = $this->getParamFromRequest( 'checkboxID' ) or $this->showErrorMessage( $this->getText( 'blacklist_choose_to_delete' ), $forwardUrl );
		$checkboxID [0] == - 1 && $this->showErrorMessage( $this->getText( 'blacklist_blank' ), $forwardUrl );
		
		$msg = '';
		$bwListService = ServiceFactory::getBWListService();
		$senders = $bwListService->getSenderAddrByIds( $checkboxID );
		try {
			$bwListService->deleteLists( $checkboxID );
			foreach ( $senders as $sender ) {
				$sender = $sender ['senderaddr'];
				SysLogger::log( "删除过滤黑名单 $sender" );
			}
			$msg = $this->getText( 'blacklist_del_success' ) . "\n" . $this->getText( 'blacklist_del_remark' );
		} catch ( Exception $e ) {
			$msg = $this->getText( 'operate_fail' );
		}
		$this->showErrorMessage( $msg, $forwardUrl );
	}

}