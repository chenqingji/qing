<!-- 告诉浏览器本网页符合XHTML1.0过渡型DOCTYPE --> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- html标识扩展，定义名字空间 -->
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><!--{html_lang name=bossmail_manage_sys}--></title>
<!--{html_css_file href="assets/css/main.css"}-->
<!--{html_js_file src="/common/js/jquery-1.9.1.min.js"}-->
<!--{html_js_file src="/assets/js/jquery.autoheight.js"}-->
<!--{html_js_file src="/common/js/language_<!--{$language}-->.js"}-->
<!--{html_js_file src="/common/js/jquery.alerts.js"}-->
<!-- 定义链接样式表 -->
<style type="text/css">
<!--
html,body {
	height: 100%;
	overflow-y: hidden;
}

.side-wrap ul li ul {
	display: none;
}

.side-wrap ul li ul.active {
	display: block;
}
-->
</style>
</head>
<body>
	<div style="height: 100%; overflow: auto; position: relative;">
		<table class="contain" style="height: 100%">
			<tr>
				<td colspan="2" class="header">
					<div class="header-wrap">
						<div class="logo">
							<img src="assets/images/logo.gif" alt="<!--{html_lang name=bossmail_manage_sys}-->" />
						</div>
						<div class="nav">
							<span class="nav_right"><!--{html_lang name=header_hello}-->
							<span title="<!--{$username}-->" id='uname'><!--{$username|truncate:12}--></span>|<a href="#" class='exitid'><!--{html_lang name=header_save_quit}--></a>
							|<a href="http://help.zzy.cn/alist.asp?sort=59" target="_blank"><!--{html_lang name=header_help}--></a>| 
							<span><!--{html_lang name=language}--> <!--{html_options name=language options=$options selected=$language onchange="return language_ch(this.value)"}--> </span>
							</span>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width="170" id="side">
					<div class="side">
						<div class="side-head"><!--{html_lang name=menu}--></div>
						<div class="side-wrap">
							<ul>
								<li><a href="<!--{html_url route='statistics/index'}-->" target="main"><!--{html_lang name=first_page}--></a>
								<!--{* 信息统计功能 *}-->
								<!--{if SysAccessAuth::isHaveAccessRight(SysRightsConfig::STATISTIC_ANALYSIS)}-->
								<li><a href="<!--{html_url route='statistics/sendReceiveStat'}-->" target="main"><!--{html_lang name=menu_statistical}--></a>
								<ul>
										<li><a href="<!--{html_url route='statistics/sendReceiveStat'}-->" target="main"><!--{html_lang name=menu_li_send_and_receive_email}--></a></li>
										<li><a href="<!--{html_url route='statistics/mailsize'}-->" target="main"><!--{html_lang name=menu_li_mail_size}--></a></li>
										<li><a href="<!--{html_url route='statistics/visitorInfoStat'}-->" target="main"><!--{html_lang name=menu_li_visitor_info_stat}--></a></li>
										<li><a href="<!--{html_url route='active/index'}-->" target="main"><!--{html_lang name=menu_li_active_user_stat}--></a></li>
									</ul>
								</li>
								<!--{/if}-->
								
								<!--{* 邮局管理*}-->
								<li><a href="<!--{html_url route='post/index'}-->" target="main" ><!--{html_lang name=menu_post_manage}--></a></li>
								
								<!--{* 服务器管理*}-->
								<!--{if SysAccessAuth::isHaveAccessRight(SysRightsConfig::SERVER_INFORMATION)}-->
								<li><a href="<!--{html_url route='server/index'}-->" target="main"><!--{html_lang name=menu_service_manage}--></a>
									<ul>
										<li><a href="<!--{html_url route='server/index'}-->" target="main"><!--{html_lang name=menu_li_service_supervising}--></a></li>
										<li><a href="<!--{html_url route='server/info'}-->" target="main"><!--{html_lang name=menu_li_server_info}--></a></li>
										<li><a href="<!--{html_url route='server/disk'}-->" target="main"><!--{html_lang name=menu_li_disk_info}--></a></li>
										<li><a href="<!--{html_url route='server/mailQueue'}-->" target="main"><!--{html_lang name=menu_li_mail_queue}--></a></li>
									</ul>
								</li>
								<!--{/if}-->
								
								<!--{*登录页面管理*}-->
								<!--{if SysAccessAuth::isHaveAccessRight(SysRightsConfig::LOGIN_PAGE_SETUP)}-->
								<li><a href="<!--{html_url route='loginpage/index'}-->" target="main"><!--{html_lang name=menu_login_page_set}--></a></li>
								<!--{/if}-->
								
								<!--{*页面风格设置*}-->
								<!--{if SysAccessAuth::isHaveAccessRight(SysRightsConfig::PAGES_STYLE_SETTING)}-->
								<li><a href="<!--{html_url route='pagestyle/index'}-->" target="main"><!--{html_lang name=menu_pagestyle}--></a></li>
								<!--{/if}-->
								
								<!--{*过滤设置*}--> 
								<!--{if SysAccessAuth::isHaveAccessRight(SysRightsConfig::FILTRATION_SETUP)}-->
								<li><a href="<!--{html_url route='blacklist/index'}-->" target="main"><!--{html_lang name=menu_filter}--></a>
									<ul>
										<li><a href="<!--{html_url route='blacklist/index'}-->" target="main"><!--{html_lang name=menu_li_black_filter}--></a></li>
										<li><a href="<!--{html_url route='whitelist/index'}-->" target="main"><!--{html_lang name=menu_li_white_filter}--></a></li>
										<li><a href="<!--{html_url route='frequency/index'}-->" target="main"><!--{html_lang name=menu_li_frequency_control}--></a></li>
										<li><a href="<!--{html_url route='keywordfilter/index'}-->" target="main"><!--{html_lang name=menu_li_keyword_list}--></a></li>
									</ul>
								</li>
								<!--{/if}-->
								
								<!--{* 管理员管理*}-->
								<!--{if SysAccessAuth::isHaveAccessRight(SysRightsConfig::ADMIN_ACCESS_FLAG)}-->	
								<li><a href="<!--{html_url route='admin/index'}-->" target="main"><!--{html_lang name=menu_admin_manage}--></a></li>
								<!--{/if}-->
								
								<!--{* 日志管理功能 *}-->
								<!--{if SysAccessAuth::isHaveAccessRight(SysRightsConfig::LOG_MANAGER_ACCESS)}-->
								<li><a href="<!--{html_url route='log/sysLog'}-->" target="main"><!--{html_lang name=menu_operlog_manage}--></a>
									<ul>
										<li><a href="<!--{html_url route='log/sysLog'}-->" target="main"><!--{html_lang name=menu_li_system_operlog}--></a></li>
										<li><a href="<!--{html_url route='log/adminLog'}-->" target="main"><!--{html_lang name=menu_li_post_operlog}--></a></li>
										<li><a href="<!--{html_url route='log/mailLog'}-->" target="main"><!--{html_lang name=menu_li_mailbox_operlog}--></a></li>
									</ul>
								</li>
								<!--{/if}-->
								
								<!--{* 系统消息 *}-->
								<li><a href="<!--{html_url route='bossmailnotice/index'}-->" target="main"><!--{html_lang name=menu_bossmail_notice}--></a></li>
								
								<!--{*广告管理*}-->
								<!--{if SysSessionUtil::getSysLoginUser()->isSupperAdmin()}-->	
								<li><a href="<!--{html_url route='advertisement/index'}-->" target="main"><!--{html_lang name=menu_ad_manage}--></a></li>
								<!--{/if}-->
								
								<!--{*系统配置*}-->
								<!--{if SysSessionUtil::getSysLoginUser()->isSupperAdmin()}-->	
								<li><a href="<!--{html_url route='systemsetup/index'}-->" target="main"><!--{html_lang name=menu_system_conf}--></a>
									<ul>
										<li><a href="<!--{html_url route='systemsetup/toServerFunctionSetup'}-->" target="main"><!--{html_lang name=menu_li_server_function_setup}--></a></li>
										<li><a href="<!--{html_url route='systemsetup/toPostTypeSetup'}-->" target="main"><!--{html_lang name=menu_li_post_type_setup}--></a></li>
									</ul>
								</li>
								<!--{/if}-->
								
								<!--{* 修改密码*}-->
								<li><a href="<!--{html_url route='password/index'}-->" target="main"><!--{html_lang name=menu_update_password}--></a></li>
								
								<!--{* 用户密码查询*}-->
								<!--{if SysAccessAuth::isHaveAccessRight(SysRightsConfig::SEARCH_PASSWORD)}-->	
								<li><a href="<!--{html_url route='userpassword/index'}-->" target='main'><!--{html_lang name=menu_find_username_password}--></a></li>
								<!--{/if}-->
								
								<!--{* 用户退出*}-->
								<li><a href="#" class='exitid'><!--{html_lang name=menu_exit}--></a></li>
							</ul>
						</div>
					</div>
				</td>
				<td id="main" width="100%"><iframe id="right" class='autoHeight' name="main" src="<!--{html_url route='statistics/index'}-->" scrolling="no" frameborder="0"></iframe></td>
			</tr>
		</table>
	</div>
<script type="text/javascript">
$().ready(function() {
	$('.exitid').click(function() {
		confirm("<!--{html_lang name=makesure_exit}-->",function(){
			location.href='<!--{html_url route="logout"}-->';
		});
	});
	var allLinks = $('.side-wrap > ul > li > a');
	allLinks.click( function() {
		var li = $(this).parent();
		var active = $('.active');
		$('ul', li).toggleClass('active');
		if (active.length > 0) {
			active.removeClass('active');
		}
	});

});
function language_ch(lan) {       
    if(lan != '') {
            parent.location.href= "<!--{html_url route='site/changeLanguage/language/"+lan+"'}-->";
    }else {
    	return false;
    }
}
</script>
</body>
</html>
