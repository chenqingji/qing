<?php

/**
 * 统计分析控制类
 * 
 * @author jm
 */
class StatisticsController extends SysController {

	/**
	 * 信息统计
	 */
	public function index() {
		/**
		$info = ServiceFactory::getStatisticsService()->getCountDomainInfo();
		$officeNum = $info ['office_num']; // 邮局数
		$allotVoid = $info ['allot_void']; // 邮箱总分配空间
		$netSpace = $info ['net_allot_void']; // 网络硬盘分配空间
		$nethdsum1 = StringUtils::transUnit( $netSpace * 1024 * 1024 ); // 网络硬盘分配空间单位转化
		$allotVoid = StringUtils::transUnit( $allotVoid ); // 邮箱总分配空间单位转化
		$quotainfo = ServiceFactory::getSysSettingService()->getSysSetting();
		$mail_num = ServiceFactory::getMailboxService()->getMailboxCount();
                 */
		
		$template = new TemplateEngine();
//		$template->assign( 'office_num', $officeNum );
//		$template->assign( 'allot_void', $allotVoid );
//		$template->assign( 'sys_setting', $quotainfo );
//		$template->assign( 'mail_num', $mail_num );
//		$template->assign( 'net_hd_sum1', $nethdsum1 );
		$template->display( "statistics_info.tpl" );
	}

	/**
	 * 获取默认按（日，月）查询
	 * 
	 * @param $type （当月统计，季度统计，年度统计）
	 */
	private function getDefaultByWhat($type) {
		$byWhat = "day";
		if ($type == "month") {
			$byWhat = "day";
		} else if ($type == "season") {
			$byWhat = "month";
		} else if ($type == "year") {
			$byWhat = "month";
		}
		return $byWhat;
	}

	/**
	 * 对时间区间做处理 用于图标上方时间范围显示
	 * 
	 * @param $type 按（日，月，年）查询
	 * @param $begin 开始时间
	 * @param $end 结束时间
	 */
	private function getTitleTimeStr($type, $begin, $end) {
		$result = array ();
		if ($type == "month") {
			$begin = substr( $begin, 0, 7 );
			$end = substr( $end, 0, 7 );
		} else if ($type == "year") {
			$begin = substr( $begin, 0, 4 );
			$end = substr( $end, 0, 4 );
		}
		if ($begin != $end) {
			$timeStr = "(" . $begin . "~" . $end . ")";
		} else {
			$timeStr = "(" . $begin . ")";
		}
		return $timeStr;
	}

	/**
	 * 获取季度统计默认时间区间
	 */
	private function getSeasonTimeSection() {
		$timeSection = array ();
		$currentMonth = date( "n" );
		$currentYear = strval( date( "Y" ) );
		if ($currentMonth >= 1 && $currentMonth <= 3) {
			$begin = $currentYear . "-01";
		} elseif ($currentMonth >= 4 && $currentMonth <= 6) {
			$begin = $currentYear . "-04";
		} elseif ($currentMonth >= 7 && $currentMonth <= 9) {
			$begin = $currentYear . "-07";
		} elseif ($currentMonth >= 10 && $currentMonth <= 12) {
			$begin = $currentYear . "-10";
		}
		$timeSection ["begin"] = $begin . "-01";
		$timeSection ["end"] = date( "Y-m-d" );
		return $timeSection;
	}

	/**
	 * 获取默认时间区间
	 * 
	 * @param $type （当月统计，季度统计，年度统计）
	 */
	private function getDefaultTimeData($type) {
		$timeData = array ();
		if ($type == "month") {
			$end = strval( date( "Y-m-d" ) );
			$begin = date( "Y-m" ) . "-01";
		} else if ($type == "season") {
			return $this->getSeasonTimeSection();
		} else if ($type == "year") {
			$currentYear = strval( date( "Y" ) );
			$begin = $currentYear . "-01-01";
			$end = date( "Y-m-d" );
		}
		$timeData ["begin"] = $begin;
		$timeData ["end"] = $end;
		return $timeData;
	}

	/**
	 * 获取中间平均数据单位
	 * 
	 * @param $type String 按（日，月，年）查询
	 */
	private function getAverageUnit($type) {
		$unit = "";
		if ($type == "day") {
			$unit = $this->getText( "statistics_day" );
		} else if ($type == "month") {
			$unit = $this->getText( "statistics_month" );
		} else if ($type == "year") {
			$unit = $this->getText( "statistics_year" );
		}
		return $unit;
	}

	/**
	 * 获取图表的图注
	 * 
	 * @param $type 按（日，月，年）查询
	 */
	private function getChartLegend($type) {
		if ($type == 'day') {
			$legend = $this->getText( "statistics_by_day" );
		} elseif ($type == 'month') {
			$legend = $this->getText( "statistics_by_month" );
		} elseif ($type == 'year') {
			$legend = $this->getText( "statistics_by_year" );
		}
		return $legend;
	}

