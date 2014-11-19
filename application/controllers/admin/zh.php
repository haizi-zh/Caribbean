<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class zh extends ZB_Controller {
		
	const PAGE_ID = 'directions';
	const PAGESIZE = 50;
	public function __construct(){
		parent::__construct();

	}
	// zan.com/admin/zh/lists
	public function lists(){
		$url = "http://www.zhihu.com/question/23748267?sort=created";
		$url = "http://www.zhihu.com/question/24660045?sort=created";
		$this->baidu($url);
	}

	// zan.com/admin/zh/qrcode
	public function qrcode(){
 		include( APPPATH.'/third_party/qrcode/qrlib.php'); 
     
    	// outputs image directly into browser, as PNG stream 
    	QRcode::png('龙红军15810033714');
    	QRcode::png('龙红军15810033714', "/tmp/1.png"); 

	}
	public function  baidu($url){

        $today = date("Ymd", time());

		require_once (APPPATH."/third_party/simple_html_dom-master/"."simple_html_dom.php");
		$url_md5 = md5($url);
        $save_path = "/home/long/".$url_md5;
        unlink($save_path);
        if(!file_exists($save_path)){
        	//var_dump(123);die;
        	$content = file_get_contents($url);
        	file_put_contents($save_path, $content);
        }else{
        	//$html = file_get_html($url);
        }

        $format_time = 0;
        $content = file_get_contents($save_path);
        //您的访问出错了

        if(strlen($content)<10000){
        	unlink($save_path);
        	echo "路由出错";
        	return 0;
        }

        if(strstr($content, "没有找到")){
        	unset($content);
        	$content = null;
        }else{
        	 var_dump(($content));
	        $html = new simple_html_dom();
	        $html->load_file($save_path);
			foreach($html->find('div .f13 span') as $element){
				//echo $element . '<br>';
				$element = strip_tags($element);
				//var_dump($element);
				$tmp = explode("&nbsp;", $element);
				$format_url = $tmp[0];
				$format_time = $tmp[1];
				break;
				//var_dump($tmp);
				//die;
			}
			unset($html);
			$html = null;

        }

        return $format_time;
	}
}