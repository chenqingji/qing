<?php
/**
 * 系统权限校验类
 * 
 * @author jm
 */
class SysAccessAuth {

	/**
	 * 校验是否具有当前control、action的操作权限
	 * 
	 * @param $filterChain
	 * @return true 校验通过，false 校验失败
	 */
	public static function checkActionRights($filterChain) {
		$accessValue = self::getAccessValue( $filterChain->controller->id, $filterChain->action->id );
		return self::checkAccessValue( $accessValue );
	}

	/**
	 * 判断是否具有当前权限位对应的权限
	 * 
	 * @param $configValue number 对应的权限位
	 * @return boolean true 具有权限 false 不具有权限
	 */
	private static function checkAccessValue($accessValue) {
		if ($accessValue == SysRightsConfig::NO_ACCESS) {
			return true;
		} else if ($accessValue == SysRightsConfig::LOGIN_ACCESS) {
			if (SysSessionUtil::getSysLoginUser() == null) {
				throw new NoLoginException();
			}
			return true;
		} else {
			$sysLoginUser = SysSessionUtil::getSysLoginUser();
			if ($sysLoginUser == null) {
				throw new NoLoginException();
			}
			$rightsArray = $sysLoginUser->getRights();
			if ($rightsArray [$accessValue] != 1) {
				throw new NoRightsException();
			}
			return true;
		}
	}

	/**
	 * 根据权限获取当前controller可访问的action
	 */
	private static function getAccessValue($controllerId, $actionId) {
		$accessArray = SysRightsConfig::getAccessConfig();
		if (array_key_exists( $controllerId, $accessArray )) {
			$actionArray = $accessArray [$controllerId];
			if (array_key_exists( $actionId, $actionArray )) {
				return $actionArray [$actionId];
			}
		}
		throw new NoRightsException( "{$controllerId}--{$actionId}还未进行配置" );
	}

	/**
	 * 判断是否具有某些按钮的权限
	 */
	public static function isHaveAccessRight($accessValue) {
		try {
			return self::checkAccessValue( $accessValue );
		} catch ( Exception $e ) {
			return false;
		}
	}
}
