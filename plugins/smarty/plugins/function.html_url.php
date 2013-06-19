<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File: function.html_url.php
 * Type: function
 * Name: html_url
 * Purpose: create yii format url
 * 
 * author: lazier
 * -------------------------------------------------------------
 */

function smarty_function_html_url($tag_arg, $smarty) {
	$route = $tag_arg['route'];
	return Yii::app()->getController()->createUrl($route);
}

?>