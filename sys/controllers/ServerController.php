<?php

/**
 * 服务器管理控制器
 * 
 * @author linfb
 */
class ServerController extends SysController {

	/**
	 * 磁盘信息分页
	 */
	const DISK_PAGE_SIZE = 25;

	/**
	 * 默认显示方法
	 */
	public function index() {
		$this->serverList();
	}

	/**
	 * 显示服务器列表
	 */
	private function serverList() {
            /**
		$server_list = Config::getServerList();
		$server_info_list = array ();
		foreach ( $server_list as $server ) {
			$server_info_list [] = $this->getServiceInfo( $server ['ip'], $server ['services'] );
		}
		$template = new TemplateEngine();
		$template->assign( "server_info_list", $server_info_list );
             * 
             */
                $template = new TemplateEngine();
		$template->display( 'server_list.tpl' );
	}

	/**
	 * 服务器服务信息细节
	 */
	public function serviceDetail() {
		$server_id = $this->getParamFromRequest( "server_id" );
		if (strlen( $server_id ) > 0) {
			$server_list = Config::getServerList();
			if ($server_list [$server_id]) {
				$service_info = $this->getServiceInfo( $server_list [$server_id] ['ip'], $server_list [$server_id] ['services'] );
				$template = new TemplateEngine();
				$template->assign( "service_info", $service_info );
				$template->display( 'service_detail.tpl' );
			} else {
				$this->showErrorMessage( "The server does not exist" );
			}
		} else {
			$this->showErrorMessage( "Server id is empty" );
		}
	}

	/**
	 * 获取服务器的服务信息
	 * 
	 * @param $server_ip array 服务器ip
	 * @param $service_list type 需检测的服务列表
	 * @return array 服务信息
	 */
	private function getServiceInfo($server_ip, $service_list) {
		$bad_service_num = 0;
		$service_status_list = $this->getServiceStateList( $server_ip, $service_list );
		foreach ( $service_status_list as $service_status ) {
			if ($service_status != 'ok') {
				$bad_service_num ++;
			}
		}
		return array (
				'ip' => $server_ip, 
				'service_num' => count( $service_list ), 
				'bad_service_num' => $bad_service_num, 
				'service_status_list' => $service_status_list );
	}

	/**
	 * 获取服务器服务状态信息
	 * 
	 * @param $server_ip array 服务器ip
	 * @param $service_list array 需检测的服务列表
	 * @return array 服务状态信息
	 */
	private function getServiceStateList($server_ip, $service_list) {
		$service_info = array ();
		foreach ( $service_list as $service ) {
			$service_info [$service] = "unknown";
			if ($service == 'mysql') {
				$service_info [$service] = (ServerServiceHelper::isMysqlServiceOk( $server_ip, 'postfix', 'postfix', 3306 )) ? 'ok' : 'bad';
			}
			if ($service == 'postfix') {
				$service_info [$service] = (ServerServiceHelper::isPostfixServiceOk( $server_ip, 25 )) ? 'ok' : 'bad';
			}
			if ($service == 'authdaemond') {
				$service_info [$service] = (ServerServiceHelper::isAuthdaemondServiceOk( $server_ip, 10086 )) ? 'ok' : 'bad';
			}
			if ($service == 'memcached') {
				$service_info [$service] = (ServerServiceHelper::isMemcachedServiceOk( $server_ip, 11211 )) ? 'ok' : 'bad';
			}
			if ($service == 'imap') {
				$service_info [$service] = (ServerServiceHelper::isImapServiceOk( $server_ip, 143 )) ? 'ok' : 'bad';
			}
			if ($service == 'pop') {
				$service_info [$service] = (ServerServiceHelper::isPopServiceOk( $server_ip, 110 )) ? 'ok' : 'bad';
			}
			if ($service == 'amavisd') {
				$service_info [$service] = (ServerServiceHelper::isAmavisdServiceOk( $server_ip, 10024 )) ? 'ok' : 'bad';
			}
			if ($service == 'apache') {
				$service_info [$service] = (ServerServiceHelper::isApacheServiceOk( $server_ip, 80 )) ? 'ok' : 'bad';
			}
		}
		return $service_info;
	}

