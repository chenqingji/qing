<?php

/**
 * 文件上传处理类
 */
class Uploader {
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
     * 附件存放物理目录
     * @var string 
     */
    private $dir;

    /**
     * 自定义文件上传时间
     * @var string 
     */
    private $time;

    /**
     * 允许上传附件类型
     * @var array 
     */
    private $allow_types = array(
        'gif', 'jpg', 'png', 'bmp', 'psd', 'ico', 'rar', 'zip', '7z', 'exe',
        'avi', 'rmvb', '3gp', 'flv', 'mp3', 'wav', 'lrc', 'krc', 'txt', 'doc','docx',
        'xls', 'ppt', 'pdf', 'chm', 'mdb', 'sql', 'log', 'con', 'dat', 'ini',
        'php', 'html', 'htm', 'ttf', 'fon', 'js', 'xml', 'dll', 'class'
    );

    /**
     * 上传控件名称
     * @var string 
     */
    private $field;

    /**
     * 最大允许文件大小，单位为B
     * @var int 
     */
    private $maxsize = 0;

    /**
     * 缩略图宽度
     * @var int 
     */
    private $thumb_width;

    /**
     * 缩略图高度
     * @var int 
     */
    private $thumb_height;

    /**
     * 水印图片地址
     * @var string 
     */
    private $watermark_file;

    /**
     * 水印位置
     * @var string 
     */
    private $watermark_pos;

    /**
     * 水印透明度
     * @var string 
     */
    private $watermark_trans;

    /**
     * 生成的文件名中的部分文字
     * @var type 
     */
    private $prefix_filename = '';
    
    /**
     * 上传结果信息
     * @var array 
     */
    private $upload_infos = array();

    /**
     * 构造方法
     * @param array $allow_types   允许上传的文件类型
     * @param int $maxsize 允许大小
     * @param string $field   上传控件名称
     * @param int $time    自定义上传时间
     */
    public function __construct($allow_types = array(), $maxsize = 1048576, $field = 'attach', $time = '') {
        if (!empty($allow_types)) {
            $this->allow_types = $allow_types;
        }
        $this->maxsize = $maxsize;
        $this->field = $field;
        $this->time = $time ? $time : time();
    }

    /**
     * 设置上传文件控件名
     * @param type $field
     */
    public function set_field($field) {
        $this->field = $field ? $field : 'attach';
    }

    /**
     * 设置允许上传的文件类型
     * @param type $allowTypes
     */
    public function set_allow_types($allowTypes) {
        if (!empty($allowTypes)) {
            $this->allow_types = $allowTypes;
        }
    }

    /**
     * 设置允许上传的文件大小
     * @param type $maxsize
     */
    public function set_maxsize($maxsize) {
        $this->maxsize = $maxsize ? $maxsize : (1024 * 1024);
    }

    /**
     * 设置上传文件的时间
     * @param type $time
     */
    public function set_time($time) {
        $this->time = $time ? $time : time();
    }

    /**
     * 获得文件上传时间
     * @return type
     */
    public function get_time() {
        return $this->time;
    }

    /**
     * 设置日志文件的文件前缀
     * @param type $prefixFilename
     */
    public function set_prefix_filename($prefixFilename) {
        $this->prefix_filename = $prefixFilename;
    }

    /**
     * 设置并创建文件具体存放的目录
     * @param string $basedir 基目录，必须为物理路径
     * @param string $filedir 自定义分级子目录，可用参数{y} {m} {d}
     */
    public function set_dir($basedir, $filedir = '') {
        $dir = $basedir;
        !is_dir($dir) && @mkdir($dir, 0777, true);

        if (!empty($filedir)) {
            $filedir = str_replace(array('{y}', '{m}', '{d}'), array(date('Y', $this->time), date('m', $this->time), date('d', $this->time)), strtolower($filedir));
            $dirs = explode('/', $filedir);
            foreach ($dirs as $d) {
                !empty($d) && $dir .= $d . '/';
                !is_dir($dir) && @mkdir($dir, 0777, true);
            }
        }
        $this->dir = $dir;
    }

