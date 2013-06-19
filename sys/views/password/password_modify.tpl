{include file='../common/sys_header.tpl'}
<div class="main">
    <form id="password_form" method="post" name="form1" class='curr_form' action="{html_url route='password/modify'}">
        <h2>{html_lang name=password_title}</h2>
        <div class="form">
            <div>
                <label>{html_lang name=password_old_password}</label> <input name="oldpass" type="password" size="25" maxlength="25" />
            </div>
            <div>
                <label>{html_lang name=password_new_password}</label> <input name="newpass"  class='strengthpwd' type="password" size="25" maxlength="25" /><em>{html_lang name=password_rule_info}</em>
            </div>
            <div>
                <label>&nbsp;</label> <span class='strength' id="pw_weak_flag">{html_lang name=password_weak}</span> <span class='strength' id="pw_normal_flag">{html_lang name=password_normal}</span>
                <span class='strength' id="pw_strong_flag">{html_lang name=password_strong}</span><b id='weak_pw_msg'></b>
            </div>
            <div>
                <label>{html_lang name=password_comfire_password}</label> <input name="newpass2" type="password" size="25" maxlength="25" /><em>{html_lang name=password_rule_info}</em>
            </div>
            <div class="submit1">
                <button type="submit" onclick='return window.PageManager.checkInput(this.form)'>{html_lang name=password_comfire}</button>
                <button type="reset" type="reset" onclick="window.PageManager.resetClick();">{html_lang name=password_clear}</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    window.PageManager={
        init:function(){
			document.form1.oldpass.focus();
			$('.strengthpwd').strength_validate({
				'val': '{$username}',
				'lang':"{html_lang name=password_strengthpwd_lang}"
			});
        },
        resetClick:function(){
			$('.strength').css('background-color','');$('#week_pw_msg').html('');  
        },
        checkInput:function(form){
            if(form.oldpass.value == ''){
                alert("{html_lang name=password_alert_old_psw_empty}",function(){
					form.oldpass.focus();
				});
                return false;
            }else if(form.oldpass.value.length>25||form.oldpass.value.length<6){
                alert("{html_lang name=password_alert_old_psw_length_rule}",function(){
					form.oldpass.focus();
				});
                return false;
            }
            if(form.newpass.value == ''){
                alert("{html_lang name=password_alert_new_psw_empty}",function(){
					form.newpass.focus();
				});
                return false;
            }else if (form.newpass.value.length>25||form.newpass.value.length<6){
                alert("{html_lang name=password_alert_new_psw_length_rule}",function(){
					form.newpass.focus();
				});
                return false;
            }
            if(form.newpass.value.indexOf(' ') > -1){
                alert("{html_lang name=password_alert_new_psw_contain_space}",function(){
					form.newpass.focus();
				});
                return false;
            }
            if(form.newpass.value.indexOf('\t') > -1){
                alert("{html_lang name=password_alert_new_psw_contain_tab}",function(){
					form.newpass.focus();
				});
                return false;
            }
			if(form.newpass2.value == ''){
                alert("{html_lang name=password_alert_confirm_psw_empty}",function(){
					form.newpass2.focus();
				});
                return false;
            }
			if (form.newpass2.value.length>25||form.newpass2.value.length<6){
                alert("{html_lang name=password_alert_confirm_psw_length_rule}",function(){
					form.newpass2.focus();
				});
                return false;
            }
            if(form.newpass2.value.indexOf(' ') > -1){
                alert("{html_lang name=password_alert_confirm_psw_contain_space}",function(){
					form.newpass2.focus();
				});
                return false;
            }
            if(form.newpass2.value.indexOf('\t') > -1){
                alert("{html_lang name=password_alert_confirm_psw_contain_tab}",function(){
					form.newpass2.focus();
				});
                return false;
            }
            if(form.newpass.value !=form.newpass2.value){
                alert("{html_lang name=password_alert_psw_not_same}",function(){
					form.newpass.focus();
				});
                return false;
            }  
            var pwdstrength = $('.strengthpwd').data('pwdstrength');
            if(pwdstrength == 1){
                alert("{html_lang name=password_alert_psw_weak}",function(){
					form.newpass.focus();
				});
                return false;
            }
            var tmp_str = "&strong=";
            if(pwdstrength == 3){
                tmp_str = tmp_str + "1";
            }else{
                tmp_str = tmp_str + "0";
            }
            document.form1.action = document.form1.action + tmp_str;
            return true;
        }
    };
    window.PageManager.init();
</script>
{include file='../common/sys_footer.tpl'}