	/**
	 * 服务器信息
	 */
	public function info() {
            /**
		$memoryInfo = ServerServiceHelper::getMemoryInfo();
		$diskInfo = ServerServiceHelper::getDiskInfo();
		$networkInfo = ServerServiceHelper::getNetworkInfo();
		
		$template = new TemplateEngine();
		$template->assign( 'serverLoad', ServerServiceHelper::getLoadInfo() );
		$template->assign( 'serverLoginCount', ServerServiceHelper::getLoginInfo() );
		$template->assign( 'serverCpu', ServerServiceHelper::getCpuInfo() );
		$template->assign( 'physicalMemoryUsed', $memoryInfo ['physical'] ['used'] );
		$template->assign( 'physicalMemoryTotal', $memoryInfo ['physical'] ['total'] );
		$template->assign( 'physicalMemoryPercent', round( $memoryInfo ['physical'] ['percent'], 2 ) );
		$template->assign( 'swapMemoryUsed', $memoryInfo ['swap'] ['used'] );
		$template->assign( 'swapMemoryTotal', $memoryInfo ['swap'] ['total'] );
		$template->assign( 'swapMemoryPercent', round( $memoryInfo ['swap'] ['percent'], 2 ) );
		$template->assign( 'diskInfo', $diskInfo );
		$template->assign( 'serverDownload', $networkInfo ['rx'] );
		$template->assign( 'serverUpload', $networkInfo ['tx'] );
             * 
             */
		$template = new TemplateEngine();
		$template->display( 'server_info.tpl' );
	}

	/**
	 * 磁盘信息
	 */
	public function disk() {
            /**
		$summaryData = $this->getSummaryData();
		$listPage = $this->getQueryPage( array (
				"defaultSortKey" => "domain", 
				"defaultSortType" => "asc", 
				"pageSize" => self::DISK_PAGE_SIZE ) );
		$this->getDiskListPage( $listPage, $summaryData ['list'] );
		
		$template = new TemplateEngine();
		$template->assign( 'listPage', $listPage );
		$template->assign( 'totalDisk', $summaryData ['basic'] ['total'] );
		$template->assign( 'usedDisk', $summaryData ['basic'] ['used'] );
		$template->assign( 'percentDisk', $summaryData ['basic'] ['percent'] );
		$template->assign( 'totalDomain', $summaryData ['basic'] ['domainnum'] );
		$template->assign( 'mailboxUsedDisk', $summaryData ['basic'] ['useddisktotalmailbox'] );
		$template->assign( 'mailboxOpenedNum', $summaryData ['basic'] ['mailboxnum'] );
		$template->assign( 'mailboxOpendedAvargeDisk', $summaryData ['basic'] ['useddiskpermailbox'] );
		$template->assign( 'page', $listPage->getQueryInfo()->getCurrentPageno() );
		$template->assign( 'sortKey', $listPage->getQueryInfo()->getSortKey() );
		$template->assign( 'sortType', $listPage->getQueryInfo()->getSortType() );
		$template->assign( 'searchKey', $listPage->getQueryParamValue( "search_key" ) );
		$template->assign( 'searchValue', CHtml::encode( $listPage->getQueryParamValue( "search_value" ) ) );
		$template->assign( 'searchCompare', $listPage->getQueryParamValue( 'search_compare' ) );
		
		$template->assign( 'list', $listPage->getResult() );
             * 
             */
		$listPage = $this->getQueryPage( array (
				"defaultSortKey" => "domain", 
				"defaultSortType" => "asc", 
				"pageSize" => self::DISK_PAGE_SIZE ) );            
		$template = new TemplateEngine();
		$template->assign( 'listPage', $listPage );
		$template->display( 'server_disk.tpl' );
	}

