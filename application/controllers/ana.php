<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ana extends ZB_Controller {
	var $browsers = array();
	var $http_code_count = array();
	var $ana_urls = array();
	var $my_route = array();
	var $spider_list = array();
	var $count = 0;
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model("mo_dianping");
		$this->load->model("mo_ana");

		$this->config->load('ana');
		$this->ana_urls = $this->config->item("ana_urls");
		$this->my_route = $this->config->item("my_route");
		$this->spider_list = $this->config->item("spider_list");

	}
//echo $this->convert(memory_get_usage(true))."  "; 
function convert($size){ 
$unit=array('b','kb','mb','gb','tb','pb'); 
return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i]; 
} 

	// data.zanbai.com/ana/normal
	// zan.com/ana/normal
	public function normal(){

        set_time_limit(3000);
        ini_set('memory_limit', '2G');
        
		$path = "/var/log/httpd/zanbai2";
		$path = "/home/zanbai";
		$files = $this->get_files($path);
		//echo $this->convert(memory_get_usage(true))."  "; 
		//$file_name = "/var/log/httpd/zanbai2/zanbai.com_20140713_access_log";
		foreach($files as $file_name){
			$start_time = time();
			$file_name_md5 = md5($file_name);
			$exist = $this->mo_ana->get_anafile_by_filenamemd5($file_name_md5);
			if($exist){
				continue;
			}
			$contents = file($file_name);
			$i = 1;
			//var_dump(count($contents));die;
			foreach($contents as $content){
				$re = $this->format_content($content);
				$i++;
				if($i > 1117800){

					echo 123;die;
					//var_dump(array_sum($this->http_code_count));
					//var_dump(arsort($this->http_code_count), $this->http_code_count);
					//var_dump(array_sum($this->browsers));
					//var_dump(arsort($this->browsers), $this->browsers);
					//die;
				}

			}
			//var_dump($this->count);
			$end_time = time();
			$add_data = array();
			$add_data['file_name'] = $file_name;
			$add_data['file_name_md5'] = $file_name_md5;
			$add_data['ctime'] = $add_data['mtime'] = $end_time;
			$add_data['format_time'] = $end_time - $start_time;

			//echo $this->convert(memory_get_usage(true))."  "; 
			$this->mo_ana->add_ana_file($add_data);

			unset($contents, $add_data, $start_time, $end_time);
			$contents = $add_data = $start_time = $end_time = null;

			echo "succ".$file_name;
			//die;
		}

		echo 'ok';
	}

	// zan.com/ana/format_content
	public function format_content($content=""){
		//$content = '"123.120.34.206 "[28/Jul/2014:10:31:01 +0800] "GET /logout/?source_url=%2Fyork%2F31%2F HTTP/1.1 "302 "20 "bdshare_firstime=1403233838575; __curBgImg__=url(/images/city/lundun.jpg); city_id=21; Hm_lvt_ff68fee1a56f64563d79ce07806ff504=1406082778,1406249378,1406276092,1406513741; Hm_lpvt_ff68fee1a56f64563d79ce07806ff504=1406513946; CNZZDATA1000199935=1503144281-1405558843-%7C1406513746; zanbai_session=a%3A6%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%2290294a95b07984a044e3ffb033f7bbe7%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A14%3A%22123.120.34.206%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A99%3A%22Mozilla%2F5.0+%28Windows+NT+6.1%29+AppleWebKit%2F537.1+%28KHTML%2C+like+Gecko%29+Chrome%2F21.0.1180.89+Safari%2F537.1%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1406514396%3Bs%3A9%3A%22user_data%22%3Bs%3A0%3A%22%22%3Bs%3A9%3A%22user_info%22%3Ba%3A4%3A%7Bs%3A3%3A%22uid%22%3Bs%3A10%3A%221395725734%22%3Bs%3A5%3A%22uname%22%3Bs%3A15%3A%22%E8%B5%9E%E4%BD%B0%E5%B0%8F%E8%BE%BE%E4%BA%BA%22%3Bs%3A5%3A%22image%22%3Bs%3A64%3A%22http%3A%2F%2Fzanbai.b0.upaiyun.com%2F2014%2F03%2Fb68639e92fc62902.jpg%21head80%22%3Bs%3A6%3A%22gender%22%3Bs%3A1%3A%220%22%3B%7D%7D8d2ef2cb90e38ac2b9dc2060d0cf9781 "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.89 Safari/537.1 "http://www.zanbai.com/york/31/';
		if(!$content){
			return;
		}
		$to_type = $city_id = $shop_id = $url_id = 0;
		$f_type = $f_city_id = $f_shop_id = $f_url_id = 0;
		$uid = 0;
		
		$diff_list = array("robots.txt", "loading.gif", "!head80");
		$to_url = "";
		foreach($diff_list as $diff){
			if(strstr($content, $diff) !== false){
				return;
			}
		}

		$content = trim($content);
		$content_md5 = md5($content);
		$exist = $this->mo_ana->check_exist($content_md5);
		if($exist){
			return ;
		}
		$tmp = explode('"', $content);
		foreach($tmp as $k => $v){
			$tmp[$k] = trim($v);
		}
		
		if(count($tmp)==7){
			$first = $tmp[0];
			$first_tmp = explode(" ", $first);
			$ip_read = $first_tmp[0];
			$fk_time = $first_tmp[3]." ".$first_tmp[4];
			$get = $tmp[1];
			if(strstr($get, "/index.php")){
				$get = str_replace("/index.php", "", $get);
			}
			$third = $tmp[2];
			$third_tmp = explode(" ", $third);
			$http_code = $third_tmp[0];
			$http_length = $third_tmp[1];
			$browser = $tmp[5];
			$from_url = $tmp[3];
			if(strstr($from_url, "/index.php")){
				$from_url = str_replace("/index.php", "", $from_url);
			}
			//var_dump($first_tmp, $tmp);
		}else{
			$ip_read = $tmp[1];
			$fk_time = $tmp[2];
			$get = $tmp[3];
			$http_code = $tmp[4];
			$http_length = $tmp[5];
			$session = $tmp[6];
			$browser = $tmp[7];
			$from_url = $tmp[8];
		}
		if($http_code == 301){
			return;
		}

		$fk_time = substr($fk_time, 1, -1);

		$time = strtotime($fk_time);
		$time_read = date("Y-m-d H:i:s", $time);
		$hour_read = date("Y-m-d H:00:00", $time);
		$hour = strtotime($hour_read);
		$day_read = date("Y-m-d 00:00:00", $time);
		$day = strtotime($day_read);
		$ip = ip2long($ip_read);
		$js_css = $this->js_css($get);
		if($js_css){
			return;
		}
		$spider_re = $this->check_spider($browser);
		$spider = $spider_re['spider'];
		$spider_type = $spider_re['spider_type'];
		if($spider_type > 0){
			return;
		}
		
		if($http_code == 200 || ($http_code ==302  && strstr($get, "logout") !== false)){
			$get_list = $this->format_get($get, $content);
			$to_type = $get_list['type'];
			$city_id = $get_list['city'];
			$shop_id = $get_list['shop_id'];
			$url_id = $get_list['id'];
			$to_url = $get_list['url'];
			if(strlen($to_url) > 300){
				$to_url = substr($to_url, 0, 200);
			}
			
			if($from_url != "-" && strpos($from_url, "zanbai.com")){
				$parse_url = parse_url($from_url);
				if($parse_url && isset($parse_url['path'])){
					$format = "GET ".$parse_url['path'];
					$url_query = "";
					if(isset($parse_url['query'])){
						$url_query = $parse_url['query'];
						//var_dump($from_url);
					}
					//var_dump($parse_url);
					$from_list = $this->format_get($format, $content, $url_query);
					//var_dump($from_list, parse_url($from_url));
					$f_type = $from_list['type'];
					$f_city_id = $from_list['city'];
					$f_shop_id = $from_list['shop_id'];
					$f_url_id = $from_list['id'];
					$from_url = $from_list['url'];
				}
			}
		}elseif($code == 302){

		}

		if(isset( $this->http_code_count[$http_code] )){
			//$this->http_code_count[$http_code] += 1;
		}else{
			//$this->http_code_count[$http_code] = 1;
		}

		if(isset( $this->browsers[$browser] )){
			//$this->browsers[$browser] += 1;
		}else{
			//$this->browsers[$browser] = 1;
		}
		

		//电脑，移动
		$browser_type = 0;

		$add_data['f_type'] = $f_type;
		$add_data['f_city_id'] = $f_city_id;
		$add_data['f_shop_id'] = $f_shop_id;
		$add_data['f_url_id'] = $f_url_id;
		$add_data['from_url'] = $from_url;

		$add_data['ip'] = $ip;
		$add_data['ip_read'] = $ip_read;
		$add_data['time'] = $time;
		$add_data['time_read'] = $time_read;
		$add_data['hour'] = $hour;
		$add_data['hour_read'] = $hour_read;
		$add_data['day'] = $day;
		$add_data['day_read'] = $day_read;
		$add_data['to_url'] = $to_url;
		$add_data['to_type'] = $to_type;
		$add_data['city_id'] = $city_id;
		$add_data['shop_id'] = $shop_id;
		$add_data['url_id'] = $url_id;
		$add_data['from_url'] = $from_url;
		$add_data['http_code'] = $http_code;
		$add_data['http_length'] = $http_length;
		$add_data['uid'] = $uid;
		$add_data['browser_type'] = $browser_type;
		$add_data['content'] = $content;
		$add_data['content_md5'] = $content_md5;
		$add_data['spider'] = $spider;
		$add_data['spider_type'] = $spider_type;
		$this->mo_ana->add_ana($add_data);

		unset($content, $add_data);
		$content = $add_data = null;
	}
