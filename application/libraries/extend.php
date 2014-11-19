<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/////////////////////////////////////////////////////////////////////////////

// @Author: zps@mbachina.com
/////////////////////////////////////////////////////////////////////////////
class extend
{
	/**
     * 构造函数
     */
    function __construct()
    {
		$this->ci =& get_instance();
    }
	
	/**
	 *	前台默认翻页
	 *      * @param int    $pagecount
     * @param int    $page
     * @param int    $result_num
     * @param int    $page_size
     */
	function defaultPage($pagecount, $page, $result_num, $page_size = 10,$k = 0){
		$action        = $_SERVER['REDIRECT_URL'];
		$data=array('/index.php/'=>'/');
		//var_dump($_SERVER, $action);
		$action=strtr($action,$data);
		$pagetable     = "<ul>";
		$pagecountlist = "";
		$temp          = "";
		
		if(isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])){
		$query = explode("&",$_SERVER['QUERY_STRING']);
			while(list($index, $value) = each($query)) {
				$a = explode("=",$value);
				if(strcmp(strtolower($a[0]),"page")!=0){
					@$temp .= $a[0]."=".$a[1]."&";
				}
			}
		}else{
			$temp = "";
		}
		
		if($pagecount > 1)
		{
			$pagetable .= '<li><a href="'.$action.'?'.$temp.'page=1">首页</a></li>';
			$start = (ceil($page/10)-1)*10;
			$end   = ceil($page/10)*10;
			if($start <= 0) $start = 1;
			if($end   >= $pagecount) $end = $pagecount;
			for($i=$start;$i<=$end;$i++)
			{	
				if($page == $i)
					$pagecountlist .= "<li class='active'><a href='#this'>".$i."</a></li>";
				else
					$pagecountlist .= "<li><a href=" . $action . "?" . $temp . "page=" . $i . ">".$i."</a></li>";
			}
			$pagetable .= $pagecountlist;
			$pagetable .= '<li><a href="'.$action.'?'.$temp.'page='.$pagecount.'">尾页</a></li>';
		}
		$pagetable .= "</ul>";
		
		return $pagetable;
	}


	function webPage($action, $pagecount, $page, $result_num, $page_size = 10,$k = 0){		
		$pagetable     = "";
		$pagecountlist = "";
		$temp          = "";
		if($pagecount > 1)
		{
			$pagetable .= "<a href='javascript:;' action-type='changePage' action-data='".$action."&page=1' >首页</a>";
			$start = (ceil($page/10)-1)*10;
			$end   = ceil($page/10)*10;
			if($start <= 0) $start = 1;
			if($end   >= $pagecount) $end = $pagecount;
			for($i=$start;$i<=$end;$i++)
			{	
				if($page == $i)
					$pagecountlist .= "<a class='current' href='javascript:;'>".$i."</a>";
				else
					$pagecountlist .= "<a href='javascript:;' action-type='changePage' action-data='".$action."&page=".$i."' >".$i."</a>";
			}
			$pagetable .= $pagecountlist;
			$pagetable .= "<a href='javascript:;' action-type='changePage' action-data='".$action."&page=".$pagecount."'>尾页</a>";
		}
		$pagetable .= "";
		
		return $pagetable;
	}




}
