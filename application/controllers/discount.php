<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class discount extends ZB_Controller {
	const PAGE_ID = 'discount_list';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_shop");
		$this->load->model("mo_coupon");
		$this->load->model("mo_geography");
		$this->load->model("mo_brand");
		$this->load->model("mo_common");
		$this->load->model("mo_discount");
		$this->load->model("mo_module");
		$this->load->model("mo_comment");
		$this->load->model("mo_user");
	}
	
	// http://10.11.12.13/discountshop/23
	public function index(){
		
		$segment_array = $this->uri->segment_array();
		if($segment_array[1]=='discountcity'){
			$city_id = $this->input->get("city", true, 0);
			$city_info = $this->mo_geography->get_city_info_by_id($city_id);
			if($city_info){
				$lower_name = $city_info['lower_name'];
			}
			$re_url = base_url("/{$lower_name}-shopdiscount/");
			redirect($re_url, 'location', 301);
		}

		$city_name = "";
		$shop_id = $this->input->get("shop_id", true, 0);
		$city_id = $this->input->get("city", true, 0);
		$page = $this->input->get("page", true, 1);

		$shop_id = intval($shop_id);
		$city_id = intval($city_id);
		$page = intval($page);

		$city_info = array();
		$pagesize = 50;
		if(!$shop_id && !$city_id){
			tool::sorry();
		}

		$shop_info = array();
		$country_id = 0;
		if($shop_id){
			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
			if(!$shop_info || $shop_info['status'] != 0){
				tool::sorry();
			}
			$country_id = $shop_info['country'];
		}else{
			$city_info = $this->mo_geography->get_city_info_by_id($city_id);
			if(!$city_info){
				tool::sorry();
			}
			$country_id = $city_info['country_id'];
		}
		
		if($shop_id){
			$city_id = $shop_info['city'];
			$country_id = $shop_info['country'];
			$city_name = $this->mo_geography->get_name_by_id($city_id);
			$brand_infos = array();
			$discount_ids = $this->mo_discount->get_discount_ids_by_shopid($shop_id, $page, $pagesize);
			$total = $this->mo_discount->get_discount_cnt_by_shopid($country_id, $city_id, $shop_id);
		}else{
			$city_name = $this->mo_geography->get_name_by_id($city_id);

			$shop_ids = $this->mo_shop->get_shops_by_brand_property_city(0, 0, $city_id, 1, 1000);
		
			$discount_re = $this->mo_discount->get_discount_ids_by_shopids($shop_ids, $page, $pagesize);
			$discount_ids = $discount_re['list'];
			$total = $discount_re['count'];
			//$total = $this->mo_discount->get_discount_cnt_by_shopids($shop_ids);
		}
		
		$page_cnt = ceil($total/$pagesize);
		$discount_list_html = "";
		$brand_infos = array();
		if($discount_ids){
			$discount_infos = $this->mo_discount->get_info_by_ids($discount_ids);
			
			$discount_data = array();
			foreach ($discount_infos as $key => $value) {
				$value['clean_body'] = strip_tags($value['body']);
				$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],240);
				if($value['pics']){
					$pics = $value['pics'];
					$value['pics_list'] = json_decode($pics, true);
				}
				$discount_infos[$key] = $value;
			}
			
			$discount_shop_infos = $this->mo_discount->get_discount_shop_info_by_discountid($discount_ids);
			
			$brand_ids = array();
			foreach($discount_shop_infos as $key => $value) {
				if($value['brand_id']){
					$brand_ids[] = $value['brand_id'];
				}
				if($value['shop_id']){
					$shop_ids[] = $value['shop_id'];
				}
			}
			$brand_infos = $shop_infos = array();
			if($brand_ids){
				$brand_infos = $this->mo_brand->get_brands_by_ids($brand_ids);
			}
			
			if($shop_ids){
				$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
			}
			foreach ($discount_infos as $discount_id => $value) {
				$discount_infos[$discount_id]['brand_id'] = $discount_shop_infos[$discount_id]['brand_id'];
				$discount_infos[$discount_id]['brand_info'] = $discount_shop_infos[$discount_id];
				$discount_shop_info = array();
				if($shop_infos){
					if( $value['shop_id'] && isset($shop_infos[$value['shop_id']])){
						$discount_shop_info = $shop_infos[$value['shop_id']];
					}
				}
				$discount_infos[$discount_id]['shop_info'] = $discount_shop_info;
			}
			
			$discount_data['city_id'] = $city_id;
			$discount_data['shop_id'] = $shop_id;
			$discount_data['brand_infos'] = $brand_infos;
			$discount_data['discount_infos'] = $discount_infos;
			$discount_data['page_cnt'] = $page_cnt;
			$discount_data['page'] = $page;
			$discount_list_html = $this->load->view("template/discount_card", $discount_data, true);

		}
		
		$data = array();
		$data['brand_infos'] = $brand_infos;
		$data['shop_id'] = $shop_id;
		$data['city_id'] = $city_id;
		$data['city_name'] = $city_name;
		$data['city_info'] = $city_info;
		$data['shop_info'] = $shop_info;
		$data['pageid'] = self::PAGE_ID;
		$data['page'] = $page;
		$data['page_cnt'] = $page_cnt;
		$data['discount_list_html'] = $discount_list_html;

		$city = $city_id;
		$this->load->model('mo_geography');

		$data['city_id'] = $city;
		$area_cities = $this->mo_geography->get_all_cities();
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		$data['area_cities'] = $area_cities;
		$data['country_code'] = $country_code;

