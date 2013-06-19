{include file='../common/sys_header.tpl'}

<div class="main">
    <h2>{html_lang name=server_disk_title}</h2>
    <form action="{html_url route='disk'}" name="diskform" id="diskform" method="post" onsubmit="return checksearch();">
        <div class="search">
            <select id="search_key" name="search_key" gtbfieldid="9" onchange="setCompare()" style="float:left;">
                <option value="">{html_lang name=server_disk_please_select}</option>
				<option value="domain">{html_lang name=server_disk_domain}</option>
				<option value="maxuser">{html_lang name=server_disk_maxuser}</option>
				<option value="openeduser">{html_lang name=server_disk_openeduser}</option>
				<option value="diskquota">{html_lang name=server_disk_diskquota}</option>
				<option value="diskquotaused">{html_lang name=server_disk_diskquotaused}</option>
				<option value="netquota">{html_lang name=server_disk_netquota}</option>
				<option value="netquotaused">{html_lang name=server_disk_netquotaused}</option>
				<option value="spaceusedall">{html_lang name=server_disk_spaceusedall}</option>
				<option value="spaceusedpermaxuser">{html_lang name=server_disk_spaceusedpermaxuser}</option>
				<option value="spaceusedperopeneduser">{html_lang name=server_disk_spaceusedperopeneduser}</option>
				<option value="crtime">{html_lang name=server_disk_crtime}</option>
				<option value="extime">{html_lang name=server_disk_extime}</option>				
            </select>
            <select name="search_compare" id="search_compare" style="display:none;float:left;">
                <option value="">{html_lang name=server_disk_select_condition}</option>
                <option value="=">=</option>
                <option value="<="><=</option>
                <option value=">=">>=</option>
            </select>
            <input type="text" maxlength="20" value="searchValue}" id="search_value" name="search_value">
			<button type="submit" name="Submit">{html_lang name=server_disk_search}</button>
        </div>
    </form>
    <dl class="info1">
        <dt>
        <ul class="info">
            <li>{html_lang name=server_disk_total}：<span>$totalDisk}</span></li>
            <li>{html_lang name=server_disk_used}：<span>$usedDisk}</span></li>
            <li>{html_lang name=server_disk_percent}：<span>$percentDisk}</span></li>
            <li>{html_lang name=server_domain_total}：<span>$totalDomain}</span>个</li>
            <li>{html_lang name=server_disk_mailbox_used}：<span>$mailboxUsedDisk}</span></li>
            <li>{html_lang name=server_mailbox_opened_num}：<span>$mailboxOpenedNum}</span>个</li>
            <li>{html_lang name=server_mailbox_average_disk}：<span>$mailboxOpendedAvargeDisk}</span></li>
        </ul>
        </dt>
    </dl><br />

    <div class="list">
        <table>
            <thead>
                <tr class="hk">
					<th>{html_sort name=server_disk_domain key=domain form=diskform}</th>
					<th>{html_sort name=server_disk_maxuser key=maxuser form=diskform}</th>
					<th>{html_sort name=server_disk_openeduser key=openeduser form=diskform}</th>
					<th>{html_sort name=server_disk_diskquota key=diskquota form=diskform}</th>
					<th>{html_sort name=server_disk_diskquotaused key=diskquotaused form=diskform}</th>
					<th>{html_sort name=server_disk_netquota key=netquota form=diskform}</th>
					<th>{html_sort name=server_disk_netquotaused key=netquotaused form=diskform}</th>
					<th>{html_sort name=server_disk_spaceusedall key=spaceusedall form=diskform}</th>
					<th>{html_sort name=server_disk_spaceusedpermaxuser key=spaceusedpermaxuser form=diskform}</th>
					<th>{html_sort name=server_disk_spaceusedperopeneduser key=spaceusedperopeneduser form=diskform}</th>
					<th>{html_sort name=server_disk_crtime key=crtime form=diskform}</th>
					<th>{html_sort name=server_disk_extime key=extime form=diskform}</th>					
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td title="$item.domain}">$item.domain}</td>
                    <td>$item.maxuser}</td>
                    <td>$item.openeduser}</td>
                    <td>{html_lang name=server_disk_no_limit_disk}</td>
                    <td>$item.diskquotaused}</td>
                    <td>$item.netquota}</td>
                    <td>$item.netquotaused}</td>
                    <td>$item.spaceusedall}</td>
                    <td>$item.spaceusedpermaxuser}</td>
                    <td>$item.spaceusedperopeneduser}</td>
                    <td title="$item.crtime}">$item.crtime}</td>
                    <td title="$item.extime}">$item.extime}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="12">
                        {html_page form=diskform}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="submit">
        <input type="button" value="{html_lang name=server_disk_view_all}" onclick="location.href='{html_url route=disk}'" />
        <input type="button" value="{html_lang name=server_disk_export_table}" id="outexcel" onclick="$('#outexceldiv').show();">
    </div>
    <div id="outexceldiv" class="custsearch" style="display:none">{html_lang name=server_disk_export_select_data}： 
        <input type="radio" name="outtype" id="outtype" value="all" class="nos" checked="checked">{html_lang name=server_disk_export_current_data}
        <input type="radio" name="outtype" id="outtype" value="thispage" class="nos">{html_lang name=server_disk_export_current_page}
        <button type="button" id="outyes"/>{html_lang name=server_disk_confirm}</button>
        <button type="button" id="outcancel" onclick="$('#outexceldiv').hide();"/>{html_lang name=server_disk_cancel}</button>
    </div>
	<form class='curr_form' action="{html_url route=exportDiskExcel}" id="excelform" name="excelform" target="_blank" method="post">
	<input type="hidden" name="pageno" value="$page}"></input>
	<input type="hidden" name="sortkey" value="$sortKey}"></input>
	<input type="hidden" name="sorttype" value="$sortType}"></input>
	<input type="hidden" name="search_key" value="$searchKey}"></input>
	<input type="hidden" name="search_value" value="$searchValue}"></input>
	<input type="hidden" name="search_compare" value="$searchCompare}"></input>
	</form>
