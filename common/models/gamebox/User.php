<?php

/**
 * 用户表
 */
class User extends ActiveRecordExt {
	
	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @param $className string active record class name.
	 * @return user the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model( $className );
	}

	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'user';
	}

}