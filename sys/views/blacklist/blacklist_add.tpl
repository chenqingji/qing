{include file='../common/sys_header.tpl'}

<div class="main">
<form autocomplete="off" id="form1" name="form1" method="post" action="{html_url route=create}" onsubmit='return check_input(this)'>
<h2>{html_lang name='blacklist_title_add'}</h2>
<div class="form">
	<div>
		<label>{html_lang name='blacklist_label_add'}</label>
		<input name="domainname" autocomplete="off" type="text" value="{$smarty.get.domain|urldecode|default:''}" maxlength="64" />
		<input type="checkbox" class="eck_input" name="filtermode" {if $smarty.get.check|default:1}checked{/if}/>{html_lang name='blacklist_exact_match'}
		<p class="notice"><em>{html_lang name='blacklist_add_tip'}</em></p>
	</div>
	<div class="submit1">
		<button name="Submit" type="submit" title="{html_lang name='blacklist_title_submit'}" >{html_lang name='add'}</button>
		<button name="Submit" type="button" onclick="location.href='{html_url route=index}'">{html_lang name='cancel'}</button>
	</div>
</div> 
</form>
</div>
<script type="text/javascript" >
	function check_input(form){
		if(form.domainname.value == ''){
			alert("{html_lang name='blacklist_required'}",function(){
				$("input[name=domainname]").focus();
			});
			return false;
		}
		var mod = form.filtermode.checked;
		if(mod){
			if(!(/^[\w\-\.\u4e00-\u9fa5]*@[\w\-\u4e00-\u9fa5]+\.[\w\-\.\u4e00-\u9fa5]+$/.test(form.domainname.value))){
				alert("{html_lang name='blacklist_invalid'}",function(){
					$("input[name=domainname]").focus();
				}); 
				return false;
			}
		}
		if((form.domainname.value.split("@").length-1) > 1){
			alert("{html_lang name='blacklist_invalid'}",function(){
				$("input[name=domainname]").focus();
			}); 
			return false;
		}
		var tmpreg = /^[\u4e00-\u9fa5A-Za-z\_\-\.@0-9]+$/;
		if(!(tmpreg.test(form.domainname.value)) || form.domainname.value.indexOf('--') >= 0 || (/.\.@./.test(form.domainname.value))){
			alert("{html_lang name='blacklist_invalid'}",function(){
				$("input[name=domainname]").focus();
			});
			return false;
		}
	}

	$(function(){
		document.form1.domainname.focus();
	});
</script>
				
{include file='../common/sys_footer.tpl'}