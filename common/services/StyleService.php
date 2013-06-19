<?php
/**
 * 登录样式service
 * 
 * @author zwm
 */
class StyleService extends ActionService {

	/**
	 * 根据id获取登录样式
	 * 
	 * @param $id int
	 */
	public function findStyleById($id) {
		return Style::model()->findByPk( $id );
	}

	/**
	 * 查询所有登录样式信息
	 */
	public function findAllStyle() {
		$criteria = new CDbCriteria();
		$criteria->order = "id asc";
		return Style::model()->findAll( $criteria );
	}

	/**
	 * 保存样式信息
	 * 
	 * @param $style model
	 * @return boolean
	 */
	public function saveStyle($style) {
		return $style->save();
	}

	/**
	 * 验证传递参数是否存在
	 * 
	 * @param $params array 格式：key使用”:字段名“格式，value为使用值
	 */
	public function getStyleByParams($params) {
		$sql = "(";
		foreach ( $params as $key => $value ) {
			$name = str_replace( ":", "", $key );
			$sql .= "$name=$key or ";
		}
		$sql = substr( $sql, 0, strlen( $sql ) - 3 ) . ")";
		if (array_key_exists( ":id", $params )) {
			$sql .= " and id !=:id ";
		}
		return Style::model()->find( $sql, $params );
		;
	}

	/**
	 * 根据样式id删除样式
	 * 
	 * @param $ids string @int
	 */
	public function deleteStyleByIds($ids) {
		return Style::model()->deleteAll( "id in ($ids)" );
	}

	/**
	 * 根据ids查询登录页样式信息
	 * 
	 * @param $ids string 登录页样式ids
	 */
	public function findStylesByIds($ids) {
		return Style::model()->findAll( "id in ($ids)" );
	}
}