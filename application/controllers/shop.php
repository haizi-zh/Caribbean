<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends ZB_Controller {

	const PAGE_ID = 'shop_detail';
	const CACHA_TIME = 3000;
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model('mo_tag');
		$this->load->model('mo_dianping');
		$this->load->model('mo_operation');
		$this->load->model("mo_module");
		$this->load->model("mo_fav");
	}


	public function index(){
		$segment_array = $this->uri->segment_array();
		if($segment_array[1]=='shop'){
			$shop_id = $this->input->get("shop_id",true,0);
			$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
			$lower_name = "";
			if($shop_re){
				$city = $shop_re[$shop_id]['city'];
				$city_info = $this->mo_geography->get_city_info_by_id($city);
				if($city_info){
					$lower_name = $city_info['lower_name'];
				}
			}
			$re_url = base_url('/'.$lower_name.'/'.$shop_id.'/');
			redirect($re_url, 'location', 301);
		}

		$check_mobile = context::get("check_mobile", false);
		if($check_mobile){
			$this->index_h5();
			return;
		}

		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;

		$data = $this->get_shop_data();
		$shop = $data['shop'];
		$is_fav = $this->mo_fav->check_exist($login_uid, $shop['id'], 0);
		$data['shop']['is_fav'] = $is_fav;
		$data['page_css'][] = "ZB_shop_detail_new.css";
		$data['page_css'][] = "newlayer.css";
		$data['page_js'] = "shop_detail_new";
		//$this->load->web_view('shop', $data);
		$data['tj_id'] = "shop";

		$this->get_adv_data();
		
		$this->load->web_view('shop_new', $data);
	}

	private function get_shop_data(){
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		#获取商家信息
		$shop_id = $this->input->get("shop_id",true,0);
		$property = $this->input->get('property', true, 0);

		$shop_id = intval($shop_id);
		$property = intval($property);
		$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		#not exist
		if(!$shop_re){
			$this->tool->sorry();
		}
		$shop_info = $shop_re[$shop_id];

		$data = $this->mo_shop->get_simple_cache("%s_shop_%s_%s", "shop_pre", array($shop_id, $property));
		if($data === false){
			#获取点评信息
			$dianping_re = $this->mo_dianping->get_dianpinginfo_by_shopid_new($shop_id);

			#点评页数
			$total = $this->mo_shop->get_dianping_cnt($shop_id);
			$page_cnt = ceil($total/10);

			#城市信息
			$city_id = $shop_re[$shop_id]['city'];
			$country_id = $shop_re[$shop_id]['country'];

			$city_info = $this->mo_geography->get_city_info_by_id($city_id);
			$country_info = $this->mo_geography->get_country_info_by_id($country_id);
			$city_name = $city_info['name'];
			$city_lower_name = $city_info['lower_name'];
			$country_name = $country_info['name'];

			#位置信息
			$lat = 0;$lon=0;
			$location = isset($shop_re[$shop_id]['location'])?$shop_re[$shop_id]['location']:'';
			if($location){
				$locations = explode(',',$location);
				$lon = trim($locations[0]);
				$lat = trim($locations[1]);
			}
			#获取热门商家
			$shop_ids = $this->mo_operation->get_value(mo_operation::HOT_SHOP);
			$hot_shops = array();
			if(!empty($shop_ids)){
				$hot_shops = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
			}

			$shaidan_data = array();
			$shaidan_data['dianpings'] = $dianping_re;
			$shaidan_data['shop_id'] = $shop_id;
			$shaidan_data['property'] = $property;
			$shaidan_data['page'] = 1;
			$shaidan_data['page_cnt'] = $page_cnt;
			$shaidan_data['show_shop_title'] = 0;
			#附近商家
			#footer
			$jsplugin_list = array('drag','popup', 'rating', 'richEditor');#需要用到的js插件
			$data = array();

			#判断是否显示品牌墙按钮
			$brand_ids = $this->mo_shop->get_brands_by_shop($shop_id);

			$have_brand = 0;
			if($brand_ids){
				$have_brand = 1;
			}

			$shop_info = $shop_re[$shop_id];
			if ($shop_info['reserve_2']) {
				$reserve_2 = $shop_info['reserve_2'];
				$url_head = substr($reserve_2, 0, 4);

				if ($url_head != 'http') {
					$shop_info['reserve_2'] = "http://".$reserve_2;
				}
			}

			if ($shop_info['desc']) {

				$shops = $this->mo_shop->get_all_shop_reserve();
				context::set('shop_list', $shops);
				$shop_city_lowernames = $this->mo_shop->get_all_shop_lowernames();
				context::set('shop_city_lowernames', $shop_city_lowernames);

				$tips_list = $this->mo_discount->get_all_tips_reserve();
				context::set('tips_list', $tips_list);

				$shop_info['desc'] = $this->tag->render_tag($shop_info['desc'], true);
			}

			#购物贴士
			

			$data = array('hot_shops'=>$hot_shops,'lat'=>$lat,'lon'=>$lon,'shop'=>$shop_info,'page'=>isset($_GET['page'])?$_GET['page']:1,'total'=>$total,'page_cnt'=>$page_cnt,'city_id'=>$city_id,'city_name'=>$city_name);
			
			$data['country_id'] = $country_id;
			$data['shaidan_data'] = $shaidan_data;
			$data['have_brand'] = $have_brand;

			$data['pageid'] = self::PAGE_ID;
			$data['jsplugin_list'] = $jsplugin_list;
			$data['shop_id'] = $shop_id;

			$city = $city_id;
			$data['city_info'] = $city_info;
			$data['city_name'] = $city_name;
			$data['country_name'] = $country_name;
			$data['city_id'] = $city;
			$area_cities = $this->mo_geography->get_all_cities();
			$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
			$data['area_cities'] = $area_cities;
			$data['country_code'] = $country_code;
			$shop_name = trim($shop_info['name']);
			$english_name = trim($shop_info['english_name']);
			$share_content = "#".$shop_name."简介#:";

			if(isset($shop_info['share_content']) && $shop_info['share_content']){
				$share_content .= $shop_info['share_content'];
			}else{
				$share_content .= $shop_info['short_desc'];
			}
			$share_content = $this->tool->clean_quotes($share_content);
			$share_content = trim($share_content);
			$share_content=preg_replace("/[\r\n]+/","\\n",$share_content);

			$share_content .= " 更多请访问赞佰网(zanbai.com)";
			$data['share_content'] = $share_content;

			$domain = context::get('domain', '');
			$share_url = $domain.$_SERVER['REQUEST_URI'];
			$data['share_url'] = $share_url;

			$share_img = "";
			if($shop_info['pic']){
				$share_img = upimage::format_brand_up_image(tool::clean_file_version($shop_info['pic']));
			}
			$data['share_img'] = $share_img;


			$shop_name = $shop_info['name'];


			#附近商家
			$nearby_shop_html = $this->mo_module->nearby_shop($shop_id);
			$data['nearby_shop_html'] = $nearby_shop_html;

			$ios_contact_html = $this->mo_common->get_ios_contact();
			$data['ios_contact_html'] = $ios_contact_html;

			$seo_keywords = $seo_description = "";

	//<title>香港 连卡佛 尖沙咀广东道 |赞佰网，出境购物指南，全球百货攻略
	//香港连卡佛，尖沙咀广东道，连卡佛，连卡佛简介，连卡佛点评，连卡佛折扣，连卡佛购物"
	//赞佰网( zanbai.com)为您提供香港购物攻略和香港购物中心的信息。连卡佛九龙区旗舰店位于香港热闹熙攘的购物区——尖沙咀的中心地带。"

			$shop_seo_keywords = $shop_info['seo_keywords'];
			$shop_all_name = $shop_info['name'];
			$shop_name = $shop_all_name;
			if($shop_info['name'] != $shop_info['english_name']){
				$shop_all_name .= " ". $shop_info['english_name'];
			}
			$desc = $shop_info['desc'];
			$offset = stripos( $desc, "。", 0);
			if($offset){
				$min_desc = trim(mb_substr($desc, 0, $offset, 'utf-8'));
			}else{
				$min_desc = trim(mb_substr($desc, 0, 60, 'utf-8'));
			}
			$min_desc = trim(mb_substr($min_desc, 0, 60, 'utf-8'));

			$data['page_title'] = $city_name." ".$shop_all_name."";
			$data['seo_keywords'] = $city_name." ".$shop_all_name." {$shop_name}简介 {$shop_name}点评 {$shop_name}折扣 {$shop_name}购物";
			$data['seo_description'] = $min_desc;

			$coupon_html = $this->mo_module->get_coupon_html($shop_id);

			$data['coupon_html'] = $coupon_html;

			$shop_tags = $this->mo_tag->get_shoptagids(array($shop_id));
			$shop_tag = array();
			$tag_list = $this->mo_tag->get_tag_list();
			if(isset($shop_tags[$shop_id])){
				$shop_tag = $shop_tags[$shop_id];
			}
			$data['shop_tag'] = $shop_tag;
			$data['tag_list'] = $tag_list;

			// 获取品牌
			$show_brands_infos = array();
			$all_brand_ids = $brand_ids;

			if($brand_ids){
				$this->config->load("recommend", true);
				$top_brands = $this->config->item("top_brands", "recommend");
				$shop_tag_brand = $this->config->item("shop_tag_brand", "recommend");
				$top_brands = explode(",", $top_brands);
				
				$top_brands = array_merge($top_brands, $shop_tag_brand);
				$top_tag_brands = array();
				foreach($brand_ids as $k=>$v){
					if(!$v || !in_array($v, $top_brands)){
						unset($brand_ids[$k]);
					}
				}

				$top_tag_brands_ = array();
				foreach ($shop_tag_brand as $k => $v) {
					if(in_array($v, $brand_ids)){
						$top_tag_brands[$v] = $v;
					}
				}
				$tmp = array();
				foreach($brand_ids as $k => $v){
					if(!isset($top_tag_brands[$v])){
						$tmp[$v] = $v;
					}
				}
				$tmp = array_unique($tmp);
				$brand_ids = $tmp;

				if($brand_ids){
					$show_brands = array();
					if(count($top_tag_brands) >= 8){
						$show_brands = array_slice($top_tag_brands, 0, 8, true);
						//$show_brands_keys = array_rand($top_tag_brands, 8);
						//foreach($show_brands_keys as $key){
						//	$show_brands[] = $top_tag_brands[$key];
						//}
					}else{
						$show_brands = $top_tag_brands;
						if(count($brand_ids) < 8-count($top_tag_brands)){
							$show_brands = $brand_ids;

							foreach($all_brand_ids as $v){
								if(count($show_brands) >=8){
									break;
								}
								$show_brands[$v] = $v;
							}
						}else{
							$show_brands_keys = array_rand($brand_ids, 8-count($top_tag_brands));
							if(is_array($show_brands_keys)){
								foreach($show_brands_keys as $key){
									$show_brands[] = $brand_ids[$key];
								}
							}else{
								$show_brands[] = $brand_ids[$show_brands_keys];
							}
						}
					}
					$show_brands_infos = $this->mo_brand->get_brands_by_ids($show_brands);
					$tmp = array();
					foreach($show_brands as $v){
						$tmp[$v] = $show_brands_infos[$v];
					}
					$show_brands_infos = $tmp;
					$show_brands_infos = array_slice($show_brands_infos, 0, 6, true);
				}
			}
			$data['show_brands_infos'] = $show_brands_infos;
			$data['city_lower_name'] = $city_lower_name;

			$recommend_shop_html = $this->mo_module->recomment_shop($city, $shop_id);
			$data['recommend_shop_html'] = $recommend_shop_html;

			$this->mo_shop->get_simple_cache("%s_shop_%s_%s", "shop_pre", array($shop_id, $property), 3600, $data);
		}
		$data['shaidan_data']['login_uid'] = $login_uid;
		$shaidan_list_html = $this->load->view("template/shaidan_card", $data['shaidan_data'], true);
		$data['shaidan_list_html'] = $shaidan_list_html;
		$discount_detail_html = $this->mo_discount->format_shopdetail_discount($shop_id, $login_uid);
		$discount_right_list_html =  $this->mo_discount->format_right_discount_list($shop_id, $login_uid);
		$data['discount_detail_html'] = $discount_detail_html;
		$data['discount_right_list_html'] = $discount_right_list_html;
		$coupon_discount_html = $this->mo_module->format_discount_coupon_html($shop_id, $shop_info, $login_uid);
		$data['coupon_discount_html'] = $coupon_discount_html;
		$coupon_discount_data = $this->mo_module->format_discount_coupon_data($shop_id, $shop_info, $login_uid);
		$data['coupon_discount_data'] = $coupon_discount_data;

		$data['macys_html'] = $this->mo_module->format_macys($data['country_id'], $data['city_id'], $data['shop_id']);
		$shoptips_html = $this->mo_discount->format_shoptips($data['country_id'], $data['city_id'], $data['shop_id'], $login_uid);
		$data['shoptips_html'] = $shoptips_html;
		return $data;
	}


	// zan.com/shop/download/?shop_id=7
	public function download(){
		$shop_id = $this->input->get("shop_id",true,0);
		$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		if(!$shop_re){
			$this->tool->sorry();
			exit();
		}
		$shop_info = $shop_re[$shop_id];
		if(!$shop_info['pdf_file']){
			$this->tool->sorry();
			exit();
		}
		$title = $shop_info['name'];
		$name = $title.".pdf";

		$up_file = $shop_info['pdf_file'];
		$filename = '/tmp/shop_pdf_'.$shop_id.".pdf";

		if(!file_exists($filename) || filesize($filename) < 10000){
			$content=file_get_contents($up_file);
			if(!$content){
				$this->tool->sorry();
				exit();
			}
			
			file_put_contents($filename, $content);//存盘
		}

	    // http headers 
	    header('Content-Type: application-x/force-download'); 
	    header('Content-Disposition: attachment; filename="' . $name .'"'); 
	    header('Content-length: ' . filesize($filename)); 
	 	// zbfile.b0.upaiyun.com/shop/1.pdf
	    // for IE6 
	    if (false === strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) { 
	        header('Cache-Control: no-cache, must-revalidate'); 
	    } 
	    header('Pragma: no-cache'); 
	         
	    // read file content and output 
	    return readfile($filename);; 

	}
	// zan.com/shop/print_2/?shop_id=5
	public function print_2(){
		$shop_id = $this->input->get("shop_id",true,0);
		$shop_id = intval($shop_id);
		$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));

		if(!$shop_re){
			echo false;
			exit();
		}
		$shop_info = $shop_re[$shop_id];
		$reserve_5 = $shop_info['reserve_5'];
		if(!$reserve_5){
			echo false;
			exit();
		}
		$data['shop_info'] = $shop_info;
		$css_domain = context::get('css_domain', '');
		
		$data['logo'] = "$css_domain/images/common/logo.png?id=20131021140000";
		echo json_encode($data);
	}
	// /shop/printd/?shop_id=1
	// zan.com/shop/printd/?shop_id=7
	public function printd(){
		$shop_id = $this->input->get("shop_id",true,0);
		$shop_id = intval($shop_id);
		$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		if(!$shop_re){
			echo false;
			exit();
		}
		$shop_info = $shop_re[$shop_id];
		$reserve_5 = $shop_info['reserve_5'];
		if(!$reserve_5){
			echo false;
			exit();
		}

		$data = $this->get_shop_data();
		$data['page_css'] = "ZB_shop_detail_new.css";
		$data['page_js'] = "shop_detail_new";
		$this->load->view('shop_print', $data);

	}
	public function get_title(){
		$shop_id = $this->input->get("shop_id",true,0);
		$shop_id = intval($shop_id);

		$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		$shop_info = $shop_re[$shop_id];
		$title = $shop_info['name'];
		echo $title;

	}


	public function index_h5(){
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;

		$data = $this->get_shop_data();
		//var_dump($data['city_info']);die;
		$shop = $data['shop'];
		$is_fav = $this->mo_fav->check_exist($login_uid, $shop['id'], 0);
		$data['shop']['is_fav'] = $is_fav;

		$data['body_class'] = "shop_detail";
		$data['page_css'] = array("/css/h5/page/city_list.css");
		$this->load->h5_view("h5/shop", $data);
	}
	public function index_h5_more(){
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;

		$data = $this->get_shop_data();
		$shop = $data['shop'];
		$data['shop_id'] = $shop['id'];
		$is_fav = $this->mo_fav->check_exist($login_uid, $shop['id'], 0);
		$data['shop']['is_fav'] = $is_fav;
		$coupon_list = $data['coupon_discount_data']['coupon_list'];
		$data['coupon_list'] = $coupon_list;
		$data['body_class'] = "shop_detail";
		$data['page_css'] = array("/css/h5/page/city_list.css");
		$this->load->h5_view("h5/shop_desc", $data);
	}
	public function index_h5_dianping(){
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		$shop_id = $this->input->get("shop_id",true,0);
		$shop_id = intval($shop_id);
		$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		$shop_info = $shop_re[$shop_id];
		$data['shop_info'] = $shop_info;
		$dianping_list = $this->mo_dianping->get_dianpinginfo_by_shopid_new($shop_id);
		$data['dianping_list'] = $dianping_list;
		$data['shop_id'] = $shop_id;

		$data['body_class'] = "discount";
		$data['page_css'] = array("/css/h5/page/city_list.css");
		$this->load->h5_view("h5/dianping_list", $data);
	}

}
