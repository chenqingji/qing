<?php

/**
 * pay管理service
 * 
 * @author jm
 */
class PayService extends ActionService {

        /**
         * 通过预付人查询出入信息
         * @param type $payer
         * @return Pay
         */
        public function getPaysByPayer($payer) {
                $criteria = new CDbCriteria();
                $criteria->compare('payer', $payer);
                return Pay::model()->find($criteria);
        }

        /**
         * 获取所有的出入信息列表
         * @return array
         */
        public function getPayList() {
                $criteria = new CDbCriteria();
                $criteria->mergeWith(array('order' => 'sort desc'));
                return Pay::model()->findAll($criteria);
        }

        /**
         * 根据id查找出入信息
         * @param type $id
         * @return Pay
         */
        public function getPayById($id) {
                return Pay::model()->findByPk($id);
        }

        /**
         * 保存/修改出入信息
         * @param Pay $payModel
         * @return boolean
         */
        public function savePay($payModel) {
                if (is_object($payModel)) {
                        if (!isset($payModel->createdTime) || empty($payModel->createdTime)) {
                                $payModel->createdTime = time();
                        }
                        if (!isset($payModel->sort) || empty($payModel->sort)) {
                                $payModel->sort = $this->findMaxSort() + 1;
                        }
                        $payModel->updatedTime = time();
                }
                return $payModel->save();
        }

        /**
         * 根据ids删除出入信息
         * @param type $ids
         * @return int 影响行数
         */
        public function deletePaysByIds($ids) {
                return Pay::model()->deleteAll("id in (" . $ids . ")");
        }

        /**
         * 根据ids查询出入信息
         * @param string $ids
         * @return array
         */
        public function findPaysByIds($ids) {
                return Pay::model()->findAll("id in ($ids)");
        }

        /**
         * 获取已知最大排序
         * @return type
         */
        public function findMaxSort() {
                $payModel = pay::model()->findBySql("select * from " . pay::model()->tableName() . " order by sort desc limit 1");
                return $payModel->sort;
        }

        /**
         * 更新记录排序值
         * @param type $payIds 出入数值
         * @param type $paySorts 顺序数值
         * @return int 影响条数
         */
        public function updateSortsByIds($payIds, $paySorts) {
                $sql = "update pay set sort = case id ";
                foreach ($payIds as $key => $id) {
                        $sql .= " when " . $id . " then " . $paySorts[$key];
                        $ids .= $id . ',';
                }
                $ids = rtrim($ids, ',');
                $sql .= " end where id in(" . $ids . ")";
                $conn = yii::app()->db;
                return $conn->createCommand($sql)->execute();
        }

}
