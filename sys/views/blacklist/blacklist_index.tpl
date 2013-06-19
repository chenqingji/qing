{include file='../common/sys_header.tpl'}

<div class="main">
<h2> {html_lang name='menu_li_black_filter'} </h2>
<div class="list">
<form id="naTab_Content0" name="form2" method="post" class='curr_form' action="{html_url route=delete}">
<table >
<thead>
<tr>
	<th width="6%">{html_lang name='blacklist_choose'}</th>
	<th>{html_lang name='blacklist_filter'}</th>
	<th>{html_lang name='blacklist_matchmod'}</th>
</tr>
</thead>
<tbody>
<tr>
	<th><input type="checkbox" name="checkboxID[]" id="ID" value="$item.id}" onClick="singlecheckaction(this);"/></th>
	<td title='$item.senderaddr|trim}'>$item.senderaddr|trim}</td>
	<td>{html_lang name='blacklist_exact_match'}</td>
</tr>
<tr>
	<th><input type="checkbox" name="checkboxID[]" id="ID" value="-1" onClick="singlecheckaction(this);"/></th>
	<td title='[---------{html_lang name='blacklist_null'}--------]'>[---------{html_lang name='blacklist_null'}--------]</td>
	<td></td>
</tr>
</tbody>
<tfoot>
<tr>
	<td style="text-align:center"><input type="checkbox" name="allcheck" value="checkbox"  onclick="select_all(this.form,this)"/></td>
	<td colspan="2">&nbsp;</td>
</tr>
</tfoot>
</table>
<div class="submit">
	<button name="Submit" type="button" onClick="location.href='{html_url route=add}'" id=focus>{html_lang name='add'}</button>
	<button name="Submit2" id='delete_id' type="submit" >{html_lang name='delete'}</button>
</div>
</form>
</div>

</div>

<script type="text/javascript">
$(function(){

	$('#delete_id').click( function() {
		size = $('table tbody :checkbox:checked').size();
		if (size < 1) {
			alert("{html_lang name='blacklist_js_choose_to_delete'}");
			return false;
		}
		confirm('{html_lang name='blacklist_js_confirm_to_delete'}', function(){ document.form2.submit();})
		return false;
	});

}); 

function select_all(form,checkallcon){
	for (var i=0;i<form.elements.length;i++){ 
		var e = form.elements[i]; 
		e.checked=checkallcon.checked; 
	}
}

function singlecheckaction(checkcon){
	if(checkcon.checked==false && document.getElementsByName('allcheck')[0].checked==true){
		document.getElementsByName('allcheck')[0].checked=false;
	}
}

$(function(){
	document.getElementById('focus').focus();
});
</script>

{include file='../common/sys_footer.tpl'}