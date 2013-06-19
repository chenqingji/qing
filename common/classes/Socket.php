<?php

/**
 * Socket类
 * 
 * @author jm
 */
class Socket {

	/**
	 * socket服务端地址
	 * 
	 * @var string
	 */
	private $_host;

	/**
	 * 端口
	 * 
	 * @var string int
	 */
	private $_port;

	/**
	 * 超时时间
	 * 
	 * @var int
	 */
	private $_timeout = 15;

	/**
	 * 错误信息数组, 如array('code' => 111, 'message' => 'Connection refused',
	 * 'description' => 'Open socket error.
	 * Host: localhost, port: 100861')
	 * 
	 * @var array
	 */
	private $_errorInfo = array ();

	/**
	 * 是否有错误
	 * 
	 * @var boolean
	 */
	private $_hasError = false;

	/**
	 * socket资源
	 * 
	 * @var resource
	 */
	private $_socket = null;

	/**
	 * 构造函数
	 * 
	 * @param $host string
	 * @param $port string|int
	 * @param $timeout int
	 */
	public function __construct($host, $port, $timeout = 30) {
		$this->_host = $host;
		$this->_port = $port;
		$this->_timeout = $timeout;
	}

	/**
	 * 关闭连接
	 */
	public function close() {
		if ($this->_socket) {
			fclose( $this->_socket );
			$this->_socket = null;
		}
	}

	/**
	 * 发送命令
	 * 
	 * @param $string string
	 * @return string
	 */
	public function send($string) {
		if (! $this->_socket && false == $this->connect()) {
			return false;
		}
		$this->write( $string );
		
		$response = '';
		while ( ! feof( $this->_socket ) ) {
			$response .= $this->read();
		}
		
		$this->close();
		return $response;
	}

	/**
	 * 返回错误信息
	 * 
	 * @return array
	 */
	public function getErrorInfo() {
		return $this->_errorInfo;
	}

	/**
	 * 设置错误信息
	 * 
	 * @param $errorCode string 错误号
	 * @param $errorMsg string 错误信息
	 * @param $description string 错误描述
	 * @return boolean
	 */
	public function setErrorInfo($errorCode, $errorMsg, $description) {
		$this->_errorInfo ['code'] = $errorCode;
		$this->_errorInfo ['message'] = $errorMsg;
		$this->_errorInfo ['description'] = $description;
		$this->_hasError = true;
		return false;
	}

	/**
	 * 是否有错误
	 * 
	 * @return boolean
	 */
	public function hasError() {
		return $this->_hasError;
	}

	/**
	 * 连接socket
	 * 
	 * @return boolean 成功返回true, 否则为false
	 */
	public function connect() {
		$this->_socket = @fsockopen( $this->_host, $this->_port, $errorCode, $errorMsg, $this->_timeout );
		if (! $this->_socket) {
			return $this->setErrorInfo( $errorCode, $errorMsg, 'Open socket error. Host: ' . $this->_host . ', port: ' . $this->_port );
		}
		return true;
	}

	/**
	 * 读取socket
	 * 
	 * @param $length int
	 * @return string boolean 否则为false
	 */
	private function read($length = 1024) {
		$response = fgets( $this->_socket, $length );
		if ($response === FALSE) {
			return $this->setErrorInfo( '', '', 'Read socket error.' );
		}
		return $response;
	}

	/**
	 * 写入socket
	 * 
	 * @param $string string
	 * @return int boolean 否则为false
	 */
	private function write($string) {
		$response = fwrite( $this->_socket, $string );
		if ($response === FALSE) {
			return $this->setErrorInfo( '', '', 'Write socket error. Command: ' . $string );
		}
		return $response;
	}
}