{include file='../common/sys_header.tpl'}
<script type="text/javascript">
function isChinese(str) {
   var lst = /[u00-uFF]/;
   return !lst.test(str);
}

function check_input(form) {
	{if !$isEdit}
		if(form.admin.value == '') {
	   		alert("{html_lang name=admin_name_empty}",function(){
	   			$('input[name=admin]').focus();
	   		});
			return false;
		}
		var pattern = /^[a-zA-Z0-9]+$/;
		if(!pattern.test(form.admin.value)) {
	   		alert("{html_lang name=admin_name_contain}",function(){
	   			$('input[name=admin]').focus();
	   		});
			return false;
		}
	{/if}
	if(form.password.value == '') {
   		alert("{html_lang name=admin_password_empty}",function(){
   			$('input[name=password]').focus();
   		});
		return false;
	} else {
        if( form.password.value.length<6 || form.password.value.length>25 ) {
            alert("{html_lang name=admin_password_length}",function(){
       			$('input[name=password]').focus();
       		});
			return false;
		}
    }
	if(form.password.value.indexOf(' ') > -1) {
		alert("{html_lang name=admin_password_space}",function(){
   			$('input[name=password]').focus();
   		});
		return false;
	}
	if(form.password.value.indexOf('\t') > -1) {
   		alert("{html_lang name=admin_password_ascii}",function(){
   			$('input[name=password]').focus();
   		});
		return false;
	}
	
	if(form.password2.value == '') {
   		alert("{html_lang name=admin_password2_empty}",function(){
   			$('input[name=password2]').focus();
   		});
		return false;
	} else {
        if( form.password2.value.length<6 || form.password2.value.length>25 ) {
            alert("{html_lang name=admin_password2_length}",function(){
       			$('input[name=password2]').focus();
       		});
			return false;
		}
    }
	if(form.password2.value.indexOf(' ') > -1) {
		alert("{html_lang name=admin_password2_space}",function(){
   			$('input[name=password2]').focus();
   		});
		return false;
	}
	if(form.password2.value.indexOf('\t') > -1) {
   		alert("{html_lang name=admin_password2_ascii}",function(){
   			$('input[name=password2]').focus();
   		});
		return false;
	}
	
	if(form.password.value !=form.password2.value) {
   		alert("{html_lang name=admin_password_twice}",function(){
   			$('input[name=password2]').focus();
   		});
		return false;
	}
	if(form.note.value.length>20) {
	   alert("{html_lang name=admin_password_note_toolong}",function(){
  			$('input[name=note]').focus();
  		});
	   return false;
	}
	$.fn.strength_validate.validate($('.strengthpwd'));
	pwdstrength = $('.strengthpwd').data('pwdstrength');
	if (pwdstrength == 1) {
	    alert("{html_lang name=admin_password_tooweak}",function(){
  			$('input[name=password]').focus();
  		});
	    return false;
	}
    tmp_str = "&strong=";
    if (pwdstrength == 3) {
        tmp_str = tmp_str + "1";
    } else {
        tmp_str = tmp_str + "0";
    }
    document.form1.action = document.form1.action + tmp_str;
    return true;
}

/**
 * 初始化密码强度校验
 */
$(function(){
	{if $isEdit || isset($isBack)}
		{if $isEdit}
			document.form1.password.focus();
		{else}
			document.form1.admin.focus();
		{/if}
		$('.strengthpwd').strength_validate({
	        'val': '{$admin}',
	        'lang':'{$lang}'
	      });
		$.fn.strength_validate.validate($('.strengthpwd'));
	{else}
		document.form1.admin.focus();
		$('.strengthpwd').strength_validate({
			'lang':'{$lang}'
		});
	{/if}
});
-->
</script>
<div class="main">
	<form id="form1" name="form1" method="post" class='curr_form' action="{html_url route=edit}">
		<h2>{if $isEdit}
					{html_lang name=admin_edit}
			{else}
					{html_lang name=admin_add}
			{/if}
		</h2>
		<div class="form">
			<div>
				<label>{html_lang name=admin_name}</label> 
				{if $isEdit}
					<span class='ccommon'>{$admin|escape}</span>
				{else}
					<input name="admin" class='ccommon' autocomplete="off" type="text" value="{$admin|escape}" maxlength="20" />
				{/if}
				<input type=hidden name="admin_id" value={$admin_id|default:''}>

			</div>
			<div>
				<label>{html_lang name=password}</label> 
				<input name="password" class='strengthpwd' type="password" value="{$password|default:''|escape}" maxlength="25" />
				<em>{html_lang name=admin_password_note}</em>
			</div>
			<div>
				<label>&nbsp;</label> 
				<span class='strength'>{html_lang name=admin_password_weak}</span> 
				<span class='strength'>{html_lang name=admin_password_in}</span> 
				<span class='strength'>{html_lang name=admin_password_strong}</span>
			</div>
			<div>
				<label>{html_lang name=admin_password_repeat}</label> 
				<input name="password2" value="{$password2|default:''|escape}" type="password" maxlength="25" />
				<em>{html_lang name=admin_password_note}</em>
			</div>
			<div>
				<label>{html_lang name=admin_note}</label>
				<textarea name="note" cols="30" rows="6">{$note|escape}</textarea>
			</div>
			<div class="submit1">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button name="Submit" type="submit" onclick='return check_input(this.form)'>{html_lang name=confirm}</button>
				<button name="Submit2" type="button" onclick="location.href='{html_url route=index}'">{html_lang name=cancel}</button>
			</div>
		</div>
	</form>
</div>
{include file='../common/sys_footer.tpl'}
