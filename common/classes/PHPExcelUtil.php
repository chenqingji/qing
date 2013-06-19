<?php
require_once (Yii::getFrameworkPath() . '/../plugins/PHPExcel/PHPExcel.php');
/**
 * Excel表格操作封装
 */
class PHPExcelUtil {

	/**
	 * 数据写入excel
	 * 
	 * @param $excelPath string
	 * @param $type string
	 * @param $titles array()
	 * @param $contents array(array())
	 * @param $title string sheet标题
	 * @param $filename string 文件名
	 */
	public static function writeExcel($excelPath = '', $type = 'Excel5', $titles = array(), $contents = array(array()), $title = '', $filename = '') {
		$PHPExcel = new PHPExcel();
		$rownum = count( $titles );
		$columnnum = count( $contents );
		/**
		 * 设置头文件
		 */
		for($currentRownum = 0; $currentRownum < $rownum; $currentRownum ++) {
			$PHPExcel->setActiveSheetIndex()->setCellValue( chr( 65 + $currentRownum ) . '1', $titles [$currentRownum] );
		}
		/**
		 * 设置内容区
		 */
		for($i = 0; $i < $columnnum; $i ++) {
			for($currentRownum = 0; $currentRownum < $rownum; $currentRownum ++) {
				$PHPExcel->setActiveSheetIndex()->setCellValue( chr( 65 + $currentRownum ) . ($i + 2), $contents [$i] [$currentRownum] );
			}
		}
		$PHPExcel->getActiveSheet()->setTitle( $title );
		$PHPExcel->setActiveSheetIndex( 0 );
		
		if (preg_match( '/IE/', $_SERVER ['HTTP_USER_AGENT'] )) {
			$filename = rawurlencode( $filename );
		}
		header( 'Content-Type: application/vnd.ms-excel' );
		header( 'Content-Disposition: attachment;filename="' . $filename . '.xls"' );
		header( "Pragma: public" );
		header( "Cache-Control: no-store, max-age=0, no-cache, must-revalidate" ); // HTTP/1.1
		header( "Cache-Control: post-check=0, pre-check=0", false );
		header( "Cache-Control: private" );
		$PHPWriter = PHPExcel_IOFactory::createWriter( $PHPExcel, $type );
		$PHPWriter->save( $excelPath );
	}

}
?>
