<?php

/**
 * sys端 统计分析--活跃用户
 * 
 * @author jm
 */
class ActiveController extends SysController {

	/**
	 * 活跃用户列表页及其搜索
	 */
	public function index() {
            /**
		$searchDate = $yesterday = date( "Y-m-d", time() - 86400 );
		$searchTimeSpan = 'day'; // 时间跨度
		
		if ($this->getParamFromRequest( 'action' ) == "search") {
			if (preg_match( "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", trim( $this->getParamFromRequest( 'searchday' ) ) )) {
				$searchDate = $this->getParamFromRequest( 'searchday' );
			}
			$searchTimeSpan = $this->getParamFromRequest( 'searchtimespan' );
		}
		
		$operator = $searchTimeSpan == '-1' ? '=' : '>=';
		$visitUserCount = ServiceFactory::getActiveUserService()->getUserVisitCount( $searchDate, $operator );
		
		$totalUserCount = ServiceFactory::getMailboxService()->getMailboxCount();
		$activePercent = $totalUserCount != 0 ? (round( $visitUserCount / $totalUserCount, 4 ) * 100) : '0';
		
		$template = new TemplateEngine();
		
		$template->assign( array (
				'yesterday' => $yesterday, 
				'yesterday_format' => date( "m/d/Y", time() - 86400 ), 
				'search_day' => $searchDate, 
				'total_user_count' => $totalUserCount, 
				'visit_user_count' => $visitUserCount, 
				'activity_percentage' => $activePercent . '%', 
				"select_$searchTimeSpan" => "selected", 
				'submit_url' => $this->createUrl( 'index', array ('action' => 'search' ) ) ) );
		
             * 
             */
                $template = new TemplateEngine();
		$template->display( 'active_index.tpl' );
	}
}