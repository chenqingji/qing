{include file='../common/sys_header.tpl'}
{html_js_file src="../common/js/My97DatePicker/WdatePicker.js"}
<div class="main">
<h2>{html_lang name='active_user'}</h2>

<div class="searchbar" >{html_lang name="active_search"}</div>
<div id="searchformdiv" class="custsearch">
<form class='curr_form' action="$submit_url}" id="searchform" name="searchform" method="POST" >
	<input type="hidden" name="h_yes_time" id="h_yes_time" value="$yesterday_format}" />
	<label>{html_lang name="active_input_time"}</label>
	<input type="text" readonly="readonly" name="searchday" id="searchday" size="11" maxlength="10" value="$search_day}" style="cursor:hand" autocomplete="off"
			onfocus="WdatePicker({ readOnly:true,lang:'{html_lang name='active_date_picker_lang'}',qsEnabled:false,isShowClear:false,isShowToday:false,maxDate:'',onpicking:function(){ $('#searchtimespan').val(-1);}})"/>
	<select name="searchtimespan" id="searchtimespan" style="vertical-align:middle;" >
		<option value="-1" >{html_lang name='active_choose_time_zoon'}</option>
		<option value="day" selected>{html_lang name="active_recent_day"}</option>
		<option value="week" >{html_lang name="active_recent_week"}</option>
		<option value="month" >{html_lang name="active_recent_month"}</option>
		<option value="year" >{html_lang name="active_recent_year"}</option>
	</select>
	&nbsp;&nbsp;<button type="submit" id="subsearch" name="subsearch" style="margin-left:0;vertical-align:middle;" >{html_lang name="active_button_ok"}</button>
</form>
</div>
<br/>

<div id="searchresultdiv" class="list" >
<table>
	<thead>
		<tr><th>{html_lang name="active_visit_user_count"}</th><th>{html_lang name="active_total_user_count"}</th><th>{html_lang name="active_user_percentage"}</th></tr>
	</thead>
	<tbody>
		<tr>
			<td>$visit_user_count}</td>
			<td>$total_user_count}</td>
			<td>$activity_percentage}</td>
		</tr>
	</tbody>
</table>
</div>
<br/>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#subsearch").bind('click',function(){
			var searchday_value = $.trim($("#searchday").val());
			if( searchday_value=="" ){
				alert("{html_lang name='active_choose_time'}");
				return false;
			}
		});

		$("#searchtimespan").bind('change',function(){
			var selectvalue = $(this).val();
			if( selectvalue == "-1" ){
				return ;
			}
			var searchdate = new Date(Date.parse($("#h_yes_time").val()));
			switch(selectvalue){
				case "day":break;
				case "week":searchdate.setTime(searchdate.getTime()-86400000*6);break;
				case "month":searchdate.setTime(searchdate.getTime()-86400000*30);break;
				case "year":searchdate.setFullYear(searchdate.getFullYear()-1);break;
				default : return;
			}
			var tmp_day = searchdate.getDate() <10 ? '0'+searchdate.getDate().toString() : searchdate.getDate();
			var tmp_mon = searchdate.getMonth() < 9 ? "0"+(searchdate.getMonth()+1).toString() : searchdate.getMonth()+1;
			$("#searchday").val( searchdate.getFullYear()+"-"+tmp_mon+"-"+tmp_day );
		});
	});
</script>

{include file='../common/sys_footer.tpl'}