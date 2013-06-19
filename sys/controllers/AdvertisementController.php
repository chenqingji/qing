<?php

/**
 * 广告管理类
 * 
 * @author nobody
 */
class AdvertisementController extends SysController {

	/**
	 * 广告名称
	 */
	private $_name = null;

	/**
	 * 广告路径
	 */
	private $_url = null;

	/**
	 * 广告id
	 */
	private $_advertisement_id = null;

	/**
	 * 广告备注
	 */
	private $_note = null;

	/**
	 * 广告ids数组
	 */
	private $_checkboxID = array ();

	/**
	 * 错误信息
	 */
	private $_error_msg = "";

	/**
	 * 列表页面
	 */
	public function index() {
		$advertisements = ServiceFactory::getAdvertisementService()->findAllAdvertisement();
		
		$template = new TemplateEngine();
		$template->assign( "advertisements", $advertisements );
		$template->display( 'advertisement_index.tpl' );
	}

	/**
	 * 跳转编辑、增加页面
	 */
	public function toEdit() {
		$this->initParams();
		$id = $this->_checkboxID;
		$template = new TemplateEngine();
		if ($id && $id [0]) {
			$advertisement = ServiceFactory::getAdvertisementService()->findAdvertisementById( trim( $id [0] ) );
			if (! $advertisement) {
				$this->showErrorMessage( $this->getText( "advertisement_advertisement_no_exit" ), $this->createUrl( "index" ) );
			}
			$this->_name = $advertisement ['name'];
			$this->_url = $advertisement ['url'];
			$this->_note = $advertisement ['note'];
			$template->assign( "advertisement_id", $advertisement ['id'] );
		}
		$template->assign( "name", $this->_name );
		$template->assign( "url", $this->_url );
		$template->assign( "note", $this->_note );
		$template->assign( "isEdit", $id !== '' );
		$template->display( "advertisement_edit.tpl" );
	}

	/**
	 * 增加、修改广告信息
	 */
	public function edit() {
		$advertisementService = ServiceFactory::getAdvertisementService();
		$this->initParams();
		$beforeAdvertiseName = "";
		if ($this->_advertisement_id !== "") {
			$advisement = $advertisementService->findAdvertisementById( $this->_advertisement_id );
			if (! $advisement) {
				$this->showErrorMessage( $this->getText( "advertisement_advertisement_no_exit" ), $this->createErrorUrl( "toEdit" ) );
			}
			$beforeAdvertiseName = $advisement->name;
		} else {
			$advisement = new Advertisement();
		}
		$advisement->name = $this->_name;
		$advisement->url = $this->_url;
		$advisement->note = $this->_note;
		
		$result = $advertisementService->saveAdvertisement( $advisement );
		$msg = $this->_name;
		if ($result) {
			if ($this->_advertisement_id !== "") {
				SysLogger::log( "修改广告 $beforeAdvertiseName" );
				$this->showErrorMessage( $this->getText( "advertisement_edit_successful" ), $this->createUrl( "index" ) );
			} else {
				SysLogger::log( "增加广告 $msg" );
				$this->showErrorMessage( $this->getText( "advertisement_add_successful" ), $this->createUrl( "index" ) );
			}
		} else {
			$this->showErrorMessage( $msg . $this->getText( "advertisement_fail" ), $this->createErrorUrl( "toEdit" ) );
		}
	}

	/**
	 * 删除广告
	 */
	public function delete() {
		$ids = StringUtils::fromArrayToString( $this->getParamFromRequest( "checkboxID" ) );
		$this->writeLog( $ids );
		
		ServiceFactory::getAdvertisementService()->deleteAdvertisementByIds( $ids );
		$this->showErrorMessage( $this->getText( "advertisement_delete" ), $this->createUrl( "index" ) );
	}

	/**
	 * 循环记录删除日志
	 */
	private function writeLog($ids) {
		$advertisement = ServiceFactory::getAdvertisementService()->findAdvertisementByIds( $ids );
		foreach ( $advertisement as $adv ) {
			SysLogger::log( "删除广告 " . $adv ['name'] );
		}
	}

	/**
	 * 创建错误跳转url
	 * 
	 * @param $toAction string 保存现场
	 */
	private function createErrorUrl($toAction) {
		return $this->createUrl( $toAction, array (
				'name' => $this->_name, 
				"url" => $this->_url, 
				"note" => $this->_note ) );
	}

	/**
	 * 获取参数数组
	 */
	private function initParams() {
		$this->_checkboxID = $this->getParamFromRequest( "checkboxID", '' );
		$this->_advertisement_id = trim( $this->getParamFromRequest( "advertisement_id" ), '' );
		$this->_name = trim( $this->getParamFromRequest( "name" ), '' );
		$this->_url = trim( $this->getParamFromRequest( "url" ), '' );
		$this->_note = trim( $this->getParamFromRequest( "note" ), '' );
	}
}
