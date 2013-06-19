<?php

require_once (Yii::getFrameworkPath() . '/../plugins/openflashchart/php-ofc-library/open-flash-chart.php');
set_include_path( get_include_path() . PATH_SEPARATOR . Yii::getFrameworkPath() . '/../plugins/openflashchart/php-ofc-library' );
/**
 * openflashchart辅助类
 * 
 * @author dengr
 */
class OpenFlashChart extends open_flash_chart {

	function __construct() {
		parent::__construct();
	}

	/**
	 * 画曲线图
	 * 
	 * @param $chartParam 图表参数
	 */
	public function drawLineChart($chartParam) {
		$title = $chartParam ["title"];
		$noData = $chartParam ["noData"];
		$contentData = $chartParam ["contentData"];
		$count = $chartParam ["count"];
		$maxVal = $chartParam ["maxVal"];
		$tip = $chartParam ["tip"];
		$color = $chartParam ["color"];
		$unit = $chartParam ["unit"];
		$xlabel = $chartParam ["xlabel"];
		$legend = $chartParam ["legend"];
		/*
		 * 生成flash统计图表
		 */
		$myofc_chart = new open_flash_chart();
		// 横轴3点(需求)
		$dis_steps_num = intval( floor( $count / 2 ) );
		
		$tmpmaxvlen = strlen( "" . intval( $maxVal ) );
		$i_maxval = intval( substr( "" . $maxVal, 0, 1 ) );
		
		if ($i_maxval > 5) {
			$myradix = pow( 10, $tmpmaxvlen - 1 ); // 基数
		} else if ($i_maxval > 2) {
			$myradix = intval( pow( 10, $tmpmaxvlen - 1 ) ) / 2;
		} else {
			$myradix = pow( 10, $tmpmaxvlen - 2 );
		}
		
		if ($myradix < 1) {
			$myradix = 1;
		}
		
		$myofc_title = new title();
		$myofc_title->text = $title;
		$myofc_chart->set_title( $myofc_title );
		
		$myofc_x_labels = new x_axis_labels();
		$myofc_x_labels->set_steps( $dis_steps_num );
		
		$xsize = count( $xlabel );
		if ($xsize > 0) {
			for($i = 0; $i < $xsize; $i ++) {
				if ($i == 0 || $i == $xsize - 1) {
					$v_x_label = new x_axis_label( $xlabel [$i], "#000000", "10", "" );
					$v_x_label->set_visible();
					$x_lables [] = $v_x_label;
				} else {
					$x_lables [] = $xlabel [$i];
				}
			}
		} else {
			$x_lables = array ("$noData" );
		}
		$myofc_x_labels->set_labels( $x_lables );
		
		$myofc_x = new x_axis();
		$myofc_x->set_labels( $myofc_x_labels );
		$myofc_x->set_colour( '#028bdb' ); // x轴线颜色
		$myofc_x->set_grid_colour( '#c6e5f8' ); // 单元格边颜色(也就是竖线)
		
		$myofc_chart->set_x_axis( $myofc_x );
		
		$myofc_y = new y_axis();
		$myofc_y->set_range( 0, ceil( $maxVal < 10 ? 10 : $maxVal ), $myradix );
		$myofc_y->set_grid_colour( '#c6e5f8' );
		$myofc_y->set_colour( '#028bdb' );
		$myofc_chart->set_y_axis( $myofc_y );
		
		$myofc_x_legend = new x_legend( "$legend" );
		$myofc_x_legend->set_style( "{font-size: 12px; color:#0000ff; font-family: Verdana; text-align: center;}" );
		$myofc_chart->set_x_legend( $myofc_x_legend );
		
		for($i = 0; $i < count( $tip ); $i ++) {
			$myofc_line = new line();
			$myofc_line->set_values( count( $contentData [$i] ) == 0 ? array (0 ) : $contentData [$i] );
			$myofc_line->set_tooltip( "#x_label# " . $tip [$i] . ": #val#" . $unit );
			$myofc_line->set_colour( "$color[$i]" );
			$myofc_line->set_key( "$tip[$i]", 12 );
			$myofc_chart->add_element( $myofc_line );
		}
		
		$myofc_chart->set_bg_colour( '#f5fbff' );
		/*
		 * 生成json
		 */
		return $myofc_chart->toString();
	}