	/**
	 * 磁盘信息报表导出
	 */
	public function exportDiskExcel() {
		$filename = $this->getText( "server_disk_export_filename" );
		$info = $this->getText( "server_disk_title" );
		$titles = $this->getDiskExcelHeader();
		$summaryData = $this->getSummaryData();
		if ($this->getParamFromRequest( 'all' )) {
			$exportData = $summaryData ['list'];
		} else {
			$exportData = $this->getCurrentPageDiskInfoData( $summaryData ['list'] );
		}
		$contents = $this->formatDiskInfoData( $exportData );
		$objPHPExcel = PHPExcelUtil::writeExcel( $excelPath = 'php://output', $type = 'Excel5', $titles, $contents, $info, $filename );
	}

	/**
	 * 邮件队列
	 */
	public function mailQueue() {
            /**
		$msg = PlatformSocketHandler::executeMailqCommand();
		if (! $msg) {
			$this->showErrorMessage( $this->getText( "server_mail_queue_socket_connect_failed" ), $this->createUrl( "index" ) );
		}
		$msg = substr( $msg, 6 );
		$msg = explode( ',', $msg );
		
		$template = new TemplateEngine();
		$template->assign( 'incoming_num', $msg [0] );
		$template->assign( 'incoming_length', StringUtils::transUnit( ($msg [1]) ) );
		$template->assign( 'defer_num', $msg [2] );
		$template->assign( 'defer_length', StringUtils::transUnit( $msg [3] ) );
		$template->assign( 'deferred_num', $msg [4] );
		$template->assign( 'deferred_length', StringUtils::transUnit( $msg [5] ) );
             * 
             */
		$template = new TemplateEngine();
		$template->display( 'mail_queue.tpl' );
	}

	/**
	 * 磁盘信息报表行头信息
	 * 
	 * @return array
	 */
	private function getDiskExcelHeader() {
		return array (
				$this->getText( "server_disk_domain" ), 
				$this->getText( "server_disk_maxuser" ), 
				$this->getText( "server_disk_openeduser" ), 
				$this->getText( "server_disk_diskquota" ), 
				$this->getText( "server_disk_diskquotaused" ), 
				$this->getText( "server_disk_netquota" ), 
				$this->getText( "server_disk_netquotaused" ), 
				$this->getText( "server_disk_spaceusedall" ), 
				$this->getText( "server_disk_spaceusedpermaxuser" ), 
				$this->getText( "server_disk_spaceusedperopeneduser" ), 
				$this->getText( "server_disk_crtime" ), 
				$this->getText( "server_disk_extime" ) );
	}

	/**
	 * 获取当前页磁盘信息 页码 排序 查询
	 * 
	 * @param $list type
	 * @return type
	 */
	private function getCurrentPageDiskInfoData($list) {
		$search = array ();
		$search ['key'] = $this->getParamFromRequest( 'search_key' );
		$search ['value'] = $this->getParamFromRequest( 'search_value' );
		$search ['compare'] = $this->getParamFromRequest( 'search_compare' );
		
		$list = $this->searchDiskData( $list, $search );
		$list = $this->orderDiskData( $list, $this->getParamFromRequest( 'sortkey' ), $this->getParamFromRequest( 'sorttype' ) );
		
		$offset = ($this->getParamFromRequest( 'pageno' ) - 1) * self::DISK_PAGE_SIZE;
		return array_slice( $list, $offset, self::DISK_PAGE_SIZE );
	}

