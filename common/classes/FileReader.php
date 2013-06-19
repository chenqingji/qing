<?php

/**
 * FileReader, 用于导入文件的解析
 * 
 * @author jm
 */
class FileReader {

	/**
	 * 获取Excel文件读取类
	 * 
	 * @return Spreadsheet_Excel_Reader
	 */
	public static function getExcelReader() {
		$excelComponentDir = FrameworkUtils::getRootPath() . '/plugins/excel/';
		require_once $excelComponentDir . 'oleread.inc';
		require_once $excelComponentDir . 'reader.php';
		return new Spreadsheet_Excel_Reader();
	}

	/**
	 * 解析excel文档生成数组
	 * 
	 * @param $filename string
	 * @param $outputEncoding string
	 * @param $sheetNum int
	 * @return array
	 */
	public static function parseExcelFile($filename, $outputEncoding = 'gb2312', $sheetNum = 0) {
		$reader = self::getExcelReader();
		$reader->setOutputEncoding( $outputEncoding );
		$reader->read( $filename );
		return $reader->sheets [$sheetNum] ['cells'];
	}

	/**
	 * 获取VCF格式文件读取类
	 * 
	 * @return VCard
	 */
	public static function getVcfReader() {
		require_once FrameworkUtils::getRootPath() . '/plugins/vcard/VCard.php';
		return new VCard();
	}

	/**
	 * 解析VCF文档生成对象数组
	 * 
	 * @param $lines array
	 * @return VCard数组
	 */
	public static function parseVcfFile(&$lines) {
		$cards = array ();
		$card = new VCard();
		while ( $card->parse( $lines ) ) {
			$property = $card->getProperty( 'N' );
			if (! $property) {
				return "";
			}
			$n = $property->getComponents();
			$tmp = array ();
			if ($n [3])
				$tmp [] = $n [3]; // Mr.
			if ($n [1])
				$tmp [] = $n [1]; // John
			if ($n [2])
				$tmp [] = $n [2]; // Quinlan
			if ($n [4])
				$tmp [] = $n [4]; // Esq.
			$ret = array ();
			if ($n [0])
				$ret [] = $n [0];
			$tmp = join( " ", $tmp );
			if ($tmp)
				$ret [] = $tmp;
			$key = join( ", ", $ret );
			$cards [$key] = $card;
			// MDH: Create new VCard to prevent overwriting previous one (PHP5)
			$card = new VCard();
		}
		ksort( $cards );
		return $cards;
	}

}
