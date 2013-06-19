<?php
/**
 * 图片
 * 
 * @author jm
 */
class ImageDemoService extends ActionService {
        
        /**
         * 预备一个ImageDemo对象
         * @return \ImageDemo
         */
        public function getImageDemoModel(){
                return new ImageDemo();
        }

       /**
         * 获取所有图片记录 @todo 加入列表翻页功能
         * @return array
         */
        public function getAllImage(){
                $sql = "select * from qing.imageDemo order by updatedTime desc";
                return ImageDemo::model()->findAllBySql($sql);
        }
        
        /**
         * 通过id获取一条图片记录
         * @param type $demoId
         * @return CActiveRecord
         */
        public function getImageById($demoId){
                return ImageDemo::model()->findByPk($demoId);
        }
        
        /**
         * 增加一条图片记录
         * @param ImageDemo $imageDemo
         * @return boolean
         */
        public function addImage($imageDemo){
                if (is_object($imageDemo)) {
                        if (!isset($imageDemo->createdTime) || empty($imageDemo->createdTime)) {
                                $imageDemo->createdTime = time();
                        }
                        $imageDemo->updatedTime = time();
                }                
                return $imageDemo->save();
                
        }
        
        /**
         * 更新图片记录
         * @param ImageDemo $imageDemo
         * @return boolean
         */
        public function updateImage($imageDemo){
                if (is_object($imageDemo)) {
                        $imageDemo->updatedTime = time();
                }                  
                return $imageDemo->update();
        }
}