//<title>【纽约购物折扣】最全纽约购物折扣信息—赞佰网</title>
//<meta name="keywords" content="纽约购物折扣" />
//<meta name="description" content="赞佰网为您提供最全纽约购物折扣信息,纽约购物中心，纽约奥特莱斯，纽约购物街区，纽约商场百货全面折扣信息" />
		$data['page_title_single'] = "【{$city_name}购物折扣】最全{$city_name}购物折扣信息—赞佰网";
		$data['seo_keywords'] = "{$city_name}购物折扣";
		$data['seo_description'] = "赞佰网为您提供最全{$city_name}购物折扣信息,{$city_name}购物中心，{$city_name}奥特莱斯，{$city_name}购物街区，{$city_name}商场百货全面折扣信息";

		$data['tj_id'] = "discount_list";

		$data['macys_html'] = $this->mo_module->format_macys($country_id );
		$data['country_id'] = "country_id";

		$recommend_shop_html = $this->mo_module->recomment_shop($city);
		$data['recommend_shop_html'] = $recommend_shop_html;

		$ios_contact_html = $this->mo_common->get_ios_contact();
		$data['ios_contact_html'] = $ios_contact_html;
		
		if($city_id){
			context::set("city_id", $city_id);
		}
		if($country_id){
			context::set("country_id", $country_id);
		}
		if($shop_id){
			context::set("shop_id", $shop_id);
		}

		$this->get_adv_data();

		$this->load->web_view('discount_list', $data);
	}

	# http://zan.com/discount_info/171
	// http://10.11.12.13/discount/detail?shop_id=23
	public function detail(){
		$check_mobile = context::get("check_mobile", false);
		if($check_mobile){
			$this->detail_h5();
			return;
		}

		$country_id = $city = $shop_id = 0;
		$this->load->library('input');
		$discount_id = $this->input->get("id");
		$discount_id = intval($discount_id);
		if(!$discount_id){
			tool::sorry();
		}



		$discount_info = $this->mo_discount->get_info_by_id($discount_id);
		if(!$discount_info){
			tool::sorry();
		}
		$city_name = $shop_name = "";
		$shop_info = array();
		$country_id = $city_id = $shop_id = 0;
		$city_info = array();


		if($discount_info && $discount_info['shop_id']){
			$shop_id = $discount_info['shop_id'];
			if (!$shop_id) {
				//$shop_id = $this->input->get("shop_id", true, 0);
			}
			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
			$city_id = $shop_info['city'];
		}else{
			$brand_id = $discount_info['brand_id'];
			$city_id = context::get("city_id", 0);
		}

		if($city_id){
			$city_info = $this->mo_geography->get_city_info_by_id($city_id);
			$city_name = $city_info['name'];
			$country_id = $city_info['country_id'];
		}

		$brand_id = $discount_info['brand_id'];
		$brand_name = "";
		if($brand_id){
			$brand_info = $this->mo_brand->get_brand_by_id($brand_id);
			if($brand_info){
				$brand_name = $brand_info['name'];
			}
		}
		
		if($shop_info){
			$shop_name = $shop_info['name'];
		}

		$data = array();
		$data['country_id'] = $country_id;

		$data['city_id'] = $city_id;
		$data['shop_id'] = $shop_id;
		$data['city_info'] = $city_info;
		$data['city_name'] = $city_name;
		$data['shop_info'] = $shop_info;
		$data['shop_name'] = $shop_name;
		$data['pageid'] = 'ping';
		

		$area_cities = $this->mo_geography->get_all_cities();
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		$data['area_cities'] = $area_cities;
		$data['country_code'] = $country_code;

		$clean_body = "#".$shop_name."最新折扣#";
		$clean_body .= $discount_info['title'];
		if(isset($discount_info['share_content']) && $discount_info['share_content']){
			$share_content = $discount_info['share_content'];
		}else{
			$share_content = $this->tool->clean_html_and_js($discount_info['body']);
		}
		$share_content = $this->tool->substr_cn2($share_content,120,'utf-8');
		$clean_body .= $share_content;
		$clean_body = $this->tool->clean_quotes($clean_body);
		$clean_body=preg_replace("/[\r\n]+/","\\n",$clean_body);
		$clean_body .= " 更多请访问赞佰网(zanbai.com)";
		$data['share_content'] = $clean_body;
		$discount_info['body'] = str_replace("<a", "<a class='pink_link' target='_blank' ", $discount_info['body']);

		#附近商家
		if($shop_id){
			$nearby_shop_html = $this->mo_module->nearby_shop($shop_id);
			$data['nearby_shop_html'] = $nearby_shop_html;

			$shop_right_discount_html = $this->mo_module->shop_right_discount($shop_id);
			$data['shop_right_discount_html'] = $shop_right_discount_html;
		}
		$ios_contact_html = $this->mo_common->get_ios_contact();
		$data['ios_contact_html'] = $ios_contact_html;

//http://master.zanbai.com/discount/detail?shop_id=&id=431
//又一城购物折扣 大专院校优惠献礼 |赞佰网，出境购物指南，全球百货攻略
//香港折扣，又一城折扣，学生折扣，折扣，优惠
//赞佰网( zanbai.com)为您提供最新最全面的香港，商场折扣、品牌折扣，为你省钱省力，轻松购物
		if($discount_info['seo_title']){
			$data['page_title'] = $discount_info['seo_title'];
		}else{
			$title = $discount_info['title'];
			$data['page_title'] = " {$title} {$brand_name}| 商场折扣 品牌折扣";
		}

		if($discount_info['seo_keywords']){
			$data['seo_keywords'] = $discount_info['seo_keywords'];
		}else{
			$discount_seo_keywords = $discount_info['seo_keywords'];
			$data['seo_keywords'] = "{$city_name}折扣, {$shop_name}购物指南, {$brand_name}折扣 折扣,优惠"." ".$discount_seo_keywords;
		}

		if($discount_info['seo_description']){
			$data['seo_description'] = $discount_info['seo_description'];
		}else{
			$desc = $clean_body;
			$seo_desc = $this->seo_desc($desc);
			$data['seo_description'] = $seo_desc;
		}
		$data['discount_info'] = $discount_info;
		$data['tj_id'] = "discount_detail";

		$country_id = $data['country_id'];
		$data['macys_html'] = $this->mo_module->format_macys($country_id );


		if($city_id){
			context::set("city_id", $city_id);
		}
		if($country_id){
			context::set("country_id", $country_id);
		}
		if($shop_id){
			context::set("shop_id", $shop_id);
		}
		$this->get_adv_data();

		$data['city_right_discount_html'] = $this->mo_module->city_right_discount($city_id);

		$data['new_york_kits_html'] = $this->mo_module->new_york_kits($city_id, 0, 210);

		$this->load->web_view('discount_detail', $data);
	}
	public function detail_h5(){
		$country_id = $city = $shop_id = 0;
		$this->load->library('input');
		$discount_id = $this->input->get("id");
		$discount_id = intval($discount_id);
		if(!$discount_id){
			tool::sorry();
		}



		$discount_info = $this->mo_discount->get_info_by_id($discount_id);
		if(!$discount_info){
			tool::sorry();
		}
		$city_info = array();

		if($discount_info && $discount_info['shop_id']){
			$shop_id = $discount_info['shop_id'];
			if (!$shop_id) {
				//$shop_id = $this->input->get("shop_id", true, 0);
			}
			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
			$city_id = $shop_info['city'];
		}
		if($city_id){
			$city_info = $this->mo_geography->get_city_info_by_id($city_id);
			$city_name = $city_info['name'];
			$country_id = $city_info['country_id'];
		}

		$data['discount_info'] = $discount_info;
		$data['city_info'] = $city_info;
		$data['body_class'] = "shop_list";
		$data['page_css'] = array("/css/h5/page/city_list.css");
		$this->load->h5_view("h5/discount_detail", $data);

	}

	public function shoptips_list2(){
		$this->load->model('mo_geography');

		$segment_array = $this->uri->segment_array();
		if($segment_array[1]=='shoptips'){
			$city = $this->input->get("city", true, 0);
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			if($city_info){
				$lower_name = $city_info['lower_name'];
			}
			$re_url = base_url("/{$lower_name}-shoppingtips/");
			redirect($re_url, 'location', 301);
		}
		


		$shop_id = $this->input->get("shop_id", true, 0);
		$page = $this->input->get("page", true, 1);
		$city = $this->input->get("city", true, 0);
		$shop_id = intval($shop_id);
		$page = intval($page);
		$city = intval($city);

		$pagesize = 9;
		$page = intval($page);
		$city = intval($city);
		$shop_id = intval($shop_id);
		$country_id = 0;

		$shop_info = array();
		if ($shop_id) {
			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
			$city = $shop_info['city'];
			$country_id = $shop_info['country'];
		}
		$city_name = "";
		if($city){
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			$city_name = $city_info['name'];
			$country_id = $city_info['country_id'];
		}
		
		$list = $this->mo_discount->get_info_by_shopid($country_id, $city, $shop_id, 2, $page, $pagesize);
		$total = $this->mo_discount->get_discount_cnt_by_shopid($country_id, $city, $shop_id, 2);
		
		$page_cnt = ceil($total/9);
		if($list){
			foreach ($list as $key => $value) {
				$value['clean_body'] = strip_tags($value['body']);
				$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],140);
				if($value['pics']){
					$pics = $value['pics'];
					$value['pics_list'] = json_decode($pics, true);
				}
				$list[$key] = $value;
			}

			$shoptips_data = array();
			$shoptips_data['list'] = $list;
			$shoptips_data['city_id'] = $city;
			$shoptips_data['shop_id'] = $shop_id;
			$shoptips_data['page_cnt'] = $page_cnt;
			$shoptips_data['page'] = $page;
			$shoptips_data['city_info'] = $city_info;
			$shoptips_list_html = $this->load->view("template/shoptips_list", $shoptips_data, true);
		}
		
		$data = array();
		$data['shop_id'] = $shop_id;

		$data['city'] = $city;
		$data['city_info'] = $city_info;

		$data['city_name'] = $city_name;
		$data['shop_info'] = $shop_info;
		$data['pageid'] = "strategy";
		$data['page'] = $page;
		$data['page_cnt'] = $page_cnt;
		$data['js_file'] = "shoptips_list";
		$data['shoptips_list_html'] = $shoptips_list_html;
		
		$data['city'] = $city;
		$area_cities = $this->mo_geography->get_all_cities();
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		$data['area_cities'] = $area_cities;
		$data['country_code'] = $country_code;

