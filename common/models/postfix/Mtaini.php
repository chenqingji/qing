<?php

/**
 * This is the model class for table "mtaini".
 * 
 * @author cqy
 *         The followings are the available columns in table 'mtaini':
 * @property integer $id
 * @property integer $smtpd_rcpt_limit
 * @property string $message_size_limit
 * @property string $attachment_count
 * @property integer $is_nofrom
 * @property integer $is_sasl
 * @property integer $con_count
 * @property integer $connection_rate_limit
 * @property string $time_unit_con
 * @property integer $mail_rate_limit
 * @property string $time_unit_mail
 * @property integer $rcpt_rate_limit
 * @property string $time_unit_rcpt
 * @property integer $tag_score
 * @property integer $tag2_score
 * @property integer $intercept_score
 * @property integer $kill_score
 * @property string $spam_mail
 */
class Mtaini extends ActiveRecordExt {

	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @param $className string active record class name.
	 * @return Mtaini the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model( $className );
	}

	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'postfix.mtaini';
	}

}