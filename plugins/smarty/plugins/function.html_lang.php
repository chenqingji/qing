<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File: function.html_lang.php
 * Type: function
 * Name: html_lang
 * Purpose: Output language name
 * 
 * author: cqy
 * -------------------------------------------------------------
 */

function smarty_function_html_lang($tag_arg, $smarty) {
	$name = $tag_arg['name'];
	$case = isset($tag_arg['case'])?$tag_arg['case']:'';
	if($case=='lower'){
		return strtolower(I18nHelper::getText($name));
	}else if ($case=='upper'){
		return strtoupper(I18nHelper::getText($name));
	}else{
		return I18nHelper::getText($name);
	} 
}
?>