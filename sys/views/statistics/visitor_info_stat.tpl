{include file='../common/sys_header.tpl'}
{html_js_file src="../plugins/openflashchart/js/swfobject.js"}
{html_js_file src="../plugins/openflashchart/js/json/json2.js"}
{html_js_file src="../common/js/My97DatePicker/WdatePicker.js"}
<div class="main">
    <h2>{html_lang name=statistics_visitor_info_title}</h2>
    <div id="showSaveSucc" class="topnotice" style="display:none"><p></p></div>
    	<div class="choosestat">
		<ul>
		
	    	<li ><input type="radio" name="stattype" value = "month" checked>&nbsp;{html_lang name=statistics_type_month}</li>
	    	<li ><input type="radio" name="stattype" value = "season"  >&nbsp;{html_lang name=statistics_type_season}</li>
	    	<li ><input type="radio" name="stattype" value = "year"  >&nbsp;{html_lang name=statistics_type_year}</li>
	    	<li ><input type="radio" name="stattype" value = "detail"  >&nbsp;{html_lang name=statistics_type_detail}</li>
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
       		<select id="selectStatType" name="selectStatType" style="vertical-align:middle;">
           		<option value="day" selected>{html_lang name=statistics_by_day}</option>
           		<option value="month" >{html_lang name=statistics_by_month}</option>
           		<option value="year" >{html_lang name=statistics_by_year}</option>
       		</select>
       		&nbsp;&nbsp;&nbsp;&nbsp;
       		<label>{html_lang name=statistics_mailbox}</label>
       		<input type="text" name="searchmail" id="searchmail" maxlength="128" value='$mail_box' />
       		&nbsp;&nbsp;<button type="button" id="subsearch" name="subsearch" style="margin-left:0;vertical-align:middle;">{html_lang name=statistics_submit}</button>
		</div>
    	


	<div class="searchbar1" >
		<label>{html_lang name=statistics_data}</label>
		<div class="choosecharttype">
			<input type="radio" name="statpictype" value="line" checked />{html_lang name=statistics_pic_line}
			<input type="radio" name="statpictype" value="pillar"  />{html_lang name=statistics_pic_bar}
		</div>
	</div>

	<div class="charttype">

		<div id="chartpic" name="chartpic">
			{html_lang name=statistics_flash_notice1}<a href="http://www.adobe.com/go/getflashplayer/" target="_blank">{html_lang name=statistics_flash_notice2}</a>
		</div>

	</div><!-- end charttype -->
	 <div class="list" name="searchresultdiv" id="searchresultdiv" >
		<table id="statdatatable" name="statdatatable" style='text-align: center;' >
		<thead>
		<tr>
		<th>{html_lang name=statistics_rec_date}</th>
		<th>{html_lang name=statistics_visitor_info_pop}</th>
		<th>{html_lang name=statistics_visitor_info_imap}</th>
		<th>{html_lang name=statistics_visitor_info_smtp}</th>
		<th>{html_lang name=statistics_visitor_info_web}</th>
		</tr>
		</thead>
		<tbody>

		<tr>
			<td>rec_date}</td>
			<td>pop}</td>
			<td>imap}</td>
			<td>smtp}</td>
			<td>web}</td>
		</tr>

		</tbody>
       <tfoot>
		<tr>
        	<td class="tc">{html_lang name=statistics_total}</td>
			<td class="tc">pop}</td>
            <td class="tc">imap}</td>
            <td class="tc">smtp}</td>
            <td class="tc">web}</td>
        </tr>

		</tfoot> 
		</table>
	</div> 

	<div class="submit" >
    	<button type="button" id="outtoexec" name="outtoexec" >{html_lang name=statistics_export}</button>
    </div>
	<form class='curr_form' action="{html_url route='statistics/exportVisitorInfoReport'}" id="excelform" name="excelform" target="_blank" method="post">
	<input type="hidden" name="type" value="$stat_type"></input>
	<input type="hidden" name="by" value="$by_type"></input>
	<input type="hidden" name="begin" value="$begin_date"></input>
	<input type="hidden" name="end" value="$end_date"></input>
	<input type="hidden" name="mailbox" value="$mail_box"></input>
	</form>

</div>
<script type="text/javascript" >

</script>
{include file='../common/sys_footer.tpl'}