	/**
	 * 获取邮件收发流量统计图表参数
	 * 
	 * @param $statData 统计数据
	 * @param $by 按（日，月，年）查询
	 * @param $begin 开始时间
	 * @param $end 结束时间
	 */
	private function getSendReceiveFlowChartParm($statData, $by, $begin, $end) {
		$timeStr = $this->getTitleTimeStr( $by, $begin, $end );
		$title = $this->getText( "statistics_send_rcpt_flow_title" ) . $timeStr . "&nbsp;" . $this->getText( "statistics_send_rcpt_flow_unit" );
		$noData = $this->getText( "statistics_nodata" );
		$tip = array (
				$this->getText( "statistics_send_flow" ), 
				$this->getText( "statistics_sent_flow" ), 
				$this->getText( "statistics_rcpt_flow" ) );
		$color = array ("#ff0000", "#0000ff", "#00ff00" );
		$unit = $this->getText( "statistics_send_rcpt_flow_unit1" );
		$legend = $this->getChartLegend( $by );
		$tmpMaxNumArr = array (); // 计算xy轴用
		$datatotalnum = 0; // 数据总数
		/*
		 * 图表数据
		 */
		$mail_size_xlabel_data = array ();
		$mail_send_size = array ();
		$mail_sent_size = array ();
		$mail_rcpt_size = array ();
		
		foreach ( $statData as $myline ) {
			$tmponeline = array ();
			$tmponeline ["send"] = $myline ['send_size'] ? $myline ['send_size'] : 0;
			$tmponeline ["send"] = $tmponeline ["send"] / 1024;
			$tmponeline ["sent"] = $myline ['sent_size'] ? $myline ['sent_size'] : 0;
			$tmponeline ["sent"] = $tmponeline ["sent"] / 1024;
			$tmponeline ["rcpt"] = $myline ['rcpt_size'] ? $myline ['rcpt_size'] : 0;
			$tmponeline ["rcpt"] = $tmponeline ["rcpt"] / 1024;
			
			$tmpMaxNumArr [] = max( $tmponeline );
			$tmponeline ['time'] = substr( $myline ['rec_date'], 0, 10 );
			
			$mail_size_xlabel_data [] = $tmponeline ['time'];
			$mail_send_size [] = $tmponeline ['send'];
			$mail_sent_size [] = $tmponeline ['sent'];
			$mail_rcpt_size [] = $tmponeline ['rcpt'];
			$datatotalnum ++;
		}
		$contentData = array ($mail_send_size, $mail_sent_size, $mail_rcpt_size );
		$count = $datatotalnum;
		/*
		 * 计算图形轴线
		 */
		if (empty( $tmpMaxNumArr )) {
			$tmpmaxval = 10;
		} else {
			$tmpmaxval = max( $tmpMaxNumArr );
		}
		$maxVal = $tmpmaxval;
		$xlabel = $mail_size_xlabel_data;
		$chartParam ["title"] = $title;
		$chartParam ["noData"] = $noData;
		$chartParam ["contentData"] = $contentData;
		$chartParam ["count"] = $count;
		$chartParam ["maxVal"] = $maxVal;
		$chartParam ["tip"] = $tip;
		$chartParam ["color"] = $color;
		$chartParam ["unit"] = $unit;
		$chartParam ["xlabel"] = $xlabel;
		$chartParam ["legend"] = $legend;
		return $chartParam;
	}

	/**
	 * 获取邮件收发数量统计图表参数
	 * 
	 * @param $statData 统计数据
	 * @param $by 按（日，月，年）查询
	 * @param $begin 开始时间
	 * @param $end 结束时间
	 */
	private function getSendReceiveNumChartParm($statData, $by, $begin, $end) {
		$timeStr = $this->getTitleTimeStr( $by, $begin, $end );
		$title = $this->getText( "statistics_send_rcpt_num_title" ) . $timeStr . "&nbsp;" . $this->getText( "statistics_send_rcpt_num_unit" );
		$noData = $this->getText( "statistics_nodata" );
		$tip = array (
				$this->getText( "statistics_send_num" ), 
				$this->getText( "statistics_sent_num" ), 
				$this->getText( "statistics_rcpt_num" ) );
		$color = array ("#ff0000", "#0000ff", "#00ff00" );
		$unit = $this->getText( "statistics_send_rcpt_num_unit1" );
		$legend = $this->getChartLegend( $by );
		$tmpMaxNumArr = array (); // 计算xy轴用
		$datatotalnum = 0; // 数据总数
		/*
		 * 图表数据
		 */
		$mail_size_xlabel_data = array ();
		$mail_send_size = array ();
		$mail_success_size = array ();
		$mail_rcpt_size = array ();
		foreach ( $statData as $myline ) {
			$tmponeline = array ();
			$tmponeline ["send"] = intval( $myline ['send_all'] ? $myline ['send_all'] : 0 );
			$tmponeline ["success"] = intval( $myline ['send_success'] ? $myline ['send_success'] : 0 );
			$tmponeline ["rcpt"] = intval( $myline ['rcpt_all'] ? $myline ['rcpt_all'] : 0 );
			
			$tmpMaxNumArr [] = max( $tmponeline );
			$tmponeline ['time'] = substr( $myline ['rec_date'], 0, 10 );
			
			$mail_size_xlabel_data [] = $tmponeline ['time'];
			$mail_send_size [] = $tmponeline ['send'];
			$mail_success_size [] = $tmponeline ['success'];
			$mail_rcpt_size [] = $tmponeline ['rcpt'];
			$datatotalnum ++;
		}
		$contentData = array ($mail_send_size, $mail_success_size, $mail_rcpt_size );
		$count = $datatotalnum;
		/*
		 * 计算图形轴线
		 */
		if (empty( $tmpMaxNumArr )) {
			$tmpmaxval = 10;
		} else {
			$tmpmaxval = max( $tmpMaxNumArr );
		}
		$maxVal = $tmpmaxval;
		$xlabel = $mail_size_xlabel_data;
		$chartParam ["title"] = $title;
		$chartParam ["noData"] = $noData;
		$chartParam ["contentData"] = $contentData;
		$chartParam ["count"] = $count;
		$chartParam ["maxVal"] = $maxVal;
		$chartParam ["tip"] = $tip;
		$chartParam ["color"] = $color;
		$chartParam ["unit"] = $unit;
		$chartParam ["xlabel"] = $xlabel;
		$chartParam ["legend"] = $legend;
		return $chartParam;
	}

