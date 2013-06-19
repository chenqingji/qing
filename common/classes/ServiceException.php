<?php
/**
 * Service操作抛出的异常，事务支持组件在扑捉到该异常时，会自动回滚。
 * 
 * @author jm
 */
class ServiceException extends Exception {

	/**
	 * 错误码
	 * 
	 * @var string
	 */
	private $serviceCode = NULL;

	/**
	 * service error code
	 */
	public function __construct($serviceCode, $replace = array()) {
		$this->serviceCode = $serviceCode;
		
		$i18nMsg = ServiceCode::$_LANGUAGE_ARRAY [$serviceCode] [I18nHelper::getCurrentLanguage()];
		if ($replace) {
			$i18nMsg = str_replace( array_keys( $replace ), array_values( $replace ), $i18nMsg );
		}
		$this->message = $i18nMsg;
	}

	/**
	 * 获取错误码
	 * 
	 * @return string
	 */
	public function getServiceCode() {
		return $this->serviceCode;
	}
}