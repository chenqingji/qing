function cls_mask(tag,cfg,win){
	cfg=cfg||{};
	this.tg=$(tag);
	this.DOC=this.tg[0].ownerDocument;
	this.win=win;
	this.msg=cfg.msg;

	this.el=$('<div style="display:none;background-color: #CCCCCC;" onclick="return false;"  ></div>',this.DOC); 
	      this.el.css({  
	            "position":"absolute",
	            "z-index":9999}
	        );
	if($.browser.msie ){
	  var ifr_el =$("<iframe  frameborder='0'></iframe>");
	  ifr_el[0].src="#";
	  this.el.append(ifr_el);
	  this.el.find('iframe').fadeTo(0,0);
	  this.el.find('iframe').hide();
	}
	if(cfg.opacity||cfg.opacity===0){
	this.el.fadeTo(0,cfg.opacity);
	}else{
	this.el.fadeTo(0,0.5); 
	}
	this.tg.append(this.el);
	this.msg_el=$("<div style='display:none;'><p></p></div>",this.DOC);
	this.msg_el.css({
	            "position":"absolute",
	            "z-index":9999}
	        );
	if(cfg.msg_cls){
	this.msg_el.addClass(cfg.msg_cls);
	}
	if(this.msg){
	this.msg_el.find("p:first").html(this.msg);
	}
	this.tg.append(this.msg_el);
	}
	cls_mask.prototype={
	  fit_resize:function(){
	      var m_w=$(this.tg).width();
	      var m_h=$(this.tg).height();
	      var m_t=(this.tg[0]==this.DOC.body)?0:$(this.tg).offset().top;
	      var m_l=(this.tg[0]==this.DOC.body)?0:$(this.tg).offset().left;
	      var msg_t=(m_h-this.msg_el.height())/2;
	      var msg_l=(m_w-this.msg_el.width())/2;
	      this.el.css({
	            "top":m_t+"px",
	            "left":m_l+"px",  
	            "width":m_w,
	            "height":m_h
	        });
	        if($.browser.msie ){
	      this.el.find('iframe').css({
	            "width":m_w,
	            "height":m_h
	        });
	        }
	     this.msg_el.css({
	            "top":m_t+msg_t,
	            "left":m_l+msg_l
	        });
	  },
	  remove:function(){
	    try{
	     this.el.remove(); 
	     this.msg_el.remove();
	    }catch(e){
	    }
	  },
	  show:function(msg){
	      if(msg){
	       this.msg_el.find("p:first").html(msg);
	       this.msg=msg;
	       }
	       this.el.show();
	       this.msg_el.show();
	       this.fit_resize();
	  },
	  hide:function(hide_delete){
	      if(hide_delete){
	        this.remove();
	      }else{
	        this.el.hide();
	        this.msg_el.hide();
	      }
	  },
	  set_css:function(css){
	  this.el.css(css);
	  },
	  set_opacity:function(opacity){
	  this.el.fadeTo(0,opacity); 
	  }
	};