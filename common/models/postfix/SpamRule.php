<?php

/**
 * This is the model class for table "spam_rule".
 * The followings are the available columns in table 'spam_rule':
 */
class SpamRule extends ActiveRecordExt {

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
		return 'postfix.spam_rule';
	}
}