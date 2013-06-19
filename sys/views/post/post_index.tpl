{include file='../common/sys_header.tpl'} 
<script type="text/javascript">
<!--
	/**
	 * 绑定按钮事件
	 */
	$(function() {
		$('#delete_id').click(function() {
			var size = $('#form1').getCheckedSize();
			if (size < 1) {
				alert("{html_lang name=post_need_choice_to_delete}");
				return false;
			}
			confirm('{html_lang name=post_check_delete}',function(){
				document.form1.action = "{html_url route=delete}";
				document.form1.submit();
			});
			return false;
		});
		$('#update_id').click(function() {
			var size = $('#form1').getCheckedSize();
			if (size == 0) {
				alert('{html_lang name=post_need_choice_to_edit}');
				return false;
			}
			if (size > 1) {
				alert('{html_lang name=post_can_not_edit_more}')
				return false;
			}
			document.form1.action = "{html_url route=toUpdate}";
			document.form1.submit();

		});
		$('#cdn_id').click(function() {
			window.location.href='{html_url route=cdnAccelerateSetting}';
		});
		$('#searchSubmit').click(function(){
			document.form1.action = "{html_url route=index}";
			document.form1.submit();
		});
		$('#parameter_id').click(function() {
			var size = $('#form1').getCheckedSize();
			if (size == 0) {
				alert('{html_lang name=post_need_choice_to_setting}');
				return false;
			}
			if (size > 1) {
				alert('{html_lang name=post_can_not_set_more}')
				return false;
			}
			document.form1.action = "{html_url route=postParameterSet}";
			document.form1.submit();
		});
	});

	/**
	 * 页面初始化复选框选中事件
	 */
	$(document).ready(function(){
		$("#form1").exCheckAll(true);
	});
//-->
</script>
<div class='main'>
	<form method="post" name="form1" id="form1" class='curr_form' action="{html_url route='post/index'}">
		<h2>{html_lang name=post_manage}</h2>
	    <div class="search">
	        <input name="search" autocomplete="off" id="search" type="text" value="{html_request_value name=search}" maxlength="30" />
	        <button name="Submit" type="submit" id="searchSubmit" >{html_lang name=post_search}</button>
	    </div>
    	<div class="list">
	    	<table>
	        	<thead>
	            	<tr>
	                	<th width="6%">{html_lang name=post_choise}</th>
	                	<th width="20%">{html_lang name=post_name}</th>
	                	<th>{html_lang name=post_status}</th>
	                	<th>{html_lang name=post_max_mailbox_num}</th>
                                <th>{html_lang name=post_post_quota}</th>
                                <th>{html_lang name=post_netdisk_quota}</th>
	                	<th>{html_lang name=post_create_time}</th>
	                	<th>{html_lang name=post_expire_time}</th>
	                </tr>
	            </thead>
	            <tbody>
                                    <tr>
		                	<th>
                                            <input name="ids[]" class="chkMe" type="checkbox" value="po_id}"/>
                                        </th>
		                	<td>
			                	<span style="float:left;width:156px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;text-align:left;">
				                	<a 
				                	href="javascript:void(0);"
                                                        style="word-break:break-all" title="domain}" >
				                		domain}
				                	</a>
		                		</span>
	                		</td>
		                	<td title="reason}">po_status}</td>
		                	<td>po_maxuser}</td>
                                        <td>{math equation="x/1024/1024" x=152345845}</td>
                                        <td>net_quota}</td>
		                	<td>cr_time}</td>
		                	<td>ex_time}</td>
		                </tr>
	            </tbody>
	            <tfoot>
                            <tr>
	                	<td width="6%" style="text-align:center">
                                    <input type="checkbox" name="allcheck" class="chkAll" value="checkbox"/>
                                </td>
		            	
                                <td colspan="7">
                                    {html_page form=form1}
                                </td>
                            </tr>
	            </tfoot>
	       	</table>
	        <div class="submit">
                        <button id='first_button' type="button" onclick="location.href='{html_url route=toAdd}'">{html_lang name=post_add}</button>
	        	<button id='delete_id' type="button" >{html_lang name=post_delete}</button>
                        <button id='update_id' type="button" >{html_lang name=post_edit}</button>
                        <button id='cdn_id' type="button">{html_lang name=post_cdn}</button>
                        <button id='parameter_id' type="button" >{html_lang name=post_parameter_button}</button>
	        </div>
    	</div>
	</form>
</div>
{include file='../common/sys_footer.tpl'}
