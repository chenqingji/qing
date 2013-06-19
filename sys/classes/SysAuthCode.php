<?php
/**
 * 验证码生成
 * 
 * @author jm
 */
class SysAuthCode {

	/**
	 * 绘画生成图片
	 */
	public static function drawAuthCode() {
		// 生成验证码图片
		Header( "Content-type: image/PNG" );
		srand( ( double ) microtime() * 1000000 ); // 播下一个生成随机数字的种子，以方便下面随机数生成的使用
		$im = imagecreate( 40, 16 ); // 制定图片背景大小
		
		$black = ImageColorAllocate( $im, 255, 255, 255 ); // 设定三种颜色
		$white = ImageColorAllocate( $im, 0, 60, 100 );
		$gray = ImageColorAllocate( $im, 22, 132, 89 );
		
		imagefill( $im, 0, 0, $gray ); // 采用区域填充法，设定（0,0）
		
		while ( ($authnum = rand() % 10000) < 1000 ) {
		}
		
		// 将四位整数验证码绘入图片
		SysSessionUtil::setAuthCode( $authnum );
		imagestring( $im, 5, 1, 0, $authnum, $black );
		// 用 col 颜色将字符串 s 画到 image 所代表的图像的 x，y 座标处（图像的左上角为 0, 0）。
		// 如果 font 是 1，2，3，4 或 5，则使用内置字体
		
		for($i = 0; $i < 200; $i ++) { // 加入干扰象素
			$randcolor = ImageColorallocate( $im, rand( 0, 255 ), rand( 0, 255 ), rand( 0, 255 ) );
			imagesetpixel( $im, rand() % 70, rand() % 30, $randcolor );
		}
		
		ImagePNG( $im );
		ImageDestroy( $im );
	}

	/**
	 * 验证码验证
	 * 
	 * @param $authcode sting
	 */
	public static function checkAuthCode($authcode) {
		return $authcode == SysSessionUtil::getAuthCode();
	}
}