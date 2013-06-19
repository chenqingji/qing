<?php

return array(
    "id" => "qing",
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'components' => array(
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host='.Config::DATABASE_IP.';dbname=qing',
            'username' => Config::DATABASE_USERNAME,
            'password' => Config::DATABASE_PASSWORD,
            'emulatePrepare' => false,
        ),
// 		'urlManager' => array(
// 			'urlFormat' => 'path',
// 			'rules' => array(
// 				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
// 			),
// 		),
//  		'log'=>array(
// 			'class'=>'CLogRouter',
// 			'routes'=>array(
// 				array(
// 					'class'=>'CFileLogRoute',
// 					'levels'=>'info,trace,error,profile',
// 					'logPath' => '/tmp/bossmail7.0/',
// 					'logFile' => 'sys.log',
// 					'categories'=>'system.db.*',
// 				),
// 			),
// 		),
    ),
    'import' => array(
        'common.models.qing.*',
        'common.classes.*',
        'common.config.*',
        'application.formmodels.*',
        'application.classes.*',
    ),
// preloading 'log' component
// 'preload'=>array('log'),
);