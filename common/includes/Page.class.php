<?php

/**
 * 列表 分页 
 * 上下一个分页条未处理 todo
 */
class Page {

    /**
     * 下一页字符
     * @var string 
     */
    public $nextPage = '>';

    /**
     * 上一页字符
     * @var string 
     */
    public $prevPage = '<';

    /**
     * 首页字符
     * @var string 
     */
    public $firstPage = 'First';

    /**
     * 尾页字符
     * @var string 
     */
    public $lastPage = 'Last';

    /**
     * 上一分页条
     * @var string 
     */
    public $prevBar = '<<';

    /**
     * 下一分页条
     * @var string 
     */
    public $nextBar = '>>';

    /**
     * 页码数左侧边界符号
     * @var string
     */
    public $formatLeft = '[';

    /**
     * 页码数右侧边界符号
     * @var string
     */
    public $formatRight = ']';

    /**
     * 页码条页码步进数
     * @var int 
     */
    public $step = 5;

    /**
     * 页码条页码显示个数
     * @var int
     */
    public $pagebarNum = 9;

    /**
     * 设置当前请求limit的开始边界 
     * @var int 
     */
    public $offset = 0;
    
    /**
     * anchor链接样式
     * @var string 
     */
    public $anchorStyle = '';

    /**
     * 当前页码样式
     * @var string
     */
    public $nowIndexStyle = '';

    /**
     * 不可用样式
     * @var string 
     */
    public $disabledStyle = '';

    /**
     * 数据总记录数
     * @var int
     */
    private $_total = 0;

    /**
     * 每页记录数
     * @var int 
     */
    private $_perPage = 10;

    /**
     * 当前页码
     * @var int 
     */
    private $_nowIndex = 1;

    /**
     * url地址头
     * @var string 
     */
    private $_url = "";

    /**
     * 请求url后缀翻页参数 用来控制url页。比如说xxx.php?page=2中的page
     * @var string 
     */
    private $_pageName = "page";

    /**
     * 总页码数
     * @var int 
     */
    private $_totalPage = 0;

    /**
     * 是否支持ajax分页模式
     * @var boolean 
     */
    private $_isAjax = false;

    /**
     * ajax js动作方法名
     * @var string 
     */
    private $_ajaxActionName = '';

    /**
     * constructor构造函数
     * 需要初始化记录总数total、每页记录数perPage、当前页码索引nowIndex、请求地址头url、[是否支持ajax分页 ajax，note:js调用的方法名]
     * @param array $array['total'],$array['perPage'],$array['nowIndex'],$array['url'],$array['ajax']...
     */
    public function __construct($array) {
        if (is_array($array)) {
            if (!array_key_exists('total', $array)) {
                $this->error(__FUNCTION__, 'need a param of total');
            }
            $total = intval($array['total']);
            $perPage = (array_key_exists('perPage', $array)) ? intval($array['perPage']) : 10;
            $nowIndex = (array_key_exists('nowIndex', $array)) ? intval($array['nowIndex']) : '';
            $url = (array_key_exists('url', $array)) ? $array['url'] : '';
        } else {
            $total = $array;
            $perPage = $this->_perPage;
            $nowIndex = '';
            $url = '';
        }
        if (!empty($array['pageName'])) {
            $this->set('pageName', $array['pageName']); //设置pagename
        }

        if ((!is_int($total)) || ($total < 0))
            $this->error(__FUNCTION__, 'total is not a positive integer!');
        if ((!is_int($perPage)) || ($perPage <= 0))
            $this->error(__FUNCTION__, 'perPage is not a positive integer!');

        $this->_totalPage = ceil($total / $perPage);
        $this->_total = $total;
        $this->_perPage = $perPage;
        $this->_setNowIndex($nowIndex);
        $this->_setUrl($url);


        if (!empty($array['ajax'])) {
            $this->openAjax($array['ajax']);
        }
        if ($this->_nowIndex >= $this->_totalPage) {
            $this->_nowIndex = $this->_totalPage;
        }
    }

