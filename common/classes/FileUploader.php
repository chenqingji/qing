<?php

/**
 * here need a demo
 * @todo 限制上传图片的宽高
 * @todo 更好的处理错误输出
 */

/**
 * 文件上传处理类 支持多个文件
 * jm
 */
class FileUploader {
        /**
         * 上传成功
         */

        const FLAG_UPLOAD_SUCCESS = 0;

        /**
         * 上传文件扩展名不合法
         */
        const FLAG_EXT_ILLEGAL = -1;

        /**
         * 上传文件大小超过程序设置最大值
         */
        const FLAG_SIZE_OVER = -2;

        /**
         * 转移文件失败
         */
        const FLAG_MOVE_UPLOADED_FILE_FAILED = -3;

        /**
         * 附件存放物理目录
         * @var string 每个项目需要手动修改该配置
         */
        private $_dir = "/tmp/file-upload/";

        /**
         * 自定义文件上传时间
         * @var string 
         */
        private $_uploadTime;

        /**
         * 允许上传附件类型
         * @var array 
         */
        private $_allowUploadTypes = array(
            'gif', 'jpg', 'png', 'bmp', 'psd', 'ico', 'rar', 'zip', '7z', 'exe',
            'avi', 'rmvb', '3gp', 'flv', 'mp3', 'wav', 'lrc', 'krc', 'txt', 'doc', 'docx',
            'xls', 'ppt', 'pdf', 'chm', 'mdb', 'sql', 'log', 'con', 'dat', 'ini',
            'php', 'html', 'htm', 'ttf', 'fon', 'js', 'xml', 'dll', 'class'
        );

        /**
         * 允许加水印的文件类型
         * @var array 
         */
        private $_allowWaterTypes = array(
            'gif', 'jpg', 'png'
        );

        /**
         * 上传控件名称
         * @var string 
         */
        private $_field;

        /**
         * 最大允许文件大小，单位为B 为0时表示不做限制！！
         * @var int 
         */
        private $_maxsize = 0;
        
        /**
         * 缩略图文件前缀
         * @var string 
         */
        private $_thumbPrefix = 'thumb-';

        /**
         * 缩略图宽度
         * @var int 
         */
        private $_thumbWidth;

        /**
         * 缩略图高度
         * @var int 
         */
        private $_thumbHeight;

        /**
         * 水印图片地址
         * @var string 
         */
        private $_watermarkFile;

        /**
         * 水印位置
         * @var int 1：顶部居左 2：顶部居中 3：顶部居右 4：底部居左 5：底部居中 6：底部居右 其他:随机
         */
        private $_watermarkPos;

        /**
         * 水印透明度
         * @var string 
         */
        private $_watermarkTrans;

        /**
         * 生成的文件名中的前缀
         * @var type 
         */
        private $_prefixFilename = '';

        /**
         * 上传结果信息
         * @var array 
         */
        private $_uploadInfos = array();

        /**
         * 构造方法
         * @param string $field   上传input name名称 默认Filedata
         * @param array $allow_types   允许上传的文件类型
         * @param int $maxsize 允许大小  单位B 默认0不限制
         * @param int $uploadTime    自定义上传时间 默认当前时间
         */
        public function __construct($field = 'Filedata', $allow_types = array(), $maxsize = 0, $uploadTime = '') {
                if (!empty($allow_types)) {
                        $this->_allowUploadTypes = $allow_types;
                }
                $this->_maxsize = $maxsize;
                $this->_field = $field;
                $this->_uploadTime = $uploadTime ? $uploadTime : time();
        }

        /**
         * 设置上传文件控件名
         * @param string $field  <input type="file" name="Filedata">
         * @return \FileUploader
         */
        public function setField($field) {
                $this->_field = $field ? $field : 'Filedata';
                return $this;
        }

        /**
         * 设置允许上传的文件类型
         * @param array $allowTypes 如：array('png','gif')
         * @return \FileUploader
         */
        public function setAllowTypes($allowTypes) {
                if (!empty($allowTypes)) {
                        $this->_allowUploadTypes = $allowTypes;
                }
                return $this;
        }

        /**
         * 设置允许上传的文件大小
         * @param int $maxsize 单位B 默认1M
         * @return \FileUploader
         */
        public function setMaxsize($maxsize) {
                $this->_maxsize = $maxsize ? $maxsize : (1024 * 1024);
                return $this;
        }

        /**
         * 设置上传文件的时间
         * @param int $uploadTime 上传时间 秒
         * @return \FileUploader
         */
        public function setUploadTime($uploadTime) {
                $this->_uploadTime = $uploadTime ? $uploadTime : time();
                return $this;
        }