	/**
	 * 邮件收发统计
	 */
	public function sendReceiveStat() {
            /**
		$sendReceiveStatService = ServiceFactory::getSendReceiveStatService();
		$type = $this->getParamFromRequest( 'type', 'month' ); // 当月统计等
		$defautBy = $this->getDefaultByWhat( $type );
		$by = $this->getParamFromRequest( 'by', $defautBy ); // 按日统计等
		$picType = $this->getParamFromRequest( "pictype", "line" );
		if ($type == "month" || $type == "season" || $type == "year") {
			$timeData = $this->getDefaultTimeData( $type );
			$begin = $timeData ["begin"];
			$end = $timeData ["end"];
			$param = array ();
		} else {
			$begin = $this->getParamFromRequest( 'begin' );
			$end = $this->getParamFromRequest( 'end' );
			$mailbox = PunyCode::encode( $this->getParamFromRequest( 'mailbox' ) );
			$param ["begin"] = $begin;
			$param ["end"] = $end;
			$param ["mailbox"] = $mailbox;
		}
		$statData = $sendReceiveStatService->getSendReceiveStatData( $type, $by, $param );
		
		$tableData = $sendReceiveStatService->getTableData( $statData );
		$totalData = $sendReceiveStatService->getTotalData( $statData );
		$tableTotal = $sendReceiveStatService->getTableTotalData( $totalData );
		
		$avgData = $sendReceiveStatService->getAverageData( count( $statData ), $totalData );
		$avgUnit = $this->getAverageUnit( $by );
		
		$flowChartParam = $this->getSendReceiveFlowChartParm( $statData, $by, $begin, $end );
		$numChartParam = $this->getSendReceiveNumChartParm( $statData, $by, $begin, $end );
		$myofcChart = new OpenFlashChart();
		if ($picType === "line") {
			$flowChartData = $myofcChart->drawLineChart( $flowChartParam );
			$numChartData = $myofcChart->drawLineChart( $numChartParam );
		} else {
			$flowChartData = $myofcChart->drawBarChart( $flowChartParam );
			$numChartData = $myofcChart->drawBarChart( $numChartParam );
		}
             * 
             */
		$template = new TemplateEngine();
                /**
		if ($type == "detail") {
			$template->assign( 'begin_date', $begin );
			$template->assign( 'end_date', $end );
			$template->assign( 'by_type', $by );
			$template->assign( 'mail_box', PunyCode::decode( $mailbox ) );
		} else {
			$template->assign( 'begin_date', date( "Y-m" ) . "-01" );
			$template->assign( 'end_date', date( "Y-m-d" ) );
			$template->assign( 'by_type', "day" );
			$template->assign( 'mail_box', "" );
		}
		$template->assign( 'pic_type', $picType );
		$template->assign( 'stat_type', $type );
		$template->assign( 'avg_data', $avgData );
		$template->assign( 'avg_unit', $avgUnit );
		$template->assign( 'table_data', $tableData );
		$template->assign( 'table_total', $tableTotal );
		$template->assign( 'flow_chart_data', $flowChartData );
		$template->assign( 'num_chart_data', $numChartData );
                 * 
                 */
		$template->display( "send_receive_stat.tpl" );
	}

	/**
	 * 判断用户是否存在
	 */
	public function checkMailExist() {
		$mailbox = urldecode( $this->getParamFromRequest( 'mailbox' ) );
		$mailbox = PunyCode::encode( $mailbox );
		$mailboxService = ServiceFactory::getMailboxService();
		$aRecord = $mailboxService->getMailboxByUsername( $mailbox );
		if ($aRecord) {
			$this->ajaxReturn( $aRecord, "", 1 );
		} else {
			$this->ajaxReturn( $aRecord, $this->getText( "statistics_user_not_exist" ), 0 );
		}
	}

	/**
	 * 导出邮件收发统计报表
	 */
	public function exportSendReceiveReport() {
		$filename = $this->getText( "statistics_export_filename" );
		$info = $this->getText( "statistics_send_rcpt_title" );
		$titles = array (
				$this->getText( "statistics_rec_date" ), 
				$this->getText( "statistics_send_flow" ), 
				$this->getText( "statistics_send_num" ), 
				$this->getText( "statistics_send_flow_success" ), 
				$this->getText( "statistics_send_num_success" ), 
				$this->getText( "statistics_send_num_fail" ), 
				$this->getText( "statistics_send_success_rate" ), 
				$this->getText( "statistics_avg_send_flow" ), 
				$this->getText( "statistics_max_send_flow" ), 
				$this->getText( "statistics_rcpt_flow" ), 
				$this->getText( "statistics_rcpt_num" ) );
		$exportData = $this->getSendReceiveReportData();
		$contents = $this->formatSendReceiveData( $exportData );
		$objPHPExcel = PHPExcelUtil::writeExcel( $excelPath = 'php://output', $type = 'Excel5', $titles, $contents, $info, $filename );
	}

