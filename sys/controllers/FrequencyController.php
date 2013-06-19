<?php

/**
 * sys端 过滤设置－频率控制
 * 
 * @author cqy
 */
class FrequencyController extends SysController {

	/**
	 * 频率控制
	 */
	public function index() {
            /**
		$frequencyService = ServiceFactory::getFrequencyService();
		
		$minute = $this->getText( 'frequency_minute' );
		$hour = $this->getText( 'frequency_hour' );
		$timeOptions = array (
				'5m' => "5 $minute", 
				'10m' => "10 $minute", 
				'15m' => "15 $minute", 
				'30m' => "30 $minute", 
				'60m' => "60 $minute", 
				'12h' => "12 $hour", 
				'24h' => "24 $hour" );
		
		$mtaini = $this->getParamFromRequest( 'smtpd_rcpt_limit' ) ? $_GET : $frequencyService->getMtaini();
		
		$template = new TemplateEngine();
		$template->assign( 'mtaini', $mtaini );
		$template->assign( 'time_options', $timeOptions );
             * 
             */
            
		$template = new TemplateEngine();
		$hour = $this->getText( 'frequency_hour' );
		$minute = $this->getText( 'frequency_minute' );
		$timeOptions = array (
				'5m' => "5 $minute", 
				'10m' => "10 $minute", 
				'15m' => "15 $minute", 
				'30m' => "30 $minute", 
				'60m' => "60 $minute", 
				'12h' => "12 $hour", 
				'24h' => "24 $hour" );   
		$template->assign( 'time_options', $timeOptions );
		$template->display( 'frequency_index.tpl' );
	}

	/**
	 * 设置频率
	 */
	public function set() {
		$frequencyService = ServiceFactory::getFrequencyService();
		
		$fields = array (
				'smtpd_rcpt_limit' => max( 0, ( int ) $this->getParamFromRequest( 'smtpd_rcpt_limit' ) ), 
				'message_size_limit' => max( 0, ( int ) $this->getParamFromRequest( 'message_size_limit' ) * 1024 ), 
				'attachment_count' => max( 0, ( int ) $this->getParamFromRequest( 'attachment_count' ) ), 
				'is_nofrom' => $this->getParamFromRequest( 'is_nofrom' ) ? '1' : '0', 
				'is_sasl' => $this->getParamFromRequest( 'is_sasl' ) ? '1' : '0', 
				'con_count' => max( 0, ( int ) $this->getParamFromRequest( 'con_count' ) ), 
				'connection_rate_limit' => max( 0, ( int ) $this->getParamFromRequest( 'connection_rate_limit' ) ), 
				'time_unit_con' => $this->getParamFromRequest( 'time_unit_con' ), 
				'mail_rate_limit' => max( 0, ( int ) $this->getParamFromRequest( 'mail_rate_limit' ) ), 
				'time_unit_mail' => $this->getParamFromRequest( 'time_unit_mail' ), 
				'rcpt_rate_limit' => max( 0, ( int ) $this->getParamFromRequest( 'rcpt_rate_limit' ) ), 
				'time_unit_rcpt' => $this->getParamFromRequest( 'time_unit_rcpt' ) );
		
		$isMailFromNone = $fields ['is_nofrom'];
		$isIgnoreSmtpValidate = $fields ['is_sasl'];
		
		$forwardUrl = $this->createUrl( 'index', $fields );
		
		$mtaini = $frequencyService->getMtaini();
		$originIsMailFromNone = $mtaini ['is_nofrom'];
		$originIsIgnoreSmtpValidate = $mtaini ['is_sasl'];
		
		$commandString = '';
		$commandArray = $this->getCommandArray( $mtaini, $fields );
		foreach ( $commandArray as $key => $value ) {
			$commandString .= $key . $value . ';';
		}
		if ($commandString) {
			$string = "rate_limit:$commandString";
			$response = PlatformSocketHandler::sendCommand( $string );
			if (strpos( $response, 'ok' ) === FALSE) {
				$msg = str_replace( '{0}', $string, $this->getText( 'frequency_create_command_fail' ) );
				$this->showErrorMessage( $msg, $forwardUrl );
			}
		}
		if ($mtaini ['attachment_count'] != $fields ['attachment_count']) {
			$response = PlatformSocketHandler::executeUmcacheCommand();
		}
		
		if (! $frequencyService->saveMtaini( $mtaini, $fields )) {
			$this->showErrorMessage( $this->getText( 'frequency_update_failure' ), $forwardUrl );
		}
		if ($originIsMailFromNone != $isMailFromNone || $originIsIgnoreSmtpValidate != $isIgnoreSmtpValidate) {
			$response = PlatformSocketHandler::executeUmnullCommand();
			if (strpos( $response, 'ok' ) === FALSE) {
				$msg = str_replace( '{0}', $string, $this->getText( 'frequency_create_command_fail' ) );
				$this->showErrorMessage( $msg, $forwardUrl );
			}
		}
		SysLogger::log( '修改频率控制' );
		$this->showErrorMessage( $this->getText( 'operate_successfully' ), $forwardUrl );
	}