        /**
         * 获得文件上传时间
         * @return int 秒
         */
        public function getUploadTime() {
                return $this->_uploadTime;
        }

        /**
         * 设置文件名中的前缀
         * @param string $prefixFilename 日志文件前缀
         * @return \FileUploader
         */
        public function setPrefixFilename($prefixFilename) {
                $this->_prefixFilename = $prefixFilename;
                return $this;
        }

        /**
         * 设置并创建文件具体存放的目录
         * @param string $basedir 基目录，必须为物理路径
         * @param string $filedir 自定义分级子目录，可用参数{y} {m} {d} 则会自动替换相应年、月、日
         * @return \FileUploader
         */
        public function setDir($basedir, $filedir = '') {
                if (empty($basedir)) {
                        return;
                }
                $dir = $basedir;
                !is_dir($dir) && @mkdir($dir, 0755, true);

                //默认为空不分级
                if (!empty($filedir)) {
                        $filedir = str_replace(array('{y}', '{m}', '{d}'), array(date('Y', $this->_uploadTime), date('m', $this->_uploadTime), date('d', $this->_uploadTime)), strtolower($filedir));
                        $dirs = explode('/', $filedir);
                        foreach ($dirs as $d) {
                                !empty($d) && $dir .= $d . '/';
                                !is_dir($dir) && @mkdir($dir, 0755, true);
                        }
                }
                $this->_dir = $dir;
                return $this;
        }

        /**
         * 图片缩略图设置，如果不生成缩略图则不用设置
         * @param int $width   缩略图宽度
         * @param int $height  缩略图高度
         * @return \FileUploader
         */
        public function setThumb($width = 0, $height = 0) {
                $this->_thumbWidth = $width;
                $this->_thumbHeight = $height;
                return $this;
        }

        /**
         * 图片水印设置，如果不生成添加水印则不用设置
         * @param string $file    水印图片文件
         * @param int $pos      水印位置 默认6 详见_watermarkPos定义
         * @param int $trans    水印透明度 默认80%
         * @return \FileUploader
         */
        public function setWaterMark($file, $pos = 6, $trans = 80) {
                $this->_watermarkFile = $file;
                $this->_watermarkPos = $pos;
                $this->_watermarkTrans = $trans;
                return $this;
        }

        /**
         * 上传主要方法  以下为返回成功或失败文件信息数组files中的参数：
         * @param name  为文件名，上传成功时是上传到服务器上的文件名，上传失败则是本地的文件名
         * @param dir   为服务器上存放该附件的物理路径，上传失败不存在该值
         * @param size  为附件大小，上传失败不存在该值
         * @param flag  为状态标志，1表示成功，-1表示文件类型不允许，-2表示文件大小超出
         * @return array   
         */
        public function upload() {
                /**
                 * 成功上传的文件信息
                 */
                $files = array();
                $field = $this->_field;
                $_uploadFiles = array();
                /**
                 * 兼容多文件上传
                 */
                if (is_string($_FILES[$field]['name'])) {
                        $_uploadFiles[$field]['name'][0] = $_FILES[$field]['name'];
                        $_uploadFiles[$field]['type'][0] = $_FILES[$field]['type'];
                        $_uploadFiles[$field]['tmp_name'][0] = $_FILES[$field]['tmp_name'];
                        $_uploadFiles[$field]['error'][0] = $_FILES[$field]['error'];
                        $_uploadFiles[$field]['size'][0] = $_FILES[$field]['size'];
                } else {
                        $_uploadFiles = $_FILES;
                }

                $keys = array_keys($_uploadFiles[$field]['name']);

                foreach ($keys as $key) {
                        if (!$_uploadFiles[$field]['name'][$key]) {
                                continue;
                        }

                        $files[$key]['name'] = $_uploadFiles[$field]['name'][$key];

                        if ($_uploadFiles[$field]['error'][$key]) {
                                $files[$key]['error'] = 'Reference php upload error message description';
                                $files[$key]['flag'] = $_uploadFiles[$field]['error'][$key];
                                continue;
                        }

                        $fileext = $this->fileext($_uploadFiles[$field]['name'][$key]);
                        $filename = $this->_prefixFilename . $this->_uploadTime . mt_rand(1000, 9999) . '.' . $fileext;
                        $filedir = $this->_dir;
                        $filesize = $_uploadFiles[$field]['size'][$key];

                        //文件类型不允许
                        if (!in_array($fileext, $this->_allowUploadTypes)) {
                                $files[$key]['error'] = $_uploadFiles[$field]['name'][$key] . ': File extension is not '.  implode('|', $this->_allowUploadTypes);
                                $files[$key]['flag'] = self::FLAG_EXT_ILLEGAL;
                                continue;
                        }

                        //文件大小超出
                        if ($this->_maxsize > 0 && ($filesize > $this->_maxsize)) {
                                $files[$key]['error'] = $_uploadFiles[$field]['name'][$key] . ': File size more than the maxsize '.$this->_maxsize;
                                $files[$key]['flag'] = self::FLAG_SIZE_OVER;
                                continue;
                        }

                        $files[$key]['source'] = $_uploadFiles[$field]['name'][$key];
                        $files[$key]['name'] = $filename;
                        $files[$key]['dir'] = $filedir;
                        $files[$key]['size'] = $filesize;

                        //保存上传文件并删除临时文件
                        if (is_uploaded_file($_uploadFiles[$field]['tmp_name'][$key])) {
                                if (!move_uploaded_file($_uploadFiles[$field]['tmp_name'][$key], $filedir . $filename)) {
                                        $files[$key]['flag'] = self::FLAG_MOVE_UPLOADED_FILE_FAILED;
                                } else {
                                        if (file_exists($_uploadFiles[$field]['tmp_name'][$key])) {
                                                @unlink($_uploadFiles[$field]['tmp_name'][$key]);
                                        }
                                        $files[$key]['flag'] = self::FLAG_UPLOAD_SUCCESS;

                                        //对图片进行加水印和生成缩略图
                                        if (in_array($fileext, $this->_allowWaterTypes)) {
                                                $this->createWaterMark($filedir . $filename);
                                                if ($this->_thumbWidth || $this->_thumbHeight) {
                                                        if ($this->createThumb($filedir . $filename, $filedir . $this->_thumbPrefix . $filename)) {
                                                                $files[$key]['thumb'] = $this->_thumbPrefix . $filename;
                                                        } else {
                                                                $files[$key]['thumb'] = 'make thumb file failed.';
                                                        }
                                                }
                                        }
                                }
                        }
                }
                $this->_uploadInfos = $files;
                return $this->_uploadInfos;
        }

