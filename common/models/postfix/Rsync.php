<?php
/**
 * postfix.rsync表model:数据库同步服务器地址（B机）
 * 表结构如下：
 * 
 * @property string ip B机IP
 */
class Rsync extends ActiveRecordExt {

	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @param $className string active record class name.
	 * @return Domain the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model( $className );
	}

	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'postfix.rsync';
	}
}