<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brandstreet extends ZB_Controller {

	const PAGE_ID = 'brand';
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
	}
	public function index(){
		#获取参数
		$shop_id = $this->input->get('shop_id',true,0);
		$shop_id = intval($shop_id);
		#加载view
		$brand_ids = $this->mo_shop->get_brands_by_shop($shop_id);
		if(!$brand_ids){
			//$this->tool->sorry();
		}
		$have_shop = array();
		$brands = $this->mo_brand->get_brands_by_ids($brand_ids,true);
		foreach ($brands as $first_char => $list) {
			foreach ($list as $key => $value) {
				if ($value['property'] > 0) {
					$have_shop[$value['id']] = $value;
					unset($brands[$first_char][$key]);
				}
			}
		}


		#城市信息
		$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		$city_id = $shop_re[$shop_id]['city'];
		$city_info = $this->mo_geography->get_city_info_by_id($city_id);
		$city_name = $city_info['name'];
		$city_lower_name = $city_info['lower_name'];
		#footer
		$data = array();
		$data['have_shop'] = $have_shop;
		$data['pageid'] = self::PAGE_ID;
		$data['brands'] = $brands;
		$data['city_id'] = $city_id;
		$data['city_name'] = $city_name;
		$data['city_lower_name'] = $city_lower_name;
		$data['city_info'] = $city_info;
		$data['shop_id'] = $shop_id;
		$shop_name = $shop_re[$shop_id]['name'];
		$data['shop_name'] = $shop_name;

		$city = $city_id;
		$data['city_name'] = $city_name;
		$data['city_id'] = $city;
		$area_cities = $this->mo_geography->get_all_cities();
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		$data['area_cities'] = $area_cities;
		$data['country_code'] = $country_code;
		
		$data['page_title'] = $city_name." ".$shop_name."拥有的品牌列表 主力百货公司 精品专卖店";

		$data['tj_id'] = "brand_street";

		$this->get_adv_data();
		
		$this->load->web_view('brandstreet', $data);
		
	}
}
