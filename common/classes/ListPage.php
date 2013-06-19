<?php

/**
 * 列表 分页
 */
class ListPage {

	/**
	 * 请求参数数组
	 * 
	 * @var QueryInfo
	 */
	private $_queryInfo = null;

	/**
	 * 数据总记录数
	 */
	private $_total = 0;

	/**
	 * 每页记录数
	 */
	private $_perPage = 25;

	/**
	 * 总页码数
	 */
	private $_totalPage = 0;

	/**
	 * 分页条最多显示的页数
	 * 
	 * @var int
	 */
	private $_linksCount = 5;

	/**
	 * 符合条件的查询结果
	 */
	private $_result = null;

	/**
	 *
	 * @return QueryInfo 获得查询条件数据
	 */
	public function getQueryInfo() {
		return $this->_queryInfo;
	}

	/**
	 * 获取分页条开始结束位置
	 */
	function getLinksPos() {
		$current = $this->getCurrentPageno();
		$last = $this->getTotalPage();
		$avg = ceil( $this->_linksCount / 2 );
		$l_remain = $r_remain = 0;
		$startIndex = $current - $avg;
		if ($startIndex < 1) {
			$l_remain = 1 - $startIndex;
			$startIndex = 1;
		}
		$endIndex = $current + $avg;
		if ($endIndex > $last) {
			$r_remain = $endIndex - $last;
			$endIndex = $last;
		}
		if ($r_remain) {
			$startIndex -= $r_remain;
			if ($startIndex < 1) {
				$startIndex = 1;
			}
		} else if ($l_remain) {
			$endIndex += $l_remain;
			if ($endIndex > $last) {
				$endIndex = $last;
			}
		}
		return array ($startIndex, $endIndex );
	}

	/**
	 *
	 * @return 总数
	 */
	public function getTotal() {
		return $this->_total;
	}

	/**
	 *
	 * @return 总页码数
	 */
	public function getTotalPage() {
		return $this->_totalPage;
	}

	/**
	 * 设置总数
	 */
	public function setTotal($_total) {
		$this->_total = $_total;
		$this->_totalPage = intval( ($_total + $this->_perPage - 1) / $this->_perPage );
	}

	/**
	 *
	 * @return 查询结果
	 */
	public function getResult() {
		return $this->_result;
	}

	/**
	 * 设置结果
	 */
	public function setResult($result) {
		$this->_result = $result;
	}

	/**
	 * 每页显示数量
	 * 
	 * @param $perPage int
	 */
	public function __construct($perPage = null) {
		if ($perPage !== null) {
			$this->_perPage = $perPage;
		}
	}

	/**
	 * 获取每页显示的记录数量
	 */
	public function getPerPage() {
		return $this->_perPage;
	}

	/**
	 * 设置请求对象数据
	 */
	public function setQueryInfo($queryInfo) {
		$this->_queryInfo = $queryInfo;
	}

	/**
	 * 获得查询参数值
	 */
	public function getQueryParamValue($key, $defaultValue = null) {
		if ($this->_queryInfo == null) {
			throw new Exception( "queryInfo未进行初始化" );
		}
		return $this->_queryInfo->getRequestValueByParam( $key, $defaultValue );
	}

	/**
	 * 获得查询开始位置
	 */
	public function getOffset() {
		return ($this->getCurrentPageno() - 1) * ($this->_perPage);
	}

	/**
	 * 获取正确当前页面
	 */
	private function getCurrentPageno() {
		if ($this->getTotalPage() && $this->getQueryInfo()->getCurrentPageno() > $this->getTotalPage()) {
			$this->getQueryInfo()->setCurrentPageno( $this->getTotalPage() );
		}
		return $this->getQueryInfo()->getCurrentPageno();
	}

}