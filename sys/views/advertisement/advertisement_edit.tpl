{include file='../common/sys_header.tpl'}
<script type="text/javascript">
function check_input(form)
{
   if(form.name.value.replace(/(^[\s]*)|([\s]*?$)/g, "") == '')
   {
   		alert("{html_lang name=advertisement_nameempty}",function(){
   			$("input[name=name]").focus();
   		});
		return false;
   }
   if(form.url.value.replace(/(^[\s]*)|([\s]*?$)/g, "") == '')
   {
   		alert("{html_lang name=advertisement_pathempty}",function(){
   			$("input[name=url]").focus();
   		});
		return false;
   }
   if( form.url.value.indexOf("'")>=0 || form.url.value.indexOf('"')>=0)
   {
   		alert("{html_lang name=advertisement_pathspecial}",function(){
   			$("input[name=url]").focus();
   		});
		return false;
   }
   return true;
}
$(function(){
    document.form1.name.focus();
});
function useAddress(ele) 
{
  var address = ele.value.replace(/(^\s+)|(\s+$)/g,'');
  if (address != '') 
  {
    if(webtypetest(address)==false){
      address='http:\/\/'+address;		
    }
    ele.value=address;
  }
}
function webtypetest(testUrl){
	if((/^http:\/\//i.test(testUrl)==true) || (/^https:\/\//i.test(testUrl)==true) 
	|| (/^mms:\/\//i.test(testUrl)==true) || (/^rtsp:\/\//i.test(testUrl)==true) )
	{
		return true;
	}else{
		return false;
	}
}
</script>  
<div class="main">
	 <form id="form1" name="form1" method="post" class='curr_form' action="{html_url route=edit}">
	<h2>{if $isEdit eq ''}{html_lang name=advertisement_pageadd} {else} {html_lang name=advertisement_pagemodify} {/if}</h2>
  <div class="form">
  <div>
    	<label>{html_lang name=advertisement_name}{html_lang name=advertisement_colon}</label>
      <input id="name" name="name" type="text" maxlength="20" value="{$name|default:''|escape:'html'}" />  
    </div>
  <div>
    	<label>{html_lang name=advertisement_path}{html_lang name=advertisement_colon}</label>
        <input id="url" name="url" type="text" maxlength="256" value="{$url|default:'http://'|escape:'html'}" onblur="useAddress(this)" /> 
        {html_lang name=advertisement_pathexample}
    </div>
  <div>
    	<label>{html_lang name=advertisement_notice}{html_lang name=advertisement_colon}</label>
        <textarea id="note" name="note" rows="20" onfocus="alreadyFocused=true;" style="width:350px;">{$note|default:''|escape:'html'}</textarea>
    </div>
    <input type="hidden" name="advertisement_id" value="{$advertisement_id|default:''}">
    <div class="submit1">
    	<button name="Submit" type="submit" onclick='return check_input(this.form)' >{html_lang name=confirm}</button>
    	<button name="Submit2" type="button" onclick="location.href='{html_url route=index}'" >{html_lang name=cancel}</button>
    </div>
  </div>
	</form>
</div>
{include file='../common/sys_footer.tpl'}