<?php

/**
 * 登录用户对象
 * 
 * @author jm
 */
class SysLoginUser {

	/**
	 * 用户名
	 */
	private $_username = null;

	/**
	 * 用户id
	 */
	private $_id = null;

	/**
	 * 权限位数组
	 */
	private $_rights = null;

	/**
	 * 返回权限位数组
	 * 
	 * @return the $_rights
	 */
	public function getRights() {
		return $this->_rights;
	}

	/**
	 *
	 * @param $_rights NULL
	 */
	public function setRights($_rights) {
		$this->_rights = $_rights;
	}

	/**
	 *
	 * @return the $_username
	 */
	public function getUsername() {
		return $this->_username;
	}

	/**
	 *
	 * @return the $_id
	 */
	public function getId() {
		return $this->_id;
	}

	/**
	 *
	 * @param $_username NULL
	 */
	public function setUsername($_username) {
		$this->_username = $_username;
	}

	/**
	 *
	 * @param $_id NULL
	 */
	public function setId($_id) {
		$this->_id = $_id;
	}

	/**
	 * 是否是admin超级管理员
	 * 
	 * @return boolean
	 */
	public function isSupperAdmin() {
		return $this->getUsername() == 'admin';
	}
}