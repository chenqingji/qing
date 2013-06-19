{include file='../common/sys_header.tpl'}
{html_js_file src="../plugins/openflashchart/js/swfobject.js"}
{html_js_file src="../plugins/openflashchart/js/json/json2.js"}
{html_js_file src="../common/js/My97DatePicker/WdatePicker.js"}

<div class="main">
	<h2>{html_lang name="statistics_mailsize"}</h2>
	<div class="searchbar" >{html_lang name="statistics_mailsize_search"}</div>
	<div name="searchformdiv" id="searchformdiv" class="custsearch" >
		<form class='curr_form' action="{$search_url}" id="searchform" name="searchform" method="POST" >
			<input type="hidden" name="search" value="1"/>
			<label>{html_lang name="statistics_mailsize_start_date"}</label>
			<input type="text" readonly="on" name="start_date" id="start_date" size="11" maxlength="10" value="{$start_date}" style="cursor:hand"
				   onfocus="WdatePicker({ readOnly:true,lang:'{html_lang name="statistics_mailsize_datepick_lang"}',qsEnabled:false,isShowClear:false,isShowToday:false,maxDate:'#F{ $dp.$D(\'end_date\')||\'{$yestoday}\'}',onpicking:function(){ $('#time_period').val(-1);} })" autocomplete="off" />
			&nbsp;&nbsp;
			<label>{html_lang name="statistics_mailsize_end_date"}</label>
			<input type="text" readonly="on" name="end_date" id="end_date" size="11" maxlength="10" value="{$end_date}" style="cursor:hand"
				   onfocus="WdatePicker({ readOnly:true,lang:'{html_lang name="statistics_mailsize_datepick_lang"}',qsEnabled:false,isShowClear:false,isShowToday:false,maxDate:'{$yestoday}',minDate:'#F{ $dp.$D(\'start_date\')}',onpicking:function(){ $('#time_period').val(-1);}})" autocomplete="off" />
			<input type="hidden" name="h_yes_time" id="h_yes_time" value="{$format_yestoday}" />
			<input type="hidden" name="h_today_time" id="h_today_time" value="{$yestoday}" />
			&nbsp;&nbsp;
			<select name="time_period" id="time_period" style="vertical-align:middle;" >
				<option value="-1" >{html_lang name="statistics_mailsize_choose_time"}</option>
				<option value="day" {$select_day|default:''}>{html_lang name="statistics_mailsize_day"}</option>
				<option value="week" {$select_week|default:''}>{html_lang name="statistics_mailsize_week"}</option>
				<option value="month" {$select_month|default:''}>{html_lang name="statistics_mailsize_month"}</option>
				<option value="year" {$select_year|default:''}>{html_lang name="statistics_mailsize_year"}</option>
			</select>
			&nbsp;&nbsp;<input id="percent" type="checkbox" name="percent" value="1" class="nos" {$check_1|default:''}/>&nbsp;{html_lang name="statistics_mailsize_by_percentage"}&nbsp;&nbsp;
			<select name="send_or_receive" id="to_or_from" style="vertical-align:middle;" >
				<option value="send" {$select_send|default:''}>{html_lang name="statistics_mailsize_sended_mail"}</option>
				<option value="receive" {$select_receive|default:''}>{html_lang name="statistics_mailsize_received_mail"}</option>
			</select>
			&nbsp;&nbsp;<button type="submit" id="subsearch" name="subsearch" style="margin-left:0;">{html_lang name="statistics_submit"}</button>
			<label id="loadingmsg" style="display:none">&nbsp;<img src="../plugins/openflashchart/tmp_ajax_loader2.gif" />&nbsp;{html_lang name="statistics_wait_notice"}</label>
		</form>
	</div>
	<div>
		<div class="searchbar1" >
			<label>{html_lang name="statistics_data"}</label>
			<div class="choosecharttype">
				<input type="radio" name="statpictype" value="line" {$check_line|default:'checked'}/>{html_lang name="statistics_pic_line"}
				<input type="radio" name="statpictype" value="pillar" {$check_pillar|default:''}/>{html_lang name="statistics_pic_bar"}
				<input type="hidden" name="curpictype" id="curpictype" value="{$line_or_bar_graph}" />
			</div>
		</div>
		<div class="charttype">
			<div id="chartpic" name="charpic">
				{html_lang name="statistics_flash_notice1"}<a href="http://www.adobe.com/go/getflashplayer/" target="_blank">{html_lang name="statistics_flash_notice2"}</a>
			</div>
		</div>
	</div>
	<div class="list" name="searchresultdiv" id="searchresultdiv" >
		<table id="statdatatable" name="statdatatable" >
			<thead>
				<tr>
					<th width='100px'>{html_lang name="statistics_rec_date"}</th>
					<th>0-5K</th>
					<th>5-10K</th>
					<th>10-50K</th>
					<th>50-100K</th>
					<th>100-500K</th>
					<th>500K-1M</th>
					<th>1-5M</th>
					<th>5-10M</th>
					<th>> 10M</th>
					<th>{html_lang name="statistics_total"}</th>
				</tr>
			</thead>
			<tbody>
				<tr bgcolor="#f5fbff">
					<td class="tc">{html_lang name="statistics_total"}</td>
					<td class="tc">{$totalInfos.sum_5k_total}</td>
					<td class="tc">{$totalInfos.sum_10k_total}</td>
					<td class="tc">{$totalInfos.sum_50k_total}</td>
					<td class="tc">{$totalInfos.sum_100k_total}</td>
					<td class="tc">{$totalInfos.sum_500k_total}</td>
					<td class="tc">{$totalInfos.sum_1m_total}</td>
					<td class="tc">{$totalInfos.sum_5m_total}</td>
					<td class="tc">{$totalInfos.sum_10m_total}</td>
					<td class="tc">{$totalInfos.sum_more_total}</td>
					<td class="tc">{$totalInfos.sum_all_total}</td>
				</tr>
				{foreach from=$infos key=key item=info}
				<tr>
					<td class="tc">{$info.rec_date}</td>
					<td class="tc">{$info.sum_5k}</td>
					<td class="tc">{$info.sum_10k}</td>
					<td class="tc">{$info.sum_50k}</td>
					<td class="tc">{$info.sum_100k}</td>
					<td class="tc">{$info.sum_500k}</td>
					<td class="tc">{$info.sum_1m}</td>
					<td class="tc">{$info.sum_5m}</td>
					<td class="tc">{$info.sum_10m}</td>
					<td class="tc">{$info.sum_more}</td>
					<td class="tc">{$info.sum_all}</td>
				</tr>
				{/foreach}
			</tbody>
			<tfoot>
				<tr>
					<td colspan="11">                	
						<div class="pages">{html_page form=searchform}</div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div> 
	<div class="submit" >
		<form class='curr_form' action="{html_url route=mailsize}" id="excelform" name="excelform" target="_blank" method="post">
			<input type="hidden" name="search" value="{$report_data.search}"/>
			<input type="hidden" name="download" value="{$report_data.download}"/>
			<input type="hidden" name="start_date" value="{$report_data.start_date}"/>
			<input type="hidden" name="end_date" value="{$report_data.end_date}"/>
			<input type="hidden" name="percent" value="{$report_data.percent}"/>
			<input type="hidden" name="send_or_receive" value="{$report_data.send_or_receive}"/>
			<input type="hidden" name="time_period" value="{$report_data.time_period}"/>
			<input type="hidden" name="pageno" value="{$report_data.pageno}"/>
			<button type="submit">{html_lang name="statistics_export"}</button>
		</form>
	</div>
