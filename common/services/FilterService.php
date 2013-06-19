<?php
/**
 * 邮件管家：邮件监控、邮件审核、邮件外发控制service
 * 
 * @author zwm
 */
class FilterService extends ActionService {

	/**
	 * 根据邮箱地址删除邮箱的邮件监控、邮件审核、邮件外发控制等信息
	 * 
	 * @param $username string
	 */
	public function deleteFilterByMbId($username) {
		$filters = Filter::model()->findAll( "object='{$username}' or action='{$username}'" );
		foreach ( $filters as $filter ) {
			ServiceFactory::getFilterKeyService()->delteFilterKeyByFilterId( $filter->id );
			ServiceFactory::getTransceiverLimitService()->delteTransceiverLimitByFilterId( $filter->id );
		}
		Filter::model()->deleteAll( "object='{$username}' or action='{$username}'" );
	}
	
	/**
	 * 指定邮局邮件管家相关记录object字段（被监控、被审核人等）更换主域名
	 * @param type $oldDomainName
	 * @param type $newDomainName 
	 */
	public function replaceObjectDomainName($oldDomainName,$newDomainName){
		$db = ConnectionFactory::getConnection('db');		
		$sql = "update postfix.filter set object=REPLACE(object,'@" . $oldDomainName . "','@" . $newDomainName . "') where object like '%@" . $oldDomainName . "'";
		$db->createCommand($sql)->execute();		
	}
	/**
	 * 指定邮局邮件管家相关记录action字段（监控人、审核人等）更换主域名
	 * @param type $oldDomainName
	 * @param type $newDomainName 
	 */
	public function replaceActionDomainName($oldDomainName,$newDomainName){
		$db = ConnectionFactory::getConnection('db');		
		$sql = "update postfix.filter set action=REPLACE(action,'@" . $oldDomainName . "','@" . $newDomainName . "') where action like '%@" . $oldDomainName . "'";
		$db->createCommand($sql)->execute();		
	}	
	/**
	 * 更换主域名，更换邮件管家相关记录主域名
	 * @param type $oldDomainName
	 * @param type $newDomainName 
	 */
	public function replaceDomainName($oldDomainName,$newDomainName){
		$this->replaceActionDomainName($oldDomainName, $newDomainName);
		$this->replaceObjectDomainName($oldDomainName, $newDomainName);
	}
}

?>