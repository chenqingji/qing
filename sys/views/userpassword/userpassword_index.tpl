{include file='../common/sys_header.tpl'}
<div class="main">
    <form id="form1" name="form1" method="post" class='curr_form' action="{html_url route=query}" autocomplete="off">
        <h2>{html_lang name=userPassword_query}</h2>
        <div class="form">
            <div>
                <label>{html_lang name=userPassword_username}</label>
                <input name="trantext" autocomplete="off" type="text" size="25" maxlength="128" value="{$username}"  />

            </div>
            <div>
                <label>{html_lang name=userPassword_password}</label>
                <input name="newpass" autocomplete="off" type="text"size="25" maxlength="30" value="{$password|escape:'html'}" readonly="true" />
            </div>
            <div class="submit1">
                <button name="Submit" type="submit" onclick='return check_input(this.form);'>{html_lang name=userPassword_search}</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
$(function(){
    document.form1.trantext.focus(); 
});
function check_input(){
    var text = $.trim(document.form1.trantext.value);
    if(!text){
        alert("{html_lang name=userPassword_name_empty}",function(){
        	$('input[name=trantext]').focus();
        });
        return false;
    }	
    if(!(/^[\w\-\.\u4e00-\u9fa5]*@[\w\-\u4e00-\u9fa5]+\.[\w\-\.\u4e00-\u9fa5]+$/.test(text))){
        alert("{html_lang name=userPassword_name_illegal}",function(){
        	$('input[name=trantext]').focus();
        }); 
        return false;
    }
}
</script> 
{include file='../common/sys_footer.tpl'}


