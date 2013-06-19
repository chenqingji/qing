{include file='../common/sys_header.tpl'}
<div class="main">
	<form class='curr_form'  action="{html_url route='systemsetup/postTypeSetup'}" method="POST" >
		<h2>{html_lang name=systemsetup_post_type_title}</h2>
        <div class="form">
			<div id="select_post_type_contain" class="nobor_input">
				<label style="line-height:16px;">{html_lang name=systemsetup_post_type}</label>
				{foreach from=$post_type_list key=post_type item=post_type_label}
					<input type="radio" name="post_type" value="{$post_type}" {if $current_post_type eq $post_type} checked="checked" {/if} id="{$post_type}_mail" />{$post_type_label} 
			    {/foreach}
				    </div>
					<div>
						<label>{html_lang name=systemsetup_post_logo}</label>
							<span style="margin-left: 25px" id="logo_contain">
						  {foreach from=$post_type_list key=post_type item=post_type_label}
								<img src="../common/logo/logo_{$post_type}.gif?t={$request_time}" id="{$post_type}_mail_logo" style="display: none"/>
			              {/foreach}
							</span>
					</div>
					<div class="submit1">
						<button type="submit" >{html_lang name=systemsetup_server_function_confirm}</button>
					</div>
			</div>
	</form>

</div>
<script type="text/javascript">
	$("#{$current_post_type}_mail_logo").show();
	$("#select_post_type_contain").find("input:radio").click(
	function(){
     var post_type=this.id.replace("_mail","");
	$("#logo_contain").find("img").each(function(){
		if(this.id.replace("_mail_logo","")==post_type){
			$(this).show();
			this.src="../common/logo/logo_"+post_type+".gif?t="+(new Date()).getTime();
		}else{
			$(this).hide();
		}
	});
	});
</script>
{include file='../common/sys_footer.tpl'}