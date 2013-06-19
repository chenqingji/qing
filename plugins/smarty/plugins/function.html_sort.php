<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File: function.html_sort.php
 * Type: function
 * Name: html_sort
 * Purpose: Output sort html
 * 
 * -------------------------------------------------------------
 */

function smarty_function_html_sort($tag_arg, $smarty) {
    $name = $tag_arg["name"];
    $sortKey = $tag_arg["key"];
    $sortForm = $tag_arg["form"];

    $queryInfo = $smarty->tpl_vars['listPage']->value->getQueryInfo();
    $currentSortType = $queryInfo->getSortType();
    $currentSortKey = $queryInfo->getSortKey();
    $i18n = SmartyI18nHelper::getInstance();

    $sortHtml = "";
    $sortType = "asc";
    if (strcmp($sortKey, $currentSortKey) == 0) {
        if (strcmp($currentSortType, "asc") == 0) {
            $sortType = "desc";
        }
        $class = strcmp($currentSortType,'asc') ==0 ? 'asc':'desc';
        $sortHtml = "<a class='".$class."' href='javascript:sortByKey(\"{$sortForm}\",\"{$sortKey}\",\"{$sortType}\");'>{$i18n->getText($name)}</a>";
    } else {
        $sortHtml = "<a href='javascript:sortByKey(\"{$sortForm}\",\"{$sortKey}\",\"{$sortType}\");'>{$i18n->getText($name)}</a>";
    }
    return $sortHtml;
}

?>