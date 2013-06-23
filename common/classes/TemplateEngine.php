<?php

/**
 * TemplateEngine类文件
 * 
 * @author jm
 */
require_once (FrameworkUtils::getPluginPath() . "/smarty/Smarty.class.php");

/**
 * TemplateEngine提供了使用模板引擎的操作接口
 * 
 * @author jm
 * @version 1.0
 */
class TemplateEngine extends Smarty {

        /**
         * 后缀格式
         * 
         * @var string
         */
        private $suffix = '.tpl';

        /**
         * 自定义viewpath
         */
        private $_viewPath = null;

        /**
         * 是否注释型标签
         */
        private $_isCommentTag = false;

        /**
         * 模板引擎构造函数
         */
        function __construct($viewPath = null, $_isCommentTag = false) {
                parent::__construct();
                if ($viewPath !== null) {
                        $this->_viewPath = $viewPath;
                }
                $this->_isCommentTag = $_isCommentTag;
        }
        
        /**
         * 获得模板数据并不直接显示
         * @param type $template 模板文件
         * @param type $cache_id
         * @param type $compile_id
         * @param type $parent
         * @return string
         */
        public function fetchHtml($template = null, $cache_id = null, $compile_id = null, $parent = null){
                $this->setTemplateEngineParameter();
                return $this->fetch($template,$cache_id,$compile_id,$parent,false);
        }

        /**
         * 模板引擎显示方法,为了支持国际化，根据当前选择语言版本自动编译多个编译版本
         */
        public function display($template = null, $cache_id = null, $compile_id = null, $parent = null) {
                $this->setTemplateEngineParameter();
                $this->assign("language", I18nHelper::getCurrentLanguage());
                $this->fetch($template, $cache_id, $compile_id, $parent, true);
        }

        /**
         * 模板引擎显示方法，默认显示框架页main.tpl  右侧部分显示指定的template
         * @param type $template 右侧显示的模板
         * @param type $cache_id
         * @param type $compile_id
         * @param type $parent
         */
        public function displayWithMain($template = null, $cache_id = null, $compile_id = null, $parent = null){
                $rightTemplate = $this->fetchHtml($template, $cache_id, $compile_id, $parent, false);
                $this->assign('right',$rightTemplate);
                $this->setTemplateEngineParameter(true);
                $this->assign("language", I18nHelper::getCurrentLanguage());
                $this->fetch('main.tpl', $cache_id, $compile_id, $parent, true);                
        }

        /**
         * 设置模板引擎相关参数
         * @param type $isMain 是否含有框架页，建议main.tpl存放在views目录下
         */
        private function setTemplateEngineParameter($isMain = false) {
                $this->_viewPath = (!$isMain) ? FrameworkUtils::getCurrentControllerId() : '';
                $this->template_dir = Yii::getPathOfAlias('application.views.' . $this->_viewPath);

                $appId = FrameworkUtils::getAppId();
                $this->compile_dir = Yii::getPathOfAlias('runtime.' . $appId . '.template_c');
                $this->cache_dir = Yii::getPathOfAlias('runtime.' . $appId . '.cache');
                $this->caching = false;

                if ($this->_isCommentTag) {
                        $this->left_delimiter = "<!--{";
                        $this->right_delimiter = "}-->";
                }
        }

}
