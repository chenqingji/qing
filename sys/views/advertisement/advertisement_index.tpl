{include file='../common/sys_header.tpl'}
<script type="text/javascript">
/**
 * 绑定删除按钮点击事件
 */
$(function(){
	$('#delete_id').click( function() {
		size = $("#form1").getCheckedSize();
        if (size < 1) {
	   		alert("{html_lang name='advertisement_choice_page_to_delete'}");
            return false;
        }
        confirm('{html_lang name="advertisement_sure_to_delete"}',function(){
			document.form1.action = "{html_url route='delete'}";
            document.form1.submit();
        });
        
        return false;
	});
}); 
/**
 * 广告管理修改
 */
function login_page_update() {
	var size = $("#form1").getCheckedSize();
	if(size!=1) {
   		alert("{html_lang name='advertisement_choice_one_least'}");
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
	<form id="form1" name="form1" method="post" class='curr_form' action="{html_url route='toEdit'}" >
	<h2>{html_lang name='advertisement_title'}</h2>
    <div class="list">
    	<table>
    	<thead>
        	<tr>
            	<th width="6%">{html_lang name='advertisement_choice'}</th>
            	<th>{html_lang name='advertisement_name'}</th>
            	<th>{html_lang name='advertisement_path'}</th>
            	<th>{html_lang name='advertisement_notice'}</th>
            </tr>
        </thead>
        {if $advertisements|@count neq 0 } 
        <tbody>
        {foreach $advertisements as $advertisement}
      	<tr>
        	<th>
        	<input type="checkbox" class="chkMe" name="checkboxID[]" value="{$advertisement.id}" />
            </th>
        	<td>{$advertisement.name|escape:'html'} </td>
        	<td title="{$advertisement.url|escape:'html'}">{$advertisement.url|escape:'html'} </td>
        	<td>{$advertisement.note|escape:'html'}</td>
        </tr>    
        {/foreach}             	
        </tbody>  
        {/if } 
		<tfoot>          
        <tr> 
         <td style="text-align:center">
         <input type="checkbox" name="allcheck" class="chkAll" value="checkbox" />
         </td>
         <td colspan="3">&nbsp;</td>
       </tr>
	   </tfoot> 
     </table>
	 <div class="submit">
	 	<button name="Submit1" type="button" onclick="window.location.href='{html_url route=toEdit}'" id=focus>{html_lang name=add}</button>
			<button name="Submit2" type="submit" id='delete_id'>{html_lang name=delete}</button>
      <button name="Submit3" type="submit" onclick="return login_page_update()">{html_lang name=edit}</button>       
	 </div>
    </div>
	</form>
</div>
{include file='../common/sys_footer.tpl'}