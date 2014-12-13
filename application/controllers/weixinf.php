<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// zanbai.com/weixinf/create_menu 
	// zanbai.com/weixinf/get_menu 
	// zanbai.com/weixinf/delete_menu 

class weixinf extends ZB_Controller {
	CONST APPID = 'wxedad39e91c7422cd';
	CONST APPSECRET = 'e6130d79e0a4f616f716a24ba6ddb785';

	CONST NOT_FOUND = "啊哦！小赞还在努力搬运该城市购物信息当中，您可以先到其它城市血拼哦！\n\n";

	CONST WELCOME = "赞佰网（www.zanbai.com）是国内出境购物第一平台，为您提供最齐全的海外购物中心信息、最及时的商场及品牌优惠信息以及最详尽独特的专属购物攻略,出境购物,一站搞定！\n\n";

	CONST HELP_ALL = "☆输入“城市名称+购物”，帮您找到该城市最热门购物地，如“纽约购物”\n\n☆输入“城市名称+优惠券”，即可获得该城市最热门商家优惠券。如“纽约优惠券”\n\n☆输入“城市名称+攻略”，获取达人撰写的最详尽购物攻略。如“纽约攻略”\n\n";

	public function __construct(){
		parent::__construct();
		require_once  APPPATH.'/third_party/weixin/wechat.class.php';
	}

	public function index(){
		$options = array(
		    'token'=>'hongjun', //填写你设定的key
		);

		$weObj = new Wechat($options);
		$weObj->valid();

		$city_help = '☆输入“城市名称+购物”，帮您找到该城市最热门购物地，如“纽约购物”'."\n\n";

		$coupon_help = '赞佰网为您独家提供美国各城市优惠券。'."\n\n";
		$coupon_help .= '☆输入“城市名称+优惠券”，即可获得该城市最热门商家优惠券。如“纽约优惠券”'."\n\n";
		$coupon_help .= '☆输入“MC”，即可获得美国最大百货公司梅西百货优惠券'."\n\n";
		$coupon_help .= '☆输入“BC”，即可获得美国最时尚连锁百货公司Bloomingdales优惠券'."\n\n";
		$coupon_help .= '☆输入“KC”，即可获得美国最大珠宝连锁店kay jewellers优惠券'."\n\n";

		$tips_help = '赞佰网为您提供最齐全的出境购物攻略。'."\n\n";
		$tips_help .= '输入“城市名称+攻略”，获取达人撰写的最详尽购物攻略。如“纽约攻略”'."\n\n";

		$type = $weObj->getRev()->getRevType();
		$getRevEvent = $weObj->getRevEvent();
		$content = $weObj->getRevContent();
		$ctime = $weObj->getRevCtime();
		$fromusername = $weObj->getRevFrom();

		$event = $key = "";
		if($type == "event"){
			$event = $getRevEvent['event'];
			$key = $getRevEvent['key'];
		}

		$this->add_event($type, $event, $key, $content, $ctime, $fromusername);
		file_put_contents('/tmp/log.txt', "123". $getRevEvent. print_r($getRevEvent, true)."33\n",FILE_APPEND);

		//MENU_KEY_MENU_CITY
		//MENU_KEY_MENU_REC
		file_put_contents('/tmp/log.txt',"type:".$type."\n",FILE_APPEND);
		file_put_contents('/tmp/log.txt',"content:".$content."\n",FILE_APPEND);
		if($getRevEvent && is_array($getRevEvent)){
			//纽约券
		    if($getRevEvent['key'] == "MENU_KEY_MENU_CITY"){
		    	$weObj->text($coupon_help)->reply();
		        exit;
		    }
		    // tips
		    if($getRevEvent['key'] == "MENU_KEY_MENU_REC"){
		        $weObj->text($tips_help)->reply();
		        exit;
		    }
		    if($getRevEvent['key'] == "MENU_KEY_MENU_SHOP"){
		        $weObj->text($city_help)->reply();
		        exit;
		    }
		}
		   
		//$getRevFrom = $weObj->getRevFrom();
		
		$coupons = array("mc"=>"mc", "bc"=>"bc", "kc"=>"kc");
		
		switch($type) {
		    case Wechat::MSGTYPE_TEXT:
		    		if($content=="帮助"||$content=="help"){
		    			$weObj->text(self::HELP_ALL)->reply();
		    		} elseif (stripos($content, "券") !==false || stripos($content, "优惠") !==false ||
		    			stripos($content, "優惠") !==false 
		    		){
		    			$re_text = $this->get_coupons($content);
		    		}elseif(stripos($content, "购物") !==false ){
		    			$re_text = $this->get_shops($content);
		    		}elseif(stripos($content, "攻略") !==false ){
		    			$re_text = $this->get_city_tips($content);
		    		}elseif(isset($coupons[strtolower($content)])){
		    			$re_text = $this->get_coupons($coupons[strtolower($content)]);
		    		}else{
		    			$re_text = $this->check_country_city($content);
		    		}

		    		if($re_text){
						if(is_array($re_text)){
							$weObj->news($re_text)->reply();
						}else{
							$weObj->text($re_text)->reply();
						}
		    		}

		            exit;
		            break;
		    case Wechat::MSGTYPE_IMAGE:
		            break;
		    default:
		            $weObj->text(self::WELCOME.self::HELP_ALL)->reply();
		}

	}