	/**
	 * 获取邮件收发统计数据
	 */
	private function getSendReceiveReportData() {
		$sendReceiveStatService = ServiceFactory::getSendReceiveStatService();
		$type = $this->getParamFromRequest( 'type', 'month' ); // 当月统计等
		$defautBy = $this->getDefaultByWhat( $type );
		$by = $this->getParamFromRequest( 'by', $defautBy ); // 按日统计等
		if ($type == "month" || $type == "season" || $type == "year") {
			$timeData = $this->getDefaultTimeData( $type );
			$begin = $timeData ["begin"];
			$end = $timeData ["end"];
			$param = array ();
		} else {
			$begin = $this->getParamFromRequest( 'begin' );
			$end = $this->getParamFromRequest( 'end' );
			$mailbox = $this->getParamFromRequest( 'mailbox' );
			$param ["begin"] = $begin;
			$param ["end"] = $end;
			$param ["mailbox"] = $mailbox;
		}
		$statData = $sendReceiveStatService->getSendReceiveStatData( $type, $by, $param );
		$exportData = array ();
		$tableData = $sendReceiveStatService->getTableData( $statData );
		$totalData = $sendReceiveStatService->getTotalData( $statData );
		$tableTotalData = $sendReceiveStatService->getTableTotalData( $totalData );
		
		$exportData ["tableData"] = $tableData;
		$exportData ["tableTotalData"] = $tableTotalData;
		return $exportData;
	}

	/**
	 * 组装邮局收发统计报表数据
	 */
	private function formatSendReceiveData($exportData) {
		$tableData = $exportData ["tableData"];
		$tableTotalData = $exportData ["tableTotalData"];
		$size = sizeof( $tableData );
		for($i = 0; $i < $size; $i ++) {
			$exportFormatData [$i] [0] = $tableData [$i] ['rec_date'];
			$exportFormatData [$i] [1] = $tableData [$i] ['send_size'];
			$exportFormatData [$i] [2] = $tableData [$i] ['send_all'];
			$exportFormatData [$i] [3] = $tableData [$i] ['sent_size'];
			$exportFormatData [$i] [4] = $tableData [$i] ['send_success'];
			$exportFormatData [$i] [5] = $tableData [$i] ['send_failed'];
			$exportFormatData [$i] [6] = $tableData [$i] ['send_rate'];
			$exportFormatData [$i] [7] = $tableData [$i] ['send_avg'];
			$exportFormatData [$i] [8] = $tableData [$i] ['send_top'];
			$exportFormatData [$i] [9] = $tableData [$i] ['rcpt_size'];
			$exportFormatData [$i] [10] = $tableData [$i] ['rcpt_all'];
		}
		$exportFormatData [$size] [0] = $this->getText( "statistics_total" );
		$exportFormatData [$size] [1] = $tableTotalData ['send_size'];
		$exportFormatData [$size] [2] = $tableTotalData ['send_all'];
		$exportFormatData [$size] [3] = $tableTotalData ['sent_size'];
		$exportFormatData [$size] [4] = $tableTotalData ['send_success'];
		$exportFormatData [$size] [5] = $tableTotalData ['send_failed'];
		$exportFormatData [$size] [6] = $tableTotalData ['send_rate'];
		$exportFormatData [$size] [7] = $tableTotalData ['send_avg'];
		$exportFormatData [$size] [8] = $tableTotalData ['send_top'];
		$exportFormatData [$size] [9] = $tableTotalData ['rcpt_size'];
		$exportFormatData [$size] [10] = $tableTotalData ['rcpt_all'];
		return $exportFormatData;
	}

	/**
	 * 用户访问统计
	 */
	public function visitorInfoStat() {
            /**
		$visitorInfoStatService = ServiceFactory::getVisitorInfoStatService();
		$type = $this->getParamFromRequest( 'type', 'month' ); // 当月统计等
		$defautBy = $this->getDefaultByWhat( $type );
		$by = $this->getParamFromRequest( 'by', $defautBy ); // 按日统计等
		$picType = $this->getParamFromRequest( "pictype", "line" );
		if ($type == "month" || $type == "season" || $type == "year") {
			$timeData = $this->getDefaultTimeData( $type );
			$begin = $timeData ["begin"];
			$end = $timeData ["end"];
			$param = array ();
		} else {
			$begin = $this->getParamFromRequest( 'begin' );
			$end = $this->getParamFromRequest( 'end' );
			$mailbox = PunyCode::encode( $this->getParamFromRequest( 'mailbox' ) );
			$param ["begin"] = $begin;
			$param ["end"] = $end;
			$param ["mailbox"] = $mailbox;
		}
		$statData = $visitorInfoStatService->getVistorInfoStatData( $type, $by, $param );
		
		$tableTotal = $visitorInfoStatService->getTotalData( $statData );
		
		$chartParam = $this->getVisitorInfoChartParm( $statData, $by, $begin, $end );
		$myofcChart = new OpenFlashChart();
		if ($picType === "line") {
			$chartData = $myofcChart->drawLineChart( $chartParam );
		} else {
			$chartData = $myofcChart->drawBarChart( $chartParam );
		}
		$template = new TemplateEngine();
		if ($type == "detail") {
			$template->assign( 'begin_date', $begin );
			$template->assign( 'end_date', $end );
			$template->assign( 'by_type', $by );
			$template->assign( 'mail_box', PunyCode::decode( $mailbox ) );
		} else {
			$template->assign( 'begin_date', date( "Y-m" ) . "-01" );
			$template->assign( 'end_date', date( "Y-m-d" ) );
			$template->assign( 'by_type', "day" );
			$template->assign( 'mail_box', "" );
		}
		$template->assign( 'pic_type', $picType );
		$template->assign( 'stat_type', $type );
		$template->assign( 'table_data', $statData );
		$template->assign( 'table_total', $tableTotal );
		$template->assign( 'chart_data', $chartData );
             * 
             */
                $template = new TemplateEngine();
		$template->display( "visitor_info_stat.tpl" );
	}

