{include file='../common/sys_header.tpl'}
<div class="main">
	<form  class='curr_form' action="{html_url route='systemsetup/serverFunctionSetup'}" method="POST" >
		<h2>{html_lang name=systemsetup_server_function_title}</h2>
        <div class="form">
			<div  class="nobor_input">
				{foreach name=sys_setting from=$sys_setting_data key=sys_seting_key item=sys_seting_item}
				 <input style="margin: 5px" name="{$sys_seting_key}" type="checkbox" {if $sys_seting_item.value eq '1'} checked="checked" {/if} value="1" />{$sys_seting_item.label}
				{if $smarty.foreach.sys_setting.iteration is div by 3}
				<br />
				{/if}
			    {/foreach}
			</div>
			<div class="submit1">
				<button type="submit" >{html_lang name=systemsetup_server_function_confirm}</button>
			</div>
			<div style="color: #FF9900">* {html_lang name=systemsetup_setup_server_function}</div>
		</div>
	</form>

</div>
{include file='../common/sys_footer.tpl'}
