<?php

/**
 * Mysql数据库操作类  无框架情况下，简单封装mysql部分常用操作
 * 
 * @author 
 */
class Mysql {

	protected $conn;
	protected $debug;

	/**
	 * 构造函数
	 * 
	 * @param string $db_host
	 * @param string $db_user
	 * @param string $db_pwd
	 * @return resource
	 */
	function __construct($db_host, $db_user, $db_pwd) {
		$this->Mysql($db_host, $db_user, $db_pwd);
	}

	function Mysql($db_host, $db_user, $db_pwd) {
		$this->debug = 1;
		if (!$this->conn = mysql_connect($db_host, $db_user, $db_pwd)) {
			$this->display('Cannot connect to mysql.');
		}
	}

	/**
	 * 选择数据库
	 * 
	 * @param string $db_name
	 * @return boolean
	 */
	function select_db($db_name) {
		if (!mysql_select_db($db_name, $this->conn)) {
			$this->display('Cannot use database.');
			return false;
		}
		return true;
	}

	/**
	 * 执行sql语句
	 * 
	 * @param string $sql
	 * @return mixed
	 */
	function query($sql) {
		if (!($result = mysql_query($sql, $this->conn))) {
			$this->display('MySQL Query Error.');
			return false;
		}
		return $result;
	}

	/**
	 * 获取一条结果集数组
	 * 
	 * @param resource $result
	 * @param int $result_type
	 * @return array 
	 */
	function fetch_array($result, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($result, $result_type);
	}

	/**
	 * 获取一条记录
	 * 
	 * @param string $sql
	 * @param int $type
	 * @return array 
	 */
	function fetch_one($sql, $type = MYSQL_ASSOC) {
		$result = $this->query($sql);
		$rs = $this->fetch_array($result, $type);
		$this->free_result($result);
		return $rs;
	}

	/**
	 * 获取多条记录
	 * 
	 * @param string $sql
	 * @param string $keyfield
	 * @return array
	 */
	function fetch_all($sql, $keyfield = '') {
		$results = array();
		$result = $this->query($sql);
		while ($r = $this->fetch_array($result)) {
			if ($keyfield) {
				$key = $r[$keyfield];
				$results[$key] = $r;
			} else {
				$results[] = $r;
			}
		}
		$this->free_result($result);
		return $results;
	}

	/**
	 * 插入记录
	 * 
	 * @param string $tableName
	 * @param array $array
	 * @return mixed 
	 */
	function insert($tableName, $array) {
		foreach ($array as &$v) {
			$v = mysql_real_escape_string($v);
		}
		return $this->query("INSERT INTO `$tableName`(`" . implode('`,`', array_keys($array)) . "`) VALUES('" . implode("','", $array) . "')");
	}

	/**
	 * 更新记录
	 * 
	 * @param string $tableName
	 * @param array $array
	 * @param string $where
	 * @return mixed 
	 */
	function update($tableName, $array, $where = '') {
		$sql = '';
		foreach ($array as $k => $v) {
			$sql .= ", `$k`='" . mysql_real_escape_string($v) . "'";
		}
		$sql = substr($sql, 1);
		$sql = "UPDATE `$tableName` SET $sql";
		$where && $sql .= " WHERE $where";
		return $this->query($sql);
	}

	/**
	 * 返回最近一次插入记录的ID
	 * 
	 * @return string 
	 */
	function insert_id() {
		return mysql_insert_id($this->conn);
	}

	/**
	 * 释放结果内存
	 * 
	 * @param resource $result
	 * @return boolean 
	 */
	function free_result(&$result) {
		return mysql_free_result($result);
	}

	/**
	 * 关闭连接
	 * 
	 * @return boolean 
	 */
	function close() {
		return mysql_close($this->conn);
	}

	/**
	 * 返回上一个 MySQL 操作产生的文本错误信息 
	 * 
	 * @return string  
	 */
	function error() {
		return mysql_error($this->conn);
	}

	/**
	 * 返回上一个 MySQL 操作中的错误信息的数字编码 
	 * 
	 * @return int 
	 */
	function errno() {
		return mysql_errno($this->conn);
	}

	/**
	 * 取得结果集中行的数目
	 * 
	 * @param resource $result
	 * @return int 
	 */
	function num_rows($result) {
		return mysql_num_rows($result);
	}

	/**
	 * 特殊字符转化
	 * 
	 * @param string $string
	 * @return string
	 */
	function escape_string($string) {
		return mysql_real_escape_string($string, $this->conn);
	}
	
	/**
	 * 设置$debug值, 值：0，1和2
	 * 
	 * @param int $debug
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}

	/**
	 * 显示错误信息并停止脚本执行。
	 * 0为不输出，1为输出简单错误信息，2为开发调试用
	 * 
	 * @param string $msg 
	 */
	function display($msg) {
		if ($this->debug == 1) {
			die($msg);
		} else if ($this->debug == 2) {
			$message = 'Message：' . $msg . '<br/>Error code：' . $this->errno() . '<br/>Error info：' . $this->error() . '<br/>';
			die($message);
		} else {
			exit;
		}
	}

}
