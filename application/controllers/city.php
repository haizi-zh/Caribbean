<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City extends ZB_Controller {

	const PAGE_ID = 'city';
	const CACHA_TIME = 3000;

	public $must_login = 0;
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model('mo_tag');
		$this->load->model('mo_module');
		$this->load->model('mo_fav');

        //$this->load->library('common/common_redis');
        //$this->redis = new common_redis();
        //$data = $redis->rpop($key);
        //$re = $redis->rpush("zy:monitor:device_status_changed", $fingerprint);
	}

	public function index(){
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;

		$segment_array = $this->uri->segment_array();
		
		if($segment_array[1]=='city'){
			$city = $this->input->get('city',true,1); #城市
			$lower_name = "";
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			if($city_info){
				$lower_name = $city_info['lower_name'];
			}
			$re_url = base_url('/'.$lower_name.'/');
			redirect($re_url, 'location', 301);
		}

		$check_mobile = context::get("check_mobile", false);
		if($check_mobile){
			$this->index_h5();
			return;
		}

		#获取参数
		$current_char = $this->input->get("fchar",true,"A");#首字母
		$brand = $this->input->get("brand",true,0); #品牌
		$page = $this->input->get('page',true,1);#页面
		$pagesize = $this->input->get("pagesize",true, 30);#每页容量
		$property = $this->input->get("property",true,0);#属性
		$city = $this->input->get('city',true,1); #城市

		$brand = intval($brand);
		$page = intval($page);
		$pagesize = intval($pagesize);
		$property = intval($property);
		$city = intval($city);

		$data = $this->mo_shop->get_simple_cache("%s_city_%s", "city_pre", array($city));
		
		if($data === false){
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			if(!$city_info){
				$this->tool->sorry();
			}
			$country_id = $city_info['country_id'];
			$city_name = $city_info['name'];
			$city_lower_name = $city_info['lower_name'];
			#选择的首字母
			$brands = $this->mo_brand->get_brands_by_first_char($current_char);
			$brands = array();

			$this->config->load("recommend", true);
			$top_brands = $this->config->item("top_brands", "recommend");
			$top_brands = explode(",", $top_brands);

			#分页总数
			$total = $this->mo_shop->get_shopcnt_by_brand_property_city($brand,$property,$city);
			$page_cnt = ceil($total/$pagesize);

			#商家详细信息和评论
			$shops = $this->mo_shop->get_shops_by_brand_property_city($brand,$property,$city,$page,$pagesize);
			$shop_infos = $this->mo_shop->provide_data($shops);

			$shop_tags = $this->mo_tag->get_shoptagids($shops);
			$tag_list = $this->mo_tag->get_tag_list();

			foreach($shop_infos as $key => $value){
				$shop_id = $value['id'];
				$exist_discount = $this->mo_discount->check_discount_for_shopid($value['id']);
				
				$shop_infos[$key]['exist_discount'] = $exist_discount;

				$brand_ids = $this->mo_shop->get_brands_by_shop($value['id']);
				$exist_coupon = $this->mo_coupon->get_coupon_by_shop_brand($value['id'], $brand_ids);
				// 获取标签
				$first = array();
				if($exist_coupon){
					$first = array_shift($exist_coupon);
					$exist_coupon = $first['id'];
				}else{
					$exist_coupon = false;
				}
				$shop_infos[$key]['exist_coupon'] = $exist_coupon;
				$shop_infos[$key]['exist_coupon_info'] = $first;

				$shop_tag = array();
				if(isset($shop_tags[$value['id']])){
					$shop_tag = $shop_tags[$value['id']];
				}
				$shop_infos[$key]['tags'] = $shop_tag;
				#图片后缀替换
				$shop_pic = $value['pic'];
				$shop_pic = str_replace("!300", "!shopviewlist", $shop_pic);
				$shop_infos[$key]['pic'] = $shop_pic;
			}

			
			$tempate_data = array("shop_infos"=>$shop_infos);
			$tempate_data['tag_list'] = $tag_list;
			$tempate_data['city_id'] = $city;
			$tempate_data['page_cnt'] = $page_cnt;
			$tempate_data['page'] = $page;
			$tempate_data['city_lower_name'] = $city_lower_name;

			#热门品牌
			$brands = $this->mo_brand->get_hot_brand_by_city_id($city);

			$first_char_array = array_keys($brands);
			$first_char_brands = array_values($brands);
			$brands = $first_char_brands?$first_char_brands[0]:array();
			$pre_brands = $brands;
			foreach($brands as $k=>$v){
				if(!in_array($v['id'], $top_brands)){
					unset($brands[$k]);
				}
			}
			if(!$brands){
				$brands = $pre_brands;
			}

			$brand_html = $this->load->view('template/small_brand_card', array('brands'=>$brands, 'city_id'=>$city), true);

			#footer
			$jsplugin_list = array();#需要用到的js插件
			$data = array();
			$data['tempate_data'] = $tempate_data;

			$data['city_lower_name'] = $city_lower_name;
			$data['page'] = $page;
			$data['page_cnt'] = $page_cnt;
			$data['first_char_array'] = $first_char_array;
			$data['current_char'] = $current_char;
			$data['brands'] = $brands;

			$data['pageid'] = self::PAGE_ID;
			$data['jsplugin_list'] = $jsplugin_list;
			$data['brand_html'] = $brand_html;

			$this->load->model('mo_geography');
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			$city_name = $city_info['name'];
			$city_lower_name = $city_info['lower_name'];
			$data['city_lower_name'] = $city_lower_name;
			$data['city_name'] = $city_name;
			$data['city_info'] = $city_info;
			$data['city_id'] = $city;
			$area_cities = $this->mo_geography->get_all_cities();
			$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
			$data['area_cities'] = $area_cities;
			$data['country_code'] = $country_code;

			$server_name = $this->input->server('SERVER_NAME');
			$cookie_city_id = $this->input->cookie("city_id", true , 0);
			if ($cookie_city_id!=$city) {
				$this->input->set_cookie( "city_id", $city, time()+864000, $server_name, "/" );
			}
	//<title>【纽约购物】纽约购物中心_纽约购物信息全介绍—赞佰网</title>
	//<meta name="keywords" content="纽约购物" />
	//<meta name="description" content="赞佰网为您提供最全面的纽约购物信息,提供纽约购物中心，纽约奥特莱斯，纽约商场百货，纽约购物街区优惠券以及其它全面购物信息" />

			$data['page_title_single'] = "【{$city_name}购物】{$city_name}购物中心_{$city_name}购物信息全介绍—赞佰网";
			$data['seo_keywords'] = "{$city_name}购物";
			$data['seo_description'] = "赞佰网为您提供最全面的{$city_name}购物信息,提供{$city_name}购物中心，{$city_name}奥特莱斯，{$city_name}商场百货，{$city_name}购物街区优惠券以及其它全面购物信息";

			//获取标签列表
			$tags_list = $this->mo_tag->get_tags_by_city($city);

			if($tags_list && isset($tags_list['4'])){
				$data['tags_four'] = $tags_list['4'];
			}else{
				$data['tags_four'] = array();
			}

			$tag_cat_list = $this->mo_tag->get_tag_cat_list();
			$data['tags_one'] = $tag_cat_list[1]['children'];
			$data['tags_two'] = $tag_cat_list[2]['children'];


			$ios_contact_html = $this->mo_common->get_ios_contact();
			$data['ios_contact_html'] = $ios_contact_html;

			$data['country_id'] = $country_id;
			$data['city'] = $city;

			$this->mo_shop->get_simple_cache("%s_city_%s", "city_pre", array($city), self::CACHA_TIME, $data);
		}

		$left_tips_html = $this->mo_module->format_shoptips($data['country_id'], $data['city'], 0, $login_uid);
		$data['left_tips_html'] = $left_tips_html;

		$data['tempate_data']['shop_infos'] = $this->mo_fav->check_fav_shops($data['tempate_data']['shop_infos'], $login_uid);
		$shop_list_html = $this->load->view("template/shop_card", $data['tempate_data'], true);
		$data['shop_list_html'] = $shop_list_html;
		$data['macys_html'] = $this->mo_module->format_macys($data['country_id']);
		$data['new_york_kits_html'] = $this->mo_module->new_york_kits($data['city'], 0, 210);

		$data['tj_id'] = "city";

		$this->get_adv_data();
		
		$this->load->web_view('city', $data);
	}
	public function index_h5(){
		$data = array();
		$city = $this->input->get('city',true, 1); #城市
		$property = $this->input->get("property",true,2);#属性
		$city = intval($city);
		$property = intval($property);

		$city_info = $this->mo_geography->get_city_info_by_id($city);
		if(!$city_info){
			$this->tool->sorry();
		}
		$shops = $this->mo_shop->get_shops_by_brand_property_city(0,$property,$city,1,200);
		$shop_infos = $this->mo_shop->provide_data($shops);

		$shop_tags = $this->mo_tag->get_shoptagids($shops);
		$tag_list = $this->mo_tag->get_tag_list();

		foreach($shop_infos as $key => $value){
			$shop_id = $value['id'];
			$exist_discount = $this->mo_discount->check_discount_for_shopid($value['id']);
			$shop_infos[$key]['exist_discount'] = $exist_discount;

			$brand_ids = $this->mo_shop->get_brands_by_shop($value['id']);
			$exist_coupon = $this->mo_coupon->get_coupon_by_shop_brand($value['id'], $brand_ids);
			// 获取标签
			$first = array();
			if($exist_coupon){
				$first = array_shift($exist_coupon);
				$exist_coupon = $first['id'];
			}else{
				$exist_coupon = false;
			}
			$shop_infos[$key]['exist_coupon'] = $exist_coupon;
			$shop_infos[$key]['exist_coupon_info'] = $first;

			$shop_tag = array();
			if(isset($shop_tags[$value['id']])){
				$shop_tag = $shop_tags[$value['id']];
			}
			$shop_infos[$key]['tags'] = $shop_tag;
			#图片后缀替换
			$shop_pic = $value['pic'];
			$shop_pic = str_replace("!300", "!shopviewlist", $shop_pic);
			$shop_infos[$key]['pic'] = $shop_pic;
		}

		$score_list = array(0=>"one", 1=>"two", 3=>"three", 4=>"four", 5=>"five");
		$city_lower_name = $city_info['lower_name'];
		$data['city_lower_name'] = $city_lower_name;
		$data['score_list'] = $score_list;
		$data['property'] = $property;
		$data['tag_list'] = $tag_list;
		$data['shop_infos'] = $shop_infos;
		
		//var_dump($shop_infos);die;
		$data['city_info'] = $city_info;//var_dump($city_info);
		$data['body_class'] = "shop_list";
		$data['page_css'] = array("/css/h5/page/city_list.css");
		$this->load->h5_view("h5/city", $data);
	}


}