	/**
	 * 获取用户访问数量统计图表参数
	 * 
	 * @param $statData 统计数据
	 * @param $by 按（日，月，年）查询
	 * @param $begin 开始时间
	 * @param $end 结束时间
	 */
	private function getVisitorInfoChartParm($statData, $by, $begin, $end) {
		$timeStr = $this->getTitleTimeStr( $by, $begin, $end );
		$title = $this->getText( "statistics_visitor_info_title" ) . $timeStr;
		$noData = $this->getText( "statistics_nodata" );
		$tip = array (
				$this->getText( "statistics_visitor_info_pop" ), 
				$this->getText( "statistics_visitor_info_imap" ), 
				$this->getText( "statistics_visitor_info_smtp" ), 
				$this->getText( "statistics_visitor_info_web" ) );
		$color = array ("#ff0000", "#0000ff", "#00ff00", "#eac100" );
		$unit = $this->getText( "statistics_visitor_info_unit" );
		$legend = $this->getChartLegend( $by );
		$tmpMaxNumArr = array (); // 计算xy轴用
		$datatotalnum = 0; // 数据总数
		/*
		 * 图表数据
		 */
		$xlabel_data = array ();
		$pop = array ();
		$imap = array ();
		$web = array ();
		$smtp = array ();
		foreach ( $statData as $myline ) {
			$tmponeline = array ();
			$tmponeline ["pop"] = intval( $myline ['pop'] ? $myline ['pop'] : 0 );
			$tmponeline ["web"] = intval( $myline ['web'] ? $myline ['web'] : 0 );
			$tmponeline ["imap"] = intval( $myline ['imap'] ? $myline ['imap'] : 0 );
			$tmponeline ["smtp"] = intval( $myline ['smtp'] ? $myline ['smtp'] : 0 );
			$tmpMaxNumArr [] = max( $tmponeline );
			$tmponeline ['time'] = substr( $myline ['rec_date'], 0, 10 );
			
			$xlabel_data [] = $tmponeline ['time'];
			$pop [] = $tmponeline ['pop'];
			$web [] = $tmponeline ['web'];
			$imap [] = $tmponeline ['imap'];
			$smtp [] = $tmponeline ['smtp'];
			$datatotalnum ++;
		}
		$contentData = array ($pop, $imap, $smtp, $web );
		$count = $datatotalnum;
		/*
		 * 计算图形轴线
		 */
		if (empty( $tmpMaxNumArr )) {
			$tmpmaxval = 10;
		} else {
			$tmpmaxval = max( $tmpMaxNumArr );
		}
		$maxVal = $tmpmaxval;
		$xlabel = $xlabel_data;
		$chartParam ["title"] = $title;
		$chartParam ["noData"] = $noData;
		$chartParam ["contentData"] = $contentData;
		$chartParam ["count"] = $count;
		$chartParam ["maxVal"] = $maxVal;
		$chartParam ["tip"] = $tip;
		$chartParam ["color"] = $color;
		$chartParam ["unit"] = $unit;
		$chartParam ["xlabel"] = $xlabel;
		$chartParam ["legend"] = $legend;
		return $chartParam;
	}

	/**
	 * 导出用户访问统计报表
	 */
	public function exportVisitorInfoReport() {
		$filename = $this->getText( "statistics_export_filename" );
		$info = $this->getText( "statistics_visitor_info_title" );
		$titles = array (
				$this->getText( "statistics_rec_date" ), 
				$this->getText( "statistics_visitor_info_pop" ), 
				$this->getText( "statistics_visitor_info_imap" ), 
				$this->getText( "statistics_visitor_info_smtp" ), 
				$this->getText( "statistics_visitor_info_web" ) );
		$exportData = $this->getVisitorInfoReportData();
		$contents = $this->formatVisitorInfoData( $exportData );
		$objPHPExcel = PHPExcelUtil::writeExcel( $excelPath = 'php://output', $type = 'Excel5', $titles, $contents, $info, $filename );
	}

	/**
	 * 获取用户访问统计数据
	 */
	private function getVisitorInfoReportData() {
		$visitorInfoStatService = ServiceFactory::getVisitorInfoStatService();
		$type = $this->getParamFromRequest( 'type', 'month' ); // 当月统计等
		$defautBy = $this->getDefaultByWhat( $type );
		$by = $this->getParamFromRequest( 'by', $defautBy ); // 按日统计等
		$picType = $this->getParamFromRequest( "pictype", "line" );
		if ($type == "month" || $type == "season" || $type == "year") {
			$timeData = $this->getDefaultTimeData( $type );
			$begin = $timeData ["begin"];
			$end = $timeData ["end"];
			$param = array ();
		} else {
			$begin = $this->getParamFromRequest( 'begin' );
			$end = $this->getParamFromRequest( 'end' );
			$mailbox = PunyCode::encode( $this->getParamFromRequest( 'mailbox' ) );
			$param ["begin"] = $begin;
			$param ["end"] = $end;
			$param ["mailbox"] = $mailbox;
		}
		$statData = $visitorInfoStatService->getVistorInfoStatData( $type, $by, $param );
		$tableTotal = $visitorInfoStatService->getTotalData( $statData );
		$exportData ["tableData"] = $statData;
		$exportData ["tableTotalData"] = $tableTotal;
		return $exportData;
	}

