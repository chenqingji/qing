<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
</head>
{html_css_file href="assets/css/main.css"}
{html_js_file src="/common/js/language_{$language}.js"}
{html_js_file src="/common/js/jquery-1.9.1.min.js"}
{html_js_file src="/common/js/jquery.alerts.js"}
<body>
<script type="text/javascript">
//显示结果封装对象
var result = {
	'msg' : {$message},
	'urls' : {$urls},
	'ismainframe' : {$ismainframe}
};

//处理方法
(function(){
	if(result.msg){
		alert(result.msg,function(){
			if(result.urls && result.urls.length > 0){
				if(result.ismainframe){
					top.location.href=result.urls.shift();
				}else{
					location.href=result.urls.shift();
				}
			}
		});;
	}
})();

///如果有存在自定义js执行之
{$returnjs}
</script>
</body>
</html>