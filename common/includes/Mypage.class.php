<?php
/**
 * 分页 用于自定义项目的分页
 */
include_once('./Page.class.php');
class Mypage extends Page{
	public function __construct($array){
		parent::__construct($array);	
	}

	public function show1(){
		$this->nextPage = '下一页&gt;';
		$this->prevPage = '&lt;上一页';
		$this->firstPage = '|&lt首页';
		$this->fastPage = '尾页&gt;|';
		$total = $this->getTotal();
		if ($total == 0) {
			return "<table><tr><td>" . 总共 . '<b> 0' . '</b> ' . 条 . "  &nbsp;&nbsp;&nbsp;<span>" . 刷新 . "</span></td>    <td align='right' class='page' >" . $this->showFirstPage() . $this->showPrevPage() . $this->showNextPage() . $this->showLastPage() . "&nbsp;&nbsp;&nbsp;&nbsp;</td>  </tr></table>";
		} else {
			return "<table><tr><td>" . 总共 . '<b> ' . $total . '</b> ' . 条 . "  &nbsp;&nbsp;&nbsp;<a href='#!' onclick=\"alert('add javascript function to flush.');\">" . 刷新 . "</a></td><td align='right' class='page' >" . $this->showFirstPage() . $this->showPrevPage() . $this->showNextPage() . $this->showLastPage() . $this->showSelect() . "</td>  </tr></table>";
		}
	}



	public function show2(){
			$this->nextPage = '<img src="./images/blank.gif" class="page_next">';
			$this->prevPage = '<img src="./images/blank.gif" class="page_prev">';
			$this->firstPage = '<img src="./images/blank.gif" class="page_first">';
			$this->lastPage = '<img src="./images/blank.gif" class="page_last">';
		$total = $this->getTotal();
			if ($total == 0) {
				return "<span>" . $this->showFirstPage() . $this->showPrevPage() . $this->showNextPage() . $this->showLastPage() . '　' . '刷新' . ' 共0' . ' 条' . '</span>';
			} else {
				return "<span>" . $this->showFirstPage() . $this->showPrevPage() . $this->showNextPage() . $this->showLastPage() . ' ' . $this->showSelect() . ' ' . '刷新' . ' 共' . $total . ' 条' . '</span>';
			}
	}

}


?>
