<?php
/**
 * postfix.gardendomain表model:邮件收发限制表
 * 表结构如下：
 * 
 * @property int id
 * @property int fid 对应postfix.filter表id
 * @property string domain 限制的域
 * @property int type 1-仅对指定域的邮件发送限制 2-排除指定域的邮件发送限制 3-仅对指定域的邮件接收限制 4-排除指定域的邮件接收限制
 */
class TransceiverLimit extends ActiveRecordExt {

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
		return 'postfix.gardendomain';
	}

}