<?php

/**
 * 项目配置常量
 * 
 * @author jm
 */
class Constants {
	
	
	/**
	 * logo路径
	 */
	const LOGO_PATH = "/var/www/html/logo/";
	
	
	/**
	 * 登录多少次后显示验证码3
	 */
	const SHOW_AUTHCODE_NUM = 3;
        
        /**
         * pay功能文件上传目录
         */
        const UPLOAD_DIR_PAY = "/var/www/html/data/qing/upload/";
        
        /**
         * pay功能文件上传重新命名的前缀
         */
        const PREFIX_NAME_FOR_PAY_UPLOAD_FILE = 'pay-';
	

}
