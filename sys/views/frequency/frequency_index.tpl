{include file='../common/sys_header.tpl'}

<div class="main">
	<h2>{html_lang name="frequency_control"}</h2>
	<form id="form1" name="form1" method="post" class='curr_form' action="{html_url route="set"}" onsubmit="return validate();">
		<div class="titlebar" >{html_lang name="frequency_base_setting"}</div>
		<div class="set" >
			<p>
				<label>{html_lang name="frequency_receipt_count_limit"}</label>
				<input name="smtpd_rcpt_limit" type="text" value="$mtaini.smtpd_rcpt_limit" maxlength="3"/>
			</p>
			<p>
				<label>{html_lang name="frequency_mail_size_limit"}</label>
				<input name="message_size_limit" type="text" value="$mtaini.message_size_limit/1024}" maxlength="7"/> KB
			</p>
			<p>
				<label>{html_lang name="frequency_attachment_count_limit"}</label>
				<input name="attachment_count" type="text" value="$mtaini.attachment_count}" maxlength="7"/> 
			</p>
			<p>
				<label>{html_lang name="frequency_mail_from_none"}</label>
				<select name="is_nofrom">
					<option value="1" >{html_lang name="frequency_accept"}</option>
					<option value="0" selected>{html_lang name="frequency_reject"}</option>
				</select>
			</p>
			<p>
				<label>{html_lang name="frequency_ignore_smtp_validate"}</label>
				<select name="is_sasl">
					<option value="0" >{html_lang name="yes"}</option>
					<option value="1" selected>{html_lang name="no"}</option>
				</select>
			</p>
		</div>
		<br />
		<div class="titlebar" >{html_lang name="frequency_ip_frequency_limit"}</div>
		<div class="set">
			<p>
				<label>{html_lang name="frequency_ip_connect_limit"}</label>
				<input name="con_count" type="text" value="$mtaini.con_count|default:0}" maxlength="3"/>
			</p>
			<p>
				<label>{html_lang name="frequency_ip_rate_connect_limit"}</label>
				<input name="connection_rate_limit" type="text" value="$mtaini.connection_rate_limit}" maxlength="4"/>
				/ {html_options name=time_unit_con options=$time_options selected="mtaini.time_unit_con"}
			</p>
		</div>
		<br />
		<div class="titlebar" >{html_lang name="frequency_send_control"}</div>
		<div class="set" >
			<p>
				<label>{html_lang name="frequency_send_rate_limit"}</label>
				<input name="mail_rate_limit" type="text" value="$mtaini.mail_rate_limit}" maxlength="6"/>
				/ {html_options name=time_unit_mail options=$time_options selected="mtaini.time_unit_mail"}
			</p>
			<p>
				<label>{html_lang name="frequency_receipt_rate_limit"}</label>
				<input name="rcpt_rate_limit" type="text" value="$mtaini.rcpt_rate_limit}" maxlength="6"/>
				/ {html_options name=time_unit_rcpt options=$time_options selected="mtaini.time_unit_rcpt"}
			</p>
		</div>
		<br />
		<div class="submit" style="border-top:1px solid #badcf4;">
			<button name="submit" type="submit" value="{html_lang name="confirm"}">{html_lang name="confirm"}</button>
		</div>
</div>
</form>
	
</div>


<script type="text/javascript">
	//alert(parseInt(003));
	
function validate(){
{literal}
	var regx1=/^[0-9]{0,3}$/;
	var regx2=/^[0-9]{0,4}$/;
	var regx3=/^[0-9]{0,6}$/;
	var regx4=/^[0-9]{0,7}$/;
{/literal}
	var form = document.form1;
	if(!form.smtpd_rcpt_limit.value || !regx1.exec(form.smtpd_rcpt_limit.value) || parseInt(form.smtpd_rcpt_limit.value) == 0){
		alert('{html_lang name="frequency_receipt_must_be_numeric"}',function(){
			$("input[name=smtpd_rcpt_limit]").focus();
		});
		return false;
	}
	if(!form.message_size_limit.value || !regx4.exec(form.message_size_limit.value) || parseInt(form.message_size_limit.value) == 0){
		alert('{html_lang name="frequency_mail_size_must_be_numeric"}',function(){
			$("input[name=message_size_limit]").focus();
		});
		return false;
	}
	if(!form.attachment_count.value ||!regx4.exec(form.attachment_count.value) || parseInt(form.attachment_count.value) == 0){
		alert('{html_lang name="frequency_attachment_must_be_numeric"}',function(){
			$("input[name=attachment_count]").focus();
		});
		return false		;
	}
	if(!form.con_count.value ||!regx1.exec(form.con_count.value) || parseInt(form.con_count.value) == 0){
		alert('{html_lang name="frequency_ip_connect_must_be_numeric"}',function(){
			$("input[name=con_count]").focus();
		});
		return false;
	}
	if(!form.connection_rate_limit.value ||!regx2.exec(form.connection_rate_limit.value) || parseInt(form.connection_rate_limit.value) == 0){
		alert('{html_lang name="frequency_ip_rate_must_be_numeric"}',function(){
			$("input[name=connection_rate_limit]").focus();
		});
		return false;		
	}
	if(!form.mail_rate_limit.value ||!regx3.exec(form.mail_rate_limit.value) || parseInt(form.mail_rate_limit.value) == 0){
		alert('{html_lang name="frequency_send_rate_must_be_numeric"}',function(){
			$("input[name=mail_rate_limit]").focus();
		});
		return false;		
	}
	if(!form.rcpt_rate_limit.value ||!regx3.exec(form.rcpt_rate_limit.value) || parseInt(form.rcpt_rate_limit.value) == 0){
		alert('{html_lang name="frequency_receipt_rate_must_be_numeric"}',function(){
			$("input[name=rcpt_rate_limit]").focus();
		});
		return false;
	}
	return true;
}
</script>

{include file='../common/sys_footer.tpl'}