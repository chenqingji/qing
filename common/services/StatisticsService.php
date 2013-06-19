<?php

/**
 * 信息统计service类
 * 
 * @author lizhran
 */
class StatisticsService extends ActionService {

	/**
	 * 查询邮局个数，网络硬盘分配空间
	 * 
	 * @return array
	 */
	public function getCountDomainInfo() {
		$db = ConnectionFactory::getConnection( 'db' );
		$info = $db->createCommand()->select( "count(*) as office_num,sum(po_quota) as allot_void,sum(net_quota) as net_allot_void" )->from( "postoffice.domain" )->queryRow();
		return $info;
	}

	/**
	 * 取得分页类中邮件大小列表
	 * 
	 * @param $listPage ListPage
	 * @param $condition string
	 * @param $params array
	 * @return array
	 */
	public function getMailSizeListPage($listPage, $condition, $params) {
		$totalCount = $this->getMailSizeCount( $condition, $params );
		$listPage->setTotal( $totalCount );
		if ($totalCount) {
			$infos = $this->getMailSizeList( $condition, $params, $listPage->getPerPage(), $listPage->getOffset() );
			$listPage->setResult( $infos );
		}
		return $listPage->getResult();
	}

	/**
	 * 获取邮件大小列表
	 * 
	 * @param $condition string where语句
	 * @param $params array where语句绑定的参数
	 * @param $limit int
	 * @param $offset int
	 * @return array
	 */
	public function getMailSizeList($condition, $params, $limit = 0, $offset = 0) {
		$select = 'rec_date, isrcpt, sum(5k) as sum_5k, sum(10k) as sum_10k, sum(50k) as sum_50k, ' . 'sum(100k) as sum_100k, sum(500k) as sum_500k, sum(1m) as sum_1m, sum(5m) as sum_5m, ' . 'sum(10m) as sum_10m,sum(more) as sum_more,sum(sum) as sum_all';
		$command = ConnectionFactory::getConnection( 'db' )->createCommand()->select( $select )->from( 'postfix.mail_size' )->where( $condition, $params )->group( 'rec_date' );
		if ($limit || $offset) {
			$command->limit( $limit, $offset );
		}
		$infos = $command->queryAll();
		return $infos;
	}

	/**
	 * 获取邮件大小总数
	 * 
	 * @param $condition string where语句
	 * @param $params array where语句绑定的参数
	 * @return int
	 */
	public function getMailSizeCount($condition, $params) {
		$result = ConnectionFactory::getConnection( 'db' )->createCommand()->select( "count(distinct(rec_date)) number" )->from( 'postfix.mail_size' )->where( $condition, $params )->queryRow();
		return $result ? $result ['number'] : 0;
	}

}