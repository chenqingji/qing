{include file='../common/sys_header.tpl'}
<div class="main">
	<h2>{html_lang name=server_service_detail_title}</h2>
	<div style="padding:0px 0px 5px 15px"><span>{html_lang name=server_service_detail_host}{$service_info.ip}</span></div>
	<div class="list">
		<table>
			<thead>
				<tr>
					<th width="6%">{html_lang name=server_service_detail_index}</th>
					<th>{html_lang name=server_service_detail_type}</th>
					<th>{html_lang name=server_service_detail_state}</th>
				</tr>
			</thead>
			<tbody>
			{foreach name=service_list from=$service_info.service_status_list key=service_name item=service_status}
				<tr>
					<th>{$smarty.foreach.service_list.iteration}</th>
					<td>{$service_name}</td>
				{if $service_status eq 'ok'}
					<td><font color="green">{html_lang name=server_service_detail_state_ok}</font></td>
				{elseif $service_status eq 'bad'}
					<td><font color="red">{html_lang name=server_service_detail_state_bad}</font></td>
				{else}
					<td><font color="#FF9900">{html_lang name=server_service_detail_state_unknown}</font></td>
				{/if}
				</tr>
			{/foreach}
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3"></td>
				</tr>
			</tfoot>
		</table>
	</div>
	<br />
	<div style="width:99%;">
    <button type="button" style="float:right;" onclick="window.location.href=window.location.href; ">{html_lang name=server_service_detail_recheck}</button>
	<button type="button" style="float:right;" onclick="window.location.href='{html_url route='server/index'}';">{html_lang name=server_service_detail_return}</button>
    </div>
	<br />
	<br />
	<br />
</div>
{include file='../common/sys_footer.tpl'}
