{include file='../common/sys_header.tpl'}

<div class="main">
    <h2>{html_lang name=server_info_title}</h2>
    <dl class="info1">
        <dt>
        <ul class="info">
            <li>{html_lang name=server_load}：<span>$serverLoad}</span></li>
            <li>{html_lang name=server_login_count}：<span>$serverLoginCount}</span>人</li>
            <li>{html_lang name=server_cpu_type}：<span>$serverCpu}</span></li>
        </ul>
        </dt>
        <dd>
            <table>
                <caption>{html_lang name=server_memory_info}</caption>
                <thead>
                    <tr>
                        <th width="25%">{html_lang name=server_type}</th>
                        <th width="25%">{html_lang name=server_used}</th>
                        <th width="25%">{html_lang name=server_total}</th>
                        <th width="25%">{html_lang name=server_percent}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>{html_lang name=server_physical_memory}</th>
                        <td>$physicalMemoryUsed}</td>
                        <td>$physicalMemoryTotal}</td>
                        <td>$physicalMemoryPercent}%</td>
                    </tr>
                    <tr>
                        <th>{html_lang name=server_swap_memory}</th>
                        <td>$swapMemoryUsed}</td>
                        <td>$swapMemoryTotal}</td>
                        <td>$swapMemoryPercent}%</td>
                    </tr>
                </tbody>
            </table>
        </dd>
        <dd>
            <table>
                <caption>{html_lang name=server_disk_info}</caption>
                <thead>
                    <tr>
                        <th width="25%">{html_lang name=server_type}</th>
                        <th width="25%">{html_lang name=server_used}</th>
                        <th width="25%">{html_lang name=server_total}</th>
                        <th width="25%">{html_lang name=server_percent}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>$currDisk.type}</th>
                        <td>$currDisk.used}</td>
                        <td>$currDisk.total}</td>
                        <td>$currDisk.percent}</td>
                    </tr>
                </tbody>
            </table>
        </dd>
        <dd>
            <table>
                <caption>{html_lang name=server_network_info}</caption>
                <thead>
                    <tr>
                        <th width="25%">{html_lang name=server_type}</th>
                        <th width="25%">{html_lang name=server_throughput}</th>
                        <th width="25%">{html_lang name=server_type}</th>
                        <th width="25%">{html_lang name=server_throughput}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>{html_lang name=server_download}（In）</th>
                        <td>$serverDownload} bytes/s</td>
                        <th>{html_lang name=server_upload}（Out）</th>
                        <td>$serverUpload} bytes/s</td>
                    </tr>
                </tbody>
            </table>
        </dd>
    </dl>

</div>
{include file='../common/sys_footer.tpl'}

