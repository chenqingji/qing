{include file='../common/sys_header.tpl'}
<div class="main">
<h2>{html_lang name='keywordfilter_title'}</h2>
<div class="searchbar" >{html_lang name='keywordfilter_search'}</div>
<form method="post" name="keywordfilterform" id="keywordfilterform" action="{html_url route=index}">
<div id="searchformdiv" class="custsearch" >
  <label>{html_lang name='keywordfilter_search_rulename'}</label><input id="search_name" name="search_name" type="text" maxlength="20" value="{$search_name}"/>&nbsp;
  <label>{html_lang name='keywordfilter_search_condition'}</label>
  <select name="search_condition" id="search_condition" style="vertical-align:middle;">
  <option value="-1" {if $search_condition eq '-1'}selected{/if}>{html_lang name='keywordfilter_select_all'}</option>
  <option value="1" {if $search_condition eq '1'}selected{/if}>{html_lang name='keywordfilter_condition_to'}</option>
  <option value="0" {if $search_condition eq '0'}selected{/if}>{html_lang name='keywordfilter_condition_from'}</option>
  <option value="2" {if $search_condition eq '2'}selected{/if}>{html_lang name='keywordfilter_condition_cc'}</option>
  <option value="3" {if $search_condition eq '3'}selected{/if}>{html_lang name='keywordfilter_condition_subject'}</option>
  <option value="4" {if $search_condition eq '4'}selected{/if}>{html_lang name='keywordfilter_condition_attachment_name'}</option>
  <option value="5" {if $search_condition eq '5'}selected{/if}>{html_lang name='keywordfilter_condition_bcc'}</option>
  <option value="6" {if $search_condition eq '6'}selected{/if}>{html_lang name='keywordfilter_condition_text'}</option>
  <option value="7" {if $search_condition eq '7'}selected{/if}>{html_lang name='keywordfilter_condition_attachment_type'}</option>
  <option value="8" {if $search_condition eq '8'}selected{/if}>{html_lang name='keywordfilter_condition_attachment_content'}</option>
  <option value="9" {if $search_condition eq '9'}selected{/if}>{html_lang name='keywordfilter_condition_ip'}</option>
  </select>
  <input name="search_keyword" id="search_keyword" type="text" maxlength="16" value="{$search_keyword}" autocomplete="off"/>&nbsp;
  <label>{html_lang name='keywordfilter_search_action'}</label>
  <select name="search_active" id="search_active" style="vertical-align:middle;">
  <option value="-1" {if $search_active eq '-1'}selected{/if}>{html_lang name='keywordfilter_select_all'}</option>
  <option value="0" {if $search_active eq '0'}selected{/if}>{html_lang name='keywordfilter_action_deliver'}</option>
  <option value="1" {if $search_active eq '1'}selected{/if}>{html_lang name='keywordfilter_action_refuse'}</option>
  <option value="2" {if $search_active eq '2'}selected{/if}>{html_lang name='keywordfilter_action_discard'}</option>
  <option value="3" {if $search_active eq '3'}selected{/if}>{html_lang name='keywordfilter_action_spam'}</option>
  </select><br />
  <label>{html_lang name='keywordfilter_search_date'}</label><input id="search_time" name="search_time" type="text" value="{$search_time}" maxlength="20"/>&nbsp;
  <label> {html_lang name='keywordfilter_search_status'}</label>
  <select name="search_status" id="search_status" style="vertical-align:middle;">
  <option value="-1" {if $search_status eq '-1'}selected{/if}>{html_lang name='keywordfilter_select_all'}</option>
  <option value="0" {if $search_status eq '0'}selected{/if}>{html_lang name='keywordfilter_status_invalid'}</option>
  <option value="1" {if $search_status eq '1'}selected{/if}>{html_lang name='keywordfilter_status_effective'}</option>
  </select>&nbsp;&nbsp;
  <button style="margin-left:0; vertical-align:middle;" type="submit">{html_lang name='keywordfilter_search_button'}</button>
</div>
<div class="list">
<table>
<thead>
<tr>
  <th width="6%">{html_lang name='keywordfilter_list_choose'}</th>
  <th>{html_lang name='keywordfilter_list_rulename'}</th>
  <th>{html_lang name='keywordfilter_list_condition'}</th>
  <th>{html_lang name='keywordfilter_list_action'}</th>
  <th>{html_lang name='keywordfilter_list_date'}</th>
  <th width="10%">{html_lang name='keywordfilter_list_status'}</th>
