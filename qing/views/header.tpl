<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理后台</title>
<link href="/assets/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/basic.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/style.css" rel="stylesheet" type="text/css" />
<link href="/css/jquery_ui_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

<!--以下css需要根据页面需要再主动添加，避免不必要的请求-->
<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/js/jquery_ui/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="/assets/js/qing.js"></script>

<!--以下js需要根据页面需要再主动添加，避免不必要的请求-->
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/jquery.validate.messages_cn.js"></script>

<script type="text/javascript">

$(document).ready(function() {

	$('.del').click( function() {
		return confirm('您确定删除吗？');
	});

	$('#side .block h4 em').click(function() {
	    var block = $(this).closest('.block');

        var open = false;
        if (block.hasClass('close')) {
        	open = true;    
        }

        $('#side .block').removeClass('open');
        $('#side .block').addClass('close');

        if (open) {
        	block.removeClass('close');
            block.addClass('open');

        } else {
            block.removeClass('open');
            block.addClass('close');
        }
    });

});

</script>

</head>