    /**
     * 图片缩略图设置，如果不生成缩略图则不用设置
     * @param int $width   缩略图宽度
     * @param int $height  缩略图高度
     */
    public function set_thumb($width = 0, $height = 0) {
        $this->thumb_width = $width;
        $this->thumb_height = $height;
    }

    /**
     * 图片水印设置，如果不生成添加水印则不用设置
     * @param string $file    水印图片
     * @param int $pos      水印位置
     * @param int $trans    水印透明度
     */
    public function set_watermark($file, $pos = 6, $trans = 80) {
        $this->watermark_file = $file;
        $this->watermark_pos = $pos;
        $this->watermark_trans = $trans;
    }

    /**
     * 主要方法。
     * 执行文件上传，处理完返回一个包含上传成功或失败的文件信息数组
     * 其中：name为文件名，上传成功时是上传到服务器上的文件名，上传失败则是本地的文件名
     * dir  为服务器上存放该附件的物理路径，上传失败不存在该值
     * size 为附件大小，上传失败不存在该值
     * flag 为状态标志，1表示成功，-1表示文件类型不允许，-2表示文件大小超出
     * @return array   
     */
    public function upload() {
        $files = array(); //成功上传的文件信息
        $field = $this->field;
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
                $files[$key]['info'] = 'Reference php upload error message description';
                $files[$key]['flag'] = $_uploadFiles[$field]['error'][$key];
                continue;
            }

            $fileext = $this->fileext($_uploadFiles[$field]['name'][$key]); //获取文件扩展名
            $filename = $this->prefix_filename . $this->time . mt_rand(1000, 9999) . '.' . $fileext; //生成文件名
            $filedir = $this->dir; //附件实际存放目录
            $filesize = $_uploadFiles[$field]['size'][$key]; //文件大小
            //文件类型不允许
            if (!in_array($fileext, $this->allow_types)) {
                $files[$key]['info'] = 'File extension illegal';
                $files[$key]['flag'] = self::FLAG_EXT_ILLEGAL;
                continue;
            }

            //文件大小超出
            if ($filesize > $this->maxsize) {
                $files[$key]['info'] = 'File size more than the maxsize';
                $files[$key]['flag'] = self::FLAG_SIZE_OVER;
                continue;
            }

            $files[$key]['name'] = $filename;
            $files[$key]['dir'] = $filedir;
            $files[$key]['size'] = $filesize;

