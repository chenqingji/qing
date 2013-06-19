<?php
/**
 * sql注入示范
 */

$post = 12; //正常的input手工输入数据

/*
$post = "1 or username like '%admin%';--";
$sqlQuery = "select * from adminTable where uid=$post";
*/
$post = "' or username like '%admin%';--";  //可能形成注入的input手工输入数据
$sqlQuery = "select * from adminTable where uid='$post'";

echo $sqlQuery;

?>
