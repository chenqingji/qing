<?php

/**
 * 服务器配置参数类
 * 
 * @author jm
 */
class Config {

	/**
	 * 是否debug模式
	 */
	const DEBUG_MODE = true;

	/**
	 * 是否支持数据库事务
	 * 注意：mysql数据库事务要求数据库以Innodb数据库引擎进行存储。在数据库表采用该引擎下，将该配置项设置为true，可以更好的保证数据完整性。
	 * 如果A机和B机数据库表引擎采用MyISAM数据库引擎，该配置项配置为true无效，建议修改为false，可以减少程序对事务的判断，以提供数据库操作效率。
	 */
	const DATABASE_TRANSACTION_SUPPORT = true;

	/**
	 * 底层服务器访问配置
	 */
	const PLATFORM_SERVER_ADDRESS = '127.0.0.1'; // IP地址
	const PLATFORM_SOCKET_SERVICE_PORT = 10024; // 端口
	
	/**
	 * Memcache服务器配置
	 */
	const MEMCACHE_SERVER = '127.0.0.1'; // IP地址
	const MEMCACHE_PORT = 11211; // 端口号
	
	/**
	 * A机mysql数据库服务器连接参数,必须
	 */
	const DATABASE_IP = "localhost"; // IP
	const DATABASE_USERNAME = "postfix"; // 用户名
	const DATABASE_PASSWORD = "postfix"; // 密码
        const DATABASE_DEFAULT_DB_NAME = 'postfix';


                /**
	 * 内部API校验访问合法性使用 KEY
	 */
	const API_CHECKSUM_KEY = 'eokjfeopuf2%^ae8*dbn~da';
	
	/**
	 * 内部API允许访问的用户IP
	 */
	public static function getApiAllowUserIps() {
		return array ("192.168.2.212" );
	}
}