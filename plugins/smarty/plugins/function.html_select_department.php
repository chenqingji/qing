<?php

/*
 * Smarty plugin 
 * ------------------------------------------------------------- 
 * File: function.html_select_department.php
 * Type: function 
 * Name: function_html_select_department 
 * Purpose: Output page html
 * -------------------------------------------------------------
 */

function smarty_function_html_select_department($tag_arg, $smarty) {
	
	$firstOption = isset( $tag_arg ['firstoption'] ) ? $tag_arg ['firstoption'] : '';
	$selectClass = isset( $tag_arg ['class'] ) ? $tag_arg ['class'] : 'sel_width1';
	$selectItem = isset( $tag_arg ['selected'] ) ? $tag_arg ['selected'] : '';
	$id = isset( $tag_arg ['id'] ) ? $tag_arg ['id'] : 'departmentId';
	
	$htmlSelect = "<select class='" . $selectClass . "'  id='$id' name='$id'>";
	if ($firstOption) {
		$htmlSelect .= "<option value='' >" . I18nHelper::getText( $firstOption ) . "</option>";
	}
	
	$departments = Yii::app()->getController()->getDomainDepartments();
	foreach ( $departments as $department ) {
		if ($selectItem == $department->id) {
			$htmlSelect .= "<option value=$department->id selected='selected'>";
		} else {
			$htmlSelect .= "<option value=$department->id>";
		}
		
		$count = floor( strlen( $department->dep_code_id ) / 4 );
		for($i = 1; $i < $count; $i ++) {
			$htmlSelect .= "&nbsp;&nbsp;&nbsp;";
		}
		$htmlSelect .= $department->name . "</option>";
	}
	
	$htmlSelect .= "</select>";
	return $htmlSelect;
}
?>