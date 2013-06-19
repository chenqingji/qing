// jQuery Alert Dialogs Plugin
//
// Version 1.1
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 14 May 2009
//
// Visit http://abeautifulsite.net/notebook/87 for more information
//
// Usage:
//		jAlert( message, [title, callback] )
//		jConfirm( message, [title, callback] )
//		jPrompt( message, [value, title, callback] )
// 
// History:
//
//		1.00 - Released (29 December 2008)
//
//		1.01 - Fixed bug where unbinding would destroy all resize events
//
// License:
// 
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC. 
//
(function($) {
	
	$.alerts = {
		
		// These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time
		
		verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
		horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
		repositionOnResize: true,           // re-centers the dialog on window resize
		overlayOpacity: .5,                // transparency level of overlay
		overlayColor: '#232323',               // base color of overlay
		draggable: false,                    // make the dialogs draggable (requires UI Draggables plugin)
		okButton: text.alerts.okButton,         // text for the OK button
		cancelButton: text.alerts.cancelButton, // text for the Cancel button
		dialogClass: null,                  // if specified, this class will be applied to all dialogs
		isHtmlEscape: true,
		
		// Public methods
		
		alert: function(message, title, callback,isHtmlEscape) {
			if( title == null ) title = text.alerts.defaultTitle;
			if(typeof isHtmlEscape != 'undefined' && !isHtmlEscape) $.alerts.isHtmlEscape = false;
			$.alerts._show(title, message, null, 'alert', function(result) {
				if( callback ) callback(result);
			});
		},
		
		confirm: function(message, title, callback) {
			if( title == null ) title = 'Confirm';
			$.alerts._show(title, message, null, 'confirm', function(result) {
				if( callback ) callback(result);
			});
		},			
		
		// Private methods
		
		_show: function(title, msg, value, type, callback) {
			
			$.alerts._hide();
			$.alerts._overlay('show');
			
			$("body", top.document).append(
			  '<div id="popup_container">' +
			    '<h1 style="display: block" id="popup_title"></h1>' +
			    '<div id="popup_content">' +
			      '<div id="popup_message"></div>' +
				'</div>' +
			  '</div>');
			
			if( $.alerts.dialogClass ) $("#popup_container", top.document).addClass($.alerts.dialogClass);
			
			// IE6 Fix
			/*
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
			
			$("#popup_container", top.document).css({
				position: pos,
				zIndex: 99999,
				padding: 0,
				margin: 0
			});
			*/
			
			$("#popup_title", top.document).text(title);
			$("#popup_title", top.document).append('<button class="popup_cancel"></button>');
			$("#popup_content", top.document).addClass(type);
			$("#popup_message", top.document).text('<p>' + ($.alerts.isHtmlEscape ? htmlspecialchars(msg) : msg) + '</p>');
			$("#popup_message", top.document).html( $("#popup_message", top.document).text().replace(/&#10;/g, '<br />') );
			
			/*
			$("#popup_container", top.document).css({
				minWidth: $("#popup_container", top.document).outerWidth(),
				maxWidth: $("#popup_container", top.document).outerWidth()
			});
			*/

			$.alerts._reposition();
			$.alerts._maintainPosition(true);
			
			switch( type ) {
				case 'alert':
					$("#popup_message", top.document).after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /></div>');
					$("#popup_ok, .popup_cancel", top.document).bind('click', function(e) {
						$.alerts._hide();
            
                        if ($.browser.msie) {
                            e = window.event ? window.event : window.parent.event;
                            e.keyCode = 15;
                        }

						callback(true);
					});
					$("#popup_ok, .popup_cancel", top.document).focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok", top.document).trigger('click');
					});
				break;
				case 'confirm':
					$("#popup_message", top.document).after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_ok", top.document).click( function() {
						$.alerts._hide();
						if( callback ) callback();
					});
					$("#popup_cancel, .popup_cancel", top.document).click( function() {
						$.alerts._hide();						
					});
					$("#popup_ok", top.document).focus();
					$("#popup_ok, #popup_cancel", top.document).keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok", top.document).trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel", top.document).trigger('click');
					});
				break;				
			}
			
			// Make draggable
			if( $.alerts.draggable ) {
				try {
					$("#popup_container", top.document).draggable({ handle: $("#popup_title", top.document) });
					$("#popup_title", top.document).css({ cursor: 'move' });
				} catch(e) { /* requires jQuery UI draggables */ }
			}
		},
		
		_hide: function() {
			$("#popup_container", top.document).remove();
			$.alerts._overlay('hide');
			$.alerts._maintainPosition(false);
		},
		
		_overlay: function(status) {
			switch( status ) {
				case 'show':
					$.alerts._overlay('hide');
                                     var   isSecure = /^https/i.test(top.location.protocol);//在非安全模式下，iframe要一个空白文件的链接，以便能够阻止IE不安全内容的警告
                                     var   secure_url=(isSecure&&$.browser.msie) ? 'javascript:""' : 'about:blank';
					$("body", top.document).append("<iframe class='pop_frame' frameborder='0' src='"+secure_url+"'></iframe>");					
				break;
				case 'hide':
					$('.pop_frame', top.document).remove();
				break;
			}
		},
		
		_reposition: function() {
                        var w_h=(top.document.compatMode == "CSS1Compat")?top.document.documentElement.clientHeight:top.document.body.clientHeight;
                        var w_w=(top.document.compatMode == "CSS1Compat")?top.document.documentElement.clientWidth:top.document.body.clientWidth;
			var w_s_t=top.document.documentElement.scrollTop||top.document.body.scrollTop;
                        var w_s_l=top.document.documentElement.scrollLeft||top.document.body.scrollLeft;
                        var topval = ((w_h/ 2) - ($("#popup_container", top.document).height() / 2)) + $.alerts.verticalOffset;
			var leftval = ((w_w/ 2) - ($("#popup_container", top.document).width() / 2)) + $.alerts.horizontalOffset;
			if( topval < 0 ) topval = 0;
			if( leftval < 0 ) leftval = 0;
			topval = topval + w_s_t;
                        leftval = leftval + w_s_l;
			$("#popup_container", top.document).css({
				top: topval + 'px',
				left: leftval + 'px'
			});
                        var content_w=(top.document.compatMode == "CSS1Compat")?top.document.documentElement.scrollWidth:top.document.body.scrollWidth;
                        var content_h=(top.document.compatMode == "CSS1Compat")?top.document.documentElement.scrollHeight:top.document.body.scrollHeight;
                        $(".pop_frame", top.document).width(Math.max(content_w,w_w));
                        $(".pop_frame", top.document).height(Math.max(content_h,w_h));
		//	$("#popup_overlay", top.document).height('1000px');
			
		},
		
		_maintainPosition: function(status) {
			if( $.alerts.repositionOnResize ) {
				switch(status) {
					case true:
						$(window).bind('resize', $.alerts._reposition);
					break;
					case false:
						$(window).unbind('resize', $.alerts._reposition);
					break;
				}
			}
		}
		
	}
	
	// Shortuct functions
	jAlert = function(message, title, callback) {
		$.alerts.alert(message, title, callback);
	}
	
	jConfirm = function(message, title, callback) {
		$.alerts.confirm(message, title, callback);
	};
	
})(jQuery);

// 重写alert和confirm
function alert(msg, callback) 
{   
  jAlert(msg, text.alerts.alertTitle, callback);
}

function confirm(msg, callback) 
{
	jConfirm(msg, text.alerts.confirmTitle, callback);
}

function htmlspecialchars(string){
	var data = [];
	for(var i = 0 ;i <string.length;i++) {
	data.push( "&#"+string.charCodeAt(i)+";");
	}
	return data.join("");
}

/**  
 *	使用示例
 * 1、 alert 类型
 *		原来：
 *			alert("请选择删除项");
 * 			return true;
 *
 *		现在：
 *			alert("请选择删除项");
 * 			return true;
 *
 *
 * 2、confirm 类型
 *		原来：
 *			if ( confirm('xxxxx') ) {
 *				// 做确定后的操作
 *			}
 *			else {
 *				// 做取消后的操作
 *			}
 *
 * 		现在：
 *	    confirm('你确定要删除吗', function() {
 *				// 做确定后的操作
 *    	});
 *
 *		// 做取消后的操作
 *    	return true;
 **/
$(function(){

    $("form").attr("autocomplete","off");
});
