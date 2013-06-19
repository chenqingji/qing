<?php

/**
 * 日志查询对象封装类
 * postfix.operlog表model:日志表
 * 表结构如下：
 * 
 * @property int id
 * @property string admin_user		管理员名
 * @property string oper			操作动作
 * @property string created_at 操作时间
 * @property string ip 登录IP
 * @property int type 0:系统管理员1:邮局管理员2：邮箱用户
 */
class Operlog extends ActiveRecordExt {

	/**
	 * 系统日志类型
	 */
	const SYS_LOG_TYPE = 0;

	/**
	 * 管理员日志类型
	 */
	const ADMIN_LOG_TYPE = 1;

	/**
	 * 邮箱日志类型
	 */
	const MAIL_LOG_TYPE = 2;

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
		return 'postfix.operlog';
	}

}

?>
