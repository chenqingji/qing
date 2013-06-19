{include file='../common/sys_header.tpl'}

<div class="main">
	<h2>{html_lang name='menu_li_white_filter'}</h2>
	<div class="list">
		<form id="whitelistForm" name="whitelistForm" method="post" class='curr_form' action="{html_url route=delete}">
			<table>
				<thead>
					<tr>
						<th width="6%">{html_lang name='whitelist_choose'}</th>
						<th>{html_lang name='whitelist_filter'}</th>
						<th>{html_lang name='whitelist_matchmod'}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th><input type="checkbox" name="checkboxID[]" class="chkMe" id="ID" value="$item.id}" /></th>
						<td title='$item.senderaddr}'>$item.senderaddr}</td>
						<td>{html_lang name='whitelist_exact_match'}</td>
					</tr>
					<tr>
						<th><input type="checkbox" name="checkboxID[]" id="ID" value="-1" class="chkMe" /></th>
						<td title='[---------{html_lang name='whitelist_null'}--------]'>[---------{html_lang
							name='whitelist_null'}--------]</td>
						<td></td>
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
				<button name="Submit" type="button" onClick="location.href='{html_url route=toAdd}'" id=focus>{html_lang name='add'}</button>
				<button name="Submit2" id='delete_id' type="submit">{html_lang name='delete'}</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
/**
 * 页面初始化复选框选中事件
 */
$(document).ready(function(){
	$("#whitelistForm").exCheckAll(true);
	$('#focus').focus();
});

$(function(){
	$('#focus').focus();
	$('#delete_id').click( function() {
		size = $('table tbody :checkbox:checked').size();
		if (size < 1) {
			alert("{html_lang name='whitelist_js_choose_to_delete'}");
			return false;
		}
		confirm('{html_lang name='whitelist_js_confirm_to_delete'}',function (){ document.whitelistForm.submit();});
		return false;
	});
}); 
</script>

{include file='../common/sys_footer.tpl'}
