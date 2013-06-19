<?php

/*
 * Smarty plugin -------------------------------------------------------------
 * File: function.html_request_value.php Type: function Name: html_request_value
 * Purpose: 自动输出查询条件中的值,需要controller中方法getQueryPage配合使用 author: lazier
 * -------------------------------------------------------------
 */

function smarty_function_html_request_value($tag_arg, $smarty) {
	$name = $tag_arg ['name'];
	$requestVaue = Yii::app ()->getRequest ()->getParam ( $name );
	if ($requestVaue === null) {
		$requestVaue = Yii::app ()->getController ()->getRequestValueFromQueryInfo ( $name );
	}
	if ($requestVaue !== null) {
		return CHtml::encode ( $requestVaue );
	} else {
		return "";
	}
}
