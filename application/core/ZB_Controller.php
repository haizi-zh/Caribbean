<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ZB_Controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
		$rsegments = $this->uri->rsegments;
		if($rsegments && isset($rsegments[3])){
			parse_str(ltrim($rsegments[3], '?'), $_GET);
		}
		
		$this->load->helper('url');

		// context::init();
		// $check_mobile = tool::check_mobile();
		
		//$check_mobile = 1;
		//var_dump($check_mobile);
		
		// context::set("check_mobile", $check_mobile);

		//$this->load->driver('cache');
		// $ip = context::get_client_ip();
		// $black_ips=array("220.181.126.42"=>"220.181.126.42", '220.181.126.4'=>'220.181.126.4');
		// if(isset($black_ips[$ip])){
		// 	echo md5(time());
		// 	die;
		// }
		
		// $this->load->model("mo_discount");
		// $this->load->model("mo_geography");
		// $this->load->model("mo_shop");
		// $this->load->helper('url');

		// $city_id = $this->input->get("city", true, 0);
		// $shop_id = $this->input->get("shop_id", true, 0);
		// $cookie_city_id = $this->input->cookie("city_id", true , 0);
		//var_dump($cookie_city_id);die;
		// if (!$city_id) {
		// 	if($cookie_city_id){
		// 		$city_id = $cookie_city_id;
		// 	}else{
		// 		$city_id = 1;
		// 		$cookie_city_id = 1;
		// 	}
		// }
		// $this->config->load('cache_key');
		// $cache_keys = $this->config->item("cache_keys");
		// context::set("cache_keys", $cache_keys);

		// $this->config->load('tj');
		// $tj = $this->config->item("tj");
		// context::set("tj", $tj);

		// $this->config->load('env');
		// $use_memcache = $this->config->item("use_memcache");
		// context::set('use_memcache', $use_memcache);
		
		// if($use_memcache){
		// 	$this->load->library('memcached_library');
		// }

		// $is_ajax_request = $this->input->is_ajax_request();
		// context::set("is_ajax_request", $is_ajax_request);
		// if(!$is_ajax_request){
		// 	if($city_id || $shop_id){
		// 		$country_id = 0;
		// 		if($city_id){
		// 			$city_info = $this->mo_geography->get_city_info_by_id($city_id);
		// 			if($city_info && isset($city_info['country_id'])){
		// 				$country_id = $city_info['country_id'];
		// 			} 
		// 		}
		// 		if ($shop_id) {
		// 			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
		// 			if($shop_info){
		// 				$country_id = $shop_info['country'];
		// 				$city_id = $shop_info['city'];
		// 			}
		// 		}
		// 		if ($country_id && $city_id) {
		// 			$shop_tips = $this->mo_discount->get_info_by_shopid($country_id, $city_id, $shop_id, 2);
		// 			if($shop_tips){
		// 				context::set("head_shop_tips", $shop_tips);
		// 				context::set("head_shop_tips_count", count($shop_tips));
		// 				context::set("head_country_id", $country_id);
		// 				context::set("head_shop_id", $shop_id);
		// 			}
		// 		}
		// 		if($city_id){
		// 			$shop_ids = $this->mo_shop->get_shops_by_brand_property_city(0, 0, $city_id, 1, 1000);	
		// 			$discount_total = $this->mo_discount->get_discount_cnt_by_shopids($shop_ids);
		// 			context::set("discount_total", $discount_total);
		// 		}
		// 		context::set("city_id", $city_id);
		// 		context::set("country_id", $country_id);
		// 		context::set("shop_id", $shop_id);
		// 	}
		// 	$this->load->model("mo_geography");
		// 	$all_city_infos = $this->mo_geography->get_all_cityinfos();
		// 	context::set("all_city_infos", $all_city_infos);

		// 	$close_app_pop = $this->input->cookie("close_app_pop", true, 0);
		// 	//$close_app_pop = 0;
		// 	context::set("close_app_pop", $close_app_pop);
		// }


		// if($city_id){
		// 	context::set("head_city_id", $city_id);
		// }

		// $cookie_city_name = "";
		// $cookie_city_lower_name = "";
		// $city_info = array();
		// if ($cookie_city_id) {
		// 	$city_info = $this->mo_geography->get_city_info_by_id($cookie_city_id);

		// 	if($city_info && isset($city_info['name'])){
		// 		$cookie_city_name = $city_info['name'];
		// 		$cookie_city_lower_name = $city_info['lower_name'];
		// 		$cookie_country_id = $city_info['country_id'];
		// 	}
		// }
		// context::set("cookie_city_lower_name", $cookie_city_lower_name);
		// context::set("cookie_city_name", $cookie_city_name);
		// context::set("cookie_city_info", $city_info);
		
		// $area_cities = $this->mo_geography->get_all_cities(0,'level_top');
		// context::set("area_cities", $area_cities);

		// $top_area_cities = $this->mo_geography->get_all_cities(0,'level_top');
		// context::set("top_area_cities", $top_area_cities);

		// $country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		// context::set("country_code", $country_code);

		// $uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		// context::set("vuid", $uid);

		// $white_user = tool::check_white($uid);
		// $white_user = false;
		// context::set("white_user", $white_user);


		// $this->config->load('adv');
		// $adv_images = $this->config->item("adv_images");
		// context::set("adv_images", $adv_images);


		// $this->config->load('env');
		// $js_version = $this->config->item("js_version");
		// $js_domain = $this->config->item("js_domain");
		// $css_domain = $this->config->item("css_domain");
		// $tj_domain = $this->config->item("tj_domain");
		// $filedomain = $this->config->item("filedomain");
		// $data_domain = $this->config->item("data_domain");
		// $imgdomain = $this->config->item("imgdomain");
		// $use_fe = $this->config->item("use_fe");
		// $domain = $this->config->item("domain");
		// $head_name = $this->config->item("head_name");

		// $admin_js_domain = $this->config->item("admin_js_domain");
		// $admin_css_domain = $this->config->item("admin_css_domain");
		// context::set('admin_js_domain', $admin_js_domain);
		// context::set('admin_css_domain', $admin_css_domain);

		// context::set('js_version', $js_version);
		// context::set('js_domain', $js_domain);
		// context::set('css_domain', $css_domain);
		// context::set('tj_domain', $tj_domain);
		// context::set('filedomain', $filedomain);
		// context::set('data_domain', $data_domain);
		// context::set('imgdomain', $imgdomain);

		// context::set('use_fe', $use_fe);
		// context::set('domain', $domain);
		// context::set('head_name', $head_name);

		// $this->config->load('pro',TRUE);
		// $recommend_city = $this->config->item("recommend_city", "pro");

		// context::set('recommend_city', $recommend_city);
	}
	
	public function mobile_json_encode($data){
		$re = $this->tool->string2int($data);
		$re = json_encode($re);
		return $re;
	}

	public function get_adv_data(){
        $country_id = context::get("country_id", 0);
        $city_id = context::get("city_id", 0);
        $shop_id = context::get("shop_id", 0);
        $imgdomain = context::get("imgdomain", "");
        $this->load->model("mo_adv");
        $list = $this->mo_adv->get_adv_by_country_city_shop($country_id,$city_id,$shop_id);
        //var_dump($country_id,$city_id,$shop_id);
        if($list){
        	$con_adv_images = array();
        	foreach($list as $v){
        		$con_adv_images[] = array("img"=>$imgdomain.$v['pic'], "url"=>$v['url']);
        	}

        	context::set("con_adv_images", $con_adv_images);
        }
	}
}

