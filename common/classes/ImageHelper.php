<?php

/**
 * 图像信息帮助
 *
 * @author jm
 */
class ImageHelper {
        
        /**
         * 图片高度选项
         */
        const IMAGE_HEIGHT = 'height';
        /**
         * 图片宽度选项
         */
        const IMAGE_WIDTH = 'width';
        /**
         * 图片mime类型
         */
        const IMAGE_MIME_TYPE = 'mime';
        /**
         * 图片内部文本字符串
         */
        const IMAGE_TEXT = 'text';

        /**
         * getimagesiez函数返回数组中索引对应的选项
         * @var array 
         */
        private static $_getimagesizeReturnArray = array(
            self::IMAGE_WIDTH => 0,
            self::IMAGE_HEIGHT => 1,
            self::IMAGE_MIME_TYPE => 2,
            self::IMAGE_TEXT => 3
        );

        /**
         * 获取图片的高度
         * @param string $file
         * @return int
         */
        public static function getHeight($file) {
                return self::getImageSize($file, self::IMAGE_HEIGHT);
        }

        /**
         * 获取图片的大小相关信息
         * @param string $file
         * @param string $option
         * @return int|array|null
         */
        private static function getImageSize($file, $option = '') {
                if (file_exists($file)) {
                        $imageSizeArray = getimagesize($file);
                        if (!empty($option)) {
                                $key = self::$_getimagesizeReturnArray[$option];
                                return $imageSizeArray[$key];
                        }
                        return $imageSizeArray;
                }
                return null;
        }

}

?>
