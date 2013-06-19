<?php

/**
 * 调试 日志 
 */
class Log {

    /**
     * 开启调试日志记录
     * @var int 0 1
     */
    private $_debug = 1;

    /**
     * 错误信息
     * @var string 
     */
    private $_errorMessage = '';

    /**
     * 错误号
     * @var int 
     */
    private $_errorNumber = 0;

    /**
     * 日志记录文件所在目录  绝对路径
     * @var string 
     */
    private $_dirname = "/tmp/";

    /**
     * 日志或输出记录文件
     * @var string 
     */
    private $_filename = 'mytracklog';

    /**
     * 写入文件方式 常用:wb a+
     * @var string 
     */
    private $_wrType = 'a+';

    /**
     * 输出方式  常用:echo print print_r var_dump
     * @var string 
     */
    private $_printType = 'print_r';

    /**
     * 操作者
     * @var string 
     */
    private $_user = '';

    /**
     * 日志过滤标记
     * @var bool false true
     */
    private $_filterFlag = false;

    /**
     * 日志过滤的关键字
     * @var string 
     */
    private $_filterKey = '';

    /**
     * 日志过滤关键字要匹配的数组
     * @var array 
     */
    private $_filterArr = array();

    /**
     * 日志记录一次尾部自动加个换行
     * @var bool false true 
     */
    private $_autoAddNewline = true;

    /**
     * 日志记录前自动增加当前格式化后的时间
     * @var bool false true 
     */
    private $_autoAddDate = false;

    /**
     * 时间格式类型 参照getFormatDate方法
     * @var type  0 1 2...
     */
    private $_dateType = 0;

    /**
     * 构造器
     */
    public function __construct() {
        
    }

    /**
     * 设置debug
     * @param int $debug 
     */
    private function setDebug($debug=1) {
        if ($debug) {
            $debug = 1;
        } else {
            $debug = 0;
        }
        $this->_debug = $debug;
        return true;
    }

    /**
     * 开启日志跟踪调试
     * @return bool 
     */
    public function openDebug() {
        return $this->setDebug(1);
    }

    /**
     * 关闭日志跟踪调试
     * @return bool 
     */
    public function closeDebug() {
        return $this->setDebug(0);
    }

    /**
     * 设置日志过滤规则，满足规则才记录日志
     * @param mix $key
     * @param mix $mix_value 
     */
    public function setFilter($key, $mix_value) {
        $this->_filterKey = $key;
        if (is_array($mix_value)) {
            $this->_filterArr = $mix_value;
        } else {
            $this->_filterArr[] = $mix_value;
        }
        $this->_filterFlag = true;
        return true;
    }

    /**
     * 取消日志过滤规则
     * @return boolean 
     */
    public function unsetFilter() {
        $this->_filterFlag = false;
        $this->_filterKey = '';
        $this->_filterArr = array();
        return true;
    }

