{include file='../common/sys_header.tpl'}
<div class='main'>
    <h2>{html_lang name=first_page} </h2>
    <ul class="info">
        <li>{html_lang name=statistics_postnumber}<span>{$office_num|default:'2'}</span>{html_lang name=statistics_number}</li>
        <li>{html_lang name=statistics_mailnumber}<span>{$mail_num|default:'1'}</span>{html_lang name=statistics_number}</li>
        <li>{html_lang name=statistics_mailspace}<span>{$allot_void|default:'10'}</span></li>
        <li>{html_lang name=statistics_netdiskspace}<span>{$net_hd_sum1|default:'11'}</span></li>
    </ul>
</div>
{include file='../common/sys_footer.tpl'}