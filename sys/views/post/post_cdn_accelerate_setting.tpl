{include file='../common/sys_header.tpl'}

<div id="main" class="main">
	<form id="form1" name="form1" method="post" class='curr_form' action="{html_url route=cdnUpdate}" autocomplete="off">
		<h2>{html_lang name="post_cdn"}</h2>
		<input name="po_ids" type="hidden" />
		<div class="list morelist" id="st" style="overflow-x: hidden;">
			<table id="st_table" border="0" cellspacing="0" cellpadding="0" width="99%">
				<thead>
					<tr>
						<th style="width:50px">{html_lang name="post_choise"}</th>
						<th>{html_lang name="post_name"}</th>
					</tr>
				</thead>
				<tbody id="st_tbody">
					{foreach from=$domains item=domain}
						<tr>
							<td align="center" ><input type="checkbox" name="ids[]" value="{$domain.po_id}" onclick="singleCheck(this);" {if $domain.is_cdn}checked="checked"{/if}/></td>
							<td title="{$domain.domain}">{$domain.domain}</td>
						</tr>
					{/foreach}
				</tbody>
				<tfoot>
				</tfoot>
			</table>
		</div>
		<div class="list morelist" id="sta">
			<table id="st_table" border="0" cellspacing="0" cellpadding="0" width="99%">
				<thead style="background-color:#f5fbff;">
					<tr>
						<td style="width:50px" align="center"><input type="checkbox"  name="allcheck" onclick="selectAll(this.form,this)"/></th>
						<td>{html_lang name="select_all"}</td>
					</tr>
				</thead>
			</table>
		</div>
		<div class="submit">
			<button type="button" onclick='return checkform(this.form)'>{html_lang name="confirm"}</button>
			<button type="button" onclick="location.href='{html_url route=index}'">{html_lang name="cancel"}</button>     
		</div>
	</form>
</div>


<script type="text/javascript">
function checkform(){
	document.form1.submit();
}

function selectAll(form,checkallcon){
	for (var i=0;i<form.elements.length;i++){ 
		var e = form.elements[i]; 
		e.checked=checkallcon.checked; 
	}
}

function singleCheck(obj){
	if(obj.checked==false && document.getElementsByName('allcheck')[0].checked==true){
		document.getElementsByName('allcheck')[0].checked=false;
	}
}
</script>

{include file='../common/sys_footer.tpl'}