</div>
<script type="text/javascript">
$().ready(function() {
	$('#search_key option[value="' + '$searchKey}' + '"]').attr('selected','selected');
	$('#search_compare option[value="' + '$searchCompare}' + '"]').attr('selected','selected');
	setCompare();
});	

$("#outyes").bind("click",function(){
	var outtype = $("input:checked[name='outtype']").val(); 
	var page="$page}";
	var sortkey="$sortKey}";
	var sorttype="$sortType}";
	var searchkey="$searchKey}";
	var searchvalue="$searchValue}";
	var searchcompare="$searchCompare}";
	var tmpreg=/^6/;	
	action="{html_url route=exportDiskExcel}";
	
	if($.browser.msie && tmpreg.test($.browser.version) ){
		if(outtype=='thispage'){
			document.excelform.action=action+'/pageno/'+page+'/sortkey/'+sortkey+'/sorttype/'+sorttype+'/search_key/'+searchkey+'/search_value/'+searchvalue+'/search_compare/'+searchcompare;
		}else{
			document.excelform.action=action+'/all/1';
		}	
		document.excelform.submit();
	}else{
		if(outtype=='thispage'){
			window.open(action+'/pageno/'+page+'/sortkey/'+sortkey+'/sorttype/'+sorttype+'/search_key/'+searchkey+'/search_value/'+searchvalue+'/search_compare/'+searchcompare,'_blank');
		}else{
			window.open(action+'/all/1','_blank');
		}
	}
});
//search compare
function setCompare(){
	var key = $('#search_key').val();
	if(key == '' || key == 'domain'){
		$('#search_compare').hide();
	}else{
		$('#search_compare').show();
	}
}

function checksearch(){
	var key = $('#search_key').val();
	var value = $('#search_value').val();
	if(value == ''){
		alert('{html_lang name=server_disk_input_keyword}');
		return false;
	}
	if( key == ''){
		alert('{html_lang name=server_disk_select_search_key}');
		return false;
	}
	if(key!= 'domain'){
		var compare = $('#search_compare').val();
		if(compare == ''){
			alert('{html_lang name=server_disk_choose_condition}');
			return false;
		}
		if( key == 'crtime' || key == 'extime'){
			var reg = /\d\d\d\d-\d\d-\d\d/;
			if(!(reg.test(value))){
				alert('{html_lang name=server_disk_input_right_date}');
				return false;
			}
		}else{
			if(isNaN(value)){
				alert('{html_lang name=server_disk_input_number_format}');
				return false;
			}
		}
	}
	return true;
}
</script>
{include file='../common/sys_footer.tpl'}

