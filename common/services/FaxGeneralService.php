<?php
/**
 * 传真号码段分配明细（针对邮局）service
 * 
 * @author zwm
 */

class FaxGeneralService extends ActionService {

	/**
	 * 根据邮局id获取所有传真号码段分配明细
	 * 
	 * @param $poId int
	 */
	public function findFaxGeneralByPoId($poId) {
		return FaxGeneral::model()->findAll( "po_id = :poId", array (":poId" => $poId ) );
	}

	/**
	 * 根据邮局id删除所有传真号码段分配明细
	 * 
	 * @param $poId int
	 */
	public function deleteFaxGeneralByPoId($poId) {
		FaxGeneral::model()->deleteAll( "po_id = :poId", array (":poId" => $poId ) );
	}

	/**
	 * 根据传真号码段分配明细id，及邮局id,删除邮箱时，同步减少传真号码段已使用数
	 * 
	 * @param $id int
	 * @param $poId int
	 */
	public function reduceUsedNumber($id, $poId) {
		$connection = ConnectionFactory::getConnection( "db" );
		$sql = "update fax_log.fax_general set use_num=use_num-1 where g_id = '$id' and po_id='$poId'";
		$connection->createCommand( $sql )->execute();
	}
	/**
	 * 更换表中相应邮局的主域名
	 * @param type $oldDomainName
	 * @param type $newDomainName 
	 */
	public function replaceDomainName($oldDomainName,$newDomainName){
		$db = ConnectionFactory::getConnection('db');		
		$sql = "update fax_log.fax_general set domain='" . $newDomainName . "' where domain='" . $oldDomainName . "'";
		$db->createCommand($sql)->execute();		
	}	

}

?>