{include file='../common/sys_header.tpl'}

<div class="main">
	<form id="addForm" name="addForm" method="post" action="{html_url route=add}" onsubmit='return check_input(this)'>
		<h2>{html_lang name='whitelist_title_add'}</h2>
		<div class="form">
			<div>
				<label>{html_lang name='whitelist_label_add'}</label>
				<input name="domainname" type="text" value="{$smarty.get.domain|urldecode|default:''}" maxlength="64" />
				<input class="eck_input" type="checkbox" name="filtermode"  value="1" {if $smarty.get.check|default:1}checked{/if}/>{html_lang name='whitelist_exact_match'}
				<p class="notice"><em>{html_lang name='whitelist_add_tip'}</em></p>
			</div>
			<div class="submit1">
				<button name="Submit" type="submit" title="{html_lang name='whitelist_title_submit'}" >{html_lang name='add'}</button>
				<button name="Submit" type="button" onclick="location.href='{html_url route=index}'">{html_lang name='cancel'}</button>
			</div>
		</div> 
	</form>
</div>
<script type="text/javascript" >
	function check_input(form){
		if(form.domainname.value == ''){
			alert("{html_lang name='whitelist_required'}",function(){
				$("input[name=domainname]").focus();
			});
			return false;
		}
		var mod = form.filtermode.checked;
		if(mod){
			if(!(/^[\w\-\.\u4e00-\u9fa5]*@[\w\-\u4e00-\u9fa5]+\.[\w\-\.\u4e00-\u9fa5]+$/.test(form.domainname.value))){
				alert("{html_lang name='whitelist_invalid'}",function(){
					$("input[name=domainname]").focus();
				}); 
				return false;
			}
		}
		if((form.domainname.value.split("@").length-1) > 1){
			alert("{html_lang name='whitelist_invalid'}",function(){
				$("input[name=domainname]").focus();
			}); 
			return false;
		}
		var tmpreg = /^[\u4e00-\u9fa5A-Za-z\_\-\.@0-9]+$/;
		if(!(tmpreg.test(form.domainname.value)) || form.domainname.value.indexOf('--') >= 0 || (/.\.@./.test(form.domainname.value))){
			alert("{html_lang name='whitelist_invalid'}",function(){
				$("input[name=domainname]").focus();
			});
			return false;
		}
	}

	$(function(){
		document.addForm.domainname.focus();
	});
</script>
				
{include file='../common/sys_footer.tpl'}