<?php

/**
 * 调用操作系统命令实现的功能封装 - 多个项目可能用到的 - 如果只是某个项目特殊需要用到 ，请写到相应项目class/ServerServiceHelper.php
 * 
 * @author jm
 */
class OSUtils {

    /**
     * 不允许生成对象
     */
    private function __construct() {
        
    }

    /**
     * 删除at定时队列
     */
    public static function removeAtObject($objectId) {
        exec("sudo /usr/bin/atrm {$objectId}");
    }
    

    
    

}
