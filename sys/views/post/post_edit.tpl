{include file='../common/sys_header.tpl'}
{assign value=add var=action }
<div class="main">
	<form name="form1" method="post" class='curr_form' action="{html_url route=$action}">
		<h2>{html_lang name=post_edit_edit}{html_lang name=post_edit_add}</h2>
		<div class="form">
			<div>
				<label>{html_lang name=post_post_name}</label> 
				{if true}
					<span class="ccommon">{$domain.domain|escape|default:''}</span>
					<input type="hidden" value=$id} name="id" />
				{else}
					<input name="domain" type="text" id="domain" class='ccommon' maxlength="64" value="{$domain.domain|escape|default:''}"
						onblur="$.fn.strength_validate.validate($('.strengthpwd'));" />
					<em>{html_lang name=post_example}</em>
				{/if}
			</div>
			{for $index=0 to 3}
				<div>
					<label>{html_lang name=post_domain_alias}{math equation="x + 1 " x=$index}{html_lang name=post_domian_punctuation}</label> 
					<input name="domain_alias{math equation='x + 1 ' x=$index}" type="text" id="domain_alias{math equation='x + 1 ' x=$index}" maxlength="64" 
						value="$mailAliases[$index].address" />{html_lang name=post_can_choose}
				</div>
			{/for}
			<div>
				<label class="label_line1">{html_lang name=post_set}</label> 
                                    <input type="checkbox" name="$key}" id="$key}" value='1' onclick="operate('$key}');" class="nos" checked="checked" />$value}　
			</div>
			<div>
				<label>{html_lang name=post_backup_time}</label> {html_lang name=post_last}&nbsp;
				<input name="po_bak_period" type="text" id="po_bak_period" value="$domain.po_bak_period}" size="5"
					maxlength="2" />{html_lang name=post_1_30_day}
			</div>
			<div>
				<label>{html_lang name=post_mailbox_nums}</label> 
				<input name="po_maxuser" type="text" id="po_maxuser" value="$domain.po_maxuser}" size="5" maxlength="5" />{html_lang name=post_mailbox_unit}
			</div>
			<div id="po_quota_div">
				<label>{html_lang name=post_mailbox_space}</label>
				<input name="po_quota" type="text" id="po_quota" value="{math equation="x/1024/1024" x=123456}" size="5" maxlength="10" />{html_lang name=post_unit_mb}
			</div>
				<div>
					<label>{html_lang name=post_net_hd}</label> 
					<input name="net_quota" type="text" id="net_quota" value="$domain.net_quota}" size="5" maxlength="10" />{html_lang name=post_unit_mb}
				</div>
			<div id="sms_buy_div">
				<label>{html_lang name=post_buy_sms}</label> 
				<input name="sms_buy" type="text" id="sms_buy" 
					value="0" size="5" maxlength="10" />$domain.sms_avail}&nbsp;
					{html_lang name=post_buy_sms_available}
			</div>
			<div id="fax_amount_div">
				<label>{html_lang name=post_fax_amount}</label> 
				<input name="fax_amount" type="text" id="fax_amount" 
					value="0.0" 
					size="5" maxlength="10" />{html_lang name=post_buy_fax_unit} 
			</div>
				<div id="pushmail_num1">
					<label>{html_lang name=post_buy_pushmail}</label> 
					<input type='text' name="pushmail_num" id="pushmail_num" size="5" maxlength="10" value="$poPushmail.pushmail_nums}"
						onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">{html_lang name=post_mailbox_unit}
				</div>
			<!-- 基础api设置start -->
				<div id="api_ip"  class="api_div">
					<label class="label_line2">{html_lang name=post_base_api_ip_allowed_addr}</label> 
					<input type="radio" class="ip_radio" id="ip_type" name="ip_type" value="nolimit" checked="checked" />{html_lang name=post_base_api_nolimit}
				 	<input type="radio" class="ip_radio" name="ip_type" id="ip_type" value="single" />{html_lang name=post_base_api_single_ip}
				 	<input type="radio" class="ip_radio" id="ip_type" name="ip_type" value="range" />{html_lang name=post_base_api_ip_range}
					<table width="100%" cellspacing="0" cellpadding="0" border="0" 
						style="width: 550px; margin-left: 80px; " id="ip_setting">
						<tbody>
							<tr>
								<td style="width: 200px;">
									<p id="single">
										{html_lang name=post_base_api_ip_addr}<input type="text" maxlength="20" id="Ip"/>
									</p>
									<p style="display: none" id="multiple" style="width:220px;">
										{html_lang name=post_base_api_ip_start}<br /><input type="text" maxlength="20" id="startIp" name="startIp"  /><br> 
										{html_lang name=post_base_api_ip_end}<br /><input type="text" maxlength="20" id="endIp" name="endIp" /><br> 
										{html_lang name=post_base_api_ip_except}<br /><input type="text" id="filterIp" name="filterIp" />
									</p>
								</td>
								<td style="width: 100px; text-align: center;">
									<button name="addIpBtn" style="margin: 0 auto;" type="button">{html_lang name=post_base_api_ip_add}</button>
									<br> <br>
									<button name="delIpBtn" style="margin: 0 auto;" type="button">{html_lang name=post_base_api_ip_delete}</button>
									<br> <br>
								</td>
								<td style="width: 250px;">
									<div class="maillist" style='margin-right: 70px;'>
										<select style="width: 250px;" size="6" name="ipList">
                                                                                        <option value="$option}">$option}</option>
										</select>
										<input type="hidden" name="ips">
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			<!-- 基础api设置end -->
			<!-- 密码start -->
			<div>
				<label>{html_lang name=post_password}</label> 
				<input name="po_pwd1" type="password" id="po_pwd1" class='strengthpwd' value="$domain.po_pwd}" maxlength="25" />
				<em>{html_lang name=post_password_note}</em>
			</div>
			<div>
				<label>&nbsp;</label> 
				<span class='strength'>{html_lang name=post_password_weak}</span> 
				<span class='strength'>{html_lang name=post_password_in}</span> 
				<span class='strength'>{html_lang name=post_password_strong}</span>
			</div>
			<div>
				<label>{html_lang name=post_password_repeat}</label> 
				<input name="po_pwd2" type="password" id="po_pwd2" value="$domain.po_pwd}" maxlength="25" />
				<em>{html_lang name=post_password_note}</em>
			</div>
			<!-- 密码end -->
			<!-- 时间start -->
			{assign var="year" value="{math equation="x + 1" x={$smarty.now|date_format:'%Y'}}"}
			{assign var="month_day" value="{$smarty.now|date_format:'%m%d'}"}
			<div>
				<label>{html_lang name=post_edit_create_time}</label> 
				<input name="year1" type="text" id="year1" value="{$smarty.now|date_format:'%Y'}" size="6" maxlength="4" />{html_lang name=post_year}
				<input name="month1" type="text" id="month1" value="{$smarty.now|date_format:'%m'}" size="6" maxlength="2" />{html_lang name=post_month}
				<input name="date1" type="text" id="date1" value="{$smarty.now|date_format:'%d'}" size="6" maxlength="2" />{html_lang name=post_day}
			</div>
			<div>
				<label>{html_lang name=post_edit_end_time}</label> 
				<input name="year2" type="text" id="year2" value="{$smarty.now|date_format:'%Y'}" size="6" maxlength="4" />{html_lang name=post_year}
				<input name="month2" type="text" id="month2" value="{$smarty.now|date_format:'%m'}" size="6" maxlength="2" />{html_lang name=post_month}
				<input name="date2" type="text" id="date2" value="{$smarty.now|date_format:'%d'}" size="6" maxlength="2" />{html_lang name=post_day}
			</div>
			<!-- 时间end -->
			<div class="submit1">
				<button name="Submit" type="submit" onclick="return checkform();">{html_lang name=post_submit}</button>
				<button name="Submit2" type="button" class="btn" onclick="location.href='{html_back_url route=index}'">{html_lang name=post_cancel}</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">

</script>
{include file='../common/sys_footer.tpl'}
