{include file='../common/sys_header.tpl'}
<div class="main">
	<h2>{html_lang name=server_mail_queue}</h2>
	<div class="list">
		<table>
			<thead>
				<tr>
					<th width="6%">{html_lang name=server_mail_queue_index}</th>
					<th>{html_lang name=server_mail_queue_name}</th>
					<th>{html_lang name=server_mail_queue_num}</th>
					<th>{html_lang name=server_mail_queue_length}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>1</th>
					<td>incoming</td>
					<td>$incoming_num}</td>
					<td>$incoming_length}</td>
				</tr>
				<tr>
					<th>2</th>
					<td>defer</td>
					<td>$defer_num}</td>
					<td>$defer_length}</td>
				</tr>
				<tr>
					<th>3</th>
					<td>deferred</td>
					<td>$deferred_num}</td>
					<td>$deferred_length}</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4"></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
{include file='../common/sys_footer.tpl'}
