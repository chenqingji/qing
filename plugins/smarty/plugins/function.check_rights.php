<?php
/**
 * 权限验证标签
 * @param array $tag_arg
 * @param object $smarty
 */
function smarty_function_check_rights($tag_arg, $smarty) {
	$actionId = $tag_arg['action'];
	$controllId = $tag_arg['controller'];
	$rights = null;
	if(!SessionUtil::getSysUserInfo()){
		$rights = SessionUtil::getSysUserInfo()->getRights();
	}
	//TODO 等待最终确认方法名称 AccessAuth::check_right($rights, $controllId, $actionId)
	return true;
}
?>