    /**
     * 日志记录内部过滤
     * @return boolean 
     */
    private function filter() {
        if ($this->_filterFlag) {
            if (!in_array($this->_filterKey, $this->_filterArr, true)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 设置日志保存目录路径
     * @param string $path 
     */
    public function setDir($path) {
        if (strcmp($path, '') != 0) {
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $path = realpath($path);
            $lastChar = substr($path, -1);
            if ($lastChar != '/') {
                $path .= '/';
            }
            $this->_dirname = $path;
        } else {
            throw new Exception('@param path is empty.');
        }
        return true;
    }

    /**
     * 获取日志保存目录路径
     * @return string 
     */
    public function getDir() {
        return $this->_dirname;
    }

    /**
     * 设置日志保存文件
     * @param string $file 
     */
    public function setFile($file) {
        if (strcmp($file, '') != 0) {
            $this->_filename = $file;
            if (!is_file($this->_dirname . $this->_filename)) {
                $fp = fopen($this->_dirname . $this->_filename, 'wb');
                if(!$fp){
                    throw new Exception('fopen resource is null.');
                }
                fclose($fp);
            }
        } else {
            throw new Exception('@param file is empty.');
        }
        return true;
    }

    /**
     * 获取日志保存文件名
     * @return string 
     */
    public function getFile() {
        return $this->_filename;
    }

    /**
     * 设置日志保存全路径 含目录和文件名  pathFile不支持不存在的文件
     * @param string $pathFile 
     */
    public function setPath($pathFile) {
        if (is_file($pathFile)) {
            $pathFile = realpath($pathFile);
            $dirname = dirname($pathFile);
            $basename = basename($pathFile);
            $this->setDir($dirname);
            $this->setFile($basename);
        } else {
            throw new Exception('file '.$pathFile.' is not exists.');
        }
        return true;
    }

    /**
     * 获取日志保存全路径  含目录和文件名
     * @return string 
     */
    public function getPath() {
        return $this->_dirname . $this->_filename;
    }

    /**
     * 设置写入日志类型  追加或覆盖
     * @param string $wrType 
     */
    public function setWrType($wrType) {
        if (strcmp($wrType, '') != 0) {
            $this->_wrType = $wrType;
        } else {
            throw new Exception('@param wrType is empty.');
        }
        return true;
    }

    /**
     * 设置变量或对象的输出方式 常用print_r
     * @param string $printType 
     */
    public function setPrintType($printType) {
        if (strcmp($printType, '') != 0) {
            $this->_printType = $printType;
        } else {
            throw new Exception('@param printType is empty.');
        }
        return true;
    }

    /**
     * 设置操作者 user
     * @param string $user 
     */
    public function setUser($user) {
        if (strcmp($user, '') != 0) {
            $this->_user = $user;
        } else {
            //$this->user = $_SERVER['REMOTE_ADDR'];
            throw new Exception('@param user is empty.');
        }
        return true;
    }

    /**
     * 获取操作者 user
     * @return string 
     */
    public function getUser() {
        return $this->_user;
    }

    /**
     * 日志是否自动换行
     * @param boolean $flag
     * @return boolean 
     */
    public function autoAddNewline($flag=true){
        if(!$flag){
            $flag = false;
        }
        $this->_autoAddNewline = $flag;
        return true;
    }
    
    /**
     * 日志是否自动增加时间
     * @param boolean $flag
     * @return boolean 
     */
    public function autoAddDate($flag=false){
        if(!$flag){
            $flag = false;
        }
        $this->_autoAddDate = $flag;
        return true;        
    }
    /**
     * 获取秒  小数点后为毫秒
     * @return type 
     */
    public function getMicrotime() {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $usec + (float) $sec;
    }

    /**
     * 获取格式化的时间
     * @param string $timeStamp
     * @return string 
     */
    public function getFormatDate($timeStamp) {
        if (!$timeStamp) {
            $timeStamp = time();
        }
        switch ($this->_dateType) {
            case 1:
                //2001-09-11 7:40:54
                $returnDate = date('Y-m-d H:i:s', $timeStamp);
                break;
            case 2:
                //20010504
                $returnDate = date('Ymd', $timeStamp);
                break;
            case 3:
                //Sat Mar 10 15:16:08 MST 2001
                $returnDate = date('D M j G:i:s', $timeStamp);
                break;
            default:
                $returnDate = date('Y-m-d H:i:s', $timeStamp);
        }
        return $returnDate;
    }

    /**
     * 写入文件操作
     * @param string $msg
     * @param string $file
     * @param string $wrType
     * @return boolean 
     */
    public function log2file($msg = '', $file = '', $wrType = '') {
        if ($this->_debug) {
            if (strcmp($file, '') === 0) {
                $file = $this->_filename;
            }
            $file = $this->_dirname . $file;
            if (strcmp($wrType, '') === 0) {
                $wrType = $this->_wrType;
            }
            $fp = fopen($file, "$wrType");
            if ($fp) {
                fputs($fp, $msg);
                fclose($fp);
            } else {
                throw new Exception('fopen resource is null.');
            }
        } else {
            return false;
        }
        return true;
    }

    /*
      通过print_r输出数组
     */

    /**
     * 记录日志
     * @param mix $var
     * @param string $file
     * @param string $wrType
     * @param string $printType
     * @return boolean 
     */
    public function log($var = '', $file = '', $wrType = '', $printType = '') {
        if ($this->_debug) {
            if ($this->filter()) {
                if (strcmp($printType, '') === 0) {
                    $printType = $this->_printType;
                }
                if (strcmp($wrType, '') === 0) {
                    $wrType = $this->_wrType;
                }
                if (strcmp($file, '') === 0) {
                    $file = $this->_filename;
                }
                /* 打开内部缓存 */
                ob_start();
                /* 输出 */
                if ($printType == 'var_dump') {
                    var_dump($var);
                } elseif ($printType == 'print_r') {
                    print_r($var);
                } elseif ($printType == 'print') {
                    print $var;
                } elseif ($printType == 'echo') {
                    echo $var;
                } else {
                    print_r($var);
                }
                /* 获取内部缓存的内容 */
                $format_var = ob_get_contents();
                /* 清空缓存并关闭内部缓存 */
                ob_end_clean();
                if ($this->_autoAddDate) {
                    $format_var .= $this->getFormatDate() . "\n";
                }

                $this->log2file($format_var, $file, $wrType);

                if ($this->_autoAddNewline) {
                    $this->log2file("\n", $file, 'a+');
                }
            } else {
                return false;
            }
        }
    }
    

}

?>
