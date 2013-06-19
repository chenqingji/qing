<?php
/**
 * 保留上一次该页面请求所有参数，更新最新参数请求
 * 如一次请求中有多个get参数：name age height，下一次请求只提交了age，则更新age参数，name和height保留上一次参数值
 * 
 * @author jm
 */
class QueryInfo {

	/**
	 * 请求参数保存数组
	 */
	private $_requestParams = array ();

	/**
	 * 当前查询页码
	 */
	private $_currentPageno = 1;

	/**
	 * 当前排序字段名称
	 */
	private $_sortKey = null;

	/**
	 * 当前排序字段采用排序方式
	 */
	private $_sortType = null;

	/**
	 *
	 * @return 当前查询页码
	 */
	public function getCurrentPageno() {
		return $this->_currentPageno;
	}

	/**
	 *
	 * @return 当前排序字段名称
	 */
	public function getSortKey() {
		return $this->_sortKey;
	}

	/**
	 *
	 * @return 当前排序字段排序方式
	 */
	public function getSortType() {
		return $this->_sortType;
	}

	/**
	 * 设置当前页码
	 * 
	 * @param $_currentPageno int
	 */
	public function setCurrentPageno($_currentPageno) {
		$this->_currentPageno = $_currentPageno;
	}

	/**
	 * 设置排序字段
	 * 
	 * @param $_sortKey string
	 */
	public function setSortKey($_sortKey) {
		$this->_sortKey = $_sortKey;
	}

	/**
	 * 设置排序方式
	 * 
	 * @param $_sortType int
	 */
	public function setSortType($_sortType) {
		$this->_sortType = $_sortType;
	}

	/**
	 * 保存请求参数
	 * 
	 * @param $key string
	 * @param $value mixed
	 */
	public function addRquestParam($key, $value) {
		$this->_requestParams [$key] = $value;
	}

	/**
	 * 批量添加请求参数
	 * 
	 * @param $params array
	 */
	public function setRequestParams($requestParams = array()) {
		$this->_requestParams = $requestParams;
	}

	/**
	 * 获取查询参数
	 */
	public function getRequestValueByParam($param, $defaultValue = null) {
		if (array_key_exists( $param, $this->_requestParams )) {
			return $this->_requestParams [$param];
		}
		return $defaultValue;
	}
}