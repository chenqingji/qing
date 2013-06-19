<?php

/**
 * postfix.pagestyle表model:邮箱页面风格表
 * 表结构如下：
 * 
 * @property int id
 * @property string name		页面名称
 * @property string en_name	英文名称
 * @property string path 页面路径
 */
class PageStyle extends ActiveRecordExt {

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
		return 'postfix.pagestyle';
	}
}