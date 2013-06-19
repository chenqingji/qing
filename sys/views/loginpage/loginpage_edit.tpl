{include file='../common/sys_header.tpl'}
<script type="text/javascript">
function check_input(form) {
	if(form.name.value.replace(/(^[\s]*)|([\s]*?$)/g, "") == ''){
		alert("{html_lang name=login_page_set_need_name}",function(){
   			$("input[name=name]").focus();
   		});
		return false;
	}
	if(form.en_name.value.replace(/(^[\s]*)|([\s]*?$)/g, "") == ''){
		alert("{html_lang name=login_page_set_need_en_name}",function(){
   			$("input[name=en_name]").focus();
   		});
		return false;
	}
	if(form.path.value.replace(/(^[\s]*)|([\s]*?$)/g, "") == ''){
		alert("{html_lang name=login_page_set_need_path}",function(){
   			$("input[name=path]").focus();
   		});
		return false;
	}
	return true;
}

$(function(){
    document.form1.name.focus();
});
-->
</script>
<div class="main">
	<form id="form1" name="form1" method="post" class='curr_form'
		action="{html_url route=edit}">
		<input type="hidden" value="{$style_id|default:''}" name="style_id" />
		<h2>
			{if $isEdit}
				{html_lang name='login_page_set_edit_style_title'}
			{else}
				{html_lang name='login_page_set_add_style_title'}
			{/if}
		</h2>
		<div class="form">
			<div>
				<label>{html_lang name='login_page_set_add_style_name'}</label> 
				<input name="name" type="text" value="{$name|escape}" autocomplete="off" maxlength="20" />
			</div>
			<div>
				<label>{html_lang name='login_page_set_add_style_en_name'}</label>
				<input name="en_name" type="text" value="{$en_name|escape}" autocomplete="off" maxlength="20" />
			</div>
			<div>
				<label>{html_lang name='login_page_set_add_style_path'}</label> 
				<input name="path" type="text" value="{$path|escape}" autocomplete="off" maxlength="20" />
			</div>
			<div class="submit1">
				<button name="Submit" type="submit" onclick='return check_input(this.form);'>{html_lang name='confirm'}</button>
				<button name="Submit2" type="button" onclick="location.href='{html_url route=index}'">{html_lang name='cancel'}</button>
			</div>
		</div>
	</form>
</div>
{include file='../common/sys_footer.tpl'}
