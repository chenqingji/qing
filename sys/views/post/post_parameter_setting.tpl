{include file='../common/sys_header.tpl'}
<script type="text/javascript" >
var change=false;
function check_input(form1){
	if(form1.monitor_limit && $.trim(form1.monitor_limit.value)==''){
		alert('{html_lang name=post_mailbox_multiples} {html_lang name=post_monitor_limit case=lower}{html_lang name=post_mailbox_multiples2}{html_lang name=post_parameter_empty}',function(){
			$('input[name=monitor_limit]').focus();
		});
		return false;
	}
	if(form1.audit_limit && $.trim(form1.audit_limit.value)==''){
		alert('{html_lang name=post_mailbox_multiples}{html_lang name=post_audit_limit case=lower}{html_lang name=post_mailbox_multiples2}{html_lang name=post_parameter_empty}',function(){
			$('input[name=audit_limit]').focus();
		});
		return false;
	}
	if(form1.maillist_limit && $.trim(form1.maillist_limit.value)==''){
		alert('{html_lang name=post_mailbox_multiples}{html_lang name=post_maillist_limit case=lower}{html_lang name=post_mailbox_multiples2}{html_lang name=post_parameter_empty}',function(){
			$('input[name=maillist_limit]').focus();
		});
		return false;
	}
	if(form1.single_maillist_foreign_limit && $.trim(form1.single_maillist_foreign_limit.value)==''){
		alert("{html_lang name=post_single_maillist_foreign_limit}{html_lang name=post_parameter_empty}",function(){
			$('input[name=single_maillist_foreign_limit]').focus();
		});
		return false;
	}
	if(form1.address_limit && $.trim(form1.address_limit.value)==''){
		alert('{html_lang name=post_address_limit}{html_lang name=post_parameter_empty}',function(){
			$('input[name=address_limit]').focus();
		});
		return false;
	}
	if(form1.mail_rule_limit && $.trim(form1.mail_rule_limit.value)==''){
		alert('{html_lang name=post_mail_rule_limit}{html_lang name=post_parameter_empty}',function(){
			$('input[name=mail_rule_limit]').focus();
		});
		return false;
	}
	if(form1.sms_rule_limit && $.trim(form1.sms_rule_limit.value)==''){
		alert('{html_lang name=post_sms_rule_limit}{html_lang name=post_parameter_empty}',function(){
			$('input[name=sms_rule_limit]').focus();
		});
		return false;
	}
	if(form1.pushmail_rule_limit && $.trim(form1.pushmail_rule_limit.value)==''){
		alert('{html_lang name=post_pushmail_rule_limit}{html_lang name=post_parameter_empty}',function(){
			$('input[name=pushmail_rule_limit]').focus();
		});
		return false;
	}
	if(form1.monitor_rule_limit && $.trim(form1.monitor_rule_limit.value)==''){
		alert('{html_lang name=post_monitor_rule_limit}{html_lang name=post_parameter_empty}',function(){
			$('input[name=monitor_rule_limit]').focus();
		});
		return false;
	}
	if(form1.monitor_limit && isNaN(form1.monitor_limit.value)){
		alert('{html_lang name=post_mailbox_multiples} {html_lang name=post_monitor_limit case=lower}{html_lang name=post_mailbox_multiples2}{html_lang name=post_error_tip}',function(){
			$('input[name=monitor_limit]').focus();
		});
		return false;
	}
	if(form1.audit_limit && isNaN(form1.audit_limit.value)){
		alert('{html_lang name=post_mailbox_multiples} {html_lang name=post_audit_limit case=lower }{html_lang name=post_mailbox_multiples2}{html_lang name=post_error_tip}',function(){
			$('input[name=audit_limit]').focus();
		});
		return false;
	}
	if(form1.maillist_limit && isNaN(form1.maillist_limit.value)){
		alert('{html_lang name=post_mailbox_multiples} {html_lang name=post_maillist_limit case=lower}{html_lang name=post_mailbox_multiples2}{html_lang name=post_error_tip}',function(){
			$('input[name=maillist_limit]').focus();
		});
		return false;
	}
	if(form1.single_maillist_foreign_limit && isNaN(form1.single_maillist_foreign_limit.value)){
		alert("{html_lang name=post_single_maillist_foreign_limit}{html_lang name=post_error_tip}",function(){
			$('input[name=single_maillist_foreign_limit]').focus();
		});
		return false;
	}
	if(form1.address_limit && isNaN(form1.address_limit.value)){
		alert('{html_lang name=post_address_limit}{html_lang name=post_error_tip}',function(){
			$('input[name=address_limit]').focus();
		});
		return false;
	}
	if(form1.mail_rule_limit && isNaN(form1.mail_rule_limit.value)){
		alert('{html_lang name=post_mail_rule_limit}{html_lang name=post_error_tip}',function(){
			$('input[name=mail_rule_limit]').focus();
		});
		return false;
	}
	if(form1.sms_rule_limit && isNaN(form1.sms_rule_limit.value)){
		alert('{html_lang name=post_sms_rule_limit}{html_lang name=post_error_tip}',function(){
			$('input[name=sms_rule_limit]').focus();
		});
		return false;
	}
	if(form1.pushmail_rule_limit && isNaN(form1.pushmail_rule_limit.value)){
		alert('{html_lang name=post_pushmail_rule_limit}{html_lang name=post_error_tip}',function(){
			$('input[name=pushmail_rule_limit]').focus();
		});
		return false;
	}
	if(form1.monitor_rule_limit && isNaN(form1.monitor_rule_limit.value)){
		alert('{html_lang name=post_monitor_rule_limit}{html_lang name=post_error_tip}',function(){
			$('input[name=monitor_rule_limit]').focus();
		});
		return false;
	}
	return true;
}
function back(){
	if(change){
    	confirm("{html_lang name=post_change_parameter_tip}",function(){
    		location.href='{html_url route='index'}'
    	});
	}else{
		location.href='{html_url route='index'}';
	}
}
function changevalue(){
	change=true;
}
$(document).ready(function(){
	$("input").bind("change", function(){
		changevalue();
	});
});
</script>
<div class='main'>
 <form id="text_form" method="post" name="form1" class='curr_form' action="{html_url route='post/postParamaterSave'}" onsubmit='return check_input(this);'>
        <h2>{html_lang name=post_parameter_set}</h2>
      
        <div class="form">
        	<input type='hidden' name='id' value="{$id|default:''}">
        	<div class="list_l">
            <label>{html_lang name=post_name}{html_lang name=post_sign}</label><span>{$domain|default:''}</span>
        	</div>
        	{if $sysSetting.is_bcc}
            <div class="list_l">
                <label>{html_lang name=post_monitor_limit}{html_lang name=post_sign}</label> 
                <input name="monitor_limit" type="text" size="2" maxlength="2" value="{$monitor_limit|default:'0'}"/>
                {html_lang name=post_sign2}{html_lang name=post_user_number}{$user_number}
                <em>
                {html_lang name=post_bracket_left} {html_lang name=post_default}
                {html_lang name=post_sign}{$domain_multiple}{html_lang name=post_sign2}{html_lang name=post_mailuser_numerber}
                {html_lang name=post_bracket_right}
                </em>
            </div>  
            <div class="list_l">
                <label>{html_lang name=post_audit_limit}{html_lang name=post_sign}</label> 
                <input name="audit_limit" type="text" size="2" maxlength="2" value="{$audit_limit|default:'0'}"/>
                {html_lang name=post_sign2}{html_lang name=post_user_number}{$user_number}
                <em>
                {html_lang name=post_bracket_left} {html_lang name=post_default}
                {html_lang name=post_sign}{$domain_multiple}{html_lang name=post_sign2}{html_lang name=post_mailuser_numerber}
                {html_lang name=post_bracket_right}
                </em>
            </div>
           {/if}
            <div class="list_l">
                <label>{html_lang name=post_maillist_limit}{html_lang name=post_sign}</label> 
                <input name="maillist_limit" type="text" size="2" maxlength="2" value="{$maillist_limit|default:'0'}" />
                {html_lang name=post_sign2}{html_lang name=post_user_number}{$user_number}
                <em>
                {html_lang name=post_bracket_left} {html_lang name=post_default}
                {html_lang name=post_sign}{$domain_multiple}{html_lang name=post_sign2}{html_lang name=post_mailuser_numerber}
                {html_lang name=post_bracket_right}
                </em>
            </div>
            <div class="list_l">
                <label>{html_lang name=post_single_maillist_foreign_limit}{html_lang name=post_sign}</label> 
                <input name="single_maillist_foreign_limit" type="text" size="5" maxlength="5" value="{$single_maillist_foreign_limit|default:'0'}"/>
                <em>
                {html_lang name=post_bracket_left} {html_lang name=post_default}
                {$single_maillist_foreign_limit_default}
                {html_lang name=post_bracket_right}
                </em>
            </div>
            <div class="list_l">
                <label>{html_lang name=post_address_limit}{html_lang name=post_sign}</label> 
                <input name="address_limit" type="text" size="5" maxlength="5" value="{$address_limit|default:'0'}"/>
                <em>
                {html_lang name=post_bracket_left} {html_lang name=post_default}
                {$address_limit_default}
                {html_lang name=post_bracket_right}
                </em>
            </div>
            <div class="list_l">
                <label>{html_lang name=post_mail_rule_limit}{html_lang name=post_sign}</label> 
                <input name="mail_rule_limit" type="text" size="5" maxlength="5" value="{$mail_rule_limit|default:'0'}"/>
                <em>
                {html_lang name=post_bracket_left} {html_lang name=post_default}
                {$mail_rule_limit_default}
                {html_lang name=post_bracket_right}
                </em>
            </div>
            {if $sysSetting.is_sms}
            <div class="list_l">
                <label>{html_lang name=post_sms_rule_limit}{html_lang name=post_sign}</label> 
                <input name="sms_rule_limit" type="text" size="5" maxlength="5" value="{$sms_rule_limit|default:'0'}"/>
               <em>
                {html_lang name=post_bracket_left} {html_lang name=post_default}
                {$sms_rule_limit_default}
                {html_lang name=post_bracket_right}
                </em>
            </div>
            {/if}
            {if $sysSetting.is_pushmail}
            <div class="list_l">
                <label>{html_lang name=post_pushmail_rule_limit}{html_lang name=post_sign}</label> 
                <input name="pushmail_rule_limit" type="text" size="5" maxlength="5" value="{$pushmail_rule_limit|default:'0'}"/>
               <em>
                {html_lang name=post_bracket_left} {html_lang name=post_default}
                {$pushmail_rule_limit_default}
                {html_lang name=post_bracket_right}
                </em>
            </div>
            {/if}
            {if $sysSetting.is_bcc}
            <div class="list_l">
                <label>{html_lang name=post_monitor_rule_limit}{html_lang name=post_sign}</label> 
                <input name="monitor_rule_limit" type="text" size="5" maxlength="5" value="{$monitor_rule_limit|default:'0'}"/>
                <em>
                {html_lang name=post_bracket_left} {html_lang name=post_default}
                {$monitor_rule_limit_default}
                {html_lang name=post_bracket_right}
                </em>
            </div>
           {/if}
            <div class="submit1">
                <button type="submit" >{html_lang name=confirm}</button>
                <button type="reset" >{html_lang name=post_reset}</button>
                <button type="button"  onclick="back()">{html_lang name=cancel}</button>
            </div>
        </div>
    </form>
</div>
{include file='../common/sys_footer.tpl'}
