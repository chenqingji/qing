<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File: function.html_page_post.php
 * Type: function
 * Name: html_page_post
 * Purpose: Output page html
 * 
 * -------------------------------------------------------------
 */

function smarty_function_html_page_post($tag_arg, $smarty) {
	$pageStyle = isset($tag_arg["class"]) ? $tag_arg["class"] : "pages";
	$targetForm = $tag_arg["form"];

	$page = $smarty->tpl_vars['listPage']->value;
	$currentPageNo = $page->getQueryInfo()->getCurrentPageno();
	$totalPage = $page->getTotalPage();
	$prevPageNo = $currentPageNo > 1 ? $currentPageNo - 1 : 1;
	$nextPageNo = $currentPageNo < $totalPage ? $currentPageNo + 1 : $totalPage;
	$total = $page->getTotal();
	$perPage = $page->getPerPage();
	$linkPos = $page->getLinksPos();
	$i18n = SmartyI18nHelper::getInstance();

	$pageHtml = "<p class='$pageStyle'>";
	$pageHtml.="{$i18n->getText('page_beforeTotal')}{$total}{$i18n->getText('page_afterTotal')} ";

	if ($currentPageNo >= $totalPage) {
		$currentPageNo = $totalPage;
	}
	if ($currentPageNo > 0) {
		/* firstPage */
		if ($currentPageNo == 1 || $perPage >= $total) {
			$pageHtml.="<span>{$i18n->getText('page_firstPage')}</span> | ";
		} else {
			$pageHtml .= "<a href='javascript:go2Page(\"{$targetForm}\",1)'>{$i18n->getText('page_firstPage')}</a> | ";
		}
		/* prevPage */
		if ($currentPageNo > 1 && $perPage < $total) {
			$pageHtml .= "<a href='javascript:go2Page(\"{$targetForm}\",$prevPageNo)'>{$i18n->getText('page_prevPage')}</a> | ";
		} else {
			$pageHtml.= "<span>{$i18n->getText('page_prevPage')}</span> | ";
		}
		/* nextPage */
		if ($currentPageNo < $totalPage) {
			$pageHtml .= "<a href='javascript:go2Page(\"{$targetForm}\",$nextPageNo)'>{$i18n->getText('page_nextPage')}</a> | ";
		} else {
			$pageHtml.= "<span>{$i18n->getText('page_nextPage')}</span> | ";
		}
		/* lastPage */
		if ($totalPage == 0 || $perPage >= $total || $currentPageNo >= $totalPage) {
			$pageHtml.= "<span>{$i18n->getText('page_lastPage')}</span> ";
		} else {
			$pageHtml .= "<a href='javascript:go2Page(\"{$targetForm}\",{$totalPage})'>{$i18n->getText('page_lastPage')}</a> ";
		}

		$pageHtml .= "<select onchange='go2Page(\"{$targetForm}\",this.value);'>";
		for ($i = 1; $i <= $totalPage; $i++) {
			if ($i == $currentPageNo) {
				$pageHtml.="<option  value='" . $i . "' selected='selected'>" . $i . "/" . $totalPage . "</option>";
			} else {
				$pageHtml.="<option  value='" . $i . "'>" . $i . "/" . $totalPage . "</option>";
			}
		}
		$pageHtml.="</select>";
	}
	$pageHtml .= "</p>";
	return $pageHtml;
}

?>