	/**
	 * 组装用户访问统计报表数据
	 */
	private function formatVisitorInfoData($exportData) {
		$tableData = $exportData ["tableData"];
		$tableTotalData = $exportData ["tableTotalData"];
		$size = sizeof( $tableData );
		for($i = 0; $i < $size; $i ++) {
			$exportFormatData [$i] [0] = $tableData [$i] ['rec_date'];
			$exportFormatData [$i] [1] = $tableData [$i] ['pop'];
			$exportFormatData [$i] [2] = $tableData [$i] ['imap'];
			$exportFormatData [$i] [3] = $tableData [$i] ['smtp'];
			$exportFormatData [$i] [4] = $tableData [$i] ['web'];
		}
		$exportFormatData [$size] [0] = $this->getText( "statistics_total" );
		$exportFormatData [$size] [1] = $tableTotalData ['pop'];
		$exportFormatData [$size] [2] = $tableTotalData ['imap'];
		$exportFormatData [$size] [3] = $tableTotalData ['smtp'];
		$exportFormatData [$size] [4] = $tableTotalData ['web'];
		return $exportFormatData;
	}

	/**
	 * 邮件大小
	 */
	public function mailsize() {
		$statisticsService = ServiceFactory::getStatisticsService();
		$listPage = $this->getQueryPage( array ("pageSize" => 20 ) );
		$template = new TemplateEngine();
		
		$yestoday = $startDate = $endDate = date( 'Y-m-d', time() - 86400 );
		
		$lineOrBarGraph = 'line';
		$percent = 0;
		if ($listPage->getQueryParamValue( 'search' )) {
			$startDate = $listPage->getQueryParamValue( 'start_date' );
			$endDate = $listPage->getQueryParamValue( 'end_date' );
			if (! $startDate || ! $endDate) {
				$this->showErrorMessage( $this->getText( 'statistics_choose_time' ), $this->createUrl( '' ) );
			}
			
			$percent = $listPage->getQueryParamValue( 'percent' ) ? 1 : 0;
			$timePeriod = $listPage->getQueryParamValue( 'time_period' );
			$sendOrReceive = $listPage->getQueryParamValue( 'send_or_receive' );
			$lineOrBarGraph = $listPage->getQueryParamValue( 'line_or_bar', 'line' );
			
			$condition = 'rec_date >= :start_date and rec_date <= :end_date and isrcpt=:isrcpt';
			$params = array (
					':start_date' => $startDate, 
					':end_date' => $endDate, 
					':isrcpt' => $sendOrReceive == 'send' ? 0 : 1 );
			
			$template->assign( "check_$percent", 'checked' );
			$template->assign( "check_$lineOrBarGraph", 'checked' );
			$template->assign( "select_$timePeriod", 'selected' );
			$template->assign( "select_$sendOrReceive", 'selected' );
		} else {
			$condition = 'rec_date >= :rec_date and isrcpt=0';
			$params = array (':rec_date' => $yestoday );
		}
		
		$infos = $statisticsService->getMailSizeListPage( $listPage, $condition, $params );
		$infos = $infos ? $infos : array ();
		$template->assign( 'listPage', $listPage );
		
		$dataTotalNum = 0;
		
		$maxNumArray = $minNumArray = $mailDateArray = $mailSizeArray = array ();
		$contents = array (0 => array () );
		
		$mail5KSize = $mail10KSize = $mail50KSize = $mail100KSize = $mail500KSize = array ();
		$mail1MSize = $mail5MSize = $mail10MSize = $mailMoreSize = $mailAllSize = array ();
		
		$mail5KTotal = $mail10KTotal = $mail50KTotal = $mail100KTotal = $mail500KTotal = 0;
		$mail1MTotal = $mail5MTotal = $mail10MTotal = $mailMoreTotal = $mailAllTotal = 0;
		
		if ($percent) {
			foreach ( $infos as $key => $info ) {
				foreach ( $info as $k => $value ) {
					if ($k == 'rec_date' || $k == 'isrcpt') {
						continue;
					}
					$infos [$key] [$k] = $info ['sum_all'] ? $this->percentRound( $value, $info ['sum_all'] ) : '0%';
				}
			}
		}
		
		$data = $statisticsService->getMailSizeList( $condition, $params );
		$dataTotalNum = count( $data );
		foreach ( $data as $key => $value ) {
			unset( $value ['isrcpt'] );
			
			$mailDateArray [] = $value ['rec_date'];
			$mail5KSize [] = intval( $value ['sum_5k'] );
			$mail10KSize [] = intval( $value ['sum_10k'] );
			$mail50KSize [] = intval( $value ['sum_50k'] );
			$mail100KSize [] = intval( $value ['sum_100k'] );
			$mail500KSize [] = intval( $value ['sum_500k'] );
			$mail1MSize [] = intval( $value ['sum_1m'] );
			$mail5MSize [] = intval( $value ['sum_5m'] );
			$mail10MSize [] = intval( $value ['sum_10m'] );
			$mailMoreSize [] = intval( $value ['sum_more'] );
			$mailAllSize [] = intval( $value ['sum_all'] );
			
			$mail5KTotal += $value ['sum_5k'];
			$mail10KTotal += $value ['sum_10k'];
			$mail50KTotal += $value ['sum_50k'];
			$mail100KTotal += $value ['sum_100k'];
			$mail500KTotal += $value ['sum_500k'];
			$mail1MTotal += $value ['sum_1m'];
			$mail5MTotal += $value ['sum_5m'];
			$mail10MTotal += $value ['sum_10m'];
			$mailMoreTotal += $value ['sum_more'];
			$mailAllTotal += $value ['sum_all'];
			
			if ($this->getParamFromRequest( 'download' )) {
				if ($percent) {
					if ($value ['sum_all']) {
						$contents [] = array (
								$value ['rec_date'], 
								$this->percentRound( $value ['sum_5k'], $value ['sum_all'] ), 
								$this->percentRound( $value ['sum_10k'], $value ['sum_all'] ), 
								$this->percentRound( $value ['sum_50k'], $value ['sum_all'] ), 
								$this->percentRound( $value ['sum_100k'], $value ['sum_all'] ), 
								$this->percentRound( $value ['sum_500k'], $value ['sum_all'] ), 
								$this->percentRound( $value ['sum_1m'], $value ['sum_all'] ), 
								$this->percentRound( $value ['sum_5m'], $value ['sum_all'] ), 
								$this->percentRound( $value ['sum_10m'], $value ['sum_all'] ), 
								$this->percentRound( $value ['sum_more'], $value ['sum_all'] ), 
								'100%' );
					} else {
						$contents [] = array (
								$value ['rec_date'], 
								'0%', 
								'0%', 
								'0%', 
								'0%', 
								'0%', 
								'0%', 
								'0%', 
								'0%', 
								'0%', 
								'0%' );
					}
				} else {
					$contents [] = array (
							$value ['rec_date'], 
							$value ['sum_5k'], 
							$value ['sum_10k'], 
							$value ['sum_50k'], 
							$value ['sum_100k'], 
							$value ['sum_500k'], 
							$value ['sum_1m'], 
							$value ['sum_5m'], 
							$value ['sum_10m'], 
							$value ['sum_more'], 
							$value ['sum_all'] );
				}
			}
			
			unset( $value ['rec_date'] );
			$maxNumArray [] = max( $value );
			$minNumArray [] = min( $value );
		}
		
		if ($this->getParamFromRequest( 'download' )) {
			if ($percent) {
				if ($mailAllTotal) {
					$contents [0] = array (
							$this->getText( 'statistics_mailsize_total' ), 
							$this->percentRound( $mail5KTotal, $mailAllTotal ), 
							$this->percentRound( $mail10KTotal, $mailAllTotal ), 
							$this->percentRound( $mail50KTotal, $mailAllTotal ), 
							$this->percentRound( $mail100KTotal, $mailAllTotal ), 
							$this->percentRound( $mail500KTotal, $mailAllTotal ), 
							$this->percentRound( $mail1MTotal, $mailAllTotal ), 
							$this->percentRound( $mail5MTotal, $mailAllTotal ), 
							$this->percentRound( $mail10MTotal, $mailAllTotal ), 
							$this->percentRound( $mailMoreTotal, $mailAllTotal ), 
							'100%' );
				} else {
					$contents [0] = array (
							$this->getText( 'statistics_mailsize_total' ), 
							'0%', 
							'0%', 
							'0%', 
							'0%', 
							'0%', 
							'0%', 
							'0%', 
							'0%', 
							'0%', 
							'0%' );
				}
			} else {
				$contents [0] = array (
						$this->getText( 'statistics_mailsize_total' ), 
						$mail5KTotal, 
						$mail10KTotal, 
						$mail50KTotal, 
						$mail100KTotal, 
						$mail500KTotal, 
						$mail1MTotal, 
						$mail5MTotal, 
						$mail10MTotal, 
						$mailMoreTotal, 
						$mailAllTotal );
			}
		}
		
		$mailSizeArray = array (
				$mail5KSize, 
				$mail10KSize, 
				$mail50KSize, 
				$mail100KSize, 
				$mail500KSize, 
				$mail1MSize, 
				$mail5MSize, 
				$mail10MSize, 
				$mailMoreSize, 
				$mailAllSize );
		
		if ($percent) {
			if ($mailAllTotal == '0') {
				$mail5KTotal = $mail10KTotal = $mail50KTotal = $mail100KTotal = $mail500KTotal = '0%';
				$mail1MTotal = $mail5MTotal = $mail10MTotal = '0%';
				$mailMoreTotal = $mailAllTotal = '0%';
			} else {
				$mail5KTotal = $this->percentRound( $mail5KTotal, $mailAllTotal );
				$mail10KTotal = $this->percentRound( $mail10KTotal, $mailAllTotal );
				$mail50KTotal = $this->percentRound( $mail50KTotal, $mailAllTotal );
				$mail100KTotal = $this->percentRound( $mail100KTotal, $mailAllTotal );
				$mail500KTotal = $this->percentRound( $mail500KTotal, $mailAllTotal );
				$mail1MTotal = $this->percentRound( $mail1MTotal, $mailAllTotal );
				$mail5MTotal = $this->percentRound( $mail5MTotal, $mailAllTotal );
				$mail10MTotal = $this->percentRound( $mail10MTotal, $mailAllTotal );
				$mailMoreTotal = $this->percentRound( $mailMoreTotal, $mailAllTotal );
				$mailAllTotal = '100%';
			}
		}
		
		if ($this->getParamFromRequest( 'download' )) {
			$this->exportMailSizeReport( $contents );
		}
		
		$totalInfos = array (
				'sum_5k_total' => $mail5KTotal, 
				'sum_10k_total' => $mail10KTotal, 
				'sum_50k_total' => $mail50KTotal, 
				'sum_100k_total' => $mail100KTotal, 
				'sum_500k_total' => $mail500KTotal, 
				'sum_1m_total' => $mail1MTotal, 
				'sum_5m_total' => $mail5MTotal, 
				'sum_10m_total' => $mail10MTotal, 
				'sum_more_total' => $mailMoreTotal, 
				'sum_all_total' => $mailAllTotal );
		
		$maxCount = $maxNumArray ? max( $maxNumArray ) : 0;
		$chartData = $this->getMailSizeFlashChartData( $lineOrBarGraph, $mailDateArray, $mailSizeArray, $maxCount, $dataTotalNum, $startDate, $endDate );
		
		$template->assign( 'totalInfos', $totalInfos );
		$template->assign( 'infos', $infos );
		
		$template->assign( 'chart_data', $chartData );
		$template->assign( 'line_or_bar_graph', $lineOrBarGraph );
		
		$template->assign( 'yestoday', $yestoday );
		$template->assign( 'format_yestoday', date( "m/d/Y", time() - 86400 ) );
		$template->assign( 'start_date', $startDate );
		$template->assign( 'end_date', $endDate );
		
		$template->assign( 'search_url', $this->createUrl( 'mailsize' ) );
		
		$currentPage = $listPage->getQueryInfo()->getCurrentPageno();
		$template->assign( 'report_data', array (
				'search' => $listPage->getQueryParamValue( 'search' ), 
				'download' => '1', 
				'start_date' => $startDate, 
				'end_date' => $endDate, 
				'percent' => $listPage->getQueryParamValue( 'percent' ) ? 1 : 0, 
				'send_or_receive' => $listPage->getQueryParamValue( 'send_or_receive' ), 
				'time_period' => $listPage->getQueryParamValue( 'time_period' ), 
				'pageno' => max( $currentPage, 1 ) ) );
		$template->assign( 'report_url', $this->createUrl( 'mailsize', array ('pageno' => max( $currentPage, 1 ) ) ) );
		
		$template->display( 'statistics_mailsize.tpl' );
	}