        /**
         * 检测是否上传成功 
         * @return boolean  true:所有都成功 false：都失败或部分成功 
         */
        public function isUploadSuccess() {
                $infos = $this->_uploadInfos;
                $status = false;
                if ($infos) {
                        $status = true;
                        foreach ($infos as $info) {
                                if ($info['flag']) {
                                        $status = false;
                                        break;
                                }
                        }
                }
                return $status;
        }

        /**
         * 创建缩略图，以相同的扩展名和生成缩略图
         * @param type $sourceFile   来源图像路径
         * @param type $thumbFile  缩略图路径
         * @return boolean
         */
        private function createThumb($sourceFile, $thumbFile) {
                $t_width = $this->_thumbWidth;
                $t_height = $this->_thumbHeight;

                if (!file_exists($sourceFile)) {
                        return false;
                }

                $sourceFileInfo = getImageSize($sourceFile);

                //如果来源图像小于或等于缩略图则拷贝源图像作为缩略图
                if ($sourceFileInfo[0] <= $t_width && $sourceFileInfo[1] <= $t_height) {
                        if (!copy($sourceFile, $thumbFile)) {
                                return false;
                        }
                        return true;
                }

                //按比例计算缩略图大小
//                if ($sourceFileInfo[0] - $t_width > $sourceFileInfo[1] - $t_height) {
                if($t_width){
                        $t_height = ($t_width / $sourceFileInfo[0]) * $sourceFileInfo[1];
                } else {
                        $t_width = ($t_height / $sourceFileInfo[1]) * $sourceFileInfo[0];
                }

                //取得文件扩展名
                $fileext = $this->fileext($sourceFile);
                switch ($fileext) {
                        case 'jpg' :
                                $soucreFileImg = ImageCreateFromJPEG($sourceFile);
                                break;
                        case 'png' :
                                $soucreFileImg = ImageCreateFromPNG($sourceFile);
                                break;
                        case 'gif' :
                                $soucreFileImg = ImageCreateFromGIF($sourceFile);
                                break;
                }

                //创建一个真彩色的缩略图像
                $thumbImg = @ImageCreateTrueColor($t_width, $t_height);

                //ImageCopyResampled函数拷贝的图像平滑度较好，优先考虑
                if (function_exists('imagecopyresampled')) {
                        @ImageCopyResampled($thumbImg, $soucreFileImg, 0, 0, 0, 0, $t_width, $t_height, $sourceFileInfo[0], $sourceFileInfo[1]);
                } else {
                        @ImageCopyResized($thumbImg, $soucreFileImg, 0, 0, 0, 0, $t_width, $t_height, $sourceFileInfo[0], $sourceFileInfo[1]);
                }

                //生成缩略图
                switch ($fileext) {
                        case 'jpg' :
                                ImageJPEG($thumbImg, $thumbFile);
                                break;
                        case 'gif' :
                                ImageGIF($thumbImg, $thumbFile);
                                break;
                        case 'png' :
                                ImagePNG($thumbImg, $thumbFile);
                                break;
                }

                //销毁临时图像
                @ImageDestroy($soucreFileImg);
                @ImageDestroy($thumbImg);

                return true;
        }