	/**
	 * 组装socket远程执行命令,返回数组
	 * 
	 * @param $mtaini Mtaini
	 * @param $fields array
	 * @return array
	 */
	private function getCommandArray($mtaini, $fields) {
		$commandArray = array ();
		if ($mtaini ['smtpd_rcpt_limit'] != $fields ['smtpd_rcpt_limit']) {
			$commandArray ['sed -i \'s/sendout_recipient_limit=.*/sendout_recipient_limit='] = "{$fields['smtpd_rcpt_limit']}/g' /etc/mail_server";
			$commandArray ['killall milter-limit'] = '';
		}
		if ($mtaini ['message_size_limit'] != $fields ['message_size_limit']) {
			$commandArray ['postconf -e message_size_limit='] = $fields ['message_size_limit'];
		}
		if ($mtaini ['is_sasl'] != $fields ['is_sasl']) {
			$commandArray ['postconf -e smtpd_sasl_auth_enable='] = $fields ['is_sasl'] ? 'yes' : 'no';
		}
		if ($mtaini ['con_count'] != $fields ['con_count']) {
			$commandArray ['postconf -e smtpd_client_connection_count_limit='] = $fields ['con_count'];
		}
		if ($commandArray) {
			$commandArray ['postfix reload'] = '';
		}
		if ($mtaini ['connection_rate_limit'] != $fields ['connection_rate_limit'] || $mtaini ['time_unit_con'] != $fields ['time_unit_con']) {
			$commandArray ['/usr/local/sbin/modify_ConRate '] = $fields ['connection_rate_limit'] . '\\\\/' . $fields ['time_unit_con'];
		}
		if ($mtaini ['mail_rate_limit'] != $fields ['mail_rate_limit'] || $mtaini ['time_unit_mail'] != $fields ['time_unit_mail']) {
			$commandArray ['/usr/local/sbin/modify_mailRate '] = $fields ['mail_rate_limit'] . '\\\\/' . $fields ['time_unit_mail'];
		}
		if ($mtaini ['rcpt_rate_limit'] != $fields ['rcpt_rate_limit'] || $mtaini ['time_unit_rcpt'] != $fields ['time_unit_rcpt']) {
			$commandArray ['/usr/local/sbin/modify_rcptRate '] = $fields ['rcpt_rate_limit'] . '\\\\/' . $fields ['time_unit_rcpt'];
		}
		if (! empty( $commandArray ['/usr/local/sbin/modify_ConRate '] ) || ! empty( $commandArray ['/usr/local/sbin/modify_mailRate '] ) || ! empty( $commandArray ['/usr/local/sbin/modify_rcptRate '] )) {
			$commandArray ['makemap hash /etc/mail/access.db < /etc/mail/access'] = '';
			$commandArray ['killall milter-limit'] = '';
		}
		return $commandArray;
	}

}