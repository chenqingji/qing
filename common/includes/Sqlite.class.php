<?php

/**
 * Sqlite数据库操作类 在无框架支持的情况下，简单封装sqlite的部分常用操作 - pdo
 * require php_pdo extension
 * require php_pdo_sqlite extension
 * 
 * @author 
 */
class SqliteDB {

	private $handle = null;
	protected $debug = 1;
	public $error = '';
	public $error_num = 0;
	
	const DATABASE_FILE_NOT_EXISTS = 1;
	const PDO_EXCEPTION = 2;
	const QUERY_ERROR = 3;
	const PDO_STMT_PREPARE_ERROR = 4;
	const PDO_STMT_EXECUTE_ERROR = 5;

	/**
	 * 构造函数
	 * 
	 * @param string $db_path
	 * @param int $debug 
	 */
	function __construct($db_path) {
		$this->SqliteDB($db_path);
	}

	function SqliteDB($db_path) {
		if (!is_file($db_path)) {
			$this->setError('Database file not exists.', self::DATABASE_FILE_NOT_EXISTS);
			return false;
		}
		$this->debug = 1;
		$dsn = "sqlite:$db_path";
		try {
			$this->handle = new PDO($dsn);
		} catch (PDOException $e) {
			$this->setError('PDO exception.', self::PDO_EXCEPTION);
			return false;
		}
	}

	/**
	 * 执行sql语句
	 * 
	 * @param string $sql
	 * @return a PDOStatement object, or false on failure
	 */
	function query($sql) {
		if (!($query = $this->handle->query($sql))) {
			$this->setError($this->handle, self::QUERY_ERROR);
			return false;
		}
		return $query;
	}

	/**
	 * 执行sql语句, 返回影响的行数, 注意返回值为0和false的情况
	 * 
	 * @param string $sql
	 * @return int
	 */
	function exec($sql) {
        // return $this->handle->exec($sql);
        $stmt = $this->handle->prepare($sql);
		if (!$stmt) {
			$this->setError($stmt, self::PDO_STMT_PREPARE_ERROR);
			return false;
		} else {
			$exec = $stmt->execute();
			if (!$exec) {
				$this->setError($stmt, self::PDO_STMT_EXECUTE_ERROR);
				return false;
			}
		}
        return true;
	}

	/**
	 * 获取一条记录
	 * 
	 * @param string $sql
	 * @param int $result_type
	 * @return array 
	 */
	function fetch_one($sql, $array = array(), $result_type = PDO::FETCH_ASSOC) {
		$result = array();
		if($this->hasError()) {
			return false;
		}
		$stmt = $this->handle->prepare($sql);
		if (!$stmt) {
			$this->setError($stmt, self::PDO_STMT_PREPARE_ERROR);
			return false;
		} else {
			$exec = $stmt->execute($array);
			if ($exec) {
				$result = $stmt->fetch($result_type);
			} else {
				$this->setError($stmt, self::PDO_STMT_EXECUTE_ERROR);
				return false;
			}
		}
		return $result;
	}

	/**
	 * 获取多条记录
	 * 
	 * @param string $sql
	 * @param string $keyfield
	 * @return array
	 */
	function fetch_all($sql, $array = array(), $keyfield = '', $result_type = PDO::FETCH_ASSOC) {
		$result = array();
		if($this->hasError()) {
			return false;
		}
		$stmt = $this->handle->prepare($sql);
		if (!$stmt) {
			$this->setError($stmt, self::PDO_STMT_PREPARE_ERROR);
			return false;
		} else {
			$exec = $stmt->execute($array);
			if ($exec) {
				$result = $stmt->fetchAll($result_type);
			} else {
				$this->setError($stmt, self::PDO_STMT_EXECUTE_ERROR);
				return false;
			}
		}
		if ($keyfield) {
			foreach ($result as $rs) {
				$result[$rs[$keyfield]] = $rs;
			}
		}
		return $result;
	}

	/**
	 * 插入记录
	 * 
	 * @param string $tableName
	 * @param array $array
	 * @return int or false
	 */
	function insert($tableName, $array) {
		foreach ($array as &$v) {
			$v = str_replace("'", "''", $v);
		}
		return $this->handle->exec("INSERT INTO `$tableName`(`" . implode('`,`', array_keys($array)) . "`) VALUES('" . implode("','", $array) . "')");
	}

	/**
	 * 更新记录
	 * 
	 * @param string $tableName
	 * @param array $array
	 * @param string $where
	 * @return int or false
	 */
	function update($tableName, $array, $where = '') {
		$sql = '';
		foreach ($array as $k => $v) {
			$v = str_replace("'", "''", $v);
			$sql .= ", `$k`='$v'";
		}
		$sql = substr($sql, 1);
		$sql = "UPDATE `$tableName` SET $sql";
		$where && $sql .= " WHERE $where";
		return $this->handle->exec($sql);
	}

	/**
	 * 返回最近一次插入的记录ID
	 * 
	 * @return string 
	 */
	function insert_id() {
		return $this->handle->lastInsertId();
	}

	/**
	 * 设置debug值
	 * 
	 * @param int $debug 
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}

	/**
	 * 设置错误信息
	 * 
	 * @param type $object 
	 * @param int $error_num
	 */
	function setError($object, $error_num) {
		if (($object instanceof PDO) || ($object instanceof PDOStatement)) {
			$info = $object->errorInfo();
			$this->error = 'Error code: ' . $info[0] . '; Error: ' . $info[2];
		}
		if(is_string($object)) {
			$this->error = $object;
		}
		$this->error_num = $error_num;
	}

	/**
	 * 是否有错误信息
	 * 
	 * @return boolean
	 */
	function hasError() {
		if(empty ($this->error) && !$this->error_num) {
			return false;
		}
		return true;
	}
	
	/**
	 * 获取错误信息
	 * 
	 * @return string 
	 */
	function getError() {
		return $this->error;
	}
	
	/**
	 * 获取错误号
	 * 
	 * @return int
	 */
	function getErrorNum() {
		return $this->error_num;
	}
}
