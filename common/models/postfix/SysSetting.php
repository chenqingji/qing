<?php
/**
 * postfix.sys_setting表model:系统配置数据表
 * 表结构如下：
 * 
 * @property int is_bcc		开通邮件管家 1 是 0 否
 * @property int is_foreign 开通海外转发 1 是 0 否
 * @property int is_session 开通邮件会话 1 是 0 否
 * @property int is_imap 开通IMAP服务 1 是 0 否
 * @property int is_quota 开通无限空间 1 是 0 否
 * @property int is_wap 支持WAP 1 是 0 否
 * @property int is_ad 支持广告 1 是 0 否
 * @property int is_sms 支持短信提醒 1 是 0 否
 * @property int is_ndisk 支持网络硬盘 1 是 0 否
 * @property int is_recall 支持邮件召回 1 是 0 否
 * @property int is_fax 支持邮件传真 1 是 0 否
 * @property int is_cdn CDN加速 1 是 0 否
 * @property int is_fax_start //deprecated服务器传真号区间设置起始号
 * @property int is_fax_end //deprecated 服务器传真号区间设置结束号
 * @property int is_mim 即时通讯 1 是 0 否
 * @property int is_smtp SMTP发信后是否保存到服务器 1 是 0 否
 * @property int is_service 支持在线客服 1 是 0 否
 * @property int is_alias 允许别名登录 1 是 0 否
 * @property string posttype 邮局类型：boss 老板邮局 jinpai 金牌邮局
 * @property int is_pushmail 开通Pushmail 1 是 0 否
 * @property int is_api 开通基础API 1 是 0 否
 */
class SysSetting extends ActiveRecordExt {

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
		return 'postfix.sys_setting';
	}
}