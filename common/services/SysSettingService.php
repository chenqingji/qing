<?php
/**
 * 系统配置service
 * 
 * @author zwm
 */
class SysSettingService extends ActionService {

	/**
	 * 系统设置key
	 */
	const MEMCACHE_KEY_SYS_SYS_SETTING = "select * from postfix.sys_setting";

	/**
	 * 系统端网络硬盘功能配置key
	 */
	const MEMCACHE_KEY_SYS_IS_NDISK = "select is_ndisk from postfix.sys_setting";

	/**
	 * 系统端短信功能配置key
	 */
	const MEMCACHE_KEY_SYS_IS_SMS = "select is_sms from postfix.sys_setting";

	/**
	 * 系统端CDN功能配置key
	 */
	const MEMCACHE_KEY_SYS_IS_CDN = "select is_cdn from postfix.sys_setting";

	/**
	 * 系统端邮件召回配置key
	 */
	const MEMCACHE_KEY_SYS_IS_RECALL = "select is_recall from postfix.sys_setting";

	/**
	 * 系统端邮件传真功能key
	 */
	const MEMCACHE_KEY_SYS_IS_FAX = "select is_fax from postfix.sys_setting";

	/**
	 * 系统端在线客服功能key
	 */
	const MEMCACHE_KEY_SYS_IS_SERVICE = "select is_service from postfix.sys_setting";

	/**
	 * 获取系统配置信息
	 * 
	 * @return SysSetting
	 */
	public function getSysSetting() {
		return SysSetting::model()->find();
	}

	/**
	 * 配置支持事务的方法，将要支持事务的方法加入到数组中
	 * 
	 * @return array 需要支持事务的方法
	 */
	public function getTransactionMethods() {
		return array ("saveSysSetting", "postTypeSetup" );
	}

	/**
	 * 保存系统设置
	 * 
	 * @param $settingData array 设置数据
	 */
	public function saveSysSetting($settingData) {
		$sysSetting = $this->getSysSetting();
		$oldIsSmtp = $sysSetting->is_smtp;
		foreach ( $settingData as $key => $value ) {
			$sysSetting->$key = $value;
		}
		if ($sysSetting->save()) {
			
			ServiceFactory::getRsyncDataService()->rsyncSysSetup( $sysSetting );
			
			$this->deleteSysSettingCache();
			
			PlatformSystemHandler::updateSyssetting( $sysSetting, $oldIsSmtp != $sysSetting->is_smtp );
			return true;
		} else {
			throw new ServiceException( ServiceCode::RSYNC_SYS_SETTING_SETUP_FAILED );
		}
	}

	/**
	 * 移除系统配置缓存
	 */
	private function deleteSysSettingCache() {
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_SYS_SYS_SETTING );
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_SYS_IS_NDISK );
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_SYS_IS_SMS );
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_SYS_IS_CDN );
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_SYS_IS_RECALL );
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_SYS_IS_FAX );
		MemcacheHelper::deleteData( self::MEMCACHE_KEY_SYS_IS_SERVICE );
	}

	/**
	 * 设置邮局类型
	 * 
	 * @param $postType string 邮局类型
	 * @return bool
	 */
	public function postTypeSetup($postType) {
		$sysSetting = $this->getSysSetting();
		$sysSetting->posttype = $postType;
		if ($sysSetting->save() && OSUtils::SysCopyLogoToPost( $postType )) {
			return true;
		} else {
			throw new ServiceException( ServiceCode::RSYNC_SYS_SETTING_POST_TYPE_SETUP_FAILED );
		}
	}
}