</div>

<script type="text/javascript">
var mychartdata={$chart_data};

function open_flash_chart_data(){
	return JSON.stringify(mychartdata);
}

function findSWF(movieName){
	if (navigator.appName.indexOf("Microsoft")!= -1){
		return window[movieName];
	} else {
		return document[movieName];
	}
}
swfobject.embedSWF(
	"../plugins/openflashchart/open-flash-chart.swf"+"?test="+Math.random(), "chartpic",
	"720", "400", "9.0.0", "../common/openflashchart/expressInstall.swf",
	{ "loading":"{html_lang name="statistics_mailsize_loading"}"},{ wmode:"opaque"}
);
$(document).ready(function(){
		$(":radio[name='statpictype']").bind("click",function(){
		var curpictype = $("#curpictype").val();
		var checkedvalue = $(":radio[name='statpictype']:checked").val();
		if( checkedvalue != curpictype ){
			if(checkedvalue == 'pillar'){
				mychartdata.elements[0].type = 'bar_3d';
				mychartdata.elements[1].type = 'bar_3d';
				mychartdata.elements[2].type = 'bar_3d';
				mychartdata.elements[3].type = 'bar_3d';
				mychartdata.elements[4].type = 'bar_3d';
				mychartdata.elements[5].type = 'bar_3d';
				mychartdata.elements[6].type = 'bar_3d';
				mychartdata.elements[7].type = 'bar_3d';
				mychartdata.elements[8].type = 'bar_3d';
				mychartdata.elements[8].type = 'bar_3d';
				mychartdata.elements[9].type = 'bar_3d';
				mychartdata.x_axis['3d']=16;
				mychartdata.x_axis.colour = '#c0e2f7'
			}else{
				mychartdata.elements[0].type = 'line';
				mychartdata.elements[1].type = 'line';
				mychartdata.elements[2].type = 'line';
				mychartdata.elements[3].type = 'line';
				mychartdata.elements[4].type = 'line';
				mychartdata.elements[5].type = 'line';
				mychartdata.elements[6].type = 'line';
				mychartdata.elements[7].type = 'line';
				mychartdata.elements[8].type = 'line';
				mychartdata.elements[9].type = 'line';
				mychartdata.x_axis.colour = mychartdata.y_axis.colour
				mychartdata.x_axis['3d']='undefined';
			}
			$("#curpictype").val(checkedvalue);
			var tmp1 = findSWF("chartpic");
			var x1 = tmp1.load( JSON.stringify(mychartdata) );
		}
	});

	$("#time_period").bind('change',function(){
		var selectvalue = $(this).val();
		if( selectvalue == "-1" ){
			return ;
		}
		var searchdate = new Date(Date.parse($("#h_yes_time").val()));
		
		switch(selectvalue){
			case "day":
				break;
			case "week":
				searchdate.setTime(searchdate.getTime()-86400000*6);
				break;
			case "month":
				searchdate.setTime(searchdate.getTime()-86400000*30);
				break;
			case "year":
				searchdate.setFullYear(searchdate.getFullYear()-1);
				break;
			default :
				return;
		}
		var tmp_day = searchdate.getDate() <10 ? '0'+searchdate.getDate().toString() : searchdate.getDate();
		var tmp_mon = searchdate.getMonth() < 9 ? "0"+(searchdate.getMonth()+1).toString() : searchdate.getMonth()+1;
		$("#start_date").val( searchdate.getFullYear()+"-"+tmp_mon+"-"+tmp_day );
		$("#end_date").val($("#h_today_time").val());
	});
	$("#outtoexec").bind("click",function(){
		$("#excelform").submit();
	});
});
</script>


{include file='../common/sys_footer.tpl'}