	/**
	 * 组装统计报表数据
	 */
	private function formatDiskInfoData($exportData) {
		$exportFormatData = array ();
		$i = 0;
		foreach ( $exportData as $po_id => $row ) {
			$exportFormatData [$i] [0] = $row ['domain'];
			$exportFormatData [$i] [1] = $row ['maxuser'];
			$exportFormatData [$i] [2] = $row ['openeduser'];
			if ($row ['diskquota'] == 0) {
				$exportFormatData [$i] [3] = $this->getText( 'server_disk_no_limit_disk' );
			} else {
				$exportFormatData [$i] [3] = $row ['diskquota'];
			}
			$exportFormatData [$i] [4] = $row ['diskquotaused'];
			$exportFormatData [$i] [5] = $row ['netquota'];
			$exportFormatData [$i] [6] = $row ['netquotaused'];
			$exportFormatData [$i] [7] = $row ['spaceusedall'];
			$exportFormatData [$i] [8] = $row ['spaceusedpermaxuser'];
			$exportFormatData [$i] [9] = $row ['spaceusedperopeneduser'];
			$exportFormatData [$i] [10] = $row ['crtime'];
			$exportFormatData [$i] [11] = $row ['extime'];
			$i ++;
		}
		return $exportFormatData;
	}

	/**
	 * 服务器磁盘信息汇总获取
	 * 
	 * @return array
	 */
	private function getSummaryData() {
		$summaryData = array ();
		
		$summaryData ['basic'] = ServerServiceHelper::getServerDiskInfo();
		$domainService = ServiceFactory::getDomainService();
		$summaryData ['basic'] ['domainnum'] = $domainService->getDomainCount();
		$mailboxService = ServiceFactory::getMailboxService();
		$summaryData ['basic'] ['mailboxnum'] = $mailboxService->getMailboxCount();
		$domainMailboxNumArr = $domainService->getDomainMailboxNum();
		$domains = $domainService->getAllFromDomain();
		$allDomainDiskUsed = 0;
		foreach ( $domains as $one ) {
			$net_quota = $one ['net_quota'];
			if (! ereg( "^[0-9]+$", $net_quota )) {
				$net_quota = 0;
			}
			$po_quota = $one ['po_quota'];
			if (! ereg( "^[0-9]+$", $po_quota )) {
				$po_quota = 0;
			}
			if (empty( $domainMailboxNumArr [$one ['po_id']] )) {
				$domainMailboxNumArr [$one ['po_id']] = 0;
			}
			if ($one ['is_quota']) {
				$diskquota = 0;
			} else {
				$diskquota = round( $po_quota / 1024 / 1024, 2 );
			}
			
			$netDiskUsed = OSUtils::getNetDiskUsed( $one ['domain'] );
			$mailDiskUsed = PlatformDomainHandler::getDomainDiskUsed( $one ['domain'] );
			$domainDiskUsed = ($netDiskUsed + $mailDiskUsed);
			$allDomainDiskUsed += $domainDiskUsed;
			
			$listData [$one ['po_id']] = array (
					'domain' => PunyCode::decode( $one ['domain'] ),  // 邮局名
					'maxuser' => $one ['po_maxuser'],  // 邮箱数
					'openeduser' => $domainMailboxNumArr [$one ['po_id']],  // 已开通邮箱数
					'diskquota' => $diskquota,  // 邮箱空间容量
					'diskquotaused' => $mailDiskUsed,  // 已使用邮箱空间容量
					'netquota' => $net_quota,  // 网络硬盘容量
					'netquotaused' => $netDiskUsed,  // 已使用网络硬盘空间
					'spaceusedall' => $domainDiskUsed,  // 已使用总空间
					'spaceusedpermaxuser' => round( $domainDiskUsed / $one ['po_maxuser'], 2 ),  // 总邮箱平均占用空间
					'spaceusedperopeneduser' => empty( $domainMailboxNumArr [$one ['po_id']] ) ? $domainDiskUsed : round( $domainDiskUsed / $domainMailboxNumArr [$one ['po_id']], 2 ),  // 已开通邮箱平均占用空间
					'crtime' => str_replace( " 00:00:00", "", $one ['cr_time'] ),  // 邮局开通时间
					'extime' => str_replace( " 00:00:00", "", $one ['ex_time'] ) ); // 邮局过期时间
			
			$summaryData ['list'] = $listData;
		}
		$summaryData ['basic'] ['useddisktotalmailbox'] = StringUtils::transUnit( $allDomainDiskUsed * 1024 * 1024 ); // 邮箱已使用总空间
		$summaryData ['basic'] ['useddiskpermailbox'] = StringUtils::transUnit( $allDomainDiskUsed / $summaryData ['basic'] ['mailboxnum'] * 1024 * 1024 ); // 已开通邮箱平均占用空间
		return $summaryData;
	}

