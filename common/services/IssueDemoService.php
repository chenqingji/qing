<?php
/**
 * 编辑
 * 
 * @author jm
 */
class IssueDemoService extends ActionService {

        /**
         * 预备一个IssueDemo对象
         * @return IssueDemo
         */
        public function getIssueDemoModel(){
                return new IssueDemo();
        }
        
        /**
         * 获取所有编辑记录 @todo 加入列表翻页功能
         * @return array
         */
        public function getAllIssue(){
                return IssueDemo::model()->findAll();
        }
        
        /**
         * 通过id获取一条编辑记录
         * @param type $demoId
         * @return CActiveRecord
         */
        public function getIssueById($demoId){
                return IssueDemo::model()->findByPk($demoId);
        }
        
        /**
         * 获取最新的一条编辑记录
         * @return CActiveRecord
         */
        public function getNewestIssue(){
                $sql = "select * from qing.issueDemo order by id desc limit 1";
                return IssueDemo::model()->findBySql($sql);
        }
        
        /**
         * 增加一条编辑记录
         * @param IssueDemo $issueDemo
         * @return boolean
         */
        public function addIssue($issueDemo){
                if (is_object($issueDemo)) {
                        if (!isset($issueDemo->createdTime) || empty($issueDemo->createdTime)) {
                                $issueDemo->createdTime = time();
                        }
                        $issueDemo->updatedTime = time();
                }               
                return $issueDemo->save();
                
        }
        
        /**
         * 更新编辑记录
         * @param IssueDemo $issueDemo
         * @return boolean
         */
        public function updateIssue($issueDemo){
                if (is_object($issueDemo)) {
                        $issueDemo->updatedTime = time();
                }                  
                return $issueDemo->update();
        }

}
