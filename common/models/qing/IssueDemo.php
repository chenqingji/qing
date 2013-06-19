<?php

/**
 * This is the model class for table "issueDemo".
 * The followings are the available columns in table 'issueDemo':
 */
class IssueDemo extends ActiveRecordExt {

	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @param $className string active record class name.
	 * @return IssueDemo the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model( $className );
	}

	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'qing.issueDemo';
	}
}