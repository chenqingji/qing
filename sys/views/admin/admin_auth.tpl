{include file='../common/sys_header.tpl'}
<div class="main">
	<form id="form1" name="form1" method="post" action="{html_url route=auth}" >
		<h2>{html_lang name=admin_access}</h2>
	    <div class="list info1">
	    	<table>
	        	<caption>
	                <p>{html_lang name=admin_now_for}<span>{$admin_name}</span>{html_lang name=admin_authorization2}</p>
					<input type="hidden" name="admin_id" value={$admin_id}>
	            </caption>
	        	<thead>
	            	<tr>
	                	<th width="6%">{html_lang name=admin_toolbar_choose}</th>
	                	<th>{html_lang name=admin_toolbar_function}</th>
	                	<th>{html_lang name=admin_toolbar_note}</th>
	                </tr>
	            </thead>
	             {if $rights|@count neq 0 } 
	            <tbody>
	            			<tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="1" 
			                		{if $rights[0]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title1}</td>
			                	<td title="{html_lang name=Note1}">{html_lang name=Note1}</td>
			                </tr>
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="3" 
			                		{if $rights[2]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title2}</td>
			                	<td title="{html_lang name=Note2}">{html_lang name=Note2}</td>
			                </tr>
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="4" 
			                		{if $rights[3]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title3}</td>
			                	<td title="{html_lang name=Note3}">{html_lang name=Note3}</td>
			                </tr>
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="5" 
			                		{if $rights[4]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title4}</td>
			                	<td title="{html_lang name=Note4}">{html_lang name=Note4}</td>
			                </tr>
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="6" 
			                		{if $rights[5]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title5}</td>
			                	<td title="{html_lang name=Note5}">{html_lang name=Note5}</td>
			                </tr>
			                {if (!SysAccessAuth::isHaveAccessRight(SysRightsConfig::POST_CDN) or !$sysSetting.is_cdn)}
		            		<tr style="display:none">
			                	<th><input type="checkbox"  name="checkboxID[]" value="0" /></th>
		            		{else}
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="16" 
			                		{if $rights[15]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                		{/if}
			                	<td>{html_lang name=Title6}</td>
			                	<td title="{html_lang name=Note6}">{html_lang name=Note6}</td>
			                </tr>
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="17" 
			                		{if $rights[16]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title7}</td>
			                	<td title="{html_lang name=Note7}">{html_lang name=Note7}</td>
			                </tr>
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="7" 
			                		{if $rights[6]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title8}</td>
			                	<td title="{html_lang name=Note8}">{html_lang name=Note8}</td>
			                </tr>
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="8" 
			                		{if $rights[7]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title9}</td>
			                	<td title="{html_lang name=Note9}">{html_lang name=Note9}</td>
			                </tr>
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="9" 
			                		{if $rights[8]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title10}</td>
			                	<td title="{html_lang name=Note10}">{html_lang name=Note10}</td>
			                </tr>
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="10" 
			                		{if $rights[9]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title11}</td>
			                	<td title="{html_lang name=Note11}">{html_lang name=Note11}</td>
			                </tr>
			                <tr>
			                	<th><input type="checkbox" class="chkMe" name="checkboxID[]" value="11" 
			                		{if $rights[10]}
			                			checked="checked"
			                		{/if}
			                	></th>
			                	<td>{html_lang name=Title12}</td>
			                	<td title="{html_lang name=Note12}">{html_lang name=Note12}</td>
			                </tr>
	            </tbody>
	            {/if}
				<tfoot>
					<tr>
						<td style="text-align:center" >
							<input type="checkbox" name="allcheck" value="checkbox"  class="chkAll"  />
						</td>
						<td colspan="2" >
							&nbsp;
						</td>
					</tr>
				</tfoot>
			</table>
			<div class="submit">
				<button name="Submit2" type="submit" >{html_lang name=admin_authorization}</button>
				&nbsp;&nbsp;
				<button name="Submit3" type="button" onclick="location.href='{html_url route=index}'" >{html_lang name=cancel}</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
<!--
/**
 * 页面初始化复选框选中事件
 */
$(document).ready(function(){
	$("#form1").exCheckAll(true);
	var checkedSize = $("#form1").getCheckedSize();
	var totalSize = $("#form1").getTotalSize();
	if(checkedSize == totalSize){
		$("#form1").find(".chkAll:checkbox").each(function(){
			this.checked="checked";
		});
	}
});
-->
</script>
{include file='../common/sys_footer.tpl'}
