<?php

/**
 * 系统通用日志组件类
 * 
 * @author jm
 */
class Logger {
    /**
     * memcache日志文件名
     */

    const CACHE_LOG_FILE = '/var/log/web_memcache';

    /**
     * WEB操作日志文件名
     */
    const WEB_LOG_FILE = '/var/log/weblog';

    /**
     * API日志目录
     */
    const API_LOG_PATH = '/var/log/api/';


    /**
     * 用来写入memcache日志
     * 
     * @param $message unknown_type
     */
    public static function cacheLog($message) {
        $filename = self::CACHE_LOG_FILE . '_' . date('Y_m_d');
        self::log($filename, $message);
    }

    /**
     * 记录WEB操作日志
     * 
     * @param $message string
     * @param $type int 值 多个项目不同日志type
     * @return type
     */
    public static function webLog($message, $operator, $type = 0) {
        $ip = $_SERVER ['REMOTE_ADDR'] ? $_SERVER ['REMOTE_ADDR'] : '127.0.0.1';
        $time = date("y-m-d H:i:s");
        $msg = "('$operator','" . addslashes($message) . "',$type,'$ip','$time')";
        $msg = str_replace(array("\r\n", "\n"), ' ', $msg) . "\n";

        self::log(self::WEB_LOG_FILE, $msg);
    }

    /**
     * 记录API日志
     * 
     * @param $message string
     */
    public static function apiLog($message) {
        $message = date("H:i:s") . "\t" . $message;
        self::log(self::API_LOG_PATH . 'api_log_' . date('Y-m-d'), $message . "\n");
    }

    /**
     * 写日志
     * 
     * @param $filename string 文件名
     * @param $message string 日志信息
     * @param $mod string 打开模式
     * @throws Exception
     */
    private static function log($filename, $message, $mod = 'a') {
        $handle = @fopen($filename, $mod);
        if (!$handle) {
            // 尝试自动创建日志目录
            $parentFolder = dirname($filename);
            if (!file_exists($parentFolder)) {
                mkdir($parentFolder, 0777);
            }
            $handle = @fopen($filename, $mod);
            if (!$handle) {
                throw new Exception("创建日志文件失败!");
            }
        }

        if (FALSE === @fwrite($handle, $message)) {
            throw new Exception('日志文件写入失败');
        }
        fclose($handle);
    }

}