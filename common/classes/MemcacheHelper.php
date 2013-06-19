<?php

/**
 * Memcache辅助类
 * 
 * @author jm
 */
class MemcacheHelper {

	/**
	 * 存储memcache实例
	 * 
	 * @var CMemCache
	 */
	private static $_instance = null;

	/**
	 * memcache服务器配置, 如array('server' => '192.168.148.183', 'port' => 11211)
	 * 
	 * @var array
	 */
	private static $_server = array ('server' => Config::MEMCACHE_SERVER, 'port' => Config::MEMCACHE_PORT );

	/**
	 * 设置memcache服务器
	 * 
	 * @param $server, array 如array('server' => '192.168.148.183', 'port' => 11211)
	 */
	public static function setServer($server) {
		self::$_server = $server;
		self::close();
		self::init();
	}

	/**
	 * 重置memcache服务器
	 */
	public static function resetServer() {
		self::$_server = array ('server' => Config::MEMCACHE_SERVER, 'port' => Config::MEMCACHE_PORT );
		self::close();
	}

	/**
	 * 获取Memcache实例
	 * 
	 * @return Memcache
	 */
	private static function getInstance() {
		if (self::$_instance == null) {
			self::init();
		}
		return self::$_instance;
	}

	/**
	 * 初始化连接
	 * 
	 * @throws Exception
	 */
	private static function init() {
		$memcache = new Memcache();
		$host = self::$_server ['server'];
		$port = self::$_server ['port'];
		$connect = @$memcache->connect( $host, $port );
		if (! $connect) {
			throw new Exception( 'Cannot connect memcache server. Host:' . $host );
		}
		self::$_instance = $memcache;
		register_shutdown_function( array ('MemcacheHelper', 'close' ) );
	}

	/**
	 * 关闭Memcache连接
	 */
	public static function close() {
		if (self::$_instance) {
			self::$_instance->close();
			self::$_instance = null;
		}
	}

	/**
	 * 从memcached中取得相应键的值
	 * 用法：MemcacheHelper::getData(SYS_WB_LIST)
	 * 
	 * @param $key string 键名，传入方式如SYS_WB_LIST
	 * @param $vars array 要替换的字符串数组，如array('{domain}' => '183.com', '{mailbox}' =>
	 *        'cqy@183.com')
	 * @param $isMd5 boolean
	 * @return mixed
	 */
	public static function getData($key, $vars = array(), $isMd5 = true) {
		if ($vars) {
			$key = str_replace( array_keys( $vars ), array_values( $vars ), $key );
		}
		$md5Key = $isMd5 ? md5( $key ) : $key;
		return self::getInstance()->get( $md5Key );
	}

	/**
	 * 设置memcache的值
	 * 注意：此处不允许重复某一key的重复设置，防止出现事务回滚后，memcache已重新设置，导致数据不匹配的问题出现。数据数据库更新，强制使用deleteData方式将memcache数据过期删除。
	 * 
	 * @param $key string 键名，传入方式如SYS_WB_LIST
	 * @param $value mixed 设置的值
	 * @param $vars array 要替换的键值对，如array('{domain}' => '183.com', '{mailbox}' =>
	 *        'cqy@183.com')
	 * @param $isMd5 boolean
	 * @return boolean 成功返回TRUE，否则FALSE
	 */
	public static function setData($key, $value, $vars = array(), $isMd5 = true, $expire = 0) {
		if ($vars) {
			$key = str_replace( array_keys( $vars ), array_values( $vars ), $key );
		}
		$md5Key = $isMd5 ? md5( $key ) : $key;
		
		if (self::getInstance()->get( $md5Key ) !== FALSE) {
			throw new Exception( "memcache key[" . $key . "] exists!" );
		}
		$data = self::getInstance()->set( $md5Key, $value, 0, $expire );
		
		$message = date( 'H:i:s' ) . "\r\n\tSet data " . ($data ? 'success' : 'failure') . "\r\n\tkey: $key\r\n\tMd5 key: $md5Key\r\n\tValue: " . serialize( $value ) . "\r\n";
		Logger::cacheLog( $message );
		
		return $data;
	}

	/**
	 * 删除memcache的值
	 * 
	 * @param $key string 键名，传入方式如SYS_WB_LIST
	 * @param $vars array 要替换的键值对，如array('{domain}' => '183.com', '{mailbox}' =>
	 *        'cqy@183.com')
	 * @param $isMd5 boolean
	 * @return boolean 成功返回TRUE，否则FALSE
	 */
	public static function deleteData($key, $vars = array(), $isMd5 = true) {
		if ($vars) {
			$key = str_replace( array_keys( $vars ), array_values( $vars ), $key );
		}
		$md5Key = $isMd5 ? md5( $key ) : $key;
		$data = self::getInstance()->delete( $md5Key );
		
		$message = date( 'H:i:s' ) . "\r\n\tDelete " . ($data ? 'success' : 'failure') . ". \r\n\tKey: $key\r\n\tMd5 key: $md5Key\r\n";
		Logger::cacheLog( $message );
		
		return $data;
	}

}