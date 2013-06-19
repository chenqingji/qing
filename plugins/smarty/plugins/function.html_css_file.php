<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File: function.html_css_file.php
 * Type: function
 * Name: html_lang
 * Purpose:生成引入css代码，方便进行版本控制
 * 
 * author: lazier
 * -------------------------------------------------------------
 */

function smarty_function_html_css_file($tag_arg, $smarty) {
	$file_href = $tag_arg["href"];
	$file_href .= ("?ver=".AppVersion::VALUE);
	return '<link rel="stylesheet" href="'.$file_href.'" type="text/css" media="all" />';
}
?>