<?php

/**
 * Description of siteContrller
 *
 * @author jm
 */
class SiteController extends SysController {

        /**
         * 登录页面显示
         */
        public function index() {
                $template = new TemplateEngine();
                $template->display('site_login.tpl');
        }
        
        public function login(){
                session_start();
                //在有需要读写session的时候才启用session，比如登录及每次连接请求session验证及一些需要跨页面的session公用
        }

}

?>