    /**
     * 设定类中指定变量名的值，如果改变量不属于这个类，将throw一个exception
     * 尽量不使用
     * @param string $var
     * @param string $value
     */
    private function set($var, $value) {
        if (in_array($var, get_object_vars($this))) {
            $this->$var = $value;
        } else {
            $this->error(__FUNCTION__, $var . " does not belong to page.");
        }
    }

    /**
     * 设置当前查询开始边界
     * limit start,rang
     * @return int 
     */
    public function getOffset(){
        return intval(($this->_nowIndex-1) * $this->_perPage);
    }
    /**
     * 获取总记录数
     * @return int 
     */
    public function getTotal() {
        return $this->_total;
    }

    /**
     * 获取每页记录数
     * @return int 
     */
    public function getPerPage() {
        return $this->_perPage;
    }

    /**
     * 获取当前页码数
     * @return int 
     */
    public function getNowIndex() {
        return $this->_nowIndex;
    }

    /**
     * 获取请求url地址头
     * @return string 
     */
    public function getUrl() {
        return $this->_url;
    }

    /**
     * 获取请求url 翻页参数名
     * @return string
     */
    public function getPageName() {
        return $this->_pageName;
    }

    /**
     * 获取总页数
     * @return int 
     */
    public function getTotalPage() {
        return $this->_totalPage;
    }

    /**
     * 获取是否支持ajax
     * @return boolean 
     */
    public function getIsAjax() {
        return $this->_isAjax;
    }

    /**
     * 获取ajax 前端js动作方法名
     * @return string 
     */
    public function getAjaxActionName() {
        return $this->_ajaxActionName;
    }

    /**
     * 打开AJAX模式
     * @param string $action 前端js方法名
     */
    public function openAjax($action) {
        $this->_isAjax = true;
        $this->_ajaxActionName = $action;
    }

    /**
     * 获取显示"下一页"的代码
     * @param string $style
     * @return string
     */
    public function showNextPage() {
        if ($this->_nowIndex < $this->_totalPage) {
            return $this->_getLink($this->_getNewUrl($this->_nowIndex + 1), $this->nextPage, $this->anchorStyle);
        }
        return '<span ' . $this->_getClassStyle($this->disabledStyle) . '>' . $this->nextPage . '</span>';
    }

    /**
     * 获取显示“上一页”的代码
     * @param string $style
     * @return string
     */
    public function showPrevPage() {
        if ($this->_nowIndex >= $this->_totalPage) {
            $this->_nowIndex = $this->_totalPage;
        }
        if ($this->_nowIndex > 1 && $this->_perPage <= $this->_total) {
            return $this->_getLink($this->_getNewUrl($this->_nowIndex - 1), $this->prevPage, $this->anchorStyle);
        }
        return '<span ' . $this->_getClassStyle($this->disabledStyle) . '>' . $this->prevPage . '</span>';
    }

    /**
     * 获取显示“首页”的代码
     * @return string
     */
    public function showFirstPage() {
        if ($this->_nowIndex == 1 || $this->_perPage >= $this->_total) {
            return '<span ' . $this->_getClassStyle($this->disabledStyle) . '>' . $this->firstPage . '</span>';
        }
        return $this->_getLink($this->_getNewUrl(1), $this->firstPage, $this->anchorStyle);
    }

    /**
     * 获取显示“尾页”的代码
     * @return string
     */
    public function showLastPage() {
        if ($this->_totalPage == 0 || $this->_perPage >= $this->_total || $this->_nowIndex >= $this->_totalPage) {
            return '<span ' . $this->_getClassStyle($this->disabledStyle) . '>' . $this->lastPage . '</span>';
        }
        return $this->_getLink($this->_getNewUrl($this->_totalPage), $this->lastPage, $this->anchorStyle);
    }

    /**
     * 按页码条步进数显示数字页码
     * @func  显示数字的连接. 如: 1 2 3 4 5 6 7 8 9
     * @return string
     */
    public function showMidPage() {
        return $this->_getPagebar($this->step);
    }

