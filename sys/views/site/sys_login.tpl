<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow" />
{html_css_file href="assets/css/main.css"}
{html_js_file src="/common/js/language_{$language}.js"}
{html_js_file src="/common/js/jquery-1.9.1.min.js"}
{html_js_file src="/common/js/jquery.alerts.js"}
<title>Welcome</title>
<script type="text/javascript">
<!--
function checkform(user_name)
{
	username = user_name.username.value;
	secretkey = user_name.secretkey.value;
	if(!username) {
		alert('{html_lang name=require_username}');
		return false;
	}
	else if(!secretkey) {
		alert('{html_lang name=require_password}');
		return false;
	}
	else {
		var auth = $('#authcode'),
			authval;
		if(auth.length >0 ){
			authval = auth.val();
			if(authval == ''){
				alert('{html_lang name=require_authcode}');
				return false;
			}
		}
		document.form1.action = "{html_url route=login}";		
		return true;
	}
}  
function language_ch(lan) {	
	if(lan != '') {
		location.href= "{html_url route=index}"+"/language/"+lan;
	}
	else return false;
}

$(function(){
   	document.form1.username.focus();
	var showauthcode = {$show_authcode};
	if(showauthcode){
		var d = new Date();
		$('div.authcode img').attr('src', '{html_url route=getAuthCode}');
		$('div.authcode').show();
	}else{
		$('div.authcode').remove();
	}
	$('div.authcode img').click(function(){
		$(this).attr('src', '{html_url route=getAuthCode}&'+Math.random());
		return false;
	});
});
// -->
</script>
</head>
<body>
	<div class="login" >
    	<h1><img src="/assets/images/login_logo.gif" alt="PICTURE" /></h1>
        <div class="language">
        	<label>{html_lang name=language}</label>
        	{html_options name=language options=$options selected=$language onchange="return language_ch(this.value)"}
        </div>
        <div class="login-form">
		<form name="form1"  method="post" onsubmit="return checkform(this)">
        	<h2>{html_lang name=adminlogin}</h2>
        	<div>
            	<label>{html_lang name=username}</label>
                <input name="username" type="text" maxlength="20" onfocus="this.select()" value="{$username|default:''}" />
            </div>
        	<div>
            	<label>{html_lang name=password}</label>
                <input name="secretkey" maxlength="25"  autocomplete="off" type="password" onfocus="this.select()" />         	
			</div>
			<div class="authcode" >
				<label>{html_lang name=authcode}</label>
				<input name="authcode" id="authcode" type="text" value="" maxlength="4"/><img src="" />
			</div>
        	<div class="button">
            	<button name="submit" type="submit">{html_lang name=login}</button>
            </div>
		</form>
        </div>
    </div>
</body>
</html>