	/**
	 * 柱状图
	 * 
	 * @param $chartParam 图表参数
	 */
	public function drawBarChart($chartParam) {
		$title = $chartParam ["title"];
		$noData = $chartParam ["noData"];
		$contentData = $chartParam ["contentData"];
		$count = $chartParam ["count"];
		$maxVal = $chartParam ["maxVal"];
		$tip = $chartParam ["tip"];
		$color = $chartParam ["color"];
		$unit = $chartParam ["unit"];
		$xlabel = $chartParam ["xlabel"];
		$legend = $chartParam ["legend"];
		/*
		 * 生成flash统计图表
		 */
		$myofc_chart = new open_flash_chart();
		// 横轴3点(需求)
		$dis_steps_num = intval( floor( $count / 2 ) );
		
		$tmpmaxvlen = strlen( "" . intval( $maxVal ) );
		$i_maxval = intval( substr( "" . $maxVal, 0, 1 ) );
		
		if ($i_maxval > 5) {
			$myradix = pow( 10, $tmpmaxvlen - 1 ); // 基数
		} else if ($i_maxval > 2) {
			$myradix = intval( pow( 10, $tmpmaxvlen - 1 ) ) / 2;
		} else {
			$myradix = pow( 10, $tmpmaxvlen - 2 );
		}
		
		if ($myradix < 1) {
			$myradix = 1;
		}
		
		$myofc_title = new title();
		$myofc_title->text = $title;
		$myofc_chart->set_title( $myofc_title );
		
		$myofc_x_labels = new x_axis_labels();
		$myofc_x_labels->set_steps( $dis_steps_num );
		$xsize = count( $xlabel );
		if ($xsize > 0) {
			for($i = 0; $i < $xsize; $i ++) {
				if ($i == 0 || $i == $xsize - 1) {
					$v_x_label = new x_axis_label( $xlabel [$i], "#000000", "10", "" );
					$v_x_label->set_visible();
					$x_lables [] = $v_x_label;
				} else {
					$x_lables [] = $xlabel [$i];
				}
			}
		} else {
			$x_lables = array ("$noData" );
		}
		$myofc_x_labels->set_labels( $x_lables );
		
		$myofc_x = new x_axis();
		$myofc_x->set_labels( $myofc_x_labels );
		$myofc_x->set_grid_colour( '#c6e5f8' ); // 单元格边颜色(也就是竖线)
		$myofc_x->set_colour( '#c0e2f7' );
		$myofc_x->set_3d( 16 );
		$myofc_chart->set_x_axis( $myofc_x );
		
		$myofc_y = new y_axis();
		$myofc_y->set_range( 0, ceil( $maxVal < 10 ? 10 : $maxVal ), $myradix );
		$myofc_y->set_grid_colour( '#c6e5f8' );
		$myofc_y->set_colour( '#028bdb' );
		$myofc_chart->set_y_axis( $myofc_y );
		
		$myofc_x_legend = new x_legend( "$legend" );
		$myofc_x_legend->set_style( "{font-size: 12px; color:#0000ff; font-family: Verdana; text-align: center;}" );
		$myofc_chart->set_x_legend( $myofc_x_legend );
		
		for($i = 0; $i < count( $tip ); $i ++) {
			$myofc_bar = new bar_3d();
			$myofc_bar->set_values( count( $contentData [$i] ) == 0 ? array (0 ) : $contentData [$i] );
			$myofc_bar->set_tooltip( "#x_label# " . $tip [$i] . ": #val#" . $unit );
			$myofc_bar->set_colour( "$color[$i]" );
			$myofc_bar->set_key( "$tip[$i]", 12 );
			$myofc_chart->add_element( $myofc_bar );
		}
		
		$myofc_chart->set_bg_colour( '#f5fbff' );
		/*
		 * 生成json
		 */
		return $myofc_chart->toString();
	}
}
