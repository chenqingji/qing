<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File: function.html_sort_post.php
 * Type: function
 * Name: html_sort_post
 * Purpose: Output sort html
 * 
 * -------------------------------------------------------------
 */

function smarty_function_html_sort_post($tag_arg, $smarty) {
	$sortKey = $tag_arg["key"];
	$sortForm = $tag_arg["form"];

	$defaultClass = isset($tag_arg['default_class']) ? $tag_arg['default_class'] : 'sort1';

	$queryInfo = $smarty->tpl_vars['listPage']->value->getQueryInfo();
	$currentSortType = $queryInfo->getSortType();
	$currentSortKey = $queryInfo->getSortKey();
	$i18n = SmartyI18nHelper::getInstance();

	$sortHtml = "";
	$sortType = "asc";

	if (strcmp($sortKey, $currentSortKey) == 0) {
		if (isset($tag_arg['default_key']) && strcmp($currentSortType, 'desc') == 0) {
			$sortKey = $tag_arg['default_key'];
			$sortType = isset($tag_arg['default_type']) ? $tag_arg['default_type'] : 'asc';
		}
		if (strcmp($currentSortType, 'asc') == 0) {
			$sortType = "desc";
			$class = 'sort2';
			$title = $i18n->getText('sort_asc');
		} else {
			$class = 'sort3';
			$title = $i18n->getText('sort_desc');
		}
		$sortHtml = "<a title='$title' href='javascript:sortByKey(\"{$sortForm}\",\"{$sortKey}\",\"{$sortType}\");' ><img src=\"assets/images/blank.gif\" class=\"$class\"></a>";
	} else {
		if (isset($tag_arg['default_key'])) {
			$title = $i18n->getText('sort_none');
			$sortHtml = "<a title='$title' href='javascript:sortByKey(\"{$sortForm}\",\"{$sortKey}\",\"{$sortType}\");'><img src=\"assets/images/blank.gif\" class=\"$defaultClass\"></a>";
		} else {
			$sortHtml = "<a href='javascript:sortByKey(\"{$sortForm}\",\"{$sortKey}\",\"{$sortType}\");'><img src=\"assets/images/blank.gif\" class=\"$defaultClass\"></a>";
		}
	}
	return $sortHtml;
}

?>