        /**
         * 为图片添加水印
         * @param type $file    要添加水印的文件
         */
        private function createWaterMark($file) {
                //文件不存在则返回
                if (!file_exists($this->_watermarkFile) || !file_exists($file)) {
                        return;
                }
                if (!function_exists('getImageSize')) {
                        return;
                }
                //检查GD支持的文件类型
                $gd_allow_types = array();

                if (function_exists('ImageCreateFromGIF'))
                        $gd_allow_types['image/gif'] = 'ImageCreateFromGIF';

                if (function_exists('ImageCreateFromPNG'))
                        $gd_allow_types['image/png'] = 'ImageCreateFromPNG';

                if (function_exists('ImageCreateFromJPEG'))
                        $gd_allow_types['image/jpeg'] = 'ImageCreateFromJPEG';

                //获取文件信息
                $fileinfo = getImageSize($file);
                $wminfo = getImageSize($this->_watermarkFile);

                if ($fileinfo[0] < $wminfo[0] || $fileinfo[1] < $wminfo[1])
                        return;

                if (array_key_exists($fileinfo['mime'], $gd_allow_types)) {
                        if (array_key_exists($wminfo['mime'], $gd_allow_types)) {
                                //从文件创建图像
                                $temp = $gd_allow_types[$fileinfo['mime']]($file);
                                $temp_wm = $gd_allow_types[$wminfo['mime']]($this->_watermarkFile);
                                

                                //水印位置
                                switch ($this->_watermarkPos) {
                                        case 1 : //顶部居左
                                                $dst_x = 0;
                                                $dst_y = 0;
                                                break;
                                        case 2 : //顶部居中
                                                $dst_x = ($fileinfo[0] - $wminfo[0]) / 2;
                                                $dst_y = 0;
                                                break;
                                        case 3 : //顶部居右
                                                $dst_x = $fileinfo[0];
                                                $dst_y = 0;
                                                break;
                                        case 4 : //底部居左
                                                $dst_x = 0;
                                                $dst_y = $fileinfo[1];
                                                break;
                                        case 5 : //底部居中
                                                $dst_x = ($fileinfo[0] - $wminfo[0]) / 2;
                                                $dst_y = $fileinfo[1];
                                                break;
                                        case 6 : //底部居右
                                                $dst_x = $fileinfo[0] - $wminfo[0];
                                                $dst_y = $fileinfo[1] - $wminfo[1];
                                                break;
                                        default : //随机
                                                $dst_x = mt_rand(0, $fileinfo[0] - $wminfo[0]);
                                                $dst_y = mt_rand(0, $fileinfo[1] - $wminfo[1]);
                                }

                                //设定图像的混色模式
                                if (function_exists('ImageAlphaBlending'))
                                        ImageAlphaBlending($temp_wm, True);

                                //保存完整的 alpha 通道信息
                                if (function_exists('ImageSaveAlpha'))
                                        ImageSaveAlpha($temp_wm, True);

                                //为图像添加水印
                                if (function_exists('imageCopyMerge')) {
                                        ImageCopyMerge($temp, $temp_wm, $dst_x, $dst_y, 0, 0, $wminfo[0], $wminfo[1], $this->_watermarkTrans);
                                }
                                       
                                //保存图片
                                switch ($fileinfo['mime']) {
                                        case 'image/jpeg' :
                                                @imageJPEG($temp, $file);
                                                break;
                                        case 'image/png' :
                                                @imagePNG($temp, $file);
                                                break;
                                        case 'image/gif' :
                                                @imageGIF($temp, $file);
                                                break;
                                }

                                //销毁零时图像
                                @imageDestroy($temp);
                                @imageDestroy($temp_wm);
                        }
                }
        }

        /**
         * 获取文件扩展名
         * @param type $filename    文件名
         * @return string
         */
        private function fileext($filename) {
                return strtolower(substr(strrchr($filename, '.'), 1, 10));
        }

}

?>