//香港购物攻略 |赞佰网，出境购物指南，全球百货攻略
//香港购物攻略，香港购物指南，香港买什么，香港购物贴士
//赞佰网( zanbai.com)为您提供最新最全面的香港购物攻略，购物指南，购物小贴士

//<title>【纽约购物攻略】最全纽约购物攻略_纽约购物贴士—赞佰网</title>
//<meta name="keywords" content="纽约购物攻略" />
//<meta name="description" content="赞佰网为您提供最全纽约购物攻略，纽约购物贴士,纽约购物中心，纽约奥特莱斯，纽约购物街区，纽约商场百货，全面纽约购物攻略" />
		$data['page_title'] = "【{$city_name}购物攻略】最全{$city_name}购物攻略_{$city_name}购物贴士—赞佰网";
		$data['page_title_single'] = "【{$city_name}购物攻略】最全{$city_name}购物攻略_{$city_name}购物贴士—赞佰网";
		$data['seo_keywords'] = "{$city_name}购物攻略";
		$data['seo_description'] = "赞佰网为您提供最全{$city_name}购物攻略，{$city_name}购物贴士,{$city_name}购物中心，{$city_name}奥特莱斯，{$city_name}购物街区，{$city_name}商场百货，全面{$city_name}购物攻略";

		$data['config_city'] = $city;
		$data['config_shop_id'] = $shop_id;

		$data['tj_id'] = "shoptips";

		$city_id = $city;
		if($city_id){
			context::set("city_id", $city_id);
		}
		if($country_id){
			context::set("country_id", $country_id);
		}
		if($shop_id){
			context::set("shop_id", $shop_id);
		}

		$this->get_adv_data();

		$this->load->web_view('shoptips_list', $data);
	}

	public function shoptips_list(){
		$this->load->model('mo_geography');

		$segment_array = $this->uri->segment_array();
		if($segment_array[1]=='shoptips'){
			$city = $this->input->get("city", true, 0);
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			if($city_info){
				$lower_name = $city_info['lower_name'];
			}
			$re_url = base_url("/{$lower_name}-shoppingtips/");
			redirect($re_url, 'location', 301);
		}
		
		$check_mobile = context::get("check_mobile", false);
		if($check_mobile){
			$this->shoptips_list_h5();
			return;
		}

		$shop_id = $this->input->get("shop_id", true, 0);
		$page = $this->input->get("page", true, 1);
		$city = $this->input->get("city", true, 0);
		$shop_id = intval($shop_id);
		$page = intval($page);
		$city = intval($city);

		$pagesize = 9;
		$page = intval($page);
		$city = intval($city);
		$shop_id = intval($shop_id);
		$country_id = 0;

		$shop_info = array();
		if ($shop_id) {
			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
			$city = $shop_info['city'];
			$country_id = $shop_info['country'];
		}
		$city_name = "";
		if($city){
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			$city_name = $city_info['name'];
			$country_id = $city_info['country_id'];
		}
		$small = 0;
		if($country_id == 1){
			$small = 1;
		}
		$pagesize = 200;
		
		$list = $this->mo_discount->get_info_by_shopid($country_id, $city, $shop_id, 2, $page, $pagesize);
		$total = $this->mo_discount->get_discount_cnt_by_shopid($country_id, $city, $shop_id, 2);

		
		$page_cnt = ceil($total/9);
		if($list){
			foreach ($list as $key => $value) {
				$value['clean_body'] = strip_tags($value['body']);
				$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],140);
				if($value['pics']){
					$pics = $value['pics'];
					$value['pics_list'] = json_decode($pics, true);
				}
				$list[$key] = $value;
			}

			$shoptips_data = array();
			$shoptips_data['list'] = $list;
			$shoptips_data['city_id'] = $city;
			$shoptips_data['shop_id'] = $shop_id;
			$shoptips_data['page_cnt'] = $page_cnt;
			$shoptips_data['page'] = $page;
			$shoptips_data['city_info'] = $city_info;
			if($small){
				$shoptips_list_html = $this->load->view("template/tips_small", $shoptips_data, true);
			}else{
				$shoptips_list_html = $this->load->view("template/shoptips_list", $shoptips_data, true);
			}
		}
		
		$data = array();
		$data['list'] = $list;
		$data['shop_id'] = $shop_id;

		$data['city'] = $city;
		$data['city_info'] = $city_info;

		$data['city_name'] = $city_name;
		$data['shop_info'] = $shop_info;
		$data['pageid'] = "strategy";
		$data['page'] = $page;
		$data['page_cnt'] = $page_cnt;
		$data['js_file'] = "shoptips_list";
		$data['shoptips_list_html'] = $shoptips_list_html;
		
		$data['city'] = $city;
		$area_cities = $this->mo_geography->get_all_cities();
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		$data['area_cities'] = $area_cities;
		$data['country_code'] = $country_code;

