<?php
/**
 * 关键字过滤service类
 * 
 * @author dengr
 */
class KeywordFilterService extends ActionService {

	public function getTransactionMethods() {
		return array ("updateActiveByIdsAndType", "deleteSpamRuleByIds" );
	}

	/**
	 * 获取分页列表对象
	 * 
	 * @param $listPage 分页参数
	 * @param $ruleName 规则名
	 * @param $searchCondition 查询条件（发送人 收件人 正文等）
	 * @param $searchKeyword 关键字
	 * @param $searchActive 行为
	 * @param $searchTime 时间
	 * @param $searchStatus 状态
	 */
	public function getKeywordFilterListPage($listPage, $ruleName, $searchCondition, $searchKeyword, $searchActive, $searchTime, $searchStatus) {
		$criteria = new CDbCriteria();
		if (trim( $ruleName ) !== "") {
			$criteria->addSearchCondition( "rulename", $ruleName, true );
		}
		if ($searchCondition != "-1") {
			$criteria->compare( "mail_condition", $searchCondition );
		}
		if (trim( $searchKeyword ) !== "") {
			$criteria->addSearchCondition( "keyword", $searchKeyword, true );
		}
		if ($searchActive != "-1") {
			$criteria->compare( "action", $searchActive );
		}
		if (trim( $searchTime ) !== "") {
			$criteria->addSearchCondition( "time", $searchTime, true );
		}
		if ($searchStatus != "-1") {
			$criteria->compare( "active", $searchStatus );
		}
		$criteria->order = "time desc";
		$totalCount = SpamRule::model()->count( $criteria );
		$listPage->setTotal( $totalCount );
		if ($totalCount > 0) {
			$resultList = null;
			$criteria->limit = $listPage->getPerPage();
			$criteria->offset = $listPage->getOffset();
			$queryResult = SpamRule::model()->findAll( $criteria );
			$listPage->setResult( $queryResult );
		}
	}

	/**
	 * 获取SpamRule对象通过id
	 * 
	 * @param $id 主键id
	 */
	public function getSpamRuleById($id) {
		return SpamRule::model()->findByPk( $id );
	}

	/**
	 * 获取SpamRule对象通过规则名
	 * 
	 * @param $name 规则名
	 */
	public function getSpamRuleByName($name) {
		$db = ConnectionFactory::getConnection( 'db' );
		$result = $db->createCommand()->select( "*" )->from( 'postfix.spam_rule' )->where( 'rulename=:rulename', array (
				':rulename' => $name ) )->queryRow();
		return $result;
	}

	/**
	 * 判断修改时是否重名 true重名 false不重名
	 * 
	 * @param $name 规则名
	 * @param $id 主键id
	 */
	public function checkSpamRuleNameExist($name, $id) {
		$db = ConnectionFactory::getConnection( 'db' );
		$result = $db->createCommand()->select( "*" )->from( 'postfix.spam_rule' )->where( 'rulename=:rulename and id<>:id', array (
				':rulename' => $name, 
				':id' => $id ) )->queryRow();
		return ! empty( $result ) ? true : false;
	}

	/**
	 * 保存spamRule对象
	 * 
	 * @param $spamRule
	 */
	public function saveSpamRule($spamRule) {
		return $spamRule->save();
	}

	/**
	 * 获取SpamRule对象数组
	 * 
	 * @param $ids id串
	 */
	public function findSpamRulesByIds($ids, $type) {
		$criteria = "";
		if ($type == "enable") {
			$criteria = " and active=0";
		}
		if ($type == "disable") {
			$criteria = " and active=1";
		}
		return SpamRule::model()->findAll( "id in (" . $ids . ")" . $criteria );
	}

	/**
	 * 批量修改状态
	 * 
	 * @param $ids id串
	 * @param $type 状态类型
	 */
	public function updateActiveByIdsAndType($ids, $type) {
		$time = date( "Y-n-j H:i:s" );
		if ($type == "enable") {
			$oper = "启用关键字过滤 ";
		}
		if ($type == "disable") {
			$oper = "禁用关键字过滤 ";
		}
		$criteria = "";
		if ($type == "enable") {
			$criteria = " and active=0";
		}
		if ($type == "disable") {
			$criteria = " and active=1";
		}
		$spamRules = SpamRule::model()->findAll( "id in (" . $ids . ")" . $criteria );
		foreach ( $spamRules as $spamRule ) {
			if ($type == "enable") {
				$spamRule->active = 1;
			}
			if ($type == "disable") {
				$spamRule->active = 0;
			}
			$spamRule->time = $time;
			$spamRule->save();
			SysLogger::log( $oper . $spamRule ['rulename'] );
		}
	}

	/**
	 * 批量删除
	 * 
	 * @param $ids id串
	 */
	public function deleteSpamRuleByIds($ids) {
		$spamRules = SpamRule::model()->findAll( "id in (" . $ids . ")" );
		foreach ( $spamRules as $spamRule ) {
			$spamRule->delete();
			SysLogger::log( "删除关键字过滤 " . $spamRule ['rulename'] );
		}
	}

}