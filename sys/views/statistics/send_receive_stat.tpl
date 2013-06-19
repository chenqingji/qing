{include file='../common/sys_header.tpl'}
{html_js_file src="../plugins/openflashchart/js/swfobject.js"}
{html_js_file src="../plugins/openflashchart/js/json/json2.js"}
{html_js_file src="../common/js/My97DatePicker/WdatePicker.js"}
<div class="main">
    <h2>{html_lang name=statistics_send_rcpt_title}</h2>
    <div id="showSaveSucc" class="topnotice" style="display:none"><p></p></div>
    	<div class="choosestat">
		<ul>
		
	    	<li class="on"><input type="radio" name="stattype" value = "month" checked>&nbsp;{html_lang name=statistics_type_month}</li>
	    	<li class=""><input type="radio" name="stattype" value = "season"  >&nbsp;{html_lang name=statistics_type_season}</li>
	    	<li class=""><input type="radio" name="stattype" value = "year"  >&nbsp;{html_lang name=statistics_type_year}</li>
	    	<li class=""><input type="radio" name="stattype" value = "detail"  >&nbsp;{html_lang name=statistics_type_detail}</li>
	    	<label id="loadingmsg" style="display:none">&nbsp;
				<img src="../plugins/openflashchart/tmp_ajax_loader2.gif" />&nbsp;{html_lang name=statistics_wait_notice}
			</label>
		</ul>
    	</div>
        <div name="searchformdiv" id="searchformdiv" class="custsearch" style="display:none;border-top:1px solid #badcf4;">
       		<div id="searchdate" style="display:inline">
       		<label>{html_lang name=statistics_begin}</label>
       		<input type="text" name="searchday_beg" id="searchday_beg" size="11" maxlength="10" value="" style="cursor:hand"   onfocus="WdatePicker({ readOnly:true,lang:'{html_lang name=statistics_language}' })"  />
       		&nbsp;&nbsp;
       		<label>{html_lang name=statistics_end}</label>
       		<input type="text"  name="searchday_end" id="searchday_end" size="11" maxlength="10" value="" style="cursor:hand"   onfocus="WdatePicker({ readOnly:true,lang:'{html_lang name=statistics_language}' })" />
       		&nbsp;&nbsp;
       		</div>
       		<div id="searchmonth" style="display:inline">
       		<label>{html_lang name=statistics_begin}</label>
       		<input type="text" name="searchmonth_beg" id="searchmonth_beg" size="11" maxlength="10" value="" style="cursor:hand"   onfocus="WdatePicker({ dateFmt:'yyyy-MM',isShowToday:false,readOnly:true,lang:'{html_lang name=statistics_language}' })"  />
       		&nbsp;&nbsp;
       		<label>{html_lang name=statistics_end}</label>
       		<input type="text"  name="searchmonth_end" id="searchmonth_end" size="11" maxlength="10" value="" style="cursor:hand"   onfocus="WdatePicker({ dateFmt:'yyyy-MM',isShowToday:false,readOnly:true,lang:'{html_lang name=statistics_language}' })" />
       		&nbsp;&nbsp;
       		</div>
       		<div id="searchyear" style="display:inline">
       		<label>{html_lang name=statistics_begin}</label>
       		<input type="text" name="searchyear_beg" id="searchyear_beg" size="11" maxlength="10" value="" style="cursor:hand"   onfocus="WdatePicker({ dateFmt:'yyyy',isShowToday:false,readOnly:true,lang:'{html_lang name=statistics_language}' })"  />
       		&nbsp;&nbsp;
       		<label>{html_lang name=statistics_end}</label>
       		<input type="text"  name="searchyear_end" id="searchyear_end" size="11" maxlength="10" value="" style="cursor:hand"   onfocus="WdatePicker({ dateFmt:'yyyy',isShowToday:false,readOnly:true,lang:'{html_lang name=statistics_language}' })" />
       		&nbsp;&nbsp;
       		</div>
       		<select id="selectStatType" name="selectStatType" style=" vertical-align:middle;">
           		<option value="day" selected>{html_lang name=statistics_by_day}</option>
           		<option value="month" >{html_lang name=statistics_by_month}</option>
           		<option value="year" >{html_lang name=statistics_by_year}</option>
       		</select>
       		&nbsp;&nbsp;&nbsp;&nbsp;
       		<label>{html_lang name=statistics_mailbox}</label>
       		<input type="text" name="searchmail" autocomplete="off" id="searchmail" maxlength="128" value='' />
       		&nbsp;&nbsp;<button type="button" id="subsearch" name="subsearch" style="margin-left:0; vertical-align:middle;">{html_lang name=statistics_submit}</button>
		</div>
    	


	<div class="searchbar1" >
		<label>{html_lang name=statistics_data}</label>
		<div class="choosecharttype">
			<input type="radio" name="statpictype" value="line" checked />{html_lang name=statistics_pic_line}
			<input type="radio" name="statpictype" value="pillar" checked />{html_lang name=statistics_pic_bar}
		</div>
	</div>

	<div class="charttype">

		<div id="chartpic" name="chartpic">
			{html_lang name=statistics_flash_notice1}<a href="http://www.adobe.com/go/getflashplayer/" target="_blank">{html_lang name=statistics_flash_notice2}</a>
		</div>

		<div id="chart_2pic" name="chart_2pic">
			{html_lang name=statistics_flash_notice1}<a href="http://www.adobe.com/go/getflashplayer/" target="_blank">{html_lang name=statistics_flash_notice2}</a>
		</div>

	<div class="listcharttype">
        	<table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>{html_lang name=statistics_avg_send_flow}(/$avg_unit)：1111</td>
                <td>{html_lang name=statistics_avg_send_flow_success}(/$avg_unit)：1222</td>
                <td>{html_lang name=statistics_avg_rcpt_flow}(/$avg_unit)：13333</td>
              </tr>
              <tr>
                <td>{html_lang name=statistics_avg_send_num}(/$avg_unit)：16666</td>
                <td>{html_lang name=statistics_avg_send_num_success}(/$avg_unit)：15555</td>
                <td>{html_lang name=statistics_avg_rcpt_num}(/$avg_unit)：14444</td>
              </tr>
            </table>
    </div>

	</div><!-- end charttype -->
	 <div class="list" name="searchresultdiv" id="searchresultdiv" >
		<table id="statdatatable" name="statdatatable" style='text-align: center;' >
		<thead>
		<tr>
		<th width='100px'>{html_lang name=statistics_rec_date}</th>
		<th>{html_lang name=statistics_send_flow}</th>
		<th>{html_lang name=statistics_send_num}</th>
		<th>{html_lang name=statistics_send_flow_success}</th>
		<th>{html_lang name=statistics_send_num_success}</th>
		<th>{html_lang name=statistics_send_num_fail}</th>
		<th>{html_lang name=statistics_send_success_rate}</th>
		<th>{html_lang name=statistics_avg_send_flow}</th>
		<th>{html_lang name=statistics_max_send_flow}</th>
		<th>{html_lang name=statistics_rcpt_flow}</th>
		<th>{html_lang name=statistics_rcpt_num}</th>
		</tr>
		</thead>
		<tbody>

		<tr>
			<td>rec_date}</td>
			<td>send_size}</td>
			<td>send_all}</td>
			<td>sent_size}</td>
			<td>send_success}</td>
			<td>send_failed}</td>
			<td>send_rate}</td>
			<td>send_avg}</td>
			<td>send_top}</td>
			<td>rcpt_size}</td>
			<td>rcpt_all}</td>
		</tr>

		</tbody>
       <tfoot>
		<tr>
        	<td class="tc">{html_lang name=statistics_total}</td>
			<td class="tc">send_size}</td>
            <td class="tc">send_all}</td>
            <td class="tc">sent_size}</td>
            <td class="tc">send_success}</td>
            <td class="tc">send_failed}</td>
            <td class="tc">send_rate}</td>
            <td class="tc">send_avg}</td>
            <td class="tc">send_top}</td>
            <td class="tc">rcpt_size}</td>
            <td class="tc">rcpt_all}</td>
        </tr>

		</tfoot> 
		</table>
	</div> 

	<div class="submit" >
    	<button type="button" id="outtoexec" name="outtoexec" >{html_lang name=statistics_export}</button>
    </div>
	<form class='curr_form' action="{html_url route='statistics/exportSendReceiveReport'}" id="excelform" name="excelform" target="_blank" method="post">
	<input type="hidden" name="type" value="$stat_type"></input>
	<input type="hidden" name="by" value="$by_type"></input>
	<input type="hidden" name="begin" value="$begin_date"></input>
	<input type="hidden" name="end" value="$end_date"></input>
	<input type="hidden" name="mailbox" value="$mail_box"></input>
	</form>

</div>

{include file='../common/sys_footer.tpl'}