	public function check_country_city($country_city="美国"){
		$country_city = trim($country_city);
		$country_id = $city_id = 0;
		$country_info = $this->mo_geography->get_country_by_name($country_city);
		if($country_info){
			$country_id = $country_info['id'];
		}else{
			$city_info = $this->mo_geography->get_city_by_name($country_city);
			if($city_info){
				$city_id = $city_info['id'];
			}
		}
		if($country_id || $city_id){
			return self::HELP_ALL;
		}else{
			$content = self::NOT_FOUND;
			return $content;
		}

	}
	// data.zanbai.com/weixinf/get_coupons
	public function get_coupons($content="纽约券"){
		$this->load->model("mo_shop");
		$this->load->model("mo_coupon");
		$this->load->model("mo_geography");
		$coupons = array("mc"=>"mc", "bc"=>"bc", "kc"=>"kc");
		$coupon_infos = array();
		if(isset($coupons[$content])){
			$coupon_ids = array();
			if($content=="bc"){
				$coupon_ids = array(197,198,199,200);
			}elseif($content=="mc"){
				$coupon_ids = array(201);

			}elseif($content == "kc"){
				$coupon_ids = array(206,208);
			}
			if($coupon_ids){
				$coupon_infos = $this->mo_coupon->get_coupon_infos($coupon_ids);
			}else{
				$error = 1;
			}
		}else{
			$city = str_replace(array("优惠券", "券", "+"), "", $content);
			$city = trim($city);
			$country_info = $this->mo_geography->get_country_by_name($city);
			if($country_info){
				$country_id = $country_info['id'];
				$shop_ids = $this->mo_shop->get_shopids_by_country($country_id);
			}else{
				$city_info = $this->mo_geography->get_city_by_name($city);
				if(!($city_info)){
					$content = self::NOT_FOUND;
					return $content;
				}
				$city_id = $city_info['id'];
				$shop_ids = $this->mo_shop->get_shopids_by_city($city_id);
			}
			
			$coupon_infos = $this->mo_coupon->get_coupons_by_shopids($shop_ids);
		foreach($coupon_infos as $k=> $v){
			//var_dump($v['id'] ."=>". $v['download_count']);
		}
		//var_dump(123123123123);
			$coupon_infos = tool::list_sort_by($coupon_infos, "download_count", "desc");
			$coupon_infos = tool::array_rand_by_number($coupon_infos, 3);
		}

		foreach($coupon_infos as $k=> $v){
			//var_dump($v['id'] ."=>". $v['download_count']);
		}

		//var_dump($coupon_infos);die;
		if($coupon_infos){
			$i = 0;
			$re = array();
			foreach($coupon_infos as $v){
			  	$i++;
			  	if($i > 10){
			  		break;
			  	}
			  	$tmp = array();
			  	$tmp['Title'] = $v['title'];
			  	$tmp['Description'] = $v['title'];
			  	$tmp['PicUrl'] = $v['pics_list'][0];
			  	$tmp['Url'] = "http://www.zanbai.com/coupon_info/".$v['id']."/1/";
			  	$re[] = $tmp;
			}
			return $re;
		}

		$content = self::NOT_FOUND;
		return $content;

	}

