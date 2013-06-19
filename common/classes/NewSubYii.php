<?php
require (dirname( __FILE__ ) . '/../config/Config.php');

// remove the following lines when in production mode
defined( 'YII_DEBUG' ) or define( 'YII_DEBUG', Config::DEBUG_MODE );
// specify how many levels of call stack should be shown in each log message
defined( 'YII_TRACE_LEVEL' ) or define( 'YII_TRACE_LEVEL', 3 );

date_default_timezone_set( 'Asia/Shanghai' );

require (dirname( __FILE__ ) . '/../../framework/yii.php');
/**
 * *禁用includePath功能，支持自定义载入类配置
 */
Yii::$enableIncludePath = false;

/**
 * 新项目使用的Yii基类，该类定义新项目使用yii的独特行为。
 * 
 * @author lazier
 */
class NewSubYii extends Yii {

}

NewSubYii::setPathOfAlias( "common", realpath( NewSubYii::getFrameworkPath() . "/../common" ) );
NewSubYii::setPathOfAlias( "runtime", realpath( NewSubYii::getFrameworkPath() . "/../runtime" ) );

