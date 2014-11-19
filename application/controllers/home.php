<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends ZB_Controller {
	
	const PAGE_ID = 'home';
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_geography');
	}

	public function index(){
		$check_mobile = context::get("check_mobile", false);
		if($check_mobile){
			$this->index_h5();
			return;
		}
		$step = $this->input->get("step", true, 0);
        $step = intval($step);
        /*
		$refer = context::get_server("HTTP_REFERER");
		$refer = "";
		if (isset($_SERVER['HTTP_REFERER'])) {
			$refer = $_SERVER['HTTP_REFERER'];

			$from_zanbai = strpos($refer, "zanbai.com");
			$from_city  = strpos($refer, "city");
			
			$cookie_city_id = $this->input->cookie("city_id", true , 0);
			if ($refer !== false && $from_zanbai !== false && !$from_city) {

				if($cookie_city_id && !$step){
					$this->tool->header_location("/city/{$cookie_city_id}");
				}
			}

		}
		*/
		$data = array();
		


//巴黎，米兰，伦敦，罗马
//首尔，东京，台北，香港，
//旧金山，洛杉矶，纽约，芝加哥，

		$home_citys = array(0=>array('1'=>'纽约','21'=>'伦敦'),
			1=>array('22'=>'米兰','20'=>'巴黎','13'=>'迈阿密','44'=>'香港'),
			2=>array('2'=>'洛杉矶','97'=>'首尔','49'=>'台北','51'=>'东京','3'=>'芝加哥','5'=>'旧金山'));
		$city_ids = array(1=>1,21=>21,22=>22,20=>20,13=>13,44=>44,2=>2,97=>97,49=>49,51=>51,3=>3,5=>5);


		$city_infos = $this->mo_geography->get_city_info_by_ids($city_ids);
		foreach ($city_infos as $key => $value) {
			$reserve_3 = $value['reserve_3'];
			$reserve_3 = str_replace("!300", "", $reserve_3);
			$city_pics[$value['id']] = $reserve_3;
		}

		//$city_pics = array('1'=>'niuyue.jpg','21'=>'lundun.jpg','22'=>'milan.jpg','20'=>'bali.jpg','23'=>'luoma.jpg','44'=>'xianggang.jpg',
		//	'2'=>'luoshanji.jpg','97'=>'shouer.jpg','49'=>'taibei.jpg','51'=>'dongjing.jpg','3'=>'zhijiage.jpg','5'=>'jiujinshan.jpg');

		#load page
		$cities = $this->mo_geography->get_all_cities();
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		
		//$this->load->model('mo_dianping');
		//$hot_dianpings_re = $this->mo_dianping->get_hot_dianping(1, 8);
		$pics = array();

		$data = array('cities'=>$cities,'country_code'=>$country_code,'pics'=>$pics);
		$data['pageid'] = self::PAGE_ID;
		$jsplugin_list = array('slider');#需要用到的js插件
		$data['jsplugin_list'] = $jsplugin_list;
		$data['home_citys'] = $home_citys;
		$data['city_infos'] = $city_infos;
		$data['city_pics'] = $city_pics;
		$data['city_ids'] = $city_ids;
		$data['tj_id'] = "home";
		
$link_list = array(
"http://www.neimanmarcus.com/" =>"Neiman Marcus",
"http://www.bloomingdales.com/" =>"Bloomingdale's",
"https://www.saksfifthavenue.com/" =>"Saks Fifth Avenue",
"http://www.lordandtaylor.com/" =>"Lord & Taylor",
"http://www.barneys.com/" =>"Barneys New York",
"http://www.walmart.com/" =>"Walmart.com",
"http://www.amazon.com/" =>"Amazon",
"http://www.ganji.com/lvyou/"=>"旅游",
"http://www.365bustour.com/"=>"美国旅游",
"http://www.zhubaijia.com/"=>"海外民宿短租",
"http://www.xianlvke.com/"=>"鲜旅客",
//"http://www.chuguoqu.com/"=>"出国去",
//"http://www.target.com/" =>"Target",
//"http://www.calvinklein.com/"=>"Aalvin Klein",
);

		$data['link_list'] = $link_list;
		$seo_keywords = "赞佰网,赞佰,zanbai,购物,出境,出国,攻略,指南,折扣,点评,购物信息,奥特莱斯,出国购物攻略,优惠券下载,购物清单,折扣信息";
		if($step){
			$data['seo_keywords'] = $seo_keywords;
			$this->load->web_view('home_new_2', $data, false, false, false);
		}else{
			$data['seo_keywords'] = $seo_keywords;
			
			$this->load->web_view('home_new_1', $data, false, false, false);
		}

	}

	public function index_h5(){
		$data = array();
		$cities = $this->mo_geography->get_all_cities();
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		$country_names = array('1'=>'北美','2'=>'欧洲','3'=>'亚太');
		$data['cities'] = $cities;
		$data['country_code'] = $country_code;
		$data['country_names'] = $country_names;
		
		$data['body_class'] = "city_list";
		$data['page_css'] = array("/css/h5/page/city_list.css");

		$this->load->h5_view("h5/home", $data);
	}


	public function index2(){
		#load page
		$cities = $this->mo_geography->get_all_cities();
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		
		//$this->load->model('mo_dianping');
		//$hot_dianpings_re = $this->mo_dianping->get_hot_dianping(1, 8);
		#轮播图片
// 		$this->load->model('mo_operation');
// 		$pics = $this->mo_operation->get_value(mo_operation::INDEX_PICS);
		$pics = array();
		
		$data = array('cities'=>$cities,'country_code'=>$country_code,'pics'=>$pics);
		$data['pageid'] = self::PAGE_ID;
		$jsplugin_list = array('slider');#需要用到的js插件
		$data['jsplugin_list'] = $jsplugin_list;
		$data['tj_id'] = "homemore";
		$this->load->web_view('home', $data);
			
		#footerz
		//$jsplugin_list = array('slider');#需要用到的js插件
		//$this->load->view('footer',array('pageid'=>self::PAGE_ID,'jsplugin_list'=>$jsplugin_list));

	}



}