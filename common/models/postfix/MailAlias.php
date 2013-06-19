<?php
/**
 * postfix.mail_alias表model:实现邮件列表、邮箱别名和域别名
 * 表结构如下：
 * 
 * @property int id
 * @property int mb_id 邮箱id
 * @property int po_id 邮局id
 * @property string goto 目标地址
 * @property string address 源地址
 * @property int type 别名类型 1:邮箱别名 2:列表名 3:列表成员 4:域别名
 * @property string note 备注
 * @property int range 列表授权
 * @property int goto_id 邮箱别名使用，邮箱 id
 * @property int alias_login 是否支持别名登录
 */
class MailAlias extends ActiveRecordExt {

	/**
	 * 邮箱别名
	 */
	const TYPE_MAILBOX_ALIAS = 1;

	/**
	 * 邮件列表对应记录
	 */
	const TYPE_MAIL_LIST = 2;

	/**
	 * 邮件列表明细对应记录
	 */
	const TYPE_MAIL_LIST_DETAIL = 3;

	/**
	 * 域别名
	 */
	const TYPE_DOMAIN_ALIAS = 4;

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
		return 'postfix.mail_alias';
	}

}

?>
