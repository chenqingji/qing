<?php

/**
 * 模型扩展类
 * 
 * @author jm
 */
class ActiveRecordExt extends CActiveRecord {

	/**
	 * 获取Connection
	 * 
	 * @return CDbConnection
	 */
	public function getDbConnection() {
		return ConnectionFactory::getConnection( 'db' );
	}

}