	// data.zanbai.com/weixin/get_shops
	public function get_shops($city="旧金山购物"){
		$city = str_replace(array("购物", "+"), "", $city);

	  $this->load->model("mo_shop");
	  $this->load->model("mo_geography");
	  $country_id = $city_id = 0;
		$country_info = $this->mo_geography->get_country_by_name($city);
		if($country_info){
			$country_id = $country_info['id'];
			$shop_ids = $this->mo_shop->get_shopids_by_country($country_id);
		}else{
			$city_info = $this->mo_geography->get_city_by_name($city);
			if(!($city_info)){         //取出的数据为空的时候
				$content = self::NOT_FOUND;
				return $content;
			}
			$city_id = $city_info['id'];
			$shop_ids = $this->mo_shop->get_shopids_by_city($city_id);
		}
	  $list = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
	  if(!($list)){         //取出的数据为空的时候
	      $content = self::NOT_FOUND;
	      return $content;
	  }

	  $list = tool::array_rand_by_number($list, 3);

	  $re = array();
	  $i = 0;
	  foreach($list as $k => $v){
	  	$i++;
	  	if($i > 10){
	  		break;
	  	}
	  	$tmp = array();
	  	$tmp['Title'] = $v['name'];
	  	$tmp['Description'] = $v['name'];
	  	$tmp['PicUrl'] = $v['pic'];
	  	$tmp['Url'] = $v['ext']['shop_url'];
	  	$re[] = $tmp;
	  	unset($list[$k]);
	  }
	  return $re;
	}

	// data.zanbai.com/weixin/get_city_tips



	public function get_city_tips($city="美国"){
	  $city = str_replace(array("攻略", "+"), "", $city);

	  $this->load->model("mo_discount");
	  $this->load->model("mo_geography");
	  $country_id = $city_id = 0;
		$country_info = $this->mo_geography->get_country_by_name($city);
		if($country_info){
			$country_id = $country_info['id'];
			// get_info_by_country_type
			  $re = $this->mo_discount->get_info_by_country_type($country_id, 2);
			  $list = $re['list'];
			  //var_dump($list);
		}else{
			  $city_info = $this->mo_geography->get_city_by_name($city);
			  if(!($city_info)){         //取出的数据为空的时候
			      $content = self::NOT_FOUND;
			      return $content;
			  }
			  $country_id = $city_info['country_id'];
			  $city_id = $city_info['id'];
			  $re = $this->mo_discount->get_info_by_country_city_shop_type($country_id, $city_id, 0, 2);
			  $list = $re['list'];
		}
	  
	  if(!($list)){         //取出的数据为空的时候
	      $content = self::NOT_FOUND;
	      return $content;
	  }

	  shuffle($list);


	  $re = array();
	  $i = 0;
	  foreach($list as $v){
	  	$i++;
	  	if($i > 10){
	  		break;
	  	}
	  	$tmp = array();
	  	$tmp['Title'] = $v['title'];
	  	$tmp['Description'] = $v['title'];
	  	$tmp['PicUrl'] = $v['pics_list'][0];
	  	$tmp['Url'] = "http://www.zanbai.com/shoptipsinfo/".$v['id'];
	  	$re[] = $tmp;
	  }
	  return $re;
	}

