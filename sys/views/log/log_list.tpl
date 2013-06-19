{include file='../common/sys_header.tpl'}
<div class="main">
	<form method="post" name="form1" id="logform" action="{if $type eq 0}{html_url route=sysLog}{elseif $type eq 1 }{html_url route=adminLog}{else}{html_url route=mailLog}{/if}">
		<h2>
		{if $type eq 0}{html_lang name=log_system_title} {elseif $type eq 1 }{html_lang name=log_post_title} {else}{html_lang name=log_user_title} {/if}
		</h2>
		<div class="search">
			<select name="search_key" style="float:left;">
				<option value="" selected='selected'>{html_lang name=log_pleaseselect}</option>
				<option value="admin_user">{if $type eq 2}{html_lang name=log_mail} {else}{html_lang name=log_admin}{/if}</option>
				<option value="created_at">{html_lang name=log_time}</option>
				<option value="ip">{html_lang name=log_ip}</option>
				<option value="oper">{html_lang name=log_action}</option>
			</select> <input name="search_val" id="search_val" type="text" value="{$searchValue}" />
			<button name="search" type="submit">{html_lang name=log_search}</button>
		</div>
	</form>
	<div class="list">
		<table id="myTable">
			<thead>
				<tr>
					<th>{if $type eq 2} {html_sort name=log_mail key=admin_user form=logform}
					 {else}{html_sort name=log_admin key=admin_user form=logform}{/if}</th>
					<th>{html_sort name=log_time key=created_at form=logform}</th>
					<th>{html_lang name=log_ip}</th>
					<th>{html_lang name=log_action}</th>
				</tr>
			</thead>
			{if $result|@count neq 0 } 
			<tbody>
				{section name=log loop=$result}
				<tr>
					<td title="{$result[log].admin_user|escape:'html'}">{$result[log].admin_user|escape:"html"}</td>
					<td>{$result[log].created_at}</td>
					<td>{$result[log].ip}</td>
					<td title="{$result[log].oper|escape:'html'}">{$result[log].oper|escape:"html"}</td>
				</tr>
				{/section}
			</tbody>
			{/if}
		<tfoot>
                <tr>
                    <td colspan=4>
                        {html_page form=logform}
                    </td>
                </tr>
       </tfoot>
		</table>
		<div class="submit">
	  		<input type='button' id='viewall' name="viewall" value='{html_lang name=log_viewall}' />
			<input type='button' id='deleteall' name="deleteall" value='{html_lang name=log_deleteall}' />
		</div>
	</div>
</div>
<script type="text/javascript">
$().ready(function() {
$('option[value=' + '{$searchKey}' + ']').attr('selected','selected');
});
$('#deleteall').click( function() {
        confirm("{html_lang name=log_deleteconfirm}",function(){
        	  document.form1.action = "{$deleteURL}";
              document.form1.submit();
        });
});
$('#viewall').click(function(){
	document.location.href = "{$viewallURL}";
});
</script>
{include file='../common/sys_footer.tpl'}
