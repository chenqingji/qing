{include file="header.tpl"}
<body>
<div id='wrap'>
    <div id='head'>
		<div class='a clearfix'>
			<h3><img src='/assets/images/logo.gif' style="height:70px;" /></h3>
			<div class='a2'>
				<ul class='u1 clearfix'>
					<li>[右上角标识Text]</li>
					<li></li>
				</ul>
				<div class='clear'></div>
				<ul class='u2 clearfix'>
					<li class='f'>&nbsp;</li>
					<li><a href='/' class='user'>用户</a></li>
					<li><a href='/' class='quit'>退出</a></li>
				</ul>
			</div>
		</div>

		<div class='b clearfix'>
			<span class='b1'>
				<a href='/admin.php' class='hm'>首页</a>
				<a href='/' class='bk'>后退</a>
				<a href='/' class='ft'>前进</a>
			</span>

			<em class='b3'>{$smarty.now|date_format:'%Y年%m月%d日 %H时%m分'}</em>
			<span class='b2'>
				你好：
				{$user|default:'管理员'}
			</span>
		</div>
    </div>

    <div id='mid' class='clearfix'>
        <div id='side'>
                <div class='in'>
			<h3>管理菜单</h3>

			<div class='block open'>
				<h4 class='clearfix'><span>财务出入</span></h4>
				<ul>
					<li><a href='index.php?r=pay/toList'>出入列表</a></li>
					<li><a href='index.php?r=pay/toEdit'>增加出入</a></li>
				</ul>
			</div>


			<div class='block open'>
				<h4 class='clearfix'><span>编辑器功能</span><em></em></h4>
			    <ul>
					<li><a href='index.php?r=pay/editor'>在线编辑</a></li>
					<li><a href='index.php?r=pay/show'>内容显示</a></li>
			    </ul>
			</div>

			<div class='block open'>
				<h4 class='clearfix'><span>上传文件</span><em></em></h4>
			    <ul>
			    	<li><a href='index.php?r=pay/toUpload'>上传照片</a></li>
			    	<li><a href='index.php?r=pay/uploadList'>照片瀑布</a></li>
                                <li><a href='index.php?r=pay/uploadListOuter' target="_blank">外部照片瀑布</a></li>
			    </ul>
			</div>

			<div class='block open'>
                                <h4 class='clearfix'><span>项目四</span><em></em></h4>
			    <ul>
			    	<li><a href=''>子项目一</a></li>
			        <li><a href=''>子项目二</a></li>
			    </ul>
			</div>

			<div class='block open'>
                                <h4 class='clearfix'><span>项目五</span><em></em></h4>
                            <ul>
                                <li><a href='/edit.php?A=toplines'>子项目五</a></li>
                                <li><a href='/edit.php?A=topline'>子项目五</a></li>
                            </ul>
                        </div>
                </div>
        </div>

        <div id='main'>
                <div class='in'>
                {$tips|default:''}
                {$right}
                </div>
        </div>
    </div>
</div>
</body>
</html>
