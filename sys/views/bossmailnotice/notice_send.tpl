{include file='../common/sys_header.tpl'}
<div class="main">
    <form class="curr_form" name="form1" id="noctice_form" action="" method="post">
        <h2>{html_lang name=bossmailnotice_title}</h2>
        <div class="form">
            <div>
                <label>{html_lang name=bossmailnotice_page_receiver}</label>
                <select name="receiver" id="receiver">
                    <option value="all" checked="checked">{html_lang name=bossmailnotice_page_receiver_select_all}</option>
                    <option value="online">{html_lang name=bossmailnotice_page_receiver_select_online}</option>
                    <option value="offline">{html_lang name=bossmailnotice_page_receiver_select_offline}</option>
                </select>
            </div>
            <div>
                <label>{html_lang name=bossmailnotice_page_receive_version}</label>
                <input id="version" name="version" autocomplete="off"  type="text" maxlength="7"/>
                <em>{html_lang name=bossmailnotice_page_receive_version_exp_1_2_1}</em>
            </div>
            <div>
                <label>{html_lang name=bossmailnotice_page_expire_time}</label>
                <input id="time_day" name="time_day" type="text" value="{$default_date}" readonly="readonly" onClick="WdatePicker({
                    readOnly:true,lang:'{html_lang name=bossmailnotice_calaor_lang}',minDate:'{$minDate}' ,maxDate:'2037-12-31 23:59:59'
                })"/>
            </div>
            <div class="nobor_input">
                <label>{html_lang name=bossmailnotice_page_show_time}</label>
                <input name="show_time" id="showall" type="radio" checked="checked" value="0"/>{html_lang name=bossmailnotice_page_show_always}
                <input name="show_time" id="custom_time" type="radio" value="1"/>{html_lang name=bossmailnotice_page_show_custom}
                <select id="custom_second" name="custom_second" disabled="disabled">
                    <option value="10">10</option>
                    <option value="30">30</option>
                    <option value="60">60</option>
                    <option value="180">180</option>
                    <option value="1800">1800</option>
                    <option value="3600">3600</option>
                </select>
			{html_lang name=bossmailnotice_page_show_second}
            </div>
            <div><label>{html_lang name=bossmailnotice_page_subject}</label><input name="subject" autocomplete="off" id="subject" type="text" style="width:300px" maxlength="60"/></div>
            <div>
                <label>{html_lang name=bossmailnotice_page_content}</label>
                <textarea name="body" id="body" cols="15" rows="8" style="width:300px;height:200px;display:none"></textarea>
            </div>
            <input type="hidden" id="notice" name="notice" value="send"/>
            <div class="submit1">
                <button type="button" onclick='window.PageManager.checkInput();return false;' >{html_lang name=bossmailnotice_page_send}</button>
            </div>
        </div>
    </form>
</div>
{html_css_file href="../common/js/newedit/skins/default.css"} 
{html_js_file src="../common/js/My97DatePicker/WdatePicker.js"}
{html_js_file src="../common/js/newedit/kindeditor.js"}
<script type="text/javascript">
window.PageManager={  
	init:function(){
		this.initBindEvent();
		this.initEditor();
	},
	initBindEvent:function(){
		$("#custom_time").click(function(){
			$("#custom_second").removeAttr("disabled");	
		});
		$("#showall").click(function(){
			$("#custom_second").attr("disabled","disabled");		
		});
	},
	initEditor:function(){
		KE.show({
			id : 'body',
			items : [
				'cut', 'copy', 'paste','fontname', 'fontsize', 'bold','italic',
				'underline','justifyleft', 'justifycenter', 'justifyright','insertorderedlist', 'insertunorderedlist',
				'indent','-','outdent','textcolor', 'bgcolor','link','unlink'],
			afterCreate : function(id) {
				KE.util.focus(id);
			},
			//避免在ssl下 ie浏览器弹出安全提示
			beforeCreate:function(){
				KE.g['body'].iframe = KE.$$('iframe');
				KE.g['body'].iframe.src="blank.html";
				KE.plugin['lang'].set('{{html_lang name=bossmailnotice_page_language}}');
			}
		});
	},
	checkInput:function(){
		var reg_ver = /^[0-9\.]*$/;
		var version = $.trim($("#version").val());
		var receiver = $("#receiver").val();
		var purebody = KE.util.getPureData("body");
		if(version && !reg_ver.test(version))
		{
			alert("{html_lang name=bossmailnotice_page_alert_version_wrong}",function(){
				$("#version").focus();
			});
			return false;
		}
		if($.trim(document.form1.subject.value).length == 0)
		{
			alert("{html_lang name=bossmailnotice_page_alert_enter_subject}",function(){
				document.form1.subject.focus();   
			}); 
			return false;  
		}
		if(document.form1.subject.value.length > 60)
		{
			alert("{html_lang name=bossmailnotice_page_alert_content_too_long}",function(){
				document.form1.subject.focus();	
			});
			return false;	
		}
		if($.trim(purebody).length == 0)
		{
			alert("{html_lang name=bossmailnotice_page_alert_enter_content}");
			return false;
		}
		if(version)
		{
			var to_version = version+"{html_lang name=bossmailnotice_page_send_version_s}";	
		}
		else
		{
			var to_version = "";	
		}
		if(receiver == "all")
		{
			to_version += "{html_lang name=bossmailnotice_page_send_all}";
		}
		else if(receiver == "online")
		{
			to_version += "{html_lang name=bossmailnotice_page_send_online}";
		}
		else if(receiver == "offline")
		{
			to_version += "{html_lang name=bossmailnotice_page_send_offline}";
		}
		if(version || receiver){
			var _this=this;
			{if $lang eq "en"}
			confirm("{html_lang name=bossmailnotice_page_alert_sure_send_1}"+receiver+"{html_lang name=bossmailnotice_page_alert_sure_send_2}"+" in version "+version,function(){
				{else}
				confirm("{html_lang name=bossmailnotice_page_alert_sure_send_1}"+to_version+"{html_lang name=bossmailnotice_page_alert_sure_send_2}",function(){
					{/if}
					_this.postForm();
				});
			}
		},
		postForm:function(){
			KE.util.setData('body'); //置编辑器内容
			var recv = $("#receiver").val();
			var vers = $("#version").val();
			var _day = $("#time_day").val();
			var _hour = $("#time_hour").val();
			var _time = $("input[name=show_time]:checked").val();
			var _second = $("#custom_second").val();
			var subj = $("#subject").val();
			var body = $("#body").val();
			var purebody = KE.util.getPureData("body");
			var noti = $("#notice").val();
			$.ajax({
				type:"post",
				url:"{html_url route='bossmailnotice/send'}",
				dataType:"json",
				data:{
					receiver:recv,version:vers,time_day:_day,time_hour:_hour,show_time:_time,custom_second:_second,subject:subj,content:body,purecontent:purebody,notice:noti
				},
				success:function(msg){
					var result=msg["data"];
					if(result["reslut"] == "success")
					{
						alert("{html_lang name=bossmailnotice_page_send_success}",function(){
							location.href=location.href;
						});
					}
					else
					{
						alert(result["message"]);	
					}
			
				}
		
			});
		}
	};
	window.PageManager.init();//初始化对象
</script>
{include file='../common/sys_footer.tpl'}
