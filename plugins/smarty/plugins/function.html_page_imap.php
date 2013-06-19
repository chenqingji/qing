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

function smarty_function_html_page_imap($tag_arg, $smarty) {
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

	$pageHtml = "<div class='page'>";
	$pageHtml.="<ul>";

	if ($currentPageNo >= $totalPage) {
		$currentPageNo = $totalPage;
	}
	if ($currentPageNo > 0) {
		$pageHtml.= "<li>共有 <span class=\"count\">$totalPage</span> 条记录 当前为 $currentPageNo/$totalPage 页 </li>";
		$pageHtml .= "<li><a href='javascript:go2Page(\"{$targetForm}\",1,$totalPage)'>首页</a></li>";
		$pageHtml .= "<li><a href='javascript:go2Page(\"{$targetForm}\",$prevPageNo,$totalPage)'>上一页</a></li>";
		$pageHtml .= "<li><a href='javascript:go2Page(\"{$targetForm}\",$nextPageNo,$totalPage)'>下一页</a></li>";
		$pageHtml .= "<li><a href='javascript:go2Page(\"{$targetForm}\",".($totalPage).",$totalPage)'>尾页</a></li>";
		$pageHtml .= "<li><input type=\"text\" class=\"shot\" id=\"gotopage\" name=\"gotopage\"><input type=\"button\" class=\"btn_login\" value=\"跳 转\" onclick=\"go2Page('$targetForm',$(&quot;#gotopage&quot;).val(),$totalPage);\"></li>";
	}
	$pageHtml .= "</ul></div>";
	return $pageHtml;
}

?>