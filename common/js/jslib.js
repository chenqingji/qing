/**
 * JSLib对象定义一些常用函数
 */
JSLib={
	/**
	 * 当页面滚动后，如果元素不在可见区域，置顶显示
	 */
	fixTop:function(tag){
		var fixEl=$(tag);
		if(fixEl.length<1){
			return;
		}
		fixEl.wrap("<div></div>");
		var wrapEl=fixEl.parent();
		var wph=wrapEl.height();
		//设置元素占用的页面大小，使元素绝对定位时，页面不会发生大小变化而产生跳动
		wrapEl.height(wph);
		var doc=fixEl[0].ownerDocument;
		var win=doc.defaultView||doc.parentWindow;
		var oldScrollTop=doc.documentElement.scrollTop;
		var elTop=fixEl.offset().top;
		var isIE6=$.browser.msie&&($.browser.version==6.0)&&!$.support.style;
		fixEl.height(wph);
		fixEl.width("100%");
		var isFix=false;
		var fixTopFun=function(){
			if(isIE6){//ie6要计算出真实的宽度
			fixEl.width($(document.body).width()-30);//滚动条宽度大概是30px
			}
			var sTop=$(doc).scrollTop();
			if(sTop!=oldScrollTop && doc.readyState === "complete"&&fixEl.length>0){
				if(sTop>elTop){
					if(!isFix){
						if(isIE6){
			             fixEl.css({
							'position':'absolute',
							'z-index':'10000'
						 });
			            }else{
						fixEl.css({
							'position':'fixed',
							'z-index':'10000',
							'top':'0px'
						 });
						}
						isFix=true;
					}
					if(isIE6){
					fixEl.css('top',sTop+'px');
				    }
				}else{
					if(isFix){
						fixEl.css({
							'position':'',
							'top':'',
							'z-index':''
						});
						isFix=false;
					}
				}
				oldScrollTop=sTop;
			}
		};
		fixTopFun();
		$(win).bind("scroll resize",function(){
			fixTopFun();
		});
	}
}