    /**
     * 按照指定页码条可显示页码数显示数字页码 
     * 默认(mode=0)页码条显示 中间的页码为当前页码   :  [1][2][3]...[9][10]
     * @return string
     */
    public function showPagebar() {
        return $this->_getPagebar($this->pagebarNum);
    }

    /**
     * 获取上一个分页条代码
     * @return string 
     */
    public function showPrevBar() {
        //todo
        return '<<';
    }

    /**
     * 获取下一个分页条代码
     * @return string 
     */
    public function showNextBar() {
        //todo
        return '>>';
    }

    /**
     * 获取分页下拉框显示 select
     * @return string
     */
    public function showSelect() {
        $return = '<select name="page_select" onchange="pagechange(this.value);">';
        $totals = $this->_totalPage;
        for ($i = 1; $i <= $this->_totalPage; $i++) {
            if ($i == $this->_nowIndex) {
                $return.='<option  value="' . $this->_getNewUrl($i) . '" selected="selected">' . $i . '/' . $totals . '</option>';
            } else {
                $return.='<option  value="' . $this->_getNewUrl($i) . '">' . $i . '/' . $totals . '</option>';
            }
        }
        unset($i);
        $return.='</select>';
        return $return;
    }

    /**
     * 控制分页显示风格
     * 这里面的设置可以定制，若要定制尽量继承重写
     * @param int $mode
     * @return string
     */
    public function show($mode = 0) {
        switch ($mode) {
            case '1':
                $this->nextPage = '下一页';
                $this->prevPage = '上一页';
                return $this->showPrevPage() . $this->showPagebar() . $this->showNextPage() . '第' . $this->showSelect() . '页';
                break;
            case '2':
                $this->nextPage = '下一页';
                $this->prevPage = '上一页';
                $this->firstPage = '首页';
                $this->lastPage = '尾页';
                return $this->showFirstPage() . $this->showPrevPage() . $this->showNextPage() . $this->showLastPage();
                break;
            case '3':
                $this->nextPage = '下一页';
                $this->prevPage = '上一页';
                return $this->showPrevPage() . $this->showPagebar() . $this->showNextPage();
                break;
            case '4':
                return $this->showPrevBar() . $this->showPrevPage() . $this->showPagebar() . $this->showNextPage() . $this->showNextBar();
                break;
            case '5':
                $this->nextPage = '下一页';
                $this->prevPage = '上一页';
                $this->firstPage = '首页';
                $this->lastPage = '尾页';
                return $this->showFirstPage() . $this->showPrevPage() . '[第' . $this->_nowIndex . '页]' . $this->showNextPage() . $this->showLastPage();
                break;
            case '6';
                $this->nextPage = 'Next ';
                $this->prevPage = 'Before ';
                $this->firstPage = 'First ';
                $this->lastPage = 'Last ';
                return 'Total Page: ' . $this->_totalPage . ' ' . $this->showFirstPage() . $this->showPrevPage() . $this->showMidPage() . $this->showNextPage() . $this->showLastPage();
                break;
            default:
                return $this->showPagebar();
                break;
        }
    }

    /**
     * 设置url头地址
     * @param: String $url
     * @return boolean
     */
    private function _setUrl($url = "") {
        if (!empty($url)) {
            //手动设置
            $this->_url = $url;
        } else {
            //自动获取
            $this->_url = $_SERVER['REQUEST_URI'];
        }
        if (strstr($this->_url, '?')) {
            $replaceArr = array('?'.$this->_pageName . '=' . $this->_nowIndex,
                                '&'.$this->_pageName . '=' . $this->_nowIndex);
            $this->_url = str_replace($replaceArr, '', $this->_url);
        }
    }

    /**
     * 为指定的页面返回地址值
     * @param int $pageno
     * @return string $url
     */
    private function _getNewUrl($pageno = 1) {
        return $this->_url . $this->_getSeparator($this->_url) . $this->_pageName . "=" . $pageno;
    }

