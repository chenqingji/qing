{include file='../common/sys_header.tpl'}
<div class="main">
	<h2>{html_lang name=server_list_title}</h2>
	<div class="list">
		<table>
			<thead>
				<tr>
					<th width="6%">{html_lang name=server_list_index_id}</th>
					<th>{html_lang name=server_list_host}</th>
					<th>{html_lang name=server_list_service_num}</th>
					<th>{html_lang name=server_list_bad_service_num}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>iteration}</th>
					<td>
						<a href="{html_url route='server/serviceDetail&server_id=1'}">ip}</a>
					</td>
					<td>service_num}</td>
					<td>bad_service_num}</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
					</td>
				</tr>
			</tfoot>
		</table>
		<br />
		<div style="width:99%;"><button type="button" style="float:right;" onclick="window.location.href=window.location.href;" >{html_lang name=server_list_recheck}</button></div>
		<br />
		<br />
		<br />
	</div>
</div>
{include file='../common/sys_footer.tpl'}
