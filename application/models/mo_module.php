<?php
class Mo_module extends ZB_Model {
	const CACHA_TIME = 86400;
	//recomment_shop
	const KEY_RECOMMENT_SHOP = "%s_2_%s";

	function __construct(){
		parent::__construct();
	}
	public function get_comment_html($vuid, $dianping_id, $type=0, $page=1, $pagesize = 10){
		$this->load->model("mo_comment");
		$this->load->model("mo_user");
		$comments = $this->mo_comment->get_commentid_by_dianpingid($dianping_id, $type, $page, $pagesize);
		$total = $this->mo_comment->get_comment_cnt_by_dianping($dianping_id, $type);

		$re = $this->format_single_comment($vuid, $comments, $total, $dianping_id, $type, $page, $pagesize);
		return $re;
	}

	public function format_single_comment($vuid, $comments, $total, $dianping_id, $type=0, $page=1, $pagesize = 10 ){
		$this->load->model("mo_comment");
		$this->load->model("mo_user");
		
		$comments_info = $this->mo_comment->get_comment_by_ids($comments);
		$users = array();
		if($comments_info){
			foreach($comments_info as $comment){
				$uids[$comment['uid']] = $comment['uid'];
			}
			$users = $this->mo_user->get_middle_userinfos($uids);
		}
		
		$page_cnt = ceil($total/ $pagesize);
		$comment_data = array();
		$comment_data['shop_id'] = 0;
		$comment_data['comments'] = $comments_info;
		$comment_data['users'] = $users;
		$comment_data['dianping_id'] = $dianping_id;
		$comment_data['login_uid'] = $vuid;
		$comment_data['type'] = $type;
		$comment_data['page_cnt'] = $page_cnt;
		$comment_data['page'] = $page;
		$page_html = "";
		if($page_cnt > 1){
			$this->load->library ( 'extend' ); // 调用分页类
			$action = "action=page&dianping_id={$dianping_id}&type={$type}";
			$page_html = $this->extend->webPage ( $action, ceil ( $total / $pagesize ) , $page, $total, $pagesize );
			
			$comment_data['page_html'] = $page_html;

		}
		$html = $this->load->view('template/comment_card', $comment_data, true);

		$re = array();
		$re['page_html'] = $page_html;
		$re['comment_list_html'] = $html;
		$re['page'] = $page;
		$re['page_cnt'] = $page_cnt;
		$re['users'] = $users;
		return $re;

	}



	// 1=>210,2=>213,5=>214
	public function new_york_kits($city,$shop_id,$id, $more = true){
		$am = array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,10=>10,11=>11,12=>12,13=>13,14=>14,15=>15,16=>16,17=>17,18=>18);
		if(!isset($am[$city])){
			return "";
		}
		$list = array(1=>210,2=>213,5=>214);
		if(isset($list[$city])){
			$id = $list[$city];
		}else{
			shuffle($list);
			$id = $list[0];
		}
		$info = $this->mo_coupon->get_info($id);
		$data = array();
		$data['info'] = $info;
		$data['id'] = $id;
		$data['img'] = $info['pics_list'][0];
		$data['more'] = $more;
		
