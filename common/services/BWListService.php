<?php

/**
 * 黑白名单Service类
 * 
 * @author jm
 */
class BWListService extends ActionService {

	/**
	 * 黑白名单缓存
	 */
	const MEMCACHE_KEY_SYS_WB_LIST = 'select * from mailbox.syswblist order by matchmod desc,senderaddr desc,wb desc';

	/**
	 * 查询相应ID的名单列表
	 * 
	 * @param $idArray array
	 * @return array
	 */
	public function getSenderAddrByIds($idArray) {
		$criteria = new CDbCriteria();
		$criteria->select = 'senderaddr';
		$criteria->addInCondition( 'id', $idArray );
		return WbList::model()->findAll( $criteria );
	}

	/**
	 * 获取黑名单或白名单列表
	 * 
	 * @param $wb string 值：'B'或'W'
	 * @return array
	 */
	public function getAllLists($wb) {
		return WbList::model()->findAll( 'wb=:wb', array (':wb' => $wb ) );
	}

	/**
	 * 获取黑名单列表
	 * 
	 * @return array
	 */
	public function getAllBlacklists() {
		return $this->getAllLists( 'B' );
	}

	/**
	 * 获取白名单列表
	 * 
	 * @return array
	 */
	public function getAllWhitelists() {
		return $this->getAllLists( 'W' );
	}

	/**
	 * 获取黑名单或白名单
	 * 
	 * @param $wb string 值：'B'或'W'
	 * @param $email string 黑名单
	 * @return array
	 */
	private function getBlackOrWhiteList($wb, $email) {
		return WbList::model()->find( 'senderaddr=:email and wb=:wb', array (':email' => $email, ':wb' => $wb ) );
	}

	/**
	 * 获取黑名单
	 * 
	 * @param $email string 黑名单
	 * @return array
	 */
	public function getBlacklist($email) {
		return $this->getBlackOrWhiteList( 'B', $email );
	}

	/**
	 * 获取白名单
	 * 
	 * @param $email string 黑名单
	 * @return array
	 */
	public function getWhitelist($email) {
		return $this->getBlackOrWhiteList( 'W', $email );
	}

	/**
	 * 获取黑名单或白名单列表总数
	 * 
	 * @param $wb string
	 * @return int
	 */
	private function getBlackOrWhiteListCount($wb) {
		return WbList::model()->count( 'wb=:wb', array (':wb' => $wb ) );
	}

	/**
	 * 获取黑名单列表总数
	 * 
	 * @return int
	 */
	public function getBlackListCount() {
		return $this->getBlackOrWhiteListCount( 'B' );
	}

	/**
	 * 获取白名单列表总数
	 * 
	 * @return int
	 */
	public function getWhiteListCount() {
		return $this->getBlackOrWhiteListCount( 'W' );
	}

	/**
	 * 添加黑名单或白名单
	 * 
	 * @param $email string
	 * @param $filterMode int
	 * @param $wb string
	 * @return boolean
	 */
	private function save($email, $filterMode, $wb) {
		$wbList = new WbList();
		$wbList->setAttribute( 'senderaddr', $email );
		$wbList->setAttribute( 'matchmod', $filterMode );
		$wbList->setAttribute( 'wb', $wb );
		return $wbList->save();
	}

	/**
	 * 添加黑名单
	 * 
	 * @param $email string
	 * @param $filterMode int
	 * @return boolean
	 */
	public function saveBlacklist($email, $filterMode) {
		$result = $this->save( $email, $filterMode, 'B' );
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_SYS_WB_LIST );
		return $result;
	}

	/**
	 * 添加白名单
	 * 
	 * @param $email string
	 * @param $filterMode int
	 * @return boolean
	 */
	public function saveWhitelist($email, $filterMode) {
		$result = $this->save( $email, $filterMode, 'W' );
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_SYS_WB_LIST );
		return $result;
	}

	/**
	 * 获取所有的黑白名单
	 * 
	 * @return array
	 */
	public function getAll() {
		$criteria = new CDbCriteria();
		$criteria->order = 'wb desc,senderaddr desc';
		return WbList::model()->findAll( $criteria );
	}

	/**
	 * 更新memcache黑白名单缓存数据
	 */
	private function setWBListMemcache() {
		$wbList = $this->getAll();
		$str = '';
		$str1 = '';
		$str2 = '';
		foreach ( $wbList as $row ) {
			$matchmod = $row ['matchmod'];
			$sender = $row ['senderaddr'];
			$wbType = $row ['wb'];
			
			$combinatString = "$matchmod&$wbType&$sender,";
			
			if ($matchmod == 1) {
				if (strpos( $sender, '@' ) === 0) {
					$str1 .= $combinatString;
				} else {
					$str .= $combinatString;
				}
			} else {
				$str2 .= $combinatString;
			}
		}
		$str = rtrim( $str . $str1 . $str2, ',' );
		
		$result = MemcacheHelper::setData( self::MEMCACHE_KEY_SYS_WB_LIST, $str );
		if (! $result) {
			throw new Exception( 'set memcache data failed' );
		}
	}

	/**
	 * 删除黑白名单列表
	 */
	public function deleteLists($idArray = array()) {
		foreach ( $idArray as $id ) {
			WbList::model()->deleteAll( 'id=:id', array (':id' => $id ) );
		}
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_SYS_WB_LIST );
	}

	/**
	 * 配置支持事务的方法，将要支持事务的方法加入到数组中
	 * 
	 * @return array 如array('getMailboxName', 'addMail')
	 */
	public function getTransactionMethods() {
		return array ('saveBlacklist', 'saveWhitelist', 'deleteLists' );
	}

}