<?php
/**
 * 邮件管家中设置的关键字内容service
 * 
 * @author zwm
 */
class FilterKeyService extends ActionService {

	/**
	 * 根据邮件管家过滤规则id删除过滤规则中关键字
	 * 
	 * @param $fileterId int
	 */
	public function delteFilterKeyByFilterId($fileterId) {
		FilterKey::model()->deleteAll( "fid=" . $fileterId );
	}
}
