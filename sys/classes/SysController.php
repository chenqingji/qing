<?php
/**
 * 系统端控制器基类
 * 
 * @author jm
 */
class SysController extends BaseController {

	/**
	 * 访问控制权限过滤器
	 * 转到自定义过滤方法filterAccessAuth
	 */
	public function filters() {
		return array ("setHtmlCharset", "handleExcepiton", "accessAuth" );
	}

	/**
	 * 统一设置html编码为utf8
	 */
	public function filterSetHtmlCharset($filterChain) {
		header( 'Content-Type:text/html;charset=utf-8' );
		$filterChain->run();
	}

	/**
	 * 自定义权限过滤方法，符合条件的可访问，不行的抛出异常
	 * 
	 * @param $filterChain object
	 */
	public function filterAccessAuth($filterChain) {
		if (SysAccessAuth::checkActionRights( $filterChain )) {
			$filterChain->run();
		}
	}

	/**
	 * 处理系统抛出的未扑捉异常
	 * 
	 * @param $filterChain
	 */
	public function filterHandleExcepiton($filterChain) {
		try {
			$filterChain->run();
		} catch ( Exception $ex ) {
			if ($ex instanceof NoRightsException) {
				$this->showErrorMessage( $this->getText( "sys_no_rights" ), $this->createUrl( "statistics/index" ) );
			}
			if ($ex instanceof NoLoginException) {
				$this->showErrorMessage( $this->getText( "user_login_expire" ), $this->createUrl( "site/index" ), "", true );
			}
			if (Config::DEBUG_MODE) {
				throw $ex;
			} else {
				// TODO:此处写入错误日志.
				$msgTemplate = new TemplateEngine( "common" );
				$msgTemplate->display( "sys_error.tpl" );
				FrameworkUtils::endApp();
			}
		}
	}

	/**
	 * 显示错误信息
	 * 
	 * @param $message string
	 * @param $url $urlArray
	 * @param $callback 支持回调方法
	 */
	public function showErrorMessage($message = "", $urls = null, $returnJs = "", $isMainFrame = false) {
		$msgTemplate = new TemplateEngine( "common" );
		$msgTemplate->assign( "message", CJavaScript::encode( $message ) );
		$msgTemplate->assign( "returnjs", $returnJs );
		$msgTemplate->assign( "ismainframe", $isMainFrame ? "true" : "false" );
		$urlArray = array ();
		if ($urls !== null) {
			if (is_array( $urls )) {
				$urlArray = $urls;
			} else {
				$urlArray [] = $urls;
			}
		}
		$msgTemplate->assign( "urls", CJavaScript::encode( $urlArray ) );
		$msgTemplate->display( "msg_show.tpl" );
		FrameworkUtils::endApp();
	}

	/**
	 * 自动返回上一页
	 */
	public function errorBack($message) {
		$url = isset( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : "";
		if (strcmp( $url, "" ) != 0) {
			$this->showErrorMessage( $message, $url );
		} else {
			$this->showErrorMessage( $message, null, "history.go(-1);" );
		}
	}

	public function ajaxReturn($data, $info = '', $status = 1) {
		$result = array ();
		$result ['status'] = $status;
		$result ['info'] = $info;
		$result ['data'] = $data;
		header( "Content-Type:text/html; charset=utf-8" );
		echo json_encode( $result );
		FrameworkUtils::endApp();
	}
}
?>