	/**
	 * 获取百分比
	 * 
	 * @param $value int
	 * @param $sum int
	 * @return string
	 */
	private function percentRound($value, $sum) {
		$percent = (100 * round( $value / $sum, 4 )) . '%';
		return $percent;
	}

	/**
	 * 配置FlashChart数据
	 * 
	 * @param $mailDateArray array 时间数组
	 * @param $mailSizeArray array 数据
	 * @param $maxNum int 最大值
	 * @param $dataTotalNum int 数据行数
	 * @param $begin string 开始时间
	 * @param $end string 结束时间
	 * @return array
	 */
	private function getMailSizeFlashChartData($lineOrBarGraph, $mailDateArray, $mailSizeArray, $maxNum, $dataTotalNum, $begin, $end) {
		$timeString = $this->getTitleTimeStr( '', $begin, $end );
		$title = $this->getText( "statistics_mailsize_stat" ) . $timeString;
		$noData = $this->getText( "statistics_nodata" );
		$tip = array (
				'0-5K', 
				'5-10K', 
				'10-50K', 
				'50-100K', 
				'100-500K', 
				'500K-1M', 
				'1M-5M', 
				'5M-10M', 
				'> 10M', 
				$this->getText( 'statistics_total' ) );
		$color = array (
				'#99cc00', 
				'#01a206', 
				'#ff9900', 
				'#0070c2', 
				'#990000', 
				'#66ccff', 
				'#ffcc00', 
				'#999999', 
				'#990099', 
				'#ED2704' );
		$unit = $this->getText( "statistics_mailsize_unit" );
		$legend = $this->getChartLegend( 'day' );
		$chartParam = array (
				'title' => $title, 
				'noData' => $noData, 
				'contentData' => $mailSizeArray, 
				'count' => $dataTotalNum, 
				'maxVal' => $maxNum, 
				'tip' => $tip, 
				'color' => $color, 
				'unit' => $unit, 
				'xlabel' => $mailDateArray, 
				'legend' => $legend );
		$openFlashChart = new OpenFlashChart();
		if ($lineOrBarGraph == "line") {
			$chartData = $openFlashChart->drawLineChart( $chartParam );
		} else {
			$chartData = $openFlashChart->drawBarChart( $chartParam );
		}
		return $chartData;
	}

	/**
	 * 导出邮件大小报表
	 */
	private function exportMailSizeReport($contents) {
		$filename = $this->getText( "statistics_export_filename" );
		$info = $this->getText( "statistics_mailsize_stat" );
		$titles = array (
				$this->getText( 'statistics_mailsize_date' ), 
				'0-5K', 
				'5-10K', 
				'10-50K', 
				'50-100K', 
				'100-500K', 
				'500-1M', 
				'1-5M', 
				'5-10M', 
				'> 10M', 
				$this->getText( 'statistics_mailsize_total' ) );
		PHPExcelUtil::writeExcel( 'php://output', 'Excel5', $titles, $contents, $info, $filename );
	}

}