<?php
/**
 * 系统广告管理封装类
 * postfix.ad_url表model：广告记录表
 * 表结构如下：
 * 
 * @property int id
 * @property string name		广告名
 * @property string url		广告路径
 * @property string note 备注
 */
class Advertisement extends ActiveRecordExt {

	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @param $className string active record class name.
	 * @return Advertisement the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model( $className );
	}

	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'postfix.ad_url';
	}

}