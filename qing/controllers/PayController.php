<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categoryController
 *
 * @author asus
 */
class PayController extends SysController {

        /**
         * 默认
         */
        public function index() {
                $this->toList();
        }

        /**
         * 添加页面
         */
        public function toAdd($tips = '') {
                $this->toEdit($tips);
        }

        /**
         * 编辑修改页面
         */
        public function toEdit($tips = '') {
                $tpl = new TemplateEngine();
                $id = $this->getParamFromRequest('id', null);
                $isEdit = false;
                if ($id) {
                        $isEdit = true;
                        $payModel = ServiceFactory::getPayService()->getPayById($id);
                        $tpl->assign('payModel', $payModel);
                }
                $tpl->displayWithMain('pay_edit.tpl');
        }

        /**
         * 列表页面
         */
        public function toList($tips = '') {
                $rows = ServiceFactory::getPayService()->getPayList();

                $tpl = new TemplateEngine();
                $tpl->assign('rows', $rows);
                $tpl->displayWithMain('pay_list.tpl');
        }

        /**
         * 增加、修改操作
         */
        public function edit() {
                $id = $this->getParamFromRequest('id');
                $project = $this->getParamFromRequest('project', '');
                $payer = $this->getParamFromRequest('payer', '');
                $pay = $this->getParamFromRequest('pay', 0.00);
                $date = strtotime($this->getParamFromRequest('date'));
                $note = $this->getParamFromRequest('note', '');

                if ($id) {
                        $payModel = ServiceFactory::getPayService()->getPayById($id);
                } else {
                        $payModel = new Pay();
                }
                $payModel->project = $project;
                $payModel->pay = $pay;
                $payModel->payer = $payer;
                $payModel->date = $date;
                $payModel->note = $note;
                if (ServiceFactory::getPayService()->savePay($payModel)) {
                        $message = "<em class='valid'>操作成功</em>";
                } else {
                        $message = "<em class='warn'>操作失败</em>";
                }
                $id ? $this->toEdit($message) : $this->toAdd($message);
        }

        /**
         * 删除
         */
        public function delete() {
                $ids = $this->getParamFromRequest('ids', null);
                if (empty($ids)) {
                        $ids = $this->getParamFromRequest('id');
                }
                $lines = 0;
                if ($ids) {
                        if (!is_array($ids)) {
                                $idArray = explode(',', $ids);
                        } else {
                                $idArray = $ids;
                        }
                        $ids = implode(',', $idArray);
                        $lines = ServiceFactory::getPayService()->deletePaysByIds($ids);
                }
                $message = "<em class='valid'>成功删除" . $lines . "条记录</em>";
                $this->toList($message);
        }

        /**
         * 排序
         */
        public function sort() {
                $payIds = $this->getParamFromRequest('payIds');
                $paySorts = $this->getParamFromRequest('paySorts');
                $affectedRwos = 0;

                if (is_array($payIds) && is_array($paySorts)) {
                        rsort($paySorts);
                        $affectedRows = ServiceFactory::getPayService()->updateSortsByIds($payIds, $paySorts);
                }
                $message = "<em class='valid'>成功排序" . $affectedRows . "条记录</em>";
                $this->toList($message);
        }

        /**
         * 在线编辑器
         */
        public function editor() {
                $tpl = new TemplateEngine();
                $tpl->displayWithMain('pay_editor.tpl');
        }

        /**
         * 发表文章
         */
        public function issue() {
//                $dir = "/var/www/html/data/editor/";
//                if (!file_exists($dir)) {
//                        mkdir($dir, 0755, TRUE);
//                }
//                $filename = $dir . "ueditor_" . date('Y-m-d');
//                $prepend = "\n\n" . date('Y-m-d H:i:s') . "\n";
//                $content = $this->getParamFromRequest('content', 'chenqingji');
//                $fp = fopen($filename, 'w');
//                fputs($fp, $prepend . $content);
//                fclose($fp);

                $content = $this->getParamFromRequest('content');
                $issueDemoService = ServiceFactory::getIssueDemoService();
                $issueDemo = $issueDemoService->getIssueDemoModel();
                $issueDemo->content = $content;
                $rtn = $issueDemoService->addIssue($issueDemo);
                echo $rtn;
                exit;
        }

        /**
         * 文章列表
         */
        public function issues() {
                
        }

        /**
         * 文章显示
         */
        public function show() {
//                $filename = "/var/www/html/data/editor/ueditor_" . date('Y-m-d');
//                $content = file_get_contents($filename);
                $id = $this->getParamFromRequest('id');
                $issueDemoService = ServiceFactory::getIssueDemoService();
                $issue = $issueDemoService->getNewestIssue();

                $tpl = new TemplateEngine();
                $tpl->assign('issue', $issue);
                $tpl->displayWithMain('pay_show.tpl');
        }

        /**
         * 上传文件
         */
        public function toUpload() {
                session_start();
                $sessionId = session_id();

                $tpl = new TemplateEngine();
                $tpl->assign('sessionId', $sessionId);
                $tpl->displayWithMain('pay_toUpload.tpl');
        }

        /**
         * 提交照片及照片相关信息
         */
        public function addFile() {
                $note = $this->getParamFromRequest('note');
                $files = $this->getParamFromRequest('files');

//                $fileString = is_array($files) ? implode(',', $files) : '';

                $imageDemoService = ServiceFactory::getImageDemoService();
                foreach ($files as $fileString) {
                        $imageDemoModel = $imageDemoService->getImageDemoModel();
                        $imageDemoModel->note = $note;
                        $imageDemoModel->name = $fileString;

                        $filePath = "/var/www/html/data/qing/"
                                . date("Y", time()) . "/"
                                . date("m", time()) . "/"
                                . date("d") . "/thumb_" . $fileString;
                        $imageHeight = ImageHelper::getHeight($filePath);

                        $imageDemoModel->height = $imageHeight ? $imageHeight : 0;
                        $imageDemoService->addImage($imageDemoModel);
                }
                $this->toUpload();
        }

        /**
         * 图片列表
         */
        public function uploadList() {
                $time = time();
                $imageDemoService = ServiceFactory::getImageDemoService();
                $images = $imageDemoService->getImageByUpdatedTime($time);

                $tpl = new TemplateEngine();
                $tpl->assign('images', $images);
                $allImageHtml = $tpl->fetchHtml('pay_image.tpl');
                
                $tpl->assign('allImageHtml',$allImageHtml);
                $tpl->displayWithMain('pay_uploadList.tpl');
        }
        
        /**
         * ajax请求获得更多图片
         */
        public function getMoreUploadList(){
                $time = $this->getParamFromRequest('lastupdatedtime',null);
                if(is_null($time)){
                        $time = time();
                }
                $imageDemoService = ServiceFactory::getImageDemoService();
                $images = $imageDemoService->getImageByUpdatedTime($time);                
                $tpl = new TemplateEngine();
                $tpl->assign('images', $images);
                $allImageHtml = $tpl->fetchHtml('pay_image.tpl');       
                echo $allImageHtml;
                exit;
        }

        /**
         * 单独页面图片列表
         */
        public function uploadListOuter() {
                $time = time();
                $imageDemoService = ServiceFactory::getImageDemoService();
                $images = $imageDemoService->getImageByUpdatedTime($time);

                $tpl = new TemplateEngine();
                $tpl->assign('images', $images);
                $allImageHtml = $tpl->fetchHtml('pay_image.tpl');
                $tpl->assign('allImageHtml',$allImageHtml);
                
                $tpl->display('pay_uploadList_outer.tpl');
        }

}

?>
