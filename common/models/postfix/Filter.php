<?php

/**
 * postfix.filter表model:邮件管家：邮件监控、邮件审核、邮件外发控制
 * 表结构如下：
 * 
 * @property int id
 * @property string rule <br>动作选择:监控、审核或收发控制 收发控制:garden 审核所有发送:audit-send 审核所有接收: audit-rcpt
 *           <br>审核所有:audit-all 监控发送:monitor-send 监控接收:monitor-rcpt 监控所有:monitor-all
 * @property string object 选中对象
 * @property string action 目标对象(收发控制时，该项取值:reject_all、reject_send、reject_recipient)
 * @property string owned 邮局id
 * @property string keyswitch 附加字段，以后扩展
 * @property int bound 范围：对内(0)、对外(1)、或全部(2)
 * @property string gardenset
 *           <br>收发控制的高级设置。有两位数字组成XX。第一位表示发送设置，第二位表示接收设置。0-无，1-仅对指定域限制，2-排除指定域限制。
 *           <br>比如：00-无做任何高级设置，01-仅对指定域进行接收限制
 */
class Filter extends ActiveRecordExt {

	/**
	 * 监控
	 */
	const TYPE_MONITOR = "monitor";

	/**
	 * 审核
	 */
	const TYPE_AUDIT = "audit";

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
		return 'postfix.filter';
	}

}