/*
$ana_urls['0'] = "default";
$ana_urls['1'] = "home";
$ana_urls['2'] = "city";
$ana_urls['3'] = "shop";
$ana_urls['4'] = "brandstreet";
$ana_urls['5'] = "citymap";
$ana_urls['6'] = "dianping";
$ana_urls['7'] = "shoptips_city";
$ana_urls['8'] = "discount_city";
$ana_urls['9'] = "shoptips_content";
$ana_urls['10'] = "discount_content";
$ana_urls['11'] = "help";
$ana_urls['12'] = "links";
$ana_urls['13'] = "sitemap";
$ana_urls['14'] = "fav";
$ana_urls['15'] = "sorry";
$ana_urls['16'] = "coupon_info";
$ana_urls['40'] = "aj";
*/
	public function format_get($get, $content = "", $query = ""){
		$city = $shop_id = $id = 0;

		$ana_urls = $this->ana_urls;
		$my_route = $this->my_route;

		$get_list = explode(" ", $get);
		if($get_list[0] == "POST"){
			return;
		}
		if($get_list[0] != "GET"){
			return;
		}

		$get_two = $get_list[1];

		// venezia-shoppingmap /shoptipsinfo/266 losangeles-shoppingtips
		// /discountcity/2 /losangeles-shopdiscount 
		// /discount/1962 /boston/140/ 

		if($get_two == "/"){
			$type = 1;
			return array("type"=>$type, "city"=>$city, "shop_id"=>$shop_id, "id"=>$id, "url"=>$get_two);
		}
		if($get_two == "/home/more/"){
			$type = 19;
			return array("type"=>$type, "city"=>$city, "shop_id"=>$shop_id, "id"=>$id, "url"=>$get_two);
		}
		$tmp = explode("/", $get_two);
		if(!isset($tmp[1])){
			return array("type"=>0, "city"=>$city, "shop_id"=>$shop_id, "id"=>$id, "url"=>$get_two);
		}
		if($tmp[1] == "aj"){
			$type = 400;
			return array("type"=>$type, "city"=>$city, "shop_id"=>$shop_id, "id"=>$id, "url"=>$get_two);
		}
		if($tmp[1] == "logout"){
			$type = 28;
			return array("type"=>$type, "city"=>$city, "shop_id"=>$shop_id, "id"=>$id, "url"=>$get_two);
		}

		
		if(strstr($content, "admin/discount/edit") !== false){
			//var_dump($content, $get, $get_two, $tmp);die;

		}
		if(isset($my_route[$tmp[1]]) && (!isset($tmp[2]) || !$tmp[2])){//城市
			$city = $my_route[$tmp[1]];
			$type = 2;
		}elseif($tmp[1] == "city"){// /city/1
			if(isset($tmp[2])){
				$shop_id = $tmp[2];
			}elseif($query){
				parse_str($query, $output);
				if(isset($output['city'])){
					$city = $output['city'];
				}else{
				}
			}else{
			}
			
			$type = 2;
		}elseif(strstr($tmp[1], "city?city=")){
			$download_info = parse_url($tmp[1]);
			parse_str($download_info['query'], $output);
			$city = $output['city'];
			$type = 2;
		}elseif( isset($my_route[$tmp[1]]) && $tmp[2] ){//shop
			$shop_id = $tmp[2];
			$type = 3;
		}elseif($tmp[1] == "shop" && isset($tmp[2]) && is_numeric($tmp[2])){// /shop/615
			if(isset($tmp[2])){
				$shop_id = $tmp[2];
			}
			
			$type = 3;
		}elseif(strstr($tmp[1], "shop?shop_id=")){
			$download_info = parse_url($tmp[1]);
			parse_str($download_info['query'], $output);
			$shop_id = $output['shop_id'];
			$type = 3;
		}elseif(isset($tmp[2]) && strstr($tmp[2], "shop?shop_id=")){
			$download_info = parse_url($tmp[2]);
			parse_str($download_info['query'], $output);
			$shop_id = $output['shop_id'];
			$type = 3;

		}elseif($tmp[1] == "brandstreet"){//品牌墙
			if(isset($tmp[2])){
				$shop_id = $tmp[2];
			}
			$type = 4;
		}elseif(strstr($get_two, "-shoppingmap")){//citymap
			$tips_list_tmp = explode("-", $tmp[1]);
			if(isset($my_route[$tips_list_tmp[0]])){
				$city = $my_route[$tips_list_tmp[0]];
			}
			$type = 5;
		}elseif($tmp[1] == "ping"){//dianping
			if(isset($tmp[2])){
				$id = $tmp[2];
			}else{
			}
			$type = 6;
		}elseif(strstr($tmp[1], "ping?id")){
			$download_info = parse_url($tmp[1]);
			parse_str($download_info['query'], $output);
			$id = $output['id'];
			$type = 6;
		}elseif($tmp[1] == "shoptips"){//攻略
			$city = $tmp[2];
			$type = 7;
		}elseif(strstr($get_two, "-shoppingtips")){//攻略
			$tips_list_tmp = explode("-", $tmp[1]);
			if(isset($my_route[$tips_list_tmp[0]])){
				$city = $my_route[$tips_list_tmp[0]];
			}else{
			}
			$type = 7;
		}elseif($tmp[1] == "discountcity"){//discountcity
			$id = $tmp[2];
			$type = 8;
		}elseif(strstr($get_two, "-shopdiscount")){//折扣
			$tips_list_tmp = explode("-", $tmp[1]);
			$city = $my_route[$tips_list_tmp[0]];
			$type = 8;
		}elseif($tmp[1] == "shoptipsinfo"){//攻略详情
			if(isset($tmp[3])){
				if($tmp[3]){
					$city = $tmp[2];
					$id = $tmp[3];
				}else{
					$id = $tmp[2];
				}
			}elseif(isset($tmp[2])){
				$id = $tmp[2];
			}
			$type = 9;
		}elseif($tmp[1] == "discount"){//discount
			$id = $tmp[2];
			$type = 10;
		}elseif($tmp[1] == "help"){//help
			if(isset($tmp[2])){
				$id = $tmp[2];
			}
			$type = 11;
		}elseif(strstr($tmp[1], "help?tab=")){
			$download_info = parse_url($tmp[1]);
			parse_str($download_info['query'], $output);
			$id = $output['tab'];
			$type = 3;
		}elseif($tmp[1] == "links"){//links
			if(isset($tmp[2])){
				$id = $tmp[2];
			}
			$type = 12;
		}elseif($tmp[1] == "sitemap"){//sitemap
			$id = $tmp[2];
			$type = 13;
		}elseif($tmp[1] == "fav"){//fav
			$id = $tmp[2];
			$type = 14;
		}elseif($tmp[1] == "sorry"){//fav
			$type = 15;
		}elseif($tmp[1] == "coupon_info"){//coupon_info
			$id = $tmp[2];
			$shop_id = $tmp[2];
			$type = 16;
		}elseif($tmp[1] == "register"){//register
			$type = 17;
		}elseif($tmp[1] == "coupon" && isset($tmp[2]) && $tmp[2] == "download_coupon"){// /coupon/download_coupon/
			$download_info = parse_url($get_two);
			if($download_info && isset($download_info['query'])){
				parse_str($download_info['query'], $output);
				if(isset($output['id'])){
					$id = $output['id'];
				}
				if(isset($output['shop_id'])){
					$shop_id = $output['shop_id'];
				}
			}
			$type = 18;
		}elseif($tmp[1] == "admin"){//admin
			$type = 20;
		}elseif($tmp[1] == "mobile"){//mobile
			$type = 21;
		}elseif($tmp[1] == "discountshop"){//discountshop
			$type = 22;
			$shop_id = $tmp[2];
		}elseif($tmp[1] == "callback" && $tmp[2] == "weibo"){//callback_weibo
			$type = 23;
		}elseif($tmp[1] == "callback" && $tmp[2] == "qq"){//callback_qq
			$type = 24;
		}elseif(strstr($tmp[1], "myprofile?")){//myprofile
			$download_info = parse_url($get_two);
			parse_str($download_info['query'], $output);
			if(isset($output['uid'])){
				$id = $output['uid'];
			}
			$type = 25;
		}elseif($tmp[1] == "shop" && isset($tmp[2]) && $tmp[2] == "download"){// /shop/615
			$download_info = parse_url($get_two);
			if($download_info && isset($download_info['query'])){	
				parse_str($download_info['query'], $output);
				if(isset($output['shop_id'])){
					$shop_id = $output['shop_id'];
					$id = $output['shop_id'];
				}
			}
			$type = 26;
		}elseif(isset($tmp[2]) && $tmp[2] == "directions"){
			$shop_lower_name = $tmp[1];
			$shop_id = $this->mo_shop->get_id_by_lowername($shop_lower_name);
			$type = 27;
		}elseif($tmp[1] == "guide"){//锦囊
			$type = 29;
			$id = $tmp[2];
		}else{
			$type = 0;
		}
		if($query){
			$get_two .= "?".$query;
		}
		return array("type"=>$type, "city"=>$city, "shop_id"=>$shop_id, "id"=>$id, "url"=>$get_two);
		//var_dump($get_list);
	}


	public function js_css($content){
		$list = array('/.js/', '/.css/', '/favicon.ico/', '/.jpg/', '/.png/', '/.jpeg/');
		foreach($list as $pattern){
			if(preg_match($pattern, $content)){
				unset($list);$list = null;
				return true;
			}
		}
		unset($list);$list = null;
		return false;
	}

	public function check_spider($content){
		$spider_list = $this->spider_list;
		foreach($spider_list as $type => $name){
			if(strstr($content, $name) !== false){
				return array("spider"=>$name, "spider_type"=>$type);
			}
		}
		return array("spider"=>'', "spider_type"=>0);
	}


    function get_files($dir) {
        $dir = realpath($dir) . "/";
        $files = array();

        if (!is_dir($dir)) {
            return $files;
        }

        $pattern = $dir . "*";
        $file_arr = glob($pattern);

        foreach ($file_arr as $file) {
            if (is_dir($file)) {
                $temp = $this->get_files($file);
                if (is_array($temp)) {
                    $files = array_merge($files, $temp);
                }
            } else {
                $files[] = $file;
            }   //  end if
        }
        return $files;
    }

/*
CREATE TABLE IF NOT EXISTS `zb_ana_new` (
  `id` bigint(32) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ip` int(10) NOT NULL DEFAULT '0',
  `ip_read` varchar(100) NOT NULL DEFAULT '',
  `time` varchar(30) NOT NULL DEFAULT '',
  `time_read` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `day` int(10) NOT NULL DEFAULT '0',
  `day_read` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `to_url` varchar(100) NOT NULL DEFAULT '',
  `to_type` int(10) NOT NULL DEFAULT '0',
  `city_id` int(10) NOT NULL DEFAULT '0',
  `shop_id` int(10) NOT NULL DEFAULT '0',
  `url_id` int(10) NOT NULL DEFAULT '0',
  `from_url` varchar(100) NOT NULL DEFAULT '',
  `http_code` int(10) NOT NULL DEFAULT '0',
  `http_length` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `browser_type` int(10) NOT NULL DEFAULT '0' COMMENT '电脑，移动端',
  `content` varchar(100) NOT NULL DEFAULT '',
  `content_md5` varchar(32) NOT NULL DEFAULT '',
  `spider` varchar(100) NOT NULL DEFAULT '',
  `spider_type` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
*/
}