            //保存上传文件并删除临时文件
            if (is_uploaded_file($_uploadFiles[$field]['tmp_name'][$key])) {
                move_uploaded_file($_uploadFiles[$field]['tmp_name'][$key], $filedir . $filename);
                if(file_exists($_uploadFiles[$field]['tmp_name'][$key])){
                    @unlink($_uploadFiles[$field]['tmp_name'][$key]);
                }
                $files[$key]['flag'] = self::FLAG_UPLOAD_SUCCESS;

                //对图片进行加水印和生成缩略图
                if (in_array($fileext, array('jpg', 'png', 'gif'))) {
                    if ($this->thumb_width) {
                        if ($this->create_thumb($filedir . $filename, $filedir . 'thumb_' . $filename)) {
                            $files[$key]['thumb'] = 'thumb_' . $filename; //缩略图文件名
                        }
                    }
                    $this->create_watermark($filedir . $filename);
                }
            }
        }
        $this->upload_infos = $files;
        return $this->upload_infos;
    }
    
    /**
     * 检测是否上传成功
     * @return boolean 
     */
    public function is_uploaded_successfully(){
        $infos = $this->upload_infos;
        $status = false;
        if($infos){
            $status = true;
            foreach($infos as $info){
                if($info['flag']){
                   $status = false;
                   break;
                }
            }
        }
        return $status;
    }

    /**
     * 创建缩略图，以相同的扩展名和生成缩略图
     * @param type $php_aspx_file   来源图像路径
     * @param type $thumb_file  缩略图路径
     * @return boolean
     */
    private function create_thumb($php_aspx_file, $thumb_file) {
        $t_width = $this->thumb_width;
        $t_height = $this->thumb_height;

        if (!file_exists($php_aspx_file)) {
            return false;
        }

        $php_aspx_info = getImageSize($php_aspx_file);

        //如果来源图像小于或等于缩略图则拷贝源图像作为缩略图
        if ($php_aspx_info[0] <= $t_width && $php_aspx_info[1] <= $t_height) {
            if (!copy($php_aspx_file, $thumb_file)) {
                return false;
            }
            return true;
        }

        //按比例计算缩略图大小
        if ($php_aspx_info[0] - $t_width > $php_aspx_info[1] - $t_height) {
            $t_height = ($t_width / $php_aspx_info[0]) * $php_aspx_info[1];
        } else {
            $t_width = ($t_height / $php_aspx_info[1]) * $php_aspx_info[0];
        }

        //取得文件扩展名
        $fileext = $this->fileext($php_aspx_file);
        switch ($fileext) {
            case 'jpg' :
                $php_aspx_img = ImageCreateFromJPEG($php_aspx_file);
                break;
            case 'png' :
                $php_aspx_img = ImageCreateFromPNG($php_aspx_file);
                break;
            case 'gif' :
                $php_aspx_img = ImageCreateFromGIF($php_aspx_file);
                break;
        }

        //创建一个真彩色的缩略图像
        $thumb_img = @ImageCreateTrueColor($t_width, $t_height);

        //ImageCopyResampled函数拷贝的图像平滑度较好，优先考虑
        if (function_exists('imagecopyresampled')) {
            @ImageCopyResampled($thumb_img, $php_aspx_img, 0, 0, 0, 0, $t_width, $t_height, $php_aspx_info[0], $php_aspx_info[1]);
        } else {
            @ImageCopyResized($thumb_img, $php_aspx_img, 0, 0, 0, 0, $t_width, $t_height, $php_aspx_info[0], $php_aspx_info[1]);
        }

        //生成缩略图
        switch ($fileext) {
            case 'jpg' :
                ImageJPEG($thumb_img, $thumb_file);
                break;
            case 'gif' :
                ImageGIF($thumb_img, $thumb_file);
                break;
            case 'png' :
                ImagePNG($thumb_img, $thumb_file);
                break;
        }

        //销毁临时图像
        @ImageDestroy($php_aspx_img);
        @ImageDestroy($thumb_img);

        return true;
    }

    /**
     * 为图片添加水印
     * @param type $file    要添加水印的文件
     */
    private function create_watermark($file) {
        //文件不存在则返回
        if (!file_exists($this->watermark_file) || !file_exists($file)) {
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
        $wminfo = getImageSize($this->watermark_file);

        if ($fileinfo[0] < $wminfo[0] || $fileinfo[1] < $wminfo[1])
            return;

        if (array_key_exists($fileinfo['mime'], $gd_allow_types)) {
            if (array_key_exists($wminfo['mime'], $gd_allow_types)) {
                //从文件创建图像
                $temp = $gd_allow_types[$fileinfo['mime']]($file);
                $temp_wm = $gd_allow_types[$wminfo['mime']]($this->watermark_file);

                //水印位置
                switch ($this->watermark_pos) {
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
                    ImageCopyMerge($temp, $temp_wm, $dst_x, $dst_y, 0, 0, $wminfo[0], $wminfo[1], $this->watermark_trans);
                } else {
                    ImageCopyMerge($temp, $temp_wm, $dst_x, $dst_y, 0, 0, $wminfo[0], $wminfo[1]);
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
