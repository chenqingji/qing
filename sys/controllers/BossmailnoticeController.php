<?php

/**
 * 向BossMail用户发送系统消息的控制器
 * 
 * @author linfb
 */
class BossmailnoticeController extends SysController {

	public function index() {
		$this->toSend();
	}

	/**
	 * 显示发送系统消息显示页面
	 */
	public function toSend() {
		$template = new TemplateEngine();
		$cur_date = date( "Y-m-d", time() + (6 * 24 * 60 * 60) );
		$min_date = date( "Y-m-d", time() + (24 * 60 * 60) );
		$template->assign( "default_date", $cur_date );
		$template->assign( "minDate", $min_date );
		$template->assign( "lang", SysSessionUtil::getLanguageType() );
		$template->display( 'notice_send.tpl' );
	}

	/**
	 * 发送系统消息方法
	 */
	public function send() {
		$notice = array ();
		$notice ["receiver"] = $this->getParamFromRequest( "receiver" );
		$notice ["version"] = $this->getParamFromRequest( "version" );
		$notice ["time_day"] = $this->getParamFromRequest( "time_day" );
		$notice ["custom_second"] = $this->getParamFromRequest( 'custom_second' );
		$notice ["show_time"] = $this->getParamFromRequest( "show_time" );
		$notice ["subject"] = $this->getParamFromRequest( "subject" );
		$notice ["content"] = $this->getParamFromRequest( "content" );
		$notice ["purecontent"] = $this->getParamFromRequest( "purecontent" );
		$reslut = $this->sendNoticeBySocket( $notice );
		$this->ajaxReturn( $reslut );
	}

	/**
	 * 通过socket向bossmail客户端发送系统消息
	 * 
	 * @param $notice array 要发送的提示信息
	 */
	private function sendNoticeBySocket($notice) {
		$receiver = $notice ['receiver'];
		$version = trim( $notice ['version'] );
		$time_day = $notice ['time_day'];
		$show_time = $notice ['show_time'];
		$custom_second = $notice ['custom_second'];
		$subject = trim( $notice ['subject'] );
		$content = trim( $notice ['content'] );
		$purecontent = html_entity_decode( trim( $notice ['purecontent'] ) );
		$purecontentlen = strlen( trim( $purecontent ) );
		$content = str_replace( '<br type="_moz" />', "", $content );
		$contenlen = strlen( trim( $content ) );
		$replace_arr = array ("&nbsp;", "<br />" );
		$content_null = str_replace( $replace_arr, "", $content );
		if (trim( $subject ) == "") {
			return $this->returnResult( "failed", $this->getText( "bossmailnotice_server_no_subject" ) );
		}
		if (trim( $content_null ) == "") {
			return $this->returnResult( "failed", $this->getText( "bossmailnotice_server_no_content" ) );
		}
		if ($receiver == "all") {
			$receiver = 0;
		} elseif ($receiver == "online") {
			$receiver = 1;
		} elseif ($receiver == "offline") {
			$receiver = 2;
		}
		if (strcmp( $time_day, "" ) > 0) {
			$out_time = strtotime( $time_day );
		} else {
			$out_time = 0; // 过期时间为空
		}
		if (! $show_time) {
			$custom_second = 0;
		}
		
		$receiver_len = strlen( trim( $receiver ) );
		$version_len = strlen( $version );
		$out_time_len = strlen( trim( $out_time ) );
		$custom_second_len = strlen( trim( $custom_second ) );
		$subject_len = strlen( $subject );
		
		$bm_str = "1,1," . $receiver_len . "," . $receiver . "," . $version_len . "," . $version . "," . $out_time_len . "," . $out_time . "," . $custom_second_len . "," . $custom_second . "," . $subject_len . "," . $subject . "," . $contenlen . "," . $content . "," . $purecontentlen . "," . $purecontent;
		
		$result = BossmailClientSocketHelper::sendMessageToClient( $bm_str );
		if (! $result) {
			return $this->returnResult( "failed", $this->getText( "bossmailnotice_server_socket_send_failed" ) );
		}
		// 写入日志文件
		$subject_log = $subject;
		$op = "发送系统消息 " . $subject_log;
		SysLogger::Log( $op );
		return $this->returnResult( "success" );
	}

	/**
	 * 返回执行结果
	 * 
	 * @param $reslut string 结果标志 success 或 failed
	 * @param $message string 提示信息
	 * @return array 返回结果
	 */
	private function returnResult($reslut, $message = "") {
		return array ("reslut" => (($reslut == "success") ? "success" : "failed"), "message" => $message );
	}
}
