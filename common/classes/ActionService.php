<?php

/**
 * 业务逻辑层基类
 * 
 * @author jm
 */
class ActionService {

	/**
	 * 配置支持事务的方法，将要支持事务的方法加入到数组中
	 * 
	 * @return array 如array('getMailboxName', 'addMail')
	 */
	public function getTransactionMethods() {
		return array ();
	}

}