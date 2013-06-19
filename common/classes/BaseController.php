<?php

/**
 * 该类继承自框架的控制器类。隔离了应用控制器类直接跟框架耦合的问题。
 * 如果框架发生变动，需要重写该类
 * 
 * @author jm
 */
class BaseController extends CController {

	/**
	 * 普通form查询类型
	 */
	const FORM_QUERY = 1;

	/**
	 * 分页查询类型
	 */
	const PAGE_QUERY = 2;

	/**
	 * 排序查询类型
	 */
	const SORT_QUERY = 3;

	/**
	 * 返回页面查询
	 */
	const BACK_QUERY = 4;

	/**
	 * 重写原创建action方法，使用CInlineActionEx生成action对象，借以支持不加前缀的action方法
	 * 
	 * @see CController::createAction()
	 */
	public function createAction($actionID) {
		if ($actionID === '')
			$actionID = $this->defaultAction;
		if (method_exists( $this, $actionID ) && strcasecmp( $actionID, 's' )) // we
		                                                                       // have
		                                                                       // actions
		                                                                       // method
			return new CInlineActionEx( $this, $actionID );
		else {
			$action = $this->createActionFromMap( $this->actions(), $actionID, $actionID );
			if ($action !== null && ! method_exists( $action, 'run' ))
				throw new CException( Yii::t( 'yii', 'Action class {class} must implement the "run" method.', array (
						'{class}' => get_class( $action ) ) ) );
			return $action;
		}
	}

	/**
	 * 获取当前信息在当前语言下的国际化信息
	 */
	protected function getText($msg, $replace = array()) {
		return I18nHelper::getText( $msg, $replace );
	}

	/**
	 * 从request获取参数
	 * 
	 * @param $paramName 参数名称
	 * @param $defaultValue 默认值
	 * @return string
	 */
	protected function getParamFromRequest($paramName, $defaultValue = null) {
		$request = Yii::app()->getRequest();
		return $request->getParam( $paramName, $defaultValue );
	}

	/**
	 * 生成查询分页对象
	 * 
	 * @return ListPage
	 */
	protected function getQueryPage($pageParam = array()) {
		$queryInfo = $this->getQueryInfoFromSession();
		if ($queryInfo == null) {
			$queryInfo = new QueryInfo();
			if (array_key_exists( "defaultSortKey", $pageParam )) {
				$queryInfo->setSortKey( $pageParam ["defaultSortKey"] );
			}
			if (array_key_exists( "defaultSortType", $pageParam )) {
				$queryInfo->setSortType( $pageParam ["defaultSortType"] );
			}
		}
		
		$queryType = $this->getQueryType();
		switch ($queryType) {
			case self::FORM_QUERY :
				$queryInfo->setRequestParams( $_REQUEST );
				$queryInfo->setCurrentPageno( 1 );
				break;
			case self::PAGE_QUERY :
				$queryInfo->setCurrentPageno( $this->getParamFromRequest( "pageno" ) );
				break;
			case self::SORT_QUERY :
				$queryInfo->setSortKey( $this->getParamFromRequest( "sortkey" ) );
				$queryInfo->setSortType( $this->getParamFromRequest( "sorttype" ) );
				break;
			case self::BACK_QUERY :
				break;
			default :
				throw new Exception( "错误的查询类型!" );
		}
		$this->saveQueryInfoIntoSession( $queryInfo );
		
		$pageSize = null;
		if (array_key_exists( "pageSize", $pageParam )) {
			$pageSize = $pageParam ["pageSize"];
		}
		$listPage = new ListPage( $pageSize );
		$listPage->setQueryInfo( $queryInfo );
		return $listPage;
	}

	/**
	 * 分页和排序查询时，从session中获取其他查询信息
	 */
	private function getQueryInfoFromSession() {
		$pageInfoArray = SessionUtils::getPageQueryInfo();
		if ($pageInfoArray != null) {
			$pageInfoKey = StringUtils::createPageQueryinfoSessionKey();
			if (array_key_exists( $pageInfoKey, $pageInfoArray )) {
				return $pageInfoArray [$pageInfoKey];
			}
		}
		return null;
	}

	/**
	 * 从queryinfo中获取查询条件数据
	 */
	public function getRequestValueFromQueryInfo($paramName) {
		$queryInfo = $this->getQueryInfoFromSession();
		if ($queryInfo == null) {
			throw new Exception( "queryinfo尚未初始化!" );
		}
		return $queryInfo->getRequestValueByParam( $paramName );
	}

	/**
	 * 保存查询条件到session中
	 */
	private function saveQueryInfoIntoSession($queryInfo) {
		$pageInfoArray = SessionUtils::getPageQueryInfo();
		if ($pageInfoArray === null) {
			$pageInfoArray = array ();
		}
		$pageInfoKey = StringUtils::createPageQueryinfoSessionKey();
		$pageInfoArray [$pageInfoKey] = $queryInfo;
		SessionUtils::setPageQueryInfo( $pageInfoArray );
	}

	/**
	 * 根据当前提交参数，判断当前查询类型
	 * 
	 * @return int 查询类型
	 */
	private function getQueryType() {
		if ($this->getParamFromRequest( "pageno" ) != null) {
			return self::PAGE_QUERY;
		}
		if ($this->getParamFromRequest( "sortkey" ) != null && $this->getParamFromRequest( "sorttype" )) {
			return self::SORT_QUERY;
		}
		if ($this->getParamFromRequest( "isback" ) == 1) {
			return self::BACK_QUERY;
		}
		return self::FORM_QUERY;
	}

	/**
	 * 创建返回url
	 */
	protected function createBackUrl($route) {
		return $this->createUrl( $route, array ("isback" => 1 ) );
	}
}

/**
 * 该类扩展自原Action类，重写了通过actionID获得action方法的方式，去掉了action前缀的方法名
 * 
 * @author jm
 */
class CInlineActionEx extends CInlineAction {

	/**
	 * Runs the action.
	 * The action method defined in the controller is invoked.
	 * This method is required by {@link CAction}.
	 */
	public function run() {
		$method = $this->getId();
		$this->getController()->$method();
	}

	/**
	 * Runs the action with the supplied request parameters.
	 * This method is internally called by {@link CController::runAction()}.
	 * 
	 * @param $params array the request parameters (name=>value)
	 * @return boolean whether the request parameters are valid
	 * @since 1.1.7
	 */
	public function runWithParams($params) {
		$methodName = $this->getId();
		$controller = $this->getController();
		$method = new ReflectionMethod( $controller, $methodName );
		if ($method->getNumberOfParameters() > 0)
			return $this->runWithParamsInternal( $controller, $method, $params );
		else
			return $controller->$methodName();
	}

}
