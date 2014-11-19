<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class direction extends ZB_Controller {
	const PAGE_ID = 'direction';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_directions");
		$this->load->model("mo_shop");
		$this->load->model("mo_module");
		$this->load->model("mo_common");
	}
	
	// zan.com/direction/?shop_id=1
	public function index(){
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		$data = array();
		$city_name = "";
		$city_id = 0;
		$shop_id = $this->input->get("shop_id", true, 0);
		$lower_name = $this->input->get("lower_name", true, '');
		if($lower_name){
			$shop_id = $this->mo_shop->get_id_by_lowername($lower_name);
		}
		$type_lists = array('1'=>'巴士','2'=>'火车','3'=>'地铁','4'=>'电车','5'=>'班车/购物快车','6'=>'观光旅游巴士(观光车)','7'=>'船');
		//$type_lists = array('0'=>'巴士','1'=>'火车','2'=>'地铁','3'=>'电车','4'=>'班车/购物快车','5'=>'观光旅游巴士(观光车)','6'=>'船');
		$shop_id = intval($shop_id);
		if(!$shop_id){
			tool::sorry();
		}
		$shop_info = array();
		if($shop_id){
			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);

			if(!$shop_info || $shop_info['status'] != 0){
				tool::sorry();
			}
			$city_id = $shop_info['city'];
		}else{
		}
		$country_id = $shop_info['country'];
		$data['country_id'] = $country_id;
		$city_info = $this->mo_geography->get_city_info_by_id($city_id);
		if(!$city_info){
			tool::sorry();
		}
		$shop_name = $shop_info['name'];
		$city_name = $city_info['name'];

		$direction_list = $this->mo_directions->get_directions_list($shop_id);
		if($direction_list){
			foreach($direction_list as $k => $direction){
				$direction_id = $direction['id'];
				$lines = $this->mo_directions->get_line_infos($direction_id);

				if($lines){
					
					foreach($lines as $line_key => $line_value){
						$have_value = 0;
						foreach($line_value as $item){
							if($item['title'] || $item['description']){
								$have_value = 1;
							}
						}
						
						if(!$have_value){
							unset($lines[$line_key]);
						}
					}
				}
				$direction_list[$k]['lines'] = $lines;
			}

		}
		$data['macys_html'] = $this->mo_module->format_macys($data['country_id']);
		$data['shop_id'] = $shop_id;
		$data['city_id'] = $city_id;
		$data['direction_list'] = $direction_list;
		$shoptips_html = $this->mo_discount->format_shoptips($data['country_id'], $data['city_id'], $data['shop_id'], $login_uid);
		$data['shoptips_html'] = $shoptips_html;
		$recommend_shop_html = $this->mo_module->recomment_shop($city_id);
		$data['recommend_shop_html'] = $recommend_shop_html;
		$data['ios_contact_html'] = $this->mo_common->get_ios_contact();

		$data['city_right_discount_html'] = $this->mo_module->city_right_discount($city_id);
		
		$icons = array(1=>"icon_bus",2=>"icon_train",3=>"icon_subway",4=>"icon_tramcar",5=>"icon_bus",6=>"icon_bus",7=>"icon_ferry");
		$item_type = array(1=>'介绍',2=>'时刻表',3=>'票价',4=>'乘车贴士',5=>'预定',6=>'咨询电话',);
		$data['item_type'] = $item_type;
		$data['shop_info'] = $shop_info;
		$data['shop'] = $shop_info;
		$city_lower_name = $city_info['lower_name'];
		$city_name = $city_info['name'];
		$data['city_name'] = $city_name;
		$data['city_lower_name'] = $city_lower_name;
		$data['icons'] = $icons;
		$data['type_lists']= $type_lists;
		$data['pageid'] = self::PAGE_ID;
		$data['page_css'] = "ZB_shop_detail_new.css";
		$data['body_class'] = "shop_detail";

		$data['city_name'] = $city_name;
		$data['shop_name'] = $shop_name;
	
		$data['page_title_single'] = "怎么去[{$city_name}][{$shop_name}] - 赞佰网";
		$data['seo_keywords'] = "怎样到达[{$shop_name}],怎么去[{$shop_name}],怎样去[{$shop_name}],如何去[{$shop_name}],如何到达[{$shop_name}]";
		$data['seo_description'] = "赞佰网(zanbai.com)国内首家为顾客提供[{$city_name}]购物资讯的网站，赞佰网不仅可以为您提供最新的[{$city_name}]购物攻略以及[{$city_name}]折扣信息，还为您提供最便捷的[{$city_name}]购物地图，可以指导您怎样到达[{$shop_name}],让您明白怎么去[{$shop_name}],如何去[{$shop_name}]，绝对不会浪费您半分钟，是您[{$city_name}]购物好帮手！";

		
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

		$this->load->web_view('direction', $data);
	}
	

}





