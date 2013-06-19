<h3 id='pos'>出入列表</h3>
<form name="list_form" action="" method="post"/>
<table id="payTable" class="clear b at" width="100%" cellspacing="1" cellpadding="0" border="0">
	<thead>
		<tr>
			<td><input  class='all chkAll' type="checkbox" value=""/></td>
			<td class='d'>项目</td>
			<td class='d'>金额</td>
			<td class='d'>预付人</td>
			<td class='d'>理论支付</td>
			<td class='d'>实际支付</td>
			<td class='d'>备注</td>
			<td class='d'>项目日期</td>
			<td class='d'>创建时间</td>
			<td class='d'>最后更新时间</td>
			<td class='c'>操作</td>
		</tr>
	</thead>

	<tbody>
                {if $rows}
                {foreach from=$rows item=row}
		 <tr>
                        <td>
                                <input class="chkMe" type="checkbox" name="ids[]" value="{$row.id}" />
                                <input type="hidden" name="payIds[]" value="{$row.id}">
                                <input type="hidden" name="paySorts[]" value="{$row.sort}">
                        </td>
			<td>{$row.project|escape|default:''}</td>
			<td>{$row.pay}</td>
			<td>{$row.payer}</td>
			<td>0</td>
                        <td>0</td>
                        <td>{$row.note}</td>
                        <td>{$row.date|date_format:"%Y-%m-%d"}</td>        
                        <td>{$row.createdTime|date_format:"%Y-%m-%d %H:%M:%S"}</td>        
                        <td>{$row.updatedTime|date_format:"%Y-%m-%d %H:%M:%S"}</td>        
                        <td><a href="index.php?r=pay/toEdit/id/{$row.id}">修改</a>&nbsp;&nbsp;<a href="index.php?r=pay/delete/id/{$row.id}">删除</a></td>
		 </tr>
                 {/foreach}
                 {/if}
	</tbody>
</table>
<div style="margin:10px 0;">
        <input type="button" name="delete_more" onclick="toDeleteList(this);return false;" value="批量删除" >
        <input type="button" name="save_order" onclick="toSortList(this);return false;" value="保存顺序" >        
</div>
</form>        

<script type="text/javascript">
        $(document).ready(function(){
               $('#payTable').exCheckAll();
               $("#payTable tbody").sortable();
        });
        function toSortList(btn){
                window.list_form.action = 'index.php?r=pay/sort';
                window.list_form.submit();
        }
        function toDeleteList(btn){
                window.list_form.action = "index.php?r=pay/delete";
                window.list_form.submit();
        }
</script>
