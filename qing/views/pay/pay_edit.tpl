<h3 id='pos'>{if $isEdit}修改{else}新增{/if}出入</h3>
<form action='index.php?r=pay/edit' method='post' id='tform'>
<input type=hidden name="id" value="{$payModel.id|default:''}">
<table class="a" width="100%" cellspacing="1" cellpadding="0" border="0">
	<tbody>
		 <tr>
			<td class='x'>项目</td>
			<td class='y'><input type='text' id='name' name='project' value='{$payModel.project|escape|default:''}' /></td>
		 </tr>
		 <tr>
			<td class='x'>金额</td>
			<td class='y'><input type='text' id='name' name='pay' value='{$payModel.pay|default:''}' /></td>
		 </tr>
		 <tr>
			<td class='x'>预付人</td>
			<td class='y'><input type='text' id='name' name='payer' value='{$payModel.payer|default:''}' /></td>
		 </tr>
		 <tr>
			<td class='x'>时间</td>
			<td class='y'><input type='text' id='name' name='date' value='{$payModel.date|date_format:"%Y-%m-%d"}' onclick="WdatePicker({ isShowWeek:true});"/></td>
		 </tr>                 
		 <tr>
			<td class='x'>备注</td>
			<td class='y'><input type='text' id='name' name='note' value='{$payModel.note|escape|default:''}' /></td>
		 </tr>  
                 <!--
		 <tr>
			<td class='x'>文件上传</td>
			<td class='y'>
				<input type='file' id='iconx' />
				<input type='hidden' id='icon' name='icon' value='icon1' />
			</td>
		 </tr>
			<td class='x t'>文件预览</td>
			<td class='y' id='upload'>
			</td>
		 </tr>
                 -->
	</tbody>

	<tfoot>
		<tr>
			<td class='x'></td>
			<td class='y'><input type='submit' value='提交' /></td>
		</tr>
	</tfoot>
</table>
</form>
<script type="text/javascript" src="/js/My97DatePicker/WdatePicker.js"></script>   

<script type="text/javascript">
	//$('.wyseditor').xheditor({ upImgUrl:"{ $uploadUrl}",upImgExt:"jpg,jpeg,gif,png" });


</script>
