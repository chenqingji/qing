<?php

/**
 * 初始化调试类 
 * $log = initLog();$log->log('chenqingji','filename');
 * @return null|\Log
 * @throws Exception 
 */
function initLog() {
    $logClassFile = '../class/Log.class.php';
    if (is_file($logClassFile)) {
        include_once($logClassFile);
        $log = new Log();
        //$log->setFilter($_SERVER['REMOTE_ADDR'], array('192.168.138.221'));
        $log->setDir('/tmp/log/');
        $log->setFile('debug');
    } else {
        throw new Exception($logClassFile . ' is not file.');
    }
    return $log;
}

/*
  //记录日志模块
  include_once('/chenqingji/class/Log.class.php');
  $log = new Log();
  $log->setDir('/tmp/log/');
  $log->setFilter($_SERVER['REMOTE_ADDR'],array('192.168.138.221'));
 */

/**
 * 获取指定目录下正则匹配到的文件名称
 * readAllFile('/chenqingji/tools/','*.php'); 
 * @param string $baseDir
 * @param string $regFile
 * @return array 
 */
function readAllFile($baseDir, $regFile) {
    if (!is_dir($baseDir)) {
        return false;
    }
    $fileArr = array();
    $fileArr = glob($baseDir . $regFile);
    for ($i = 0; $i < count($fileArr); $i++) {
        $fileArr[$i] = basename($fileArr[$i]);
    }
    return $fileArr;
}

/**
 * 模拟post请求
 * 返回
 * @param type $urlArr
 * @param type $queryString
 * @return type
 * @throws Exception 
 */
function post_request($urlArr, $queryString = '') {
    if (!isset($urlArr['host']) || strcmp($urlArr['host'], "") == 0) {
        throw new Exception('host is null.');
    }
    if (!isset($urlArr['port']) || strcmp($urlArr['port'], "") == 0) {
        throw new Exception('port is null.');
    }
    $request .= "POST " . $urlArr['path'] . " HTTP/1.1\n";
    $request .= "Host: " . $urlArr["host"] . "\n";
    $request .= "Referer: " . $urlArr["referer"] . "\n";
    $request .= "Content-type: application/x-www-form-urlencoded\n";
    $request .= "Content-length: " . strlen($queryString) . "\n";
    $request .= "Connection: close\n";
    $request .= "\n";
    $request .= $queryString . "\n";
    $fp = fsockopen($urlArr["host"], $urlArr["port"]);
    if (!$fp) {
        throw new Exception('fsockopen fail.');
    }
    //把HTTP头发送出去
    if (!fputs($fp, $request)) {
        throw new Exception('request fail.');
    }
    if ($fp) {
        while (!feof($fp)) {
            //请求返回数据包括请求成功http头部信息，换行显示，过滤http头部信息，返回的数据只有一行的话只要取最后一行
            $result = fgets($fp);
        }
        fclose($fp);
    }
    return $result;
}

/**
 * 测试跟踪方法被调用行径
 * @global type $a 
 */
function recur() {
    $a = 0;
    $a++;
    if ($a < 4) {
        recur();
        debug_print_backtrace();
    }
    return true;
}

/**
 * 可用ajax请求来模拟该种情况
 * @return boolean 
 */
function testLongRequest() {
    include_once('../class/Log.class.php');
    $log = new Log();
    $log->setDir('/tmp/log/');
    $log->setFile('long');

    $limit = 5;
    $init = 0;
    $log->log(time(), '', 'wb');
    session_write_close();
    while ($init < $limit) {
        sleep(3);
        $str = 'testLongRequest:	' . date('Y-m-d H:i:s', time()) . "\n";
        $log->log($str);
        $init++;
    }
    echo 'Test End.';
    return true;
}

/**
 * 测试相同一个请求，后续请求中断之前的相同请求（后台处于循环中 ）
 */
function testOneProcStopAnotherProc() {
    include_once('../class/Log.class.php');
    $log = new Log();
    $log->setDir('/tmp/log/');
    $log->setFile('process');

    if ($_SESSION['processFlag'] == 'new') {
        $_SESSION['processFlag'] = 'old';
        $log->log('new proc case had old proc running.');
    } else {
        $_SESSION['processFlag'] = 'new';
        $log->log('new proc.');
    }
    session_write_close();
    for ($i = 0; $i < 10; $i++) {
        sleep(3);
        session_start();
        $log->log($i . '	session:' . $_SESSION['processFlag']);
        session_write_close();
    }
    session_start();
    unset($_SESSION['processFlag']);
}

/**
 *  功能：实现边执行边输出到页面
 *  在非压缩情况下，输出缓存时，服务器才去寻找判断客户端等待接收的socket是否还存在，即客户端连接是否被中断
 *  可通过ignore_user_abort(true)设置忽略用户中断，继续执行脚本，并通过connection_aborted()捕捉用户中断
 */
function flushOutStr() {
    if (!ini_get('safe_mode')) {
        @apache_setenv('no-gzip', 1);
        @ini_set('zlib.output_compression', 0);
        @ini_set('implicit_flush', 1);
    }
    ignore_user_abort(true);
    $infoString = "Hello World" . "<br />";
    $i = 0;

    while ($i < 10) {
        //set_time_limit(10);
        sleep(1);
        $i++;
        echo time() . ':' . $infoString;
        ob_flush();
        flush();
        if (connection_aborted()) {
            //在ignore_user_abort有效情况下，此处可处理用户中断后的操作
            break;
        }
    }
}

/**
 * 获取一定格式配置文件的配置
 * @param string $configFile
 * @return type 
 */
function getConfig($configFile) {
    if (!$configFile) {
        $configFile = '../config/config-ip';
    }
    $arr = parse_ini_file($configFile, true);
    return $arr;
}

/**
 * 可作为顶级异常处理函数，可作为类静态方法  
 * set_exception_handler（'topException'）
 * set_exception_handler(array('class','topException'));
 * @param type $e 
 */
function topException($e) {
    echo 'i am topException.';
    echo "\n" . $e->getMessage();
}

/**
 * 字符串简单加密
 * @param type $txt
 * @return type
 */
function easy_encode($txt){
	for($i=0;$i<strlen($txt);$i++){
		$mou = ord($txt[$i]) + 1;
		$txt[$i]= chr($mou);
	}
	return $txt= urlencode($txt);
}

/**
 * 字符串简单解密
 * @param type $txt
 * @return type
 */
function easy_decode($txt){
	$txt=urldecode($txt);
	for($i=0;$i<strlen($txt);$i++){
		$txt[$i]=chr(ord($txt[$i])-1);
	}
	return $txt;
}


?>