//香港购物攻略 |赞佰网，出境购物指南，全球百货攻略
//香港购物攻略，香港购物指南，香港买什么，香港购物贴士
//赞佰网( zanbai.com)为您提供最新最全面的香港购物攻略，购物指南，购物小贴士

//<title>【纽约购物攻略】最全纽约购物攻略_纽约购物贴士—赞佰网</title>
//<meta name="keywords" content="纽约购物攻略" />
//<meta name="description" content="赞佰网为您提供最全纽约购物攻略，纽约购物贴士,纽约购物中心，纽约奥特莱斯，纽约购物街区，纽约商场百货，全面纽约购物攻略" />
		$data['page_title'] = "【{$city_name}购物攻略】最全{$city_name}购物攻略_{$city_name}购物贴士—赞佰网";
		$data['page_title_single'] = "【{$city_name}购物攻略】最全{$city_name}购物攻略_{$city_name}购物贴士—赞佰网";
		$data['seo_keywords'] = "{$city_name}购物攻略";
		$data['seo_description'] = "赞佰网为您提供最全{$city_name}购物攻略，{$city_name}购物贴士,{$city_name}购物中心，{$city_name}奥特莱斯，{$city_name}购物街区，{$city_name}商场百货，全面{$city_name}购物攻略";

		$data['config_city'] = $city;
		$data['config_shop_id'] = $shop_id;

		$data['tj_id'] = "shoptips";

		$city_id = $city;
		if($city_id){
			context::set("city_id", $city_id);
		}
		if($country_id){
			context::set("country_id", $country_id);
		}
		if($shop_id){
			context::set("shop_id", $shop_id);
		}
		$this->get_adv_data();
		if($small){
			$data['pageid'] = "fav";
			$data['page_css'] = "ZB_ping.css";
			$this->load->web_view("shoptips/list", $data);
		}else{
			$this->load->web_view('shoptips_list', $data);
		}

	}

	public function shoptips_list_h5(){

		$shop_id = $this->input->get("shop_id", true, 0);
		$page = $this->input->get("page", true, 1);
		$city = $this->input->get("city", true, 0);
		$shop_id = intval($shop_id);
		$page = intval($page);
		$city = intval($city);

		$pagesize = 9;
		$page = intval($page);
		$city = intval($city);
		$shop_id = intval($shop_id);
		$country_id = 0;

		$shop_info = array();
		if ($shop_id) {
			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
			$city = $shop_info['city'];
			$country_id = $shop_info['country'];
		}
		$city_name = "";
		if($city){
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			$city_name = $city_info['name'];
			$country_id = $city_info['country_id'];
		}

		$pagesize = 200;
		$list = $this->mo_discount->get_info_by_shopid($country_id, $city, $shop_id, 2, $page, $pagesize);
		

		if($list){
			foreach ($list as $key => $value) {
				$value['clean_body'] = strip_tags($value['body']);
				$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],140);
				if($value['pics']){
					$pics = $value['pics'];
					$value['pics_list'] = json_decode($pics, true);
				}
				$list[$key] = $value;
			}

			$shoptips_data = array();
			$shoptips_data['list'] = $list;
			$shoptips_data['city_id'] = $city;
			$shoptips_data['shop_id'] = $shop_id;

			$shoptips_data['page'] = $page;
			$shoptips_data['city_info'] = $city_info;
		}

		$data['list'] = $list;
		//var_dump($shop_infos);die;
		$data['city_info'] = $city_info;
		$data['body_class'] = "shop_list";
		$data['page_css'] = array("/css/h5/page/city_list.css");
		$this->load->h5_view("h5/tips_list", $data);
	}

	// http://10.11.12.13/discount/detail?shop_id=23
	public function shoptips_detail(){
		$shop_id = 0;
		$segment_array = $this->uri->segment_array();
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		if(isset($segment_array[3])){
			$discount_id = $segment_array[3];
			$re_url = base_url("/shoptipsinfo/{$discount_id}/");
			redirect($re_url, 'location', 301);
		}
		
		if(isset($_GET['city'])){
			$discount_id = $_GET['id'];
			$re_url = base_url("/shoptipsinfo/{$discount_id}/");
			redirect($re_url, 'location', 301);
		}
		

		$check_mobile = context::get("check_mobile", false);
		if($check_mobile){
			$this->shoptips_detail_h5();
			return;
		}
		$page = $this->input->get("page",true,1);
		$page = intval($page);

		$discount_id = $this->input->get("id", true, 0);
		$discount_id = intval($discount_id);
		
		if(!$discount_id){
			tool::sorry();
		}

		$discount_info = $this->mo_discount->get_info_by_id($discount_id, true);
		
		if(!$discount_info || ( $discount_info['status'] != 0 && $discount_info['status'] != 3)){
			tool::sorry();
		}
		$country_id = 0;

		if($discount_info['city']){
			if(strstr($discount_info['city'], ",")==false){
				$city = $discount_info['city'];
			}else{
				$tmp = explode(",", $discount_info['city']);
				foreach($tmp as $v){
					if($v){
						$city = $v;
					}
				}
			}
			if(strstr($discount_info['country'], ",")==false){
				$country_id = $discount_info['country'];
			}else{
				$tmp = explode(",", $discount_info['country']);
				foreach($tmp as $v){
					if($v){
						$country_id = $v;
					}
				}
			}
		}else{
			$city = $this->input->cookie("city_id", true , 0);
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			$country_id = $city_info['country_id'];
			//攻略查看。cookie的国家不同。则以攻略所属国家第一个城市显示
			$country_ids = explode(",", $discount_info['country']);
			$tmp = array();
			$tmp_country_id = 0;
			foreach($country_ids as $v){
				if($v){
					$tmp[$tmp_country_id] = $v;
					if(!$tmp_country_id){
						$tmp_country_id = $v;
					}
 				}
			}
			$country_ids = $tmp;
			if(!isset($country_ids[$country_id])){
				$city_list = $this->mo_geography->get_cities_by_country($tmp_country_id);
				if($city_list){
					$city = $city_list[0]['id'];	
				}
			}
		}


		$city_name = $country_id = "";
		if($city){
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			if($city_info){
				$city_name = $city_info['name'];
				$country_id = $city_info['country_id'];
			}
		}
		$no_index = 0;
		$six = strtotime("2014-06-15 18:00:00");
		if($city > 19 && time() < $six ){
			$no_index=1;
		}

		//var_dump($city, $discount_info);die;
		
		$data = array();
		$data['country_id'] = $country_id;
		$data['no_index'] = $no_index;
		$data['id'] = $discount_id;
		$data['city'] = $city;
		$data['city_id'] = $city;
		$data['city_name'] = $city_name;
		
		$data['pageid'] = 'ping';
		//去除样式
		$body = $discount_info['body'];
		$body = preg_replace("/style=[^>]*/",'',$body);
		$discount_info['body'] = $body;
		$data['discount_info'] = $discount_info;
		
		$area_cities = $this->mo_geography->get_all_cities();
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		$data['area_cities'] = $area_cities;
		$data['country_code'] = $country_code;

		#相关城市购物攻略
		//$this->config->load("recommend", true);
		//$home_city_ids = $this->config->item("home_city_ids", "recommend");
		
		$right_tips_html = $this->mo_module->get_city_tips($country_id, $city, 0);
		$data['right_tips_html'] = $right_tips_html;

		//选取掉了相关城市攻略的展示
		//$right_relation_tips_html = $this->mo_module->ger_relation_city_tips();
		//$data['right_relation_tips_html'] = $right_relation_tips_html;


		$share_content = "";
		if($country_id=='15'){
			$share_content = "#日本购物攻略#";
		}elseif($city==49){
			$share_content = "#台湾购物攻略#";
		}elseif($city==45){
			$share_content = "#澳门购物攻略#";
		}elseif($city==44){
			$share_content = "#香港购物攻略#";
		}elseif($city==97){
			$share_content = "#首尔购物攻略#";
		}elseif($city==54){
			$share_content = "#迪拜购物攻略#";
		}elseif($city==1){
			$share_content = "#纽约购物攻略#";
		}elseif($city==54){
			$share_content = "#迪拜购物攻略#";
		}elseif($country_id==1){
			$share_content = "#美国购物攻略#";
		}elseif($country_id==2){
			$share_content = "#加拿大购物攻略#";
		}
		$area_o = array(4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12,18=>18);
		if(isset($area_o[$country_id])){
			$share_content = "#欧洲购物攻略#";
		}

		if(isset($discount_info['share_content']) && $discount_info['share_content']){
			$clean_body = $discount_info['share_content'];
		}else{
			$clean_body = $this->tool->clean_html_and_js($discount_info['body']);
			$clean_body = $this->tool->substr_cn2($clean_body, 120);
		}
		$clean_body = $share_content . "[".$discount_info['title']."]".$clean_body;


		$clean_body = $this->tool->clean_quotes($clean_body);
		$clean_body=preg_replace("/[\r\n]+/","\\n",$clean_body);
		$clean_body .= " 更多请访问赞佰网(zanbai.com)";
		$data['share_content'] = $clean_body;

		$domain = context::get('domain', '');
		$share_url = $domain.$_SERVER['REQUEST_URI'];
		$data['share_url'] = $share_url;
			
		$share_img = "";
		if($discount_info['pics_list']){
			$share_img = upimage::format_brand_up_image($discount_info['pics_list'][0]);
		}

		$data['share_img'] = $share_img;

		$ios_contact_html = $this->mo_common->get_ios_contact();
		$data['ios_contact_html'] = $ios_contact_html;

//香港购物攻略 尖沙咀购物攻略 |赞佰网，出境购物指南，全球百货攻略
//香港购物攻略，尖沙咀购物攻略，尖沙咀必去商场，尖沙咀精品店
//赞佰网( zanbai.com)为您提供最新最全面的香港购物攻略，购物指南，购物小贴士。全面介绍尖沙咀的购物攻略，必去商家、特色商家、精品店铺。
		$title = $discount_info['title'];

//title：[文章标题]_[城市购物攻略] - 赞佰网
//keyword：[城市],[购物攻略],[自定义值]
//没有默认值。
//description：[文章标题],赞佰网[城市购物攻略],为您提供[城市]最新的购物攻略和购物指南，更多[城市购物攻略]以及[文章标题]，请问访问赞佰网（www.zanbai.com）。
		if($discount_info['seo_title']){
			$data['page_title'] = $discount_info['seo_title'];
		}else{
			$data['page_title_single'] = "{$title}-赞佰网";
		}
		$data['page_title_single'] = "{$title}_{$city_name}购物攻略 - 赞佰网";
		if($discount_info['seo_keywords']){
			$data['seo_keywords'] = $discount_info['seo_keywords'];
		}else{
			$data['seo_keywords'] = "{$city_name}购物攻略,{$city_name}购物指南,{$city_name}买什么,{$city_name}购物贴士";
		}
		$data['seo_keywords'] = "{$city_name},购物攻略,".$discount_info['seo_keywords'];
		if($discount_info['seo_description']){
			$data['seo_description'] = $discount_info['seo_description'];
		}else{
			$desc = $clean_body;
			$seo_desc = $this->seo_desc($desc);
			$data['seo_description'] = $seo_desc;
		}
		$data['seo_description'] = "{$title},赞佰网{$city_name}购物攻略,为您提供{$city_name}最新的购物攻略和购物指南，更多{$city_name}购物攻略以及{$title}，请问访问赞佰网（www.zanbai.com）。";


		$shoptips_body = $discount_info['body'];
		$shoptips_body = $this->tool->clean_file_version($discount_info['body'],'!pingbody');
		$shoptips_body = str_replace("<img", "<img alt='{$title}' action-type='show_big_img' ", $shoptips_body);
		//<a class="pink_link"
		$shoptips_body = str_replace("<a", "<a class='pink_link' target='_blank' ", $shoptips_body);
		$data['shoptips_body'] = $shoptips_body;

		//回去本城市的热门商家
		$data['recommend_shop_html'] = $this->mo_module->recomment_shop($city);
		
		$data['tj_id'] = "shoptips_detail";

		$data['macys_html'] = $this->mo_module->format_macys($data['country_id']);

		$city_id = $city;
		if($city_id){
			context::set("city_id", $city_id);
		}
		if($country_id){
			context::set("country_id", $country_id);
		}
		
		$right_coupon_html = $this->mo_module->format_shoptips($data['country_id'], $data['city'], 0, 0);
		$data['right_coupon_html'] = $right_coupon_html;

		//$data['new_york_kits_html'] = $this->mo_module->new_york_kits($data['city'], 0, 210);


		$pre_next = $this->mo_discount->get_info_pre_next($discount_id, $country_id, $city, $shop_id, 2);
		$data['pre_next'] = $pre_next;
		$this->get_adv_data();

		$have_shop_ids = $discount_info['have_shop_ids'];
		
		$shops = $this->mo_shop->get_shopinfo_by_ids($have_shop_ids);
		$data['shops'] = $shops;


		#评论信息

		$vuid = context::get('vuid', 0);
		$data['vuid'] = $vuid;
		$dianping_id = $discount_id;
		$comment_re = $this->mo_module->get_comment_html($vuid, $dianping_id, 1, 1, 10);
		
		
		$comment_list_html = $comment_re['comment_list_html'];
		$page_cnt = $comment_re['page_cnt'];
		$users = $comment_re['users'];

		/*
		
		$comments = $this->mo_comment->get_commentid_by_dianpingid($dianping_id, 1);
		$comments_info = $this->mo_comment->get_comment_by_ids($comments);
		$users = array();
		if($comments_info){
			foreach($comments_info as $comment){
				$uids[] = $comment['uid'];
			}
			$users = $this->mo_user->get_middle_userinfos($uids);
		}

		#回复总数
		$total = $this->mo_comment->get_comment_cnt_by_dianping($dianping_id, 1);
		$page_cnt = ceil($total/10);
		$comment_data = array("comments"=>$comments_info,'users'=>$users,'dianping_id'=>$dianping_id,'shop_id'=>$shop_id,'login_uid'=>$login_uid);
		$comment_data['type'] = 1;
		$comment_list_html = $this->load->view("template/comment_card",$comment_data,true);
		*/

		$data['comment_list_html'] = $comment_list_html;
		$data['page'] = $page;
		$data['page_cnt'] = $page_cnt;
		$data['users'] = $users;
		
		$data['new_york_kits_html'] = $this->mo_module->new_york_kits($data['city'], 0, 210);

		$this->load->web_view('shoptips_detail', $data);
	}

	public function shoptips_detail_h5(){
		$discount_id = $this->input->get("id", true, 0);
		$discount_id = intval($discount_id);
		
		if(!$discount_id){
			tool::sorry();
		}

		$discount_info = $this->mo_discount->get_info_by_id($discount_id, true);
		
		if(!$discount_info || ( $discount_info['status'] != 0 && $discount_info['status'] != 3)){
			tool::sorry();
		}
		$country_id = 0;

		if($discount_info['city']){
			if(strstr($discount_info['city'], ",")==false){
				$city = $discount_info['city'];
			}else{
				$tmp = explode(",", $discount_info['city']);
				foreach($tmp as $v){
					if($v){
						$city = $v;
					}
				}
			}

			if(strstr($discount_info['country'], ",")==false){
				$country_id = $discount_info['country'];
			}else{
				$tmp = explode(",", $discount_info['country']);
				foreach($tmp as $v){
					if($v){
						$country_id = $v;
					}
				}
			}
		}else{
			$city = $this->input->cookie("city_id", true , 0);
			$country_id = $discount_info['country'];
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			if($city_info['country_id'] != $country_id){
				$city_list = $this->mo_geography->get_cities_by_country($country_id);
				if($city_list){
					$city = $city_list[0]['id'];
				}
			}
		}

		$city_name = $country_id = "";
		if($city){
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			if($city_info){
				$city_name = $city_info['name'];
				$country_id = $city_info['country_id'];
			}
		}

		
		$data['city_info'] = $city_info;
		$discount_info = tool::clean_file_version($discount_info, "!settingimage");
		$data['discount_info'] = $discount_info;
		
		$data['body_class'] = "shop_list";
		$data['page_css'] = array("/css/h5/page/city_list.css");
		$this->load->h5_view("h5/tips_detail", $data);
	}
	protected function seo_desc($desc){
		$desc = $this->tool->clean_quotes($desc);
		$desc=preg_replace("/[\r\n]+/","\\n",$desc);
		$offset = stripos( $desc, "。", 0);
		if($offset){
			$min_desc = trim(mb_substr($desc, 0, $offset, 'utf-8'));
		}else{
			$min_desc = trim(mb_substr($desc, 0, 60, 'utf-8'));
		}
		$min_desc = trim(mb_substr($min_desc, 0, 60, 'utf-8'));
		return $min_desc;
	}
}





