<?php
/**
 * postfix.style表model:登录页面表
 * 表结构如下：
 * 
 * @property int id
 * @property string name		页面名称
 * @property string en_name	页面英文名
 * @property string path 页面路径
 */
class Style extends ActiveRecordExt {

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
		return 'postfix.style';
	}
}