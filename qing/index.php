<?php
$yii = dirname(__FILE__).'/../common/classes/NewSubYii.php';
$config=dirname(__FILE__).'/config/main.php';

require_once($yii);

NewSubYii::createWebApplication($config)->run();
