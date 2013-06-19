<?php
/**
 * 页面风格管理controller
 */
class PagestyleController extends SysController {

	/**
	 * 名称
	 */
	private $_name = null;

	/**
	 * 英文名称
	 */
	private $_en_name = null;

	/**
	 * 路劲
	 */
	private $_path = null;

	/**
	 * 样式id
	 */
	private $_style_id = null;

	/**
	 * 样式id数组
	 */
	private $_checkboxID = array ();

	/**
	 * 错误信息
	 */
	private $_error_msg = "";

	/**
	 * 跳转列表页
	 */
	public function index() {
		$styles = ServiceFactory::getPageStyleService()->findAllStyle();
		
		$template = new TemplateEngine();
		$template->assign( "styles", $styles );
		$template->display( "pagestyle_index.tpl" );
	}

	/**
	 * 跳转编辑、增加页面
	 */
	public function toEdit() {
		$this->initParams();
		$id = $this->_checkboxID;
		$template = new TemplateEngine();
		if ($id && $id [0]) {
			$style = ServiceFactory::getPageStyleService()->findStyleById( trim( $id [0] ) );
			if (! $style) {
				$this->showErrorMessage( $this->getText( "pagestyle_set_not_find_style" ), $this->createUrl( "index" ) );
			}
			$this->_name = $style ['name'];
			$this->_en_name = $style ['en_name'];
			$this->_path = $style ['path'];
			$template->assign( "style_id", $style ['id'] );
		}
		$template->assign( "name", $this->_name );
		$template->assign( "en_name", $this->_en_name );
		$template->assign( "path", $this->_path );
		
		$template->assign( "isEdit", $id !== '' );
		$template->display( "pagestyle_edit.tpl" );
	}

	/**
	 * 增加、修改邮箱风格样式信息
	 */
	public function edit() {
		$this->initParams();
		$beforeName = "";
		
		$styleService = ServiceFactory::getPageStyleService();
		if ($this->checkDataIsExist()) {
			$this->showErrorMessage( $this->_error_msg, $this->createErrorUrl( "toEdit" ) );
		}
		if ($this->_style_id !== "") {
			$style = $styleService->findStyleById( $this->_style_id );
			if (! $style) {
				$this->showErrorMessage( $this->getText( "pagestyle_set_not_find_style" ) );
			}
			$beforeName = $style->name;
		} else {
			$style = new PageStyle();
		}
		$style->name = $this->_name;
		$style->en_name = $this->_en_name;
		$style->path = $this->_path;
		
		$result = $styleService->saveStyle( $style );
		
		if ($this->_style_id !== "") {
			$msg = $this->getText( "pagestyle_set_edit_name" ) . $this->_name;
		} else {
			$msg = $this->getText( "pagestyle_set_add_name" ) . $this->_name;
		}
		if ($result) {
			SysLogger::log( ($this->_style_id !== "" ? "修改邮箱页面风格 $beforeName 为 " : "添加邮箱页面风格 ") . $this->_name );
			$this->showErrorMessage( $msg . $this->getText( "pagestyle_set_success" ), $this->createUrl( "index" ) );
		} else {
			$this->showErrorMessage( $msg . $this->getText( "pagestyle_set_fail" ), $this->createErrorUrl( "toEdit" ) );
		}
	}

	/**
	 * 删除邮箱页面样式信息
	 */
	public function delete() {
		$ids = StringUtils::fromArrayToString( $this->getParamFromRequest( "checkboxID" ) );
		$this->writeDeleteLog( $ids );
		ServiceFactory::getPageStyleService()->deleteStyleByIds( $ids );
		$this->showErrorMessage( $this->getText( "pagestyle_set_delete_success" ), $this->createUrl( "index" ) );
	}

	/**
	 * 跳转邮箱页面风格用于显示
	 */
	public function toShow() {
		$template = new TemplateEngine();
		$template->assign( "imgUrl", $this->getParamFromRequest( "imgUrl" ) . "_big.gif" );
		$template->display( "pagestyle_show.tpl" );
	}

	/**
	 * 根据ids写删除日志
	 * 
	 * @param $ids string 邮箱页面风格ids
	 */
	private function writeDeleteLog($ids) {
		$styles = ServiceFactory::getPageStyleService()->findStylesByIds( $ids );
		foreach ( $styles as $style ) {
			SysLogger::log( "删除邮箱页面风格 " . $style ['name'] );
		}
	}

	/**
	 * 创建错误跳转url
	 * 
	 * @param $toAction string
	 */
	private function createErrorUrl($toAction) {
		return $this->createUrl( $toAction, array (
				'name' => $this->_name, 
				"en_name" => $this->_en_name, 
				"path" => $this->_path, 
				"checkboxID" => array ($this->_style_id ) ) );
	}

	/**
	 * 验证输入内容是否重复
	 */
	private function checkDataIsExist() {
		$params = array (":name" => $this->_name, ":en_name" => $this->_en_name, ":path" => $this->_path );
		if ($this->_style_id) {
			$params = array_merge( $params, array (":id" => $this->_style_id ) );
		}
		$style = ServiceFactory::getPageStyleService()->getStyleByParams( $params );
		if ($style) {
			if ($style ['name'] == $this->_name) {
				$this->_error_msg = $this->getText( "pagestyle_set_name_exist" );
			} else if ($style ['en_name'] == $this->_en_name) {
				$this->_error_msg = $this->getText( "pagestyle_set_en_name_exist" );
			} else if ($style ['path'] == $this->_path) {
				$this->_error_msg = $this->getText( "pagestyle_set_en_path_exist" );
			}
			return $this->_error_msg;
		}
		return false;
	}

	/**
	 * 获取参数数组
	 */
	private function initParams() {
		$this->_checkboxID = $this->getParamFromRequest( "checkboxID", '' );
		$this->_style_id = trim( $this->getParamFromRequest( "style_id" ), '' );
		$this->_name = trim( $this->getParamFromRequest( "name" ) );
		$this->_en_name = trim( $this->getParamFromRequest( "en_name" ) );
		$this->_path = trim( $this->getParamFromRequest( "path" ) );
	}

}