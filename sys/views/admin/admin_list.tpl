{include file='../common/sys_header.tpl'}
<div class="main">
	<form id="form1" name="form1" method="post" class='curr_form' action="{html_url route=delete}">
		<h2>{html_lang name=admin_manager}</h2>
		<div class="list">
			<table>
				<thead>
					<tr>
						<th width="6%">{html_lang name=admin_toolbar_choose}</th>
						<th>{html_lang name=admin_toolbar_admin}</th>
						<th>{html_lang name=admin_toolbar_note}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th><input type="checkbox"  name="checkboxID[]" class="chkMe" value="$admin->id}" /></th>
						<td>$admin->name|escape}</td>
						<td>$admin->note|escape}</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td style="text-align: center"><input type="checkbox" name="allcheck" value="checkbox" class="chkAll" /></td>
						<td colspan="2">&nbsp;</td>
					</tr>
				</tfoot>
			</table>
			<div class="submit">
				<button name="Submit" type="button" onclick="location.href='{html_url route=toEdit}'" id=focus>{html_lang name=add}</button>
				<button name="Submit2" type="submit" id='delete_id'>{html_lang name=delete}</button>
				<button name="Submit3" type="button" onclick='mail_change(this.form)'>{html_lang name=edit}</button>
				<button name="Submit3" type="button" onclick='mail_auth(this.form)'>{html_lang name=admin_authorization}</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
/**
 * 删除按钮绑定验证事件
 */
$(function(){
    $('#delete_id').click( function() {
    	var size = $("#form1").getCheckedSize();
        if (size < 1) {
   			alert("{html_lang name=admin_delete_choose}");
            return false;
        }
        confirm("{html_lang name=admin_delete_confirm}",function(){
			document.form1.submit();
        });
        return false;
    });

});

/**
 * 用户修改验证
 */
function mail_change(form) {
	var size = $("#form1").getCheckedSize();
	if(size == 0) {
	   alert("{html_lang name=admin_update_choose}");
	   return false;
	}
	if(size > 1) {
	   alert("{html_lang name=admin_update_multi}");
	   return false;
	}
	form.action="{html_url route=toEdit}";
	form.submit();
}

/**
 * 赋权验证
 */
function mail_auth(form) {
	var size = $("#form1").getCheckedSize();
	if(size == 0) {
	   alert("{html_lang name=admin_auth_choose}");
	   return false;
	}
	if(size > 1) {
	   alert("{html_lang name=admin_auth_multi}");
	   return false;
	}
	form.action="{html_url route=toAuth}";
	form.submit();
}

/**
 * 页面初始化复选框选中事件
 */
$(document).ready(function(){
	$("#form1").exCheckAll(true);
});
</script>
{include file='../common/sys_footer.tpl'}
