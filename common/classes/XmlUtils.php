<?php

/**
 * XML操作辅助类
 * 
 * @author jm
 */
class XmlUtils {

	/**
	 * 私有构造方法
	 */
	private function __construct() {
	}

	/**
	 * 数组转化为xml字符串
	 * 
	 * @param $data array
	 * @param $rootNodeName string
	 * @param $xml SimpleXMLElement
	 */
	public static function arrayToXml($data, $rootNodeName = 'root', $xml = null) {
		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get( 'zend.ze1_compatibility_mode' ) == 1) {
			ini_set( 'zend.ze1_compatibility_mode', 0 );
		}
		if ($xml == null) {
			$xml = simplexml_load_string( "<?xml version='1.0' encoding='utf-8'?><$rootNodeName />" );
		}
		// loop through the data passed in.
		foreach ( $data as $key => $value ) {
			// no numeric keys in our xml please!
			if (is_numeric( $key )) {
				// make string key...
				$key = "unknownNode_" . ( string ) $key;
			}
			// replace anything not alpha numeric
			$key = preg_replace( '/[^a-z0-9\-\_]/i', '', $key ); 
			// if there is another array found recrusively call this function
			if (is_array( $value )) {
				$node = $xml->addChild( $key );
				// recrusive call.
				self::arrayToXml( $value, $rootNodeName, $node );
			} else {
				// add single node.
				$value = htmlentities( $value, ENT_QUOTES, "UTF-8" );
				$xml->addChild( $key, $value );
			}
		}
		// pass back as string. or simple xml object if you want!
		return $xml->asXML();
	}
}
