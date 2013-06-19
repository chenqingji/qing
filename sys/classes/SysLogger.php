<?php

/**
 * 日志组件类,使用该类配合config等日志配置进行日志记录的输出
 * 
 * @author jm
 */
class SysLogger {

    /**
     * 私有构造方法不允许该类实例化
     */
    private function __construct() {
        
    }

    /**
     * 生成系统端weblog日志，该部分日志是operlog数据库的数据部分。type=0
     */
    public static function log($message) {
        Logger::webLog($message, SysSessionUtil::getSysLoginUser()->getUsername(), Operlog::SYS_LOG_TYPE);
    }

}
