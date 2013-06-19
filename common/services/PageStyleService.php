<?php
/**
 * 邮箱页面风格样式service
 * 
 * @author lizhran
 */
class PageStyleService extends ActionService {

	/**
	 * 根据id获取邮箱风格信息
	 * 
	 * @param $id int
	 */
	public function findStyleById($id) {
		return PageStyle::model()->findByPk( $id );
	}

	/**
	 * 查询所有邮箱风格信息
	 * 
	 * @return array 所有邮箱页面样式
	 */
	public function findAllStyle() {
		$criteria = new CDbCriteria();
		$criteria->order = "id asc";
		return PageStyle::model()->findAll( $criteria );
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
		return PageStyle::model()->find( $sql, $params );
		;
	}

	/**
	 * 根据样式id删除样式
	 * 
	 * @param $ids string @int
	 */
	public function deleteStyleByIds($ids) {
		return PageStyle::model()->deleteAll( "id in ($ids)" );
	}

	/**
	 * 根据ids查询邮箱风格页面样式信息
	 * 
	 * @param $ids string 邮箱风格页样式ids
	 */
	public function findStylesByIds($ids) {
		return PageStyle::model()->findAll( "id in ($ids)" );
	}
}