    /**
     * 判断url是否含有查询参数
     * @param string $url
     * @return boolean 
     */
    private function _hasQueryString($url) {
        return (strstr($url, '?')) ? true : false;
    }

    /**
     * 获取&或？ 用于url地址
     * @param string $url
     * @return string 
     */
    private function _getSeparator($url) {
        return $this->_hasQueryString($url) ? '&' : '?';
    }

    /**
     * 设置当前页码
     * @param int $nowIndex 
     */
    private function _setNowIndex($nowIndex) {
        if (empty($nowIndex)) {
            //系统获取
            if (isset($_GET["{$this->_pageName}"])) {
                $this->_nowIndex = intval($_GET["{$this->_pageName}"]);
            } else {
                $this->_nowIndex = 1;
            }
        } else {
            //手动设置
            $this->_nowIndex = intval($nowIndex);
        }
        if ($this->_nowIndex >= $this->_totalPage) {
            $this->_nowIndex = $this->_totalPage;
        }
    }

    /**
     * 获取分页显示文字，比如说默认情况下_getFormatText('<a href="">1</a>')将返回[<a href="">1</a>]
     * @param String $str
     * @return string
     */
    private function _getFormatText($str) {
        return $this->formatLeft . $str . $this->formatRight;
    }

    /**
     * 获取组装的anchor链接html
     * @param string $url
     * @param string $text
     * @param string $style
     * @return string 
     */
    private function _getLink($url, $text, $style = '') {
        if ($this->_isAjax) {
            //如果是使用AJAX模式
            return '<a ' . $this->_getClassStyle($style) . ' href="javascript:' . $this->_ajaxActionName . '(\'' . $url . '\',\'' . $this->nowIndex . '\')">' . $text . '</a>';
        } else {
            return '<a ' . $this->_getClassStyle($style) . ' href="' . $url . '">' . $text . '</a>';
        }
    }

    /**
     * 自动处理样式设置
     * @param string $style
     * @return string 
     */
    private function _getClassStyle($style) {
        return $style = empty($style) ? '' : 'class="' . $style . '"';
    }

    /**
     * 获取页码条数字分页逻辑实现
     * @param int $step
     * @return string 
     */
    private function _getPagebar($step) {
        if (strcmp($step, '') == 0) {
            $step = $this->pagebarNum;
        }
        $begin = $this->_getBegin($step);
        $return = '';
        for ($i = $begin; $i < $begin + $step; $i++) {
            if ($i <= $this->_totalPage) {
                if ($i == $this->_nowIndex) {
                    $return .= $this->_getFormatText('<span ' . $this->_getClassStyle($this->nowIndexStyle) . '>&nbsp;' . $i . '&nbsp;</span>');
                } else {
                    $return .= $this->_getFormatText($this->_getLink($this->_getNewUrl($i), $i, $this->anchorStyle));
                }
            } else {
                break;
            }
            //$return .= "\n";
        }
        unset($begin, $i);
        return $return;
    }

    /**
     * 获取页码条中间位置
     * @param int $step
     * @return int 
     */
    private function _getPlus($step) {
        $plus = ceil($step / 2);
        if ($step - $plus + $this->_nowIndex > $this->_totalPage) {
            $plus = ($step - $this->_totalPage + $this->_nowIndex);
        }
        return $plus;
    }

    /**
     * 获取页码条开始页码数
     * @param int $step
     * @return int 
     */
    private function _getBegin($step) {
        $plus = $this->_getPlus($step);
        $begin = $this->_nowIndex - $plus + 1;
        return ($begin >= 1) ? $begin : 1;
    }

    /**
     * 出错处理方式
     * @param string $function
     * @param string $errormsg
     * @throws Exception 
     */
    private function error($function, $errormsg) {
        //die('Error in file <b>'.__FILE__.'</b> ,Function <b>'.$function.'()</b> :'.$errormsg);
        //$message = 'Error in file <b>' . __FILE__ . '</b> ,Function <b>' . $function . '()</b> :' . $errormsg;
        //throw new Exception($message);
        throw new Exception($errormsg);
    }

}

?>
