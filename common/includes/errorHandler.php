<?php
/**
 * 自定义错误日志
 */
set_error_handler('errorHandler');
function errorHandler( $errno, $errstr, $errfile, $errline, $errcontext) {
	include_once('./Log.class.php');
	$log = new Log();
	$log -> setDir('/tmp/log/');
	$log -> setFile('sure');
	
	$log -> log('ERROR:'.date('Y-m-d H:i:s',time()));
	$log -> log('Into '.__FILE__.' at line '.__LINE__);
	$log -> log('---ERRNO---');
	$log -> log($errno);
	$log -> log('---ERRMSG---');
	$log -> log($errstr);
	$log -> log('---ERRFILE---');
	$log -> log($errfile);
	$log -> log('---ERRCONTEXT---');
	$log -> log($errcontext);

}

function errorLog(){
	error_log('willful error write to email.',1,'chenqingji@166.com');
	error_log('willful error write to error log file.',3,'/tmp/log/errorlog');
	return true;
}

function b(){
	trigger_error('chenqingji error',E_USER_ERROR);
	//include_once('hh.php');
}

//todo
b();

?>