		$html = $this->load->view("modules/new_york_kits", $data, true);
		return $html;

	}
	//相关晒单
	public function right_shop_ping($shop_id, $ping_id){
		$this->load->model("mo_dianping");
		$dianping_re = $this->mo_dianping->get_dianpinginfo_by_shopid_new($shop_id);
		if(isset($dianping_re[$ping_id])){
			unset($dianping_re[$ping_id]);
		}
		$data = array();
		$data['list'] = $dianping_re;
		$html = $this->load->view("modules/right_shop_ping", $data, true);
		
		return $html;

	}
	public function get_right_coupon($city_id=0, $coupon_id = 0){
		$data = array();
		$this->load->model("mo_coupon");
		$this->load->model("mo_shop");
		$this->load->model("mo_geography");
		$city_info = $this->mo_geography->get_city_info_by_id($city_id);
		$city_name = $city_info['name'];
		$shop_ids = $this->mo_shop->get_shops_by_brand_property_city(0,0, $city_id, 1, 10000);
		$list = $this->mo_coupon->get_coupons_by_shopids($shop_ids);
		if($list){
			foreach($list as $k=>$v){
				if($v['id'] == $coupon_id){
					unset($list[$k]);
				}
			}
			if($list && count($list)>10){
				$rand = array_rand($list, 10);
				$re = array();
				foreach($rand as $v){
					$re[$v] = $list[$v];
				}
				$list = $re;
			}
		}
		$data['list'] = $list;
		$data['city_name'] = $city_name;
		$shoptips_html = $this->load->view("modules/right_coupon", $data, true);
		
		return $shoptips_html;
	}
	public function format_macys($country_id = 0, $city_id=0, $shop_id = 0, $coupon_id = 0){
		if( !$country_id ){
			$cookie_city_info = context::get("cookie_city_info", false);
			if($cookie_city_info){
				$country_id = $cookie_city_info['country_id'];
			}
		}
		if($country_id  != 1){
			return "";
		}
		$this->load->model("mo_adv");
		$list = $this->mo_adv->get_adv_by_country_city_shop($country_id,$city_id,$shop_id, 2);
		if(!$list){
			return "";
		}
		$adv_info = $list[0];
		if($coupon_id && $adv_info && $adv_info['n_coupon_id']){
			if(strstr($adv_info['n_coupon_id'], ",{$coupon_id},") !== false){
				return "";
			}
		}


		$data = array();
		
		$data['adv_info'] = $adv_info;
		$data['imgdomain'] = context::get("imgdomain", "");
		$data['domain'] = context::get("domain", "");
		$data['adv_pic'] = $data['imgdomain'].$adv_info['pic'];
		
		$shoptips_html = $this->load->view("modules/macys", $data, true);
		return $shoptips_html;
	}

	public function format_shoptips($country_id, $city_id, $shop_id, $uid){
		$this->load->model("mo_discount");
		$this->load->model('mo_geography');

		$country_id = intval($country_id);
		$city_id = intval($city_id);
		$shop_id = intval($shop_id);
		$uid = intval($uid);

		$list = $this->mo_discount->get_info_by_shopid($country_id, $city_id, $shop_id, 2, 1, 100);

		if(!$list){
			return "";
		}
		$city_info = $this->mo_geography->get_city_info_by_id($city_id);
		$data['city_info'] = $city_info;

		$tips_count = count($list);
		if($tips_count > 5){
			$rand = array_rand($list, 5);
			$tmp = array();
			foreach($rand as $v){
				$tmp[$v] = $list[$v];
			}
			$list = $tmp;
		}

		$data['list'] = $list;
		$data['city_id'] = $city_id;
		$data['shop_id'] = $shop_id;
		$data['tips_count'] = $tips_count;
		$shoptips_html = $this->load->view("modules/shoptips", $data, true);
		return $shoptips_html;
	}

	public function nearby_shop($shop_id){
		$this->load->model('mo_shop');
		$this->load->model('mo_geography');

		$nearby_shop_infos = $this->mo_shop->get_shop_ids_nearby($shop_id);
		$shop_infos = array_slice($nearby_shop_infos, 0, 10);
		$show_more = 0;
		$shop_infos_count = count($shop_infos);
		
		if($shop_infos_count > 2){
			$show_more = 1;
		}

		$city_infos = $city_ids = array();
		if($shop_infos){
			foreach($shop_infos as $v){
				$city_ids[] = $v['city'];
			}
			$city_infos = $this->mo_geography->get_city_info_by_ids($city_ids);
		}
		$data['city_infos'] = $city_infos;
		$data['shop_infos'] = $shop_infos;
		$data['show_more'] = $show_more;
		$html = $this->load->view("modules/nearby_shop", $data, true);
		return $html;
	}
	// 推荐商家 KEY_RECOMMENT_SHOP
	public function recomment_shop($city_id, $shop_id=0){
		$this->load->model('mo_tag');
		$this->load->model('mo_shop');
		$this->load->model('mo_geography');

		$re = $this->get_simple_cache(self::KEY_RECOMMENT_SHOP, "mo_module", array($city_id), self::CACHA_TIME);
		$re = false;
		if($re === false){
			$tag_ids = array(1);
			$shop_ids = $this->mo_shop->get_shops_by_brand_property_city(0, 0, $city_id, 1, 1000);

			$shops = $this->mo_tag->get_shop_ids_by_tagids($tag_ids, $shop_ids);
			$this->get_simple_cache(self::KEY_RECOMMENT_SHOP, "mo_module", array($city_id), self::CACHA_TIME, $shops);
		}else{
			$shops = $re;
		}
		if($shop_id){
			foreach($shops as $k => $v){
				if($shop_id == $v){
					unset($shops[$k]);
					break;
				}
			}
		}
		//var_dump($shop_ids);
		$shops = tool::array_rand_by_number($shops, 2);

		$shop_infos = array();
		$show_more = 0;
		if($shops){
			$rand_count = count($shops);
			if($rand_count > 3){
				$show_more = 1;
			}
			$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shops, true);
			$shop_infos = array_slice($shop_infos, 0, 8, true);
		}

		$city_infos = $city_ids = array();
		if($shop_infos){
			foreach($shop_infos as $v){
				$city_ids[] = $v['city'];
			}
			$city_infos = $this->mo_geography->get_city_info_by_ids($city_ids);
		}

		$data = array();
		$data['city_infos'] = $city_infos;

		$data['shop_infos'] = $shop_infos;
		$data['show_more'] = $show_more;
		$html = $this->load->view("modules/recomment_shop", $data, true);

		

		return $html;
	}

	public function shop_right_discount($shop_id){
		$this->load->model("mo_discount");

		$discount_ids = $this->mo_discount->get_discount_ids_by_shopid($shop_id);
		if(!$discount_ids){
			return "";
		}
		$discount_id = 0;
		$info = array();
		$more = 0;
		if ($discount_ids) {
			if(count($discount_ids)>5){
				$more = 1;
			}
			$discount_ids = array_slice($discount_ids, 0, 5);
			$infos = $this->mo_discount->get_info_by_ids($discount_ids);
		}
		$data = array();
		if($infos){
			foreach ($infos as $key => $value) {
				$value['clean_body'] = strip_tags($value['body']);
				$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],40);
				if($value['pics']){
					$pics = $value['pics'];
					$value['pics_list'] = json_decode($pics, true);
				}
				$infos[$key] = $value;
			}
		}
		$list = $infos;
		$data['more'] = $more;
		$data['list'] = $list;
		$data['shop_id'] = $shop_id;
		$shaidan_list_html = $this->load->view("modules/shop_discount_right_list", $data, true);
		return $shaidan_list_html;
	}

	public function city_right_discount($city_id){
		$this->load->model("mo_discount");
		$this->load->model("mo_shop");
		$this->load->model("mo_geography");
		$shop_ids = $this->mo_shop->get_shops_by_brand_property_city(0, 0, $city_id, 1, 1000);
		$discount_re = $this->mo_discount->get_discount_ids_by_shopids($shop_ids, 1, 100);
		$city_info = $this->mo_geography->get_city_info_by_id($city_id);
		$discount_ids = $discount_re['list'];
		$total = $discount_re['count'];
		if(!$discount_ids){
			return "";
		}
		$discount_id = 0;
		$info = array();
		$more = 0;
		if($total>5){
			$more = 1;
		}

		if ($discount_ids) {
			$discount_ids = array_slice($discount_ids, 0, 5);
			$infos = $this->mo_discount->get_info_by_ids($discount_ids);
			foreach($infos as $k => $v){
				
			}
		}

		$data = array();
		if($infos){
			foreach ($infos as $key => $value) {
				$value['clean_body'] = strip_tags($value['body']);
				$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],40);
				if($value['pics']){
					$pics = $value['pics'];
					$value['pics_list'] = json_decode($pics, true);
				}
				$infos[$key] = $value;
			}
		}
		$list = $infos;
		$data['more'] = $more;
		$data['list'] = $list;
		$data['city_id'] = $city_id;
		$data['city_info'] = $city_info;
		$shaidan_list_html = $this->load->view("modules/city_right_discount_list", $data, true);
		return $shaidan_list_html;
	}

	public function get_ping_right_pinglist($shop_id, $ping_id=0){
		$this->load->model("mo_dianping");

		$data = array();
		$list = $this->mo_dianping->get_dianpinginfo_by_shopid($shop_id, 1, 100);
		$tmp = array();
		if($list){
			foreach($list as $k=>$v){
				if($v['id'] == $ping_id){
					continue;
				}
				if(!$v['has_pic']){
					continue;
				}
				$pic = "";
				if($v['pics']){
					$pics = json_decode($v['pics'], true);
					$pic = $pics[0]."!pingpreview";
				}
				$tmp[$k] = $v;
				$tmp[$k]['pic'] = $pic;
				if(count($tmp) > 10){
					break;
				}
			}
		}
		$list = $tmp;

		//var_dump($list);
		$data['list'] = $list;
		$data['shop_id'] = $shop_id;
		$html = $this->load->view("modules/right_ping_list", $data, true);
		return $html;
	}

	public function get_city_tips($country_id, $city, $shop_id=0){
		$this->load->model("mo_discount");
		$this->load->model('mo_geography');

		$city_name = $city_lower_name = "";
		$city_info = array();
		if($city){
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			
			$city_name = $city_info['name'];
			$city_lower_name = $city_info['lower_name'];
		}

		$right_list = $this->mo_discount->get_info_by_shopid($country_id, $city, $shop_id, 2);
		if ($right_list) {
			foreach ($right_list as $key => $item) {
				if($item['status'] == 1){
					unset($right_list[$key]);
				}
			}
		}
		$data['city_info'] = $city_info;
		$data['city_lower_name'] = $city_lower_name;
		$data['city'] = $city;
		$data['city_name'] = $city_name;
		$data['right_list'] = $right_list;
		$shaidan_list_html = $this->load->view("modules/city_tips", $data, true);
		return $shaidan_list_html;
	}
	

	public function ger_relation_city_tips(){
		$this->load->model("mo_discount");
		$this->load->model('mo_geography');

		$city_discount_cnt = $this->mo_discount->get_random_discount();
		$city_ids = array_keys($city_discount_cnt);
		
		$rand_city_ids = array_rand($city_ids, 10);
		$tmp = array();
		foreach ($rand_city_ids as $key => $value) {
			$tmp[] = $city_ids[$value];
		}
		$city_ids = $tmp;
		
		$city_infos = $this->mo_geography->get_city_info_by_ids($city_ids);
		
		$data['city_infos'] = $city_infos;
		$data['city_discount_cnt'] = $city_discount_cnt;
		$html = $this->load->view("modules/city_relation_tips", $data, true);
		return $html;

	}

	public function right_user_info($suid, $uid){
		$this->load->model('mo_social');
		$this->load->model('mo_user');

		$relation = $this->mo_social->get_relation($uid);
		$userinfo_re = $this->mo_user->get_middle_userinfos(array($uid));
		$user = isset($userinfo_re[$uid])?$userinfo_re[$uid]:array();
		if(!$user){
			return "";
		}
		$data['user_info'] = $user;
		$data['relation'] = $relation;
		$data['ouid'] = $uid;
		$data['suid'] = $suid;
		$html = $this->load->view("modules/right_user_info", $data, true);
		return $html;

	}

	public function get_coupon_html($shop_id){
		$this->load->model('mo_coupon');
		$this->load->model('mo_shop');

		$brand_ids = $this->mo_shop->get_brands_by_shop($shop_id);
		$list = $this->mo_coupon->get_coupon_by_shop_brand($shop_id, $brand_ids);
		$html = "";
		if($list){
			$data['list'] = $list;
			$html = $this->load->view("modules/coupon_middle", $data, true);
		}
		return $html;
	}

	public function format_discount_coupon_html($shop_id, $shop_info, $login_uid=0){
		$this->load->model("mo_discount");
		$this->load->model('mo_coupon');
		$this->load->model('mo_shop');
		$this->load->model('mo_fav');

		$shop_id = intval($shop_id);
		$discount_type = $shop_info['discount_type'];
		
		$now = time();
		$data = array();
		$more = 0;
		$discount_list = array();

		/*
		$discount_ids = $this->mo_discount->get_discount_ids_by_shopid($shop_id, 1, 100);
		
		if ($discount_ids) {
			if(count($discount_ids)>5){
				$more = 1;
			}
			$discount_list = $this->mo_discount->get_info_by_ids($discount_ids);
			$now = time();
			if($discount_list){
				foreach($discount_list as $k=>$v){
					if($v['etime'] < $now){
						unset($discount_list[$k]);
					}
					// $v['shop_type'] == 1 && $discount_type==1
					if($discount_type==1){
						unset($discount_list[$k]);
						continue;	
					}
				}
			}
			$discount_list = array_slice($discount_list, 0, 5);

		}
		$data = array();
		if($discount_list){
			foreach ($discount_list as $key => $value) {
				if($value['etime'] < $now){
					unset($discount_list[$key]);
					continue;
				}
				$value['clean_body'] = $this->tool->clean_html_and_js_simple($value['body']);
				$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],80);
				if($value['pics']){
					$pics = $value['pics'];
					$value['pics_list'] = json_decode($pics, true);
				}
				$time_format = time::format_stime_etime_month($value['stime'], $value['etime']);
				$value['time_format'] = $time_format;
				$discount_list[$key] = $value;
			}
		}
		*/

		$brand_ids = $this->mo_shop->get_brands_by_shop($shop_id);
		$coupon_list = $this->mo_coupon->get_coupon_by_shop_brand($shop_id, $brand_ids);
		
		$coupon_list = $this->mo_fav->check_fav_coupons($coupon_list, $login_uid);

		$data['shop_id'] = $shop_id;
		$data['shop_info'] = $shop_info;
		$data['shop_name'] = $shop_info['name'];
		$data['discount_list'] = $discount_list;
		$data['coupon_list'] = $coupon_list;

		$data['shop_info'] = $shop_info;

		$shaidan_list_html = $this->load->view("modules/coupon_discount", $data, true);
		return $shaidan_list_html;
		
	}
	//format_discount_coupon_data
	public function format_discount_coupon_data($shop_id, $shop_info, $login_uid=0){
		$this->load->model("mo_discount");
		$this->load->model('mo_coupon');
		$this->load->model('mo_shop');
		$this->load->model('mo_fav');

		$shop_id = intval($shop_id);
		$discount_type = $shop_info['discount_type'];
		
		$now = time();
		$data = array();
		$more = 0;
		$discount_list = array();

		/*
		$discount_ids = $this->mo_discount->get_discount_ids_by_shopid($shop_id, 1, 100);
		
		if ($discount_ids) {
			if(count($discount_ids)>5){
				$more = 1;
			}
			$discount_list = $this->mo_discount->get_info_by_ids($discount_ids);
			$now = time();
			if($discount_list){
				foreach($discount_list as $k=>$v){
					if($v['etime'] < $now){
						unset($discount_list[$k]);
					}
					// $v['shop_type'] == 1 && $discount_type==1
					if($discount_type==1){
						unset($discount_list[$k]);
						continue;	
					}
				}
			}
			$discount_list = array_slice($discount_list, 0, 5);

		}
		$data = array();
		if($discount_list){
			foreach ($discount_list as $key => $value) {
				if($value['etime'] < $now){
					unset($discount_list[$key]);
					continue;
				}
				$value['clean_body'] = $this->tool->clean_html_and_js_simple($value['body']);
				$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],80);
				if($value['pics']){
					$pics = $value['pics'];
					$value['pics_list'] = json_decode($pics, true);
				}
				$time_format = time::format_stime_etime_month($value['stime'], $value['etime']);
				$value['time_format'] = $time_format;
				$discount_list[$key] = $value;
			}
		}
		*/

		$brand_ids = $this->mo_shop->get_brands_by_shop($shop_id);
		$coupon_list = $this->mo_coupon->get_coupon_by_shop_brand($shop_id, $brand_ids);
		
		$coupon_list = $this->mo_fav->check_fav_coupons($coupon_list, $login_uid);

		$data['shop_id'] = $shop_id;
		$data['shop_info'] = $shop_info;
		$data['shop_name'] = $shop_info['name'];
		$data['discount_list'] = $discount_list;
		$data['coupon_list'] = $coupon_list;

		$data['shop_info'] = $shop_info;
		return $data;
		
	}
}