	// data.zanbai.com/weixin/create_menu 
	// data.zanbai.com/weixin/get_menu 
	// data.zanbai.com/weixin/delete_menu 
	public function create_menu(){
		$options = array(
		    'token'=>'hongjun', //填写你设定的key
		    'appid' => self::APPID,
		    'appsecret'=>self::APPSECRET,
		    'debug'=>true,
		    'logcallback'=>'logdebug'
		);
		$weObj = new Wechat($options);
		//$weObj->valid();
		$data = array();
		$data[] = array("name"=>"热门城市",
						"sub_button"=>array(
						array('type'=>"view", "name"=>"北美", "url"=>"http://www.zanbai.com/home/index_h5/?#amc"),
						array('type'=>"view", "name"=>"欧洲", "url"=>"http://www.zanbai.com/home/index_h5/?#eup"),
						array('type'=>"view", "name"=>"亚太", "url"=>"http://www.zanbai.com/home/index_h5/?#asia")
						)
				 );
		$data[] = array("name"=>"攻略优惠",
						"sub_button"=>array(
						array('type'=>"click", "name"=>"热门商家", "key"=>"MENU_KEY_MENU_SHOP"),
						array('type'=>"click", "name"=>"美国优惠券", "key"=>"MENU_KEY_MENU_CITY"),
						array('type'=>"click", "name"=>"购物攻略", "key"=>"MENU_KEY_MENU_REC")
						)
				 );
		$data[] = array('type'=>"view", "name"=>"下载App", "url"=>"https://itunes.apple.com/cn/app/zan-bai-wang-chu-jing-gou/id774874759?mt=8#");
		$data2['button'] = $data;
		$data = $data2;

		$re = $weObj->createMenu($data);

		//$menus = $weObj->getMenu();
		var_dump($re, $data);
	}
	// data.zanbai.com/weixin/get_menu 
	public function get_menu(){
		$options = array(
		    'token'=>'hongjun', //填写你设定的key
		    'appid' => self::APPID,
		    'appsecret'=>self::APPSECRET,
		    //'debug'=>true,
		    //'logcallback'=>'logdebug'
		);
		$weObj = new Wechat($options);
		$menus = $weObj->getMenu();
		var_dump($menus);
	}
	// data.zanbai.com/weixin/delete_menu 
	public  function delete_menu(){
		$options = array(
		    'token'=>'hongjun', //填写你设定的key
		    'appid' => self::APPID,
		    'appsecret'=>self::APPSECRET,
		    'debug'=>true,
		    'logcallback'=>'logdebug'
		);
		$weObj = new Wechat($options);
		$re = $weObj->deleteMenu();
		var_dump( $re);
	}

	function logdebug($text){
	    file_put_contents('/tmp/log.txt', time()."\n",FILE_APPEND);        
	}

	function add_event($type, $event, $key, $keyword, $ctime, $fromusername){
		$list = array("text"=>100, "image"=>101, "voice"=>102, "video"=>103, "music"=>104, "news"=>105);
		if(isset($list[$type])){
			$type = $list[$type];
		}
		if(!$keyword){
			$keyword = '';
		}
		$this->load->model("mo_weixinevent");
		$add_data = array();
		switch ($key) {
			case 'http://www.zanbai.com/home/index_h5/?#asia':
				$type=1;
				break;
			case 'http://www.zanbai.com/home/index_h5/?#eup':
				$type=2;
				break;
			case 'http://www.zanbai.com/home/index_h5/?#amc':
				$type=3;
				break;
			case 'https://itunes.apple.com/cn/app/zan-bai-wang-chu-jing-gou/id774874759?mt=8#':
				$type=4;
				break;
			case 'MENU_KEY_MENU_SHOP':
				$type=5;
				break;
			case 'MENU_KEY_MENU_CITY':
				$type=6;
				break;
			case 'MENU_KEY_MENU_REC':
				$type=7;
				break;
			case 'SimpleXMLElement Object':
				if($event == 'unsubscribe'){
					$type = 8;
				}elseif($event == "subscribe"){
					$type = 9;
				}
				break;
			default:
				break;
		}
		$add_data['type'] = $type;
		$add_data['keyword'] = $keyword;
		$add_data['fromusername'] = $fromusername;
		$add_data['ctime'] = $ctime;
		$add_data['day'] = strtotime(date("Y-m-d", $ctime));
		$add_data['from'] = 2;
		
		$this->mo_weixinevent->add($add_data);
	}

}