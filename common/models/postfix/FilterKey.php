<?php

/**
 * postfix.filter_key表model:邮件管家中设置的关键字内容
 * 表结构如下：
 * 
 * @property int id
 * @property int fid			Filter表的id
 * @property int block			标题、收件人或者其他条件
 * @property string keycode 关键字
 * @property boolean flag 是否精确匹配1：精确 0：模糊 默认是模糊匹配
 */
class FilterKey extends ActiveRecordExt {

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
		return 'postfix.filter_key';
	}

}