<?php
/**
 * 管理员查询服务类
 * 
 * @author jm
 */
class AdminService extends ActionService {

	/**
	 * 通过用户名查询管理员对象
	 * 
	 * @param $username unknown_type
	 */
	public function getAdminByName($name) {
		$criteria = new CDbCriteria();
		$criteria->compare( 'name', $name );
		return Admin::model()->find( $criteria );
	}

	/**
	 * 获取所有的管理员列表
	 */
	public function getAdminList() {
		$criteria = new CDbCriteria();
		$criteria->mergeWith( array ('order' => 'id ASC' ) );
		return Admin::model()->findAll( $criteria );
	}

	/**
	 * 根据id查找管理员信息
	 * 
	 * @param $id string
	 */
	public function getAdminById($id) {
		return Admin::model()->findByPk( $id );
	}

	/**
	 * 保存/修改管理员信息
	 * 
	 * @param $admin model
	 */
	public function saveAdmin($admin) {
		return $admin->save();
	}

	/**
	 * 根据管理员ids删除管理员信息
	 * 
	 * @param $ids string
	 */
	public function deleteAdminByIds($ids) {
		Admin::model()->deleteAll( "id in (" . $ids . ")" );
	}

	/**
	 * 根据ids查询管理员信息
	 * 
	 * @param $ids string 管理员ids
	 */
	public function findAdminsByIds($ids) {
		return Admin::model()->findAll( "id in ($ids) and name !='admin'" );
	}
}
