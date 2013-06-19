<?php

/**
 * 连接工厂类
 * 
 * @author jm
 */
class ConnectionFactory {

	/**
	 * 保存连接的静态数组
	 * 
	 * @var array
	 */
	private static $connections = array ();

	/**
	 * 获取连接，如果service中的方法有支持事务，则同时开始事务
	 * 
	 * @param $name string 连接名，配置文件中的键名
	 * @param $beginTransaction boolean 是否开启事务
	 * @return CDbConnection
	 * @throws CDbException
	 */
	public static function getConnection($name) {
		if (empty( self::$connections [$name] )) {
			self::$connections [$name] = new ConnectionWrapper( Yii::app()->$name, false );
		}
		$connectionWrapper = self::$connections [$name];
		if (! $connectionWrapper->getConnection() instanceof CDbConnection) {
			throw new CDbException( Yii::t( 'yii', 'Active Record requires a "db" CDbConnection application component.' ) );
		}
		
		if (! $connectionWrapper->getIsCurrentMethodUsed()) {
			ServiceFactory::handleConnectionTransactionState( $connectionWrapper->getConnection() );
			$connectionWrapper->setIsCurrentMethodUsed( true );
		}
		
		return $connectionWrapper->getConnection();
	}

	/**
	 * 重置所有connection的使用状态设置为false
	 */
	public static function resetConnectionState() {
		foreach ( self::$connections as $conn ) {
			$conn->setIsCurrentMethodUsed( false );
		}
	}

	/**
	 *
	 * @return 返回所有的connections
	 */
	public static function getUsedConnections() {
		$usedConnections = array ();
		foreach ( self::$connections as $conn ) {
			if ($conn->getIsCurrentMethodUsed()) {
				$usedConnections [] = $conn->getConnection();
			}
		}
		return $usedConnections;
	}
}

/**
 * 数据库连接的封装类
 * 
 * @author jm
 */
class ConnectionWrapper {

	/**
	 * 数据库链接
	 * 
	 * @var CDbConnection
	 */
	private $_connection = null;

	/**
	 * 是否某service方式是否使用该链接
	 * 
	 * @var boolean
	 */
	private $_isCurrentMethodUsed = false;

	/**
	 *
	 * @return the $_isCurrentMethodUsed
	 */
	public function getIsCurrentMethodUsed() {
		return $this->_isCurrentMethodUsed;
	}

	/**
	 *
	 * @param $_isCurrentMethodUsed boolean
	 */
	public function setIsCurrentMethodUsed($_isCurrentMethodUsed) {
		$this->_isCurrentMethodUsed = $_isCurrentMethodUsed;
	}

	/**
	 * 构造函数
	 * 
	 * @param $isStartTransation $connection
	 * @param $isStartTransation boolean
	 */
	public function __construct($connection, $isCurrentMethodUsed = false) {
		$this->setConnection( $connection );
		$this->setIsCurrentMethodUsed( $isCurrentMethodUsed );
	}

	/**
	 *
	 * @return the $_connection
	 */
	public function getConnection() {
		return $this->_connection;
	}

	/**
	 *
	 * @param $_connection CDbConnection
	 */
	public function setConnection($_connection) {
		$this->_connection = $_connection;
	}
}