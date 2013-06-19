<?php
/**
 * 继承自yii日志路由基类,该类支持生成每天日志文件
 * 
 * @author jm
 */
class DayLogRoute extends CLogRoute {

	/**
	 *
	 * @var string directory storing log files
	 */
	private $_logPath;

	/**
	 *
	 * @var string log file name
	 */
	private $_logFile = 'application';

	/**
	 * Initializes the route.
	 * This method is invoked after the route is created by the route manager.
	 */
	public function init() {
		parent::init();
		if ($this->getLogPath() === null)
			$this->setLogPath( Yii::app()->getRuntimePath() );
	}

	/**
	 *
	 * @return string directory storing log files. Defaults to application
	 *         runtime path.
	 */
	public function getLogPath() {
		return $this->_logPath;
	}

	/**
	 *
	 * @param $value string directory for storing log files.
	 * @throws CException if the path is invalid
	 */
	public function setLogPath($value) {
		$this->_logPath = realpath( $value );
		if ($this->_logPath === false || ! is_dir( $this->_logPath ) || ! is_writable( $this->_logPath ))
			throw new CException( Yii::t( 'yii', 'CFileLogRoute.logPath "{path}" does not point to a valid directory. Make sure the directory exists and is writable by the Web server process.', array (
					'{path}' => $value ) ) );
	}

	/**
	 *
	 * @return string log file name. Defaults to 'application.log'.
	 */
	public function getLogFile() {
		return $this->_logFile . '.' . date( 'Y-m-d' );
	}

	/**
	 *
	 * @param $value string log file name
	 */
	public function setLogFile($value) {
		$this->_logFile = $value;
	}

	/**
	 * Saves log messages in files.
	 * 
	 * @param $logs array list of log messages
	 */
	protected function processLogs($logs) {
		$logFile = $this->getLogPath() . DIRECTORY_SEPARATOR . $this->getLogFile();
		$fp = @fopen( $logFile, 'a' );
		@flock( $fp, LOCK_EX );
		foreach ( $logs as $log )
			@fwrite( $fp, $this->formatLogMessage( $log [0], $log [1], $log [2], $log [3] ) );
		@flock( $fp, LOCK_UN );
		@fclose( $fp );
	}
}