	/**
	 * 获取磁盘信息分页排序
	 * 
	 * @param $listPage type
	 * @param $list type
	 * @throws Exception
	 */
	private function getDiskListPage($listPage, $list) {
		if (! is_array( $list )) {
			throw new Exception( 'list is not array' );
		}
		$search = array ();
		$search ['key'] = $listPage->getQueryParamValue( "search_key" );
		$search ['value'] = $listPage->getQueryParamValue( "search_value" );
		$search ['compare'] = $listPage->getQueryParamValue( 'search_compare' );
		
		$list = $this->searchDiskData( $list, $search );
		$totalCount = count( $list );
		$listPage->setTotal( $totalCount );
		
		$list = $this->orderDiskData( $list, $listPage->getQueryInfo()->getSortKey(), $listPage->getQueryInfo()->getSortType() );
		
		$list = array_slice( $list, $listPage->getOffset(), $listPage->getPerPage() ); // 显示一页数据
		$listPage->setResult( $list );
	}

	/**
	 * 查找
	 * 
	 * @param $list type 各个邮局信息数组
	 * @param $search type 查询数组
	 *        array('key'=>'domain','value'=>'xx.com','compare'=>'=')
	 */
	private function searchDiskData($list, $search) {
		if (strcmp( $search ['key'], '' ) != 0 && strcmp( $search ['value'], '' ) != 0) {
			foreach ( $list as $po_id => $row ) {
				$match = false;
				$theValue = $row [$search ['key']];
				if ($search ['key'] == 'diskquota') {
					if ($theValue == 0) {
						$theValue = 999999999;
					}
				}
				
				if ($search ['key'] == 'domain') {
					if (strpos( $row ['domain'], $search ['value'] ) === false) {
						unset( $list [$po_id] );
					}
					continue;
				}
				
				switch ($search ['compare']) {
					case '=' :
						$match = ($theValue == $search ['value']);
						break;
					case '>=' :
						$match = ($theValue >= $search ['value']);
						break;
					case '<=' :
						$match = ($theValue <= $search ['value']);
						break;
				}
				if (! $match) {
					unset( $list [$po_id] );
				}
			}
		}
		return $list;
	}

	/**
	 * 排序 只做一维
	 * 
	 * @param $data type 各个邮局的信息数组
	 * @param $sortKey type 排序值域由数组$data key值决定
	 * @param $sortType type 排序类型 desc asc
	 * @return array
	 * @throws Exception
	 */
	private function orderDiskData($data, $sortKey, $sortType) {
		$sort = array ();
		if (empty( $sortKey ) || empty( $sortType )) {
			throw new Exception( 'sort type or sort key is null' );
		}
		foreach ( $data as $po_id => $row ) {
			$sort [$po_id] = $row [$sortKey];
			if ($sortKey == 'diskquota') {
				// 无限空间
				$sort [$po_id] = $row [$sortKey] == 0 ? 999999999 : $row [$sortKey];
			}
		}
		if ($sortType == 'asc') {
			array_multisort( $sort, SORT_ASC, $data );
		} elseif ($sortType == 'desc') {
			array_multisort( $sort, SORT_DESC, $data );
		}
		return $data;
	}

}
