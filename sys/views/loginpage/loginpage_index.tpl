{include file='../common/sys_header.tpl'}
<script>
/**
 * 绑定删除按钮点击事件
 */
$(function(){
	$('#delete_id').click( function() {
		size = $("#form1").getCheckedSize();
        if (size < 1) {
	   		alert("{html_lang name='login_page_set_choice_page_to_delete'}");
            return false;
        }
        confirm('{html_lang name="login_page_set_sure_to_delete"}',function(){
			document.form1.action = "{html_url route='delete'}";
            document.form1.submit();
        });
        return false;
	});
}); 
/**
 * 登录页面样式修改
 */
function login_page_update() {
	var size = $("#form1").getCheckedSize();
	if(size!=1) {
   		alert("{html_lang name='login_page_set_choice_one_least'}");
	    return false;
	}
}
/**
 * 页面初始化复选框选中事件
 */
$(document).ready(function(){
	$("#form1").exCheckAll(true);
});
</script>
<div class="main">
	<form id="form1" name="form1" method="post" class='curr_form' action="{html_url route='toEdit'}">
		<h2>{html_lang name=login_page_set_title}</h2>
	    <div class="list">
	   		<table>
	        	<thead>
	            	<tr>
	                	<th width="6%">{html_lang name=login_page_set_choice}</th>
	                	<th>{html_lang name=login_page_set_chinese_name}</th>
	                	<th>{html_lang name=login_page_set_english_name}</th>
	                	<th>{html_lang name=login_page_set_path}</th>
	                	<th>{html_lang name=login_page_set_thumbnail}</th>
	                </tr>
	            </thead>
	             {if $styles|@count neq 0 } 
	            <tbody>
	            	{foreach $styles as $style}
		            	<tr>
		                	<th>
		                    	<input type="checkbox" class="chkMe" name="checkboxID[]" value="{$style.id}" />
		                    </th>
		                	<td>{$style.name|escape}</td>
		                	<td>{$style.en_name|escape} </td>
		                	<td>{$style.path|escape}</td>
		                	<td class="tc">
		                		<a href='{html_url route="loginpage/toShow&imgUrl=assets/images/loginpage/{$style.path|escape}"}' target='_blank' style="line-height:0;vertical-align:bottom;">
		                			<img src="assets/images/loginpage/{$style.path|escape}.jpg" width="60" height="40" border="0">
		                		</a>
	                		</td>
		                </tr>
					{/foreach}
	            </tbody>
	            {/if}
				<tfoot>			
	         		<tr>
						<td style="text-align:center">
			            	<input type="checkbox" name="allcheck" class="chkAll" value="checkbox" />
			            </td>
						<td colspan="4">&nbsp;</td>
	        		</tr>	
				</tfoot>
	      	</table> 
			<div class="submit">
				<button type="button" onclick="window.location.href='{html_url route=toEdit}'" id=focus>{html_lang name=add}</button>
				<button id='delete_id' type="submit" >{html_lang name=delete}</button>
				<button type="submit" onclick="return login_page_update()">{html_lang name=edit}</button>
			</div>
		</div>
	</form>
</div>
{include file='../common/sys_footer.tpl'}