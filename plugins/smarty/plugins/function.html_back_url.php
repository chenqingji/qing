<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File: function.html_back_url.php
 * Type: function
 * Name: html_back_url
 * Purpose: 生成自动返回列表页面,保存查询条件
 * 
 * author: lazier
 * -------------------------------------------------------------
 */

function smarty_function_html_back_url($tag_arg, $smarty) {
	$route = $tag_arg['route'];
	return Yii::app()->getController()->createUrl($route,array ("isback" =>1 ));
}