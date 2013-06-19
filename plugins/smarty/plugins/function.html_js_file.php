<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File: function.html_js_file.php
 * Type: function
 * Name: html_lang
 * Purpose:生成引入js代码，方便进行版本控制
 * 
 * author: lazier
 * -------------------------------------------------------------
 */

function smarty_function_html_js_file($tag_arg, $smarty) {
	$file_src = $tag_arg["src"];
	$file_src .= ("?ver=".AppVersion::VALUE);
	return '<script type="text/javascript" src="'.$file_src.'"></script>';
}
?>