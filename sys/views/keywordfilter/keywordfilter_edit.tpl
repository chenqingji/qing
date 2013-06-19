{include file='../common/sys_header.tpl'}
<div class="main">
<h2>{if $isEdit}
	{html_lang name='keywordfilter_update_title'}
	{else}
	{html_lang name='keywordfilter_add_title'}
	{/if}</h2>
<form id="form1" method="post" name="form1" action="{html_url route=edit}">
<div class="form">
  <input name="id" id="id" type="hidden" value="{$spam_rule.id}"/>
<div>
	<label>{html_lang name='keywordfilter_add_rule_name'}</label>
  <input name="rulename" id="rulename" type="text" size="25" maxlength="20" value="{$spam_rule.rulename|escape}"/>
</div>
<div>
	<label>{html_lang name='keywordfilter_add_condition'}</label>
	<select name="condition" id="condition" onchange="condition_change()">
		  <option value="1" {if $spam_rule.mail_condition eq '1'}selected{/if}>{html_lang name='keywordfilter_condition_to'}</option>
		  <option value="0" {if $spam_rule.mail_condition eq '0'}selected{/if}>{html_lang name='keywordfilter_condition_from'}</option>
		  <option value="2" {if $spam_rule.mail_condition eq '2'}selected{/if}>{html_lang name='keywordfilter_condition_cc'}</option>
		  <option value="3" {if $spam_rule.mail_condition eq '3'}selected{/if}>{html_lang name='keywordfilter_condition_subject'}</option>
		  <option value="4" {if $spam_rule.mail_condition eq '4'}selected{/if}>{html_lang name='keywordfilter_condition_attachment_name'}</option>
		  <option value="5" {if $spam_rule.mail_condition eq '5'}selected{/if}>{html_lang name='keywordfilter_condition_bcc'}</option>
		  <option value="6" {if $spam_rule.mail_condition eq '6'}selected{/if}>{html_lang name='keywordfilter_condition_text'}</option>
		  <option value="7" {if $spam_rule.mail_condition eq '7'}selected{/if}>{html_lang name='keywordfilter_condition_attachment_type'}</option>
		  <option value="8" {if $spam_rule.mail_condition eq '8'}selected{/if}>{html_lang name='keywordfilter_condition_attachment_content'}</option>
		  <option value="9" {if $spam_rule.mail_condition eq '9'}selected{/if}>{html_lang name='keywordfilter_condition_ip'}</option>
  	</select>
    {html_lang name='keywordfilter_add_contain'}<input name="keyword" id="keyword" type="text" maxlength="16" size="50"  value="{$spam_rule.keyword|escape}" autocomplete="off"/>
     <p class="notice1">{html_lang name='keywordfilter_add_notice'}</p>
</div>
<div>
	<label>{html_lang name='keywordfilter_add_action'}</label>
	<select name="active" id="active">
    	 <option value="0" {if $spam_rule.action eq '0'}selected{/if}>{html_lang name='keywordfilter_action_deliver'}</option>
  		 <option value="1" {if $spam_rule.action eq '1'}selected{/if}>{html_lang name='keywordfilter_action_refuse'}</option>
 		 <option value="2" {if $spam_rule.action eq '2'}selected{/if}>{html_lang name='keywordfilter_action_discard'}</option>
 		 <option value="3" {if $spam_rule.action eq '3'}selected{/if}>{html_lang name='keywordfilter_action_spam'}</option>
    </select>
</div>
<div>
	<label class="label_line2">{html_lang name='keywordfilter_add_mode'}</label>
  <input type="radio" name="mode" id="mode1" class="nos" value="0" {if $spam_rule.mode neq '1' }checked{/if} />{html_lang name='keywordfilter_spam_rule_mode_fuzz_match'}　　<input type="radio" name="mode" id="mode2" class="nos" value="1" {if $spam_rule.mode eq '1'}checked{/if}/>{html_lang name='keywordfilter_spam_rule_mode_exact_match'}
</div>
<div>
<label>{html_lang name='keywordfilter_add_remark'}</label>
<textarea id="remark" cols="30" name="remark" oninput="if(this.value.length>255) this.value=this.value.substr(0,255)" onpropertychange="if(this.value.length>255) this.value=this.value.substr(0,255)">{$spam_rule.remark}</textarea>
</div>
<div class="submit1">
	<button id="theSub" type="submit">{html_lang name='keywordfilter_add_submit'}</button>
	<button type="button" onclick="location.href='{html_url route=index}'">{html_lang name='keywordfilter_add_cancel'}</button>
</div>
</div>
</form>
</div>
<script type="text/javascript">
function condition_change()
{
    var value = $("#condition").val();
    if(value == '6' || value == '8' || value == '9')
    {
	$("#mode1").attr("checked",true);
	$("#mode2").attr("disabled",true);
    }
    else
    {
	$("#mode2").attr("disabled",false);
    }
    if(value == '9')
    {
	$("#active").val("1");
	$("#active").attr("disabled",true);
    }
    else
    {
	$("#active").attr("disabled",false);
    }
}

$(document).ready(function(){
  $("#form1").submit(function(){
    var rulename=$("#rulename").val();
    var id=$("#id").val();
    if(!rulename.replace(/(^\s+)|(\s+$)/g,''))	{
  		alert('{html_lang name='keywordfilter_add_input_rule_name'}',function(){
  			$("#rulename").focus();
  		});return false;
  	}
    var keyword=$("#keyword").val();
  	if(!keyword.replace(/(^\s+)|(\s+$)/g,''))	{
  		alert('{html_lang name='keywordfilter_add_input_keyword'}',function(){
  			$("#keyword").focus();
  		});return false;
  	}
  	if( (keyword.indexOf(" ")>-1) || (keyword.indexOf("`")>-1) || (keyword.indexOf('"')>-1) 
  	  || (keyword.indexOf("(")>-1)  || (keyword.indexOf("'")>-1) || (keyword.indexOf(")")>-1)){
  	    alert("{html_lang name='keywordfilter_add_keyword_alert'}",function(){
  			$("#keyword").focus();
  		});return false;
  	}
    var condition = $("#condition").val();
	if(condition == '9')
	{
		{literal}
		var pattern=/^\d{1,3}(.\d{1,3}){0,3}$/; 
		{/literal}
		if(!pattern.exec(keyword))
		{
			alert("{html_lang name='keywordfilter_add_ip_invalid'}",function(){
	  			$("#keyword").focus();
	  		});return false;
		}
	}
	$("#active").attr("disabled",false);
	  $.ajax({
	         type: "POST",
	         url: "{html_url route=checkNameExist}",
	         data:{ rulename:rulename,id:id },
	         dataType:'json',
	         success: function(data){
	         		c=data;
	         },
	       async: false
	      });
		if(c.status!=1)
		{
			alert(c.info,function(){
	  			$("#rulename").focus();
	  		});
			return false;
		}
	document.form1.submit();
	return false;
  });
});
</script>
{include file='../common/sys_footer.tpl'}