</tr>
</thead>
{if $result|@count neq 0 } 
<tbody>
{section name=sec1 loop=$result}
<tr class="{if $result[sec1].active eq '0'}gray{/if}">
<th><input name="checkboxID[]" type="checkbox" class="{if $result[sec1].active eq '0'}invalid{/if}{if $result[sec1].active eq '1'}effective{/if} chkMe" value="{$result[sec1].id}"  /></th>
<td><span style="float:left;width:156px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;text-align:left;">
<a href="{html_url route=toEdit}/checkboxID/{$result[sec1].id}" style="word-break:break-all" title="{$result[sec1].rulename|escape:'html'}">{$result[sec1].rulename|escape:"html"}</a></span></td>
<td title="{$conditionArray[$result[sec1].mail_condition]} {$modeArray[$result[sec1].mode]}[{$result[sec1].keyword|escape:'html'}]">{$conditionArray[$result[sec1].mail_condition]}&nbsp;{$modeArray[$result[sec1].mode]}[{$result[sec1].keyword|escape:"html"}]</td>
<td>{$actionArray[$result[sec1].action]}</td>
<td>{$result[sec1].time|escape:"html"}</td>
<td>{$statusArray[$result[sec1].active]}</td>
</tr>
{/section}
</tbody>
{/if}
<tfoot>
<tr>
<td width="6%" style="text-align:center">
<input type="checkbox" id="checkAll" value="checkbox" class="chkAll" /></td>
<td colspan="5">{html_page form=keywordfilterform}</td>
</tr>
</tfoot>
</table>
<div class="submit">
  <button id='first_button' type="button" onclick="location.href='{html_url route=toEdit}'">{html_lang name='keywordfilter_list_add'}</button>
  <button id='delete_id' type="button">{html_lang name='keywordfilter_list_delete'}</button>
  <button id='update_id' type="button">{html_lang name='keywordfilter_list_modify'}</button>
  <button id='enable_id' type="button">{html_lang name='keywordfilter_list_enable'}</button>
  <button id='disable_id' type="button">{html_lang name='keywordfilter_list_disable'}</button>
</div>
<div class="topnotice"><p>{html_lang name='keywordfilter_list_notice'}</p></div>
</div>
</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $("#keywordfilterform").exCheckAll(true);
  $("#delete_id").click(function(){
	var size = $("#keywordfilterform").getCheckedSize();
    if(size<1){
      alert("{html_lang name='keywordfilter_select_delete'}"); return false;
    }
    confirm("{html_lang name='keywordfilter_comfirm_delete'}", function(){
			document.keywordfilterform.action = "{html_url route=delete}";
			document.keywordfilterform.submit();
		});
		return false;
  });
  
  $("#update_id").click(function(){
	var size = $("#keywordfilterform").getCheckedSize();
    if(size<1){
     		 alert("{html_lang name='keywordfilter_select_modify'}");return false;
    }
    if(size>1){
			alert("{html_lang name='keywordfilter_select_modify_only_one'}");return false;
	}
		document.keywordfilterform.action = "{html_url route=toEdit}";
		document.keywordfilterform.submit();
  });
  
  $("#enable_id").click(function(){
	var size = $("#keywordfilterform").getCheckedSize();
	if(size<1){
      alert("{html_lang name='keywordfilter_select_enable'}");return false;
    }
	var effectiveSize=$(".effective:checkbox:checked").length;    
    if(effectiveSize>0){
      alert("{html_lang name='keywordfilter_alert_choose_invalid'}");return false;
    }
    confirm("{html_lang name='keywordfilter_comfirm_enable'}", function(){
      	document.keywordfilterform.action = "{html_url route=enable}";
	  	document.keywordfilterform.submit();	
    });	return false;			
  });
  
  $("#disable_id").click(function(){
	  var size = $("#keywordfilterform").getCheckedSize();
	    if(size<1){
      alert("{html_lang name='keywordfilter_select_disable'}");return false;
    }
	var invalidSize=$(".invalid:checkbox:checked").length;    
    if(invalidSize>0){
      alert("{html_lang name='keywordfilter_alert_choose_effective'}");
      return false;
    }
    confirm("{html_lang name='keywordfilter_comfirm_disable'}", function(){
      	document.keywordfilterform.action = "{html_url route=disable}";
		document.keywordfilterform.submit();	
    });	return false;		
  }); 
})
</script>
{include file='../common/sys_footer.tpl'}
