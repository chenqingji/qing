var iframe;

function reinitIframe()
{
    // FF
    if(iframe.contentDocument && iframe.contentDocument.body)
    {
		iframe.height = Math.max(iframe.contentDocument.body.offsetHeight+20,400) ;
	} 	
	else if(iframe.contentWindow.document.body) // ie
	{
		iframe.height = Math.max(iframe.contentWindow.document.body.scrollHeight+20,400);
	}
}

function reinitIframe2()
{
	the_height = $('.mailboxside').height() - 15;
	iframe.height = the_height;
}

$(document).ready(function(){ 

    iframe = document.getElementById('right');

	// 邮箱端处理
	if ( $('.mailboxside').length > 0 )
    	window.setInterval("reinitIframe2()", 100);
	else {
    	window.setInterval("reinitIframe()", 100);
	}
});
