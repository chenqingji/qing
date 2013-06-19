<?php
/**
 * 日志查询相关service
 * 
 * @author zcs
 */
class OperlogService extends ActionService {

	/**
	 * 查询分页使用方法
	 * 
	 * @param $listPage ListPage 分页对象
	 * @param $type int 日志类型
	 * @param $domain array 邮局数组
	 */
	public function getOperlogListPage($listPage, $type, $domain = NULL, $users = NULL) {
		$criteria = new CDbCriteria();
		$criteria->compare( 'type', $type );
		
		if ($domain != NULL) {
			$createTime = $domain ['cr_time'];
			$domainName = $domain ['domain'];
			if ($type == Operlog::ADMIN_LOG_TYPE) {
				if ($users->getRole() == 'super' || $users->getRole() == 'boss') {
					$criteria->addCondition( "(admin_user like '%@{$domainName}(%' or admin_user='{$domainName}') and created_at>'{$createTime}'" );
				} else {
					$criteria->addCondition( " admin_user like '{$users->getUsername()}%' and created_at>'{$createTime}'" );
				}
			} else if ($type == Operlog::MAIL_LOG_TYPE) {
				$criteria->addCondition( " (admin_user like '%@{$domainName}%' or admin_user='{$domainName}') and created_at>'{$createTime}' and oper like '用户登录%'" );
			}
		}
		
		$searchKey = $listPage->getQueryParamValue( "search_key" );
		$searchValue = $listPage->getQueryParamValue( "search_val" );
		if (! empty( $searchKey ) && ! empty( $searchValue )) {
			$criteria->addSearchCondition( $searchKey, $searchValue );
		}
		$totalCount = Operlog::model()->count( $criteria );
		$listPage->setTotal( $totalCount );
		
		if ($totalCount > 0) {
			if ($listPage->getQueryInfo()->getSortKey() != null && $listPage->getQueryInfo()->getSortType() != null) {
				$criteria->order = "{$listPage->getQueryInfo()->getSortKey()} {$listPage->getQueryInfo()->getSortType()}";
			}
			$criteria->limit = $listPage->getPerPage();
			$criteria->offset = $listPage->getOffset();
			
			$queryResult = Operlog::model()->findAll( $criteria );
			$listPage->setResult( $queryResult );
		}
	}

	/**
	 * 获取查询结果
	 * 
	 * @param $listPage ListPage 分页对象
	 * @param $type int 日志类型
	 * @param $domain array 邮局数组
	 */
	public function getOperlogResult($listPage, $type, $domain = NULL, $users = NULL) {
		$criteria = new CDbCriteria();
		$criteria->compare( 'type', $type );
		if (is_array( $domain )) {
			$createTime = $domain ['cr_time'];
			$domainName = $domain ['domain'];
			
			if ($type == 1) {
				if ($users->getRole() == 'super' || $users->getRole() == 'boss') {
					$criteria->addCondition( "(admin_user like '%@{$domainName}(%' or admin_user='{$domainName}') and created_at>'{$createTime}'" );
				} else {
					$criteria->addCondition( " admin_user like '{$users->getUsername()}%' and created_at>'{$createTime}'" );
				}
			
			}
			if ($type == 2) {
				$criteria->addCondition( " (admin_user like '%@{$domainName}%' or admin_user='{$domainName}') and created_at>'{$createTime}' and oper like '用户登录%'" );
			}
		}
		$searchKey = $listPage->getQueryParamValue( "searchkey" );
		$searchValue = $listPage->getQueryParamValue( "searchval" );
		if (! empty( $searchKey ) && ! empty( $searchValue )) {
			$criteria->addSearchCondition( $searchKey, $searchValue );
		}
		if ($listPage->getQueryInfo()->getSortKey() != null && $listPage->getQueryInfo()->getSortType() != null) {
			$criteria->order = "{$listPage->getQueryInfo()->getSortKey()} {$listPage->getQueryInfo()->getSortType()}";
		}
		$queryResult = Operlog::model()->findAll( $criteria );
		
		return $queryResult;
	}

	/**
	 * 格式化结果数据用于输出
	 * 
	 * @param $result array
	 *
	 */
	private function formatResult($result) {
		$admin_user = $result ['admin_user'];
		$cr_date = $result ['created_at'];
		$ip = $result ['ip'];
		$oper = $result ['oper'];
		$type = $result ['type'];
		return array ('admin_user' => $admin_user, 'cr_date' => $cr_date, 'ip' => $ip, 'oper' => $oper, 'type' => $type );
	}

	/**
	 * 获取组装的表格数据
	 * 
	 * @param $myresult array
	 */
	public function getTableData($myresult) {
		$tableData = array ();
		foreach ( $myresult as $result ) {
			$tableData [] = $this->formatResult( $result );
		}
		return $tableData;
	}

	/**
	 *
	 * @param $type int 日志类型
	 */
	public function deleteAll($type) {
		return Operlog::model()->deleteAll( 'type=:type', array (':type' => $type ) );
	}
	
	
	/**
	 * 相应域名的邮箱操作日志记录更换主域名
	 * @param type $oldDomainName
	 * @param type $newDomainName 
	 */
	public function replaceDomainNameWithMailboxOperate($oldDomainName,$newDomainName){
		$db = ConnectionFactory::getConnection('db');
		$sql = "update postfix.operlog set admin_user=REPLACE(admin_user,'@" . $oldDomainName . "','@" . $newDomainName . "') where admin_user like '%@" . $oldDomainName . "'";
		$db->createCommand($sql)->execute();		
	}
	
	/**
	 * 相应域名的邮局操作日志记录更换主域名
	 * @param type $oldDomainName
	 * @param type $newDomainName 
	 */
	public function replaceDomainNameWithPostOperate($oldDomainName,$newDomainName){
		$db = ConnectionFactory::getConnection('db');
		$sql = "update postfix.operlog set admin_user='" . $newDomainName . "' where admin_user='" . $oldDomainName . "'";
		$db->createCommand($sql)->execute();		
	}
	/**
	 * 更换表中相应邮局的主域名
	 * @param type $oldDomainName
	 * @param type $newDomainName 
	 */
	public function replaceDomainName($oldDomainName,$newDomainName){
		$this->replaceDomainNameWithMailboxOperate($oldDomainName, $newDomainName);
		$this->replaceDomainNameWithPostOperate($oldDomainName, $newDomainName);
	}	
}
