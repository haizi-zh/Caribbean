<?php
#点评操作类
class Mo_discount extends ZB_Model {

	//discount_cnt_by_shopids
	const CACHA_TIME = 86400;
	const KEY_DISCOUNT_CNT_BY_SHOPIDS = "%s_1_%s_%s";

	// get_info_by_shopid
	const KEY_GET_INFO_BY_SHOPID = "%s_2_%s_%s_%s_%s_%s_%s";
	// get_info_by_country_type
	const KEY_GET_INFO_BY_COUNTRY_TYPE = "%s_2_%s_%s";

	//get_have_dicount_shopids
	const KEY_GET_HAVE_DISCOUNT_SHOPIDS = "%s_3_%s_%s";

	// get_discount_ids_by_shopid
	const KEY_GET_DISCOUNT_IDS_BY_SHOPID = "%s_4_%s_%s_%s";
	# get_all_tips_reserve
	const KEY_GET_ALL_TIPS_RESERVE = "%s_5";
	# get_info_by_id
	const KEY_GET_INFO_BY_ID = "%s_6_%s_%s";
	const KEY_GET_INFO_BY_IDS = "%s_7_%s_%s";
	// get_discount_ids_by_shopids
	const KEY_GET_DISCOUNT_IDS_BY_SHOPIDS = "%s_8_%s";

	// get_info_pre_next
	const KEY_GET_INFO_PRE_NEXT = "%s_9_%s_%s_%s_%s_%s";

	function __construct(){
		parent::__construct();
		$this->load->model('do/do_discount');
		$this->load->model('do/do_discount_shop');
		$this->load->model("do/do_city");
		$this->load->model("do/do_country");
	}
	public function format_shoptips($country_id, $city_id, $shop_id, $uid){
		$this->load->model("mo_geography");

		$country_id = intval($country_id);
		$city_id = intval($city_id);
		$shop_id = intval($shop_id);
		$uid = intval($uid);

		$list = $this->get_info_by_shopid($country_id, $city_id, $shop_id, 2, 1, 100);

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
	public function get_last_discount($shop_id){
		$discount_ids = $this->get_discount_ids_by_shopid($shop_id);
		$discount_id = 0;
		$info = array();
		if ($discount_ids) {
			$discount_id = $discount_ids[0];
			$info = $this->get_info_by_id($discount_id);
		}
		return $info;
	}
	
	public function format_shopdetail_discount($shop_id, $uid){
		$this->load->model("mo_shop");

		$shop_id = intval($shop_id);
		$uid = intval($uid);
		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);

		$discount_ids = $this->get_discount_ids_by_shopid($shop_id);
		$discount_id = 0;
		$info = array();
		if ($discount_ids) {
			$discount_id = $discount_ids[0];
			$info = $this->get_info_by_id($discount_id);
		}
		$data = array();
		if($info){
			$info['clean_body'] = strip_tags($info['body']);
			$info['clean_body'] = $this->tool->substr_cn2($info['clean_body'],40);
			$pics = $info['pics'];
			if($info['pics']){
				$info['pics_list'] = json_decode($pics, true);
			}
		}

		$more = 0;
		$infos = array();
		if ($discount_ids) {
			if(count($discount_ids)>5){
				$more = 1;
			}
			$discount_ids = array_slice($discount_ids, 0, 10);
			$infos = $this->get_info_by_ids($discount_ids);
			$infos = array_slice($infos, 0, 5);
		}
		$data = array();
		if($infos){
			foreach ($infos as $key => $value) {
				
				$value['clean_body'] = $this->tool->clean_html_and_js_simple($value['body']);
				
				$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],80);

				if($value['pics']){
					$pics = $value['pics'];
					$value['pics_list'] = json_decode($pics, true);
				}
				$infos[$key] = $value;
			}
		}
		$data['shop_id'] = $shop_id;
		$data['infos'] = $infos;
		$data['info'] = $info;
		$data['discount_id'] = $discount_id;
		$data['shop_info'] = $shop_info;
		$shaidan_list_html = $this->load->view("modules/discount_big", $data, true);
		return $shaidan_list_html;

	}
	public function format_right_discount_list($shop_id, $uid){
		
		$white_user = tool::check_white($uid);
		if(!$white_user){
			return "";
		}
		$discount_ids = $this->get_discount_ids_by_shopid($shop_id);
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
			$infos = $this->get_info_by_ids($discount_ids);
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
	
	public function add($data){
		$discount_id = $this->do_discount->add($data);
		if (!$discount_id) {
			return false;
		}
		$relation_data = array();
  		$relation_data['brand_id'] = $data['brand_id'];
  		$relation_data['shop_id'] = $data['shop_id'];
  		$relation_data['discount_id'] = $discount_id;
  		$relation_data['discount_type'] = $data['type'];
  		$relation_data['ctime'] = $data['ctime'];
  		$relation_data['stime'] = $data['stime'];
  		$relation_data['etime'] = $data['etime'];
		$this->do_discount_shop->add($relation_data);
		return $discount_id;
	}

	public function edit($data, $id){
		$discount_info = $this->mo_discount->get_info_by_id_foradmin($id);
		$stime = $data['stime'];
		$etime = $data['etime'];
		$old_stime = $discount_info['stime'];
		$old_etime = $discount_info['etime'];
		$discount_id = $this->do_discount->edit($data, $id);
		if (!$discount_id) {
			return false;
		}
		if($stime != $old_stime || $etime != $old_etime){
			$relation_data['stime'] = $stime;
			$relation_data['etime'] = $etime;
			$this->do_discount_shop->edit_time($id, $relation_data);
		}
		return $discount_id;
	}

	public function add_shoptips($data){
		$discount_id = $this->do_discount->add($data);
		if (!$discount_id) {
			return false;
		}
		return $discount_id;
	}
	public function add_brand($data){
		$this->load->model("mo_shop");

		$brand_id = $data['brand_id'];
		if (isset($data['shop_ids']) && $data['shop_ids']) {
			$shop_ids = $data['shop_ids'];
		}else{
			$shop_ids = $this->mo_shop->get_shops_by_brand($brand_id);
			if(!$shop_ids){
				return false;
			}
		}
		
		$discount_id = $this->do_discount->add($data);
		if (!$discount_id) {
			return false;
		}
		foreach ($shop_ids as $key => $shop_id) {
			$relation_data = array();
			$relation_data['brand_id'] = $brand_id;
			$relation_data['shop_id'] = $shop_id;
			$relation_data['discount_id'] = $discount_id;
			$relation_data['discount_type'] = $data['type'];
			$relation_data['ctime'] = $data['ctime'];
	  		$relation_data['stime'] = $data['stime'];
	  		$relation_data['etime'] = $data['etime'];
			$this->do_discount_shop->add($relation_data);
		}
		return $discount_id;



	}


	public function delete($data){
		$discount_id = isset($data['id'])?$data['id']:0;
		$res = $this->do_discount->delete($discount_id) ;
		$this->do_discount_shop->delete($discount_id);

		return $res;
		
	}


	public function recover($data){
		$discount_id = isset($data['id'])?$data['id']:0;
		$re = $this->do_discount->recover($discount_id);
		$this->do_discount_shop->recover($discount_id);

		return $re;
	}


	public function get_info_by_id_foradmin($id){
		if(!$id){
			return array();
		}
		$discount_info = array();
		$discount_infos = $this->get_info_by_ids_foradmin(array($id));
		if($discount_infos && isset($discount_infos[$id])){
			$discount_info = $discount_infos[$id];
		}
		return $discount_info;
	}
	public function get_info_by_ids_foradmin($ids){
		$format_re = $this->do_discount->get_info_by_ids($ids);
		$return = array();
		foreach($format_re as $each){
			$return[$each['id']] = $each;
		}
		return $return;
	}

	public function get_all_tips_reserve(){
		//KEY_GET_ALL_TIPS_RESERVE
		$re = $this->get_simple_cache(self::KEY_GET_ALL_TIPS_RESERVE, "mo_discount", array(), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		$list = $this->do_discount->get_all_tips();
		$tmp = array();
		foreach($list as $k => $v){
			$tmp[$v['title']] = array('city'=>$v['city'], 'id'=>$v['id']);
		}
		$this->get_simple_cache(self::KEY_GET_ALL_TIPS_RESERVE, "mo_discount", array(), self::CACHA_TIME, $tmp);
		
		return $tmp;
	}

	//KEY_GET_INFO_BY_ID
	public function get_info_by_id($id, $status=false){
		
		if(!$id){
			return array();
		}
		$key_status = 0;
		if($status){
			$key_status = 1;
		}

		$re = $this->get_simple_cache(self::KEY_GET_INFO_BY_ID, "mo_discount", array($id, $key_status), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}

		$discount_info = array();
		$discount_infos = $this->get_info_by_ids(array($id), $status);
		if($discount_infos && isset($discount_infos[$id])){
			$discount_info = $discount_infos[$id];
			if ($discount_info['body']) {
				$this->load->model("mo_shop");

				$shops = $this->mo_shop->get_all_shop_reserve();
				context::set('shop_list', $shops);
				$shop_city_lowernames = $this->mo_shop->get_all_shop_lowernames();
				context::set('shop_city_lowernames', $shop_city_lowernames);
			
				$tips_list = $this->get_all_tips_reserve();
				context::set('tips_list', $tips_list);

				$body = $this->tag->render_tag($discount_info['body'], true);

				// action-url-shop-id
				preg_match_all("/action-url-shop-id=\"(.*?)\"/is", $body, $out);
				$have_shop_ids = array();
				if($out[1]){
					$have_shop_ids = array_unique($out[1]);
				}
				$discount_info['have_shop_ids'] = $have_shop_ids;
				$discount_info['body'] = $body;
			}
		}
		$this->get_simple_cache(self::KEY_GET_INFO_BY_ID, "mo_discount", array($id, $key_status), self::CACHA_TIME, $discount_info);
		return $discount_info;
	}

	//KEY_GET_INFO_BY_IDS
	public function get_info_by_ids($ids, $status=false){
		if(!$ids){
			return array();
		}
		$key_status = 0;
		if($status){
			$key_status = 1;
		}

		$re = $this->get_multi_cache(self::KEY_GET_INFO_BY_IDS, "mo_discount", $ids, array($key_status));
		$data = $re['data'];
		$diff_ids = $re['diff_ids'];
		if(!$diff_ids){
			return $data;
		}

		$format_re = $this->do_discount->get_info_by_ids($diff_ids);
		$return = array();
		foreach($format_re as $each){
			if(!$status){
				if($each['status']!=0){
					continue;
				}
			}
			$return[$each['id']] = $each;
		}
		$format_re = $return;

		$uids = array();
		foreach($format_re as $key=>$value){
			$pics_list = array();
			if($value['pics']){
				$pics_list = json_decode($value['pics'], true);
			}
			$value['pics_list'] = $pics_list;
			
			$value['clean_body'] = $this->tool->clean_html_and_js($value['body']);
			$body = $value['body'];

			$offset = strpos($body, "赞佰网编辑");
			if (!$offset) {
				//$body .= "<br/><br/>赞佰网编辑 <br/>zanbai.com     出境购物指南，全球百货攻略";
			}
			$value['body'] = $body;
			$uids[] = $value['uid'];
			$format_re[$key] = $value;
		}

		#获取用户信息
		$this->load->model('mo_user');
		$userinfos_re = $this->mo_user->get_middle_userinfos($uids);

		#把用户信息加入返回值
		foreach($format_re as $index=>$dianping){
			$dianping['user_info'] = isset($userinfos_re[$dianping['uid']])?$userinfos_re[$dianping['uid']]:array();
			$format_re[$index] = $dianping;
		}
		$re = $this->get_multi_cache(self::KEY_GET_INFO_BY_IDS, "mo_discount", $ids, array($key_status), self::CACHA_TIME, $format_re );
		
		$data = $re['data'];
		$diff_ids = $re['diff_ids'];

		return $data;
	}

	//KEY_GET_INFO_BY_SHOPID
	public function get_info_by_shopid($country_id, $city_id, $shop_id=0, $type = 1, $page=1, $pagesize=10){
		$re = $this->get_info_by_country_city_shop_type($country_id, $city_id, $shop_id, $type);
		$list = $re['list'];
		$offset = ($page - 1) * $pagesize;
		$re = array_slice($list, $offset, $pagesize, true);
		return $re;
	}
	// KEY_GET_INFO_PRE_NEXT
	public function get_info_pre_next($discount_id, $country_id, $city_id, $shop_id=0, $type = 1){
		$re = $this->get_simple_cache(self::KEY_GET_INFO_PRE_NEXT, "mo_discount", array($discount_id, $country_id, $city_id, $shop_id, $type), self::CACHA_TIME);
		if($re != false){
			return $re;
		}

		$re = $this->get_info_by_country_city_shop_type($country_id, $city_id, $shop_id, $type);

		if(!$re['list']){
			return array();
		}
		$list = $re['list'];
		$next = $pre = array();

		foreach($list as $k => $v){
			if($v['id'] == $discount_id){
				if(isset($list[$k-1])){
					$pre = $list[$k-1];
				}else{
					$pre = $list[count($list)-1];
				}
				if(isset($list[$k+1])){
					$next = $list[$k+1];
				}else{
					$next = $list[0];
				}
				if($next['id'] == $discount_id){
					$next = array();
				}
				if($pre['id'] == $discount_id){
					$pre = array();
				}
				break;
			}
		}
		$re = array();
		$re['pre'] = $pre;
		$re['next'] = $next;

		$this->get_simple_cache(self::KEY_GET_INFO_PRE_NEXT, "mo_discount", array($discount_id, $country_id, $city_id, $shop_id, $type), self::CACHA_TIME, $re);
		return $re;

	}
	public function get_info_by_country_type($country_id, $type=1){
		$page = 1;
		$pagesize = 100000;
		$re = $this->get_simple_cache(self::KEY_GET_INFO_BY_COUNTRY_TYPE, "mo_discount", array($country_id, $type, $page, $pagesize), self::CACHA_TIME);
		if($re != false){
			return $re;
		}
		$country_id = intval($country_id);

		$re = $this->do_discount->get_info_by_country($country_id, $type ,$page, $pagesize);
		$format_re = $this->tool->std2array($re);
		$count = count($format_re);
		$uids = array();
		foreach($format_re as $key=>$value){
			$value['clean_body'] = $this->tool->clean_html_and_js($value['body']);
			$uids[] = $value['uid'];
			$pics_list = array();
			if($value['pics']){
				$pics_list = json_decode($value['pics'], true);
			}
			$value['pics_list'] = $pics_list;
			$format_re[$key] = $value;
		}
		#获取用户信息
		$this->load->model('mo_user');
		$userinfos_re = $this->mo_user->get_middle_userinfos($uids);
		#把用户信息加入返回值
		foreach($format_re as $index=>$dianping){
			$dianping['user_info'] = isset($userinfos_re[$dianping['uid']])?$userinfos_re[$dianping['uid']]:array();
			$format_re[$index] = $dianping;
		}
		$data = array();
		$data['count'] = $count;
		$data['list'] = $format_re;
		$this->get_simple_cache(self::KEY_GET_INFO_BY_COUNTRY_TYPE, "mo_discount", array($country_id, $type, $page, $pagesize), self::CACHA_TIME, $data);

		return $data;
	}

	public function get_info_by_country_city_shop_type($country_id, $city_id, $shop_id=0, $type=1){
		$page = 1;
		$pagesize = 100000;
		$re = $this->get_simple_cache(self::KEY_GET_INFO_BY_SHOPID, "mo_discount", array($country_id, $city_id, $shop_id, $type, $page, $pagesize), self::CACHA_TIME);
		if($re != false){
			return $re;
		}
		$country_id = intval($country_id);
		$city_id = intval($city_id);
		$shop_id = intval($shop_id);

		$re = $this->do_discount->get_info_by_shopid($country_id, $city_id, $shop_id, $type ,$page, $pagesize);
		$format_re = $this->tool->std2array($re);
		$count = count($format_re);
		$uids = array();
		foreach($format_re as $key=>$value){
			$value['clean_body'] = $this->tool->clean_html_and_js($value['body']);
			$uids[] = $value['uid'];
			$pics_list = array();
			if($value['pics']){
				$pics_list = json_decode($value['pics'], true);
			}
			$value['pics_list'] = $pics_list;
			$format_re[$key] = $value;
		}
		#获取用户信息
		$this->load->model('mo_user');
		$userinfos_re = $this->mo_user->get_middle_userinfos($uids);
		#把用户信息加入返回值
		foreach($format_re as $index=>$dianping){
			$dianping['user_info'] = isset($userinfos_re[$dianping['uid']])?$userinfos_re[$dianping['uid']]:array();
			$format_re[$index] = $dianping;
		}
		$data = array();
		$data['count'] = $count;
		$data['list'] = $format_re;
		$this->get_simple_cache(self::KEY_GET_INFO_BY_SHOPID, "mo_discount", array($country_id, $city_id, $shop_id, $type, $page, $pagesize), self::CACHA_TIME, $data);

		return $data;
	}



	public function get_discount_cnt_by_shopid($country_id, $city_id, $shop_id=0, $type=1){
		$re = $this->get_info_by_country_city_shop_type($country_id, $city_id, $shop_id, $type);
		$count = $re['count'];
		return $count;
		
		$country_id = intval($country_id);
		$city_id = intval($city_id);
		$shop_id = intval($shop_id);

		#从do层获取结果
		$re = $this->do_discount->get_discount_cnt_by_shopid($country_id, $city_id, $shop_id, $type);
		$re = $this->tool->std2array($re);
		return $re;
	}


	public function get_random_discount(){
		#从do层获取结果
		$re = $this->do_discount->get_random_discount();
		$tmp = array();
		foreach ($re as $key => $value) {
			if(!$value['city']){
				continue;
			}
			$tmp[$value['city']] = $value['cnt'];
		}
		$re = $tmp;
		return $re;
	}




	public function get_discount_shop_info_by_discountid($discount_ids){
		$re = $this->do_discount_shop->get_discount_shop_info_by_discountid($discount_ids);
		$re = $this->tool->std2array($re);
		$tmp = array();
		foreach ($re as $key => $value) {
			$tmp[$value['discount_id']] = $value;
		}
		$re = $tmp;
		return $re;
	}


	public function get_discount_shops_by_discountid($discount_ids){
		$re = $this->do_discount_shop->get_discount_shops_by_discountid($discount_ids);
		return $re;
	}

	// KEY_GET_DISCOUNT_IDS_BY_SHOPID
	public function get_discount_ids_by_shopid($shop_id,$page=1,$pagesize=10){
		$offset = ($page - 1) * $pagesize;
		$re = $this->get_simple_cache(self::KEY_GET_HAVE_DISCOUNT_SHOPIDS, "mo_discount", array($shop_id, 1, 10000), self::CACHA_TIME);
		if($re !== false){
			$re = array_slice($re, $offset, $pagesize);
			return $re;
		}

		$re = $this->do_discount_shop->get_discount_ids_by_shopid($shop_id,1,10000);
		$this->get_simple_cache(self::KEY_GET_HAVE_DISCOUNT_SHOPIDS, "mo_discount", array($shop_id, 1, 10000), self::CACHA_TIME, $re);
		$re = array_slice($re, $offset, $pagesize);

		return $re;
	}

	public function get_discount_ids_cnt_by_shopid($shop_id){
		$re = $this->do_discount_shop->get_discount_ids_cnt_by_shopid($shop_id);
		$re = $this->tool->std2array($re);
		if (isset($re['cnt'])) {
			return $re['cnt'];
		}
		return 0;
	}
	// 获取城市包含的discount
	
	// KEY_GET_DISCOUNT_IDS_BY_SHOPIDS
	public function get_discount_ids_by_shopids($shop_ids,$page=1,$pagesize=10){
		$offset = ($page - 1)*$pagesize;

		$shop_ids_json = json_encode($shop_ids);
		$re = $this->get_simple_cache(self::KEY_GET_DISCOUNT_IDS_BY_SHOPIDS, "mo_discount", array($shop_ids_json), self::CACHA_TIME);
		if($re !== false){
			$re['list'] = array_slice($re['list'], $offset, $pagesize);
			return $re;
		}

		$re = $this->do_discount_shop->get_discount_ids_by_shopids($shop_ids,1,1000000);
		$data = array();
		$data['list'] = array();
		$data['count'] = 0;
		if($re){
			$brand_ids = array();
			foreach($re as $k => $v){
				if(!isset($brands[$v['brand_id']] )){
					$brand_ids[$v['brand_id']] = $k;
				}
			}
			$result = array();
			foreach($brand_ids as $v){
				$result[$v] = $re[$v]['discount_id'];
			}
			$data['list'] = $result;
			$data['count'] = count($result);
		}
		$this->get_simple_cache(self::KEY_GET_DISCOUNT_IDS_BY_SHOPIDS, "mo_discount", array($shop_ids_json), self::CACHA_TIME, $data);
		
		if($data['list']){
			$data['list'] = array_slice($data['list'], $offset, $pagesize);
		}
		return $data;
	}

	public function get_have_dicount_shopids($shop_ids){
		$etime = strtotime('tomorrow');
		$shop_ids_str = json_encode($shop_ids);
		$re = $this->get_simple_cache(self::KEY_GET_HAVE_DISCOUNT_SHOPIDS, "mo_discount", array($shop_ids_str, $etime), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		
		$re = $this->do_discount_shop->get_have_dicount_shopids($shop_ids, $etime);

		$this->get_simple_cache(self::KEY_GET_HAVE_DISCOUNT_SHOPIDS, "mo_discount", array($shop_ids_str, $etime), self::CACHA_TIME, $re);

		return $re;
	}

	// KEY_DISCOUNT_CNT_BY_SHOPIDS
	public function get_discount_cnt_by_shopids($shop_ids){
		$etime = strtotime('tomorrow');
		$shop_ids_str = json_encode($shop_ids);

		$re = $this->get_simple_cache(self::KEY_DISCOUNT_CNT_BY_SHOPIDS, "mo_discount", array($shop_ids_str, $etime), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}

		$re = $this->do_discount_shop->get_discount_cnt_by_shopids($shop_ids, $etime);
		$re = $this->tool->std2array($re);
		if (isset($re['cnt'])) {
			$this->get_simple_cache(self::KEY_DISCOUNT_CNT_BY_SHOPIDS, "mo_discount", array($shop_ids_str, $etime), self::CACHA_TIME, $re['cnt']);
			return $re['cnt'];
		}

		return 0;
	}

	#检测商家是否有折扣
	public function check_discount_for_shopid($shop_id){
		$shop_id = intval($shop_id);
		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
		$discount_type = $shop_info['discount_type'];

		$discount_ids = $this->get_discount_ids_by_shopid($shop_id, 1, 100);
		if(!$discount_ids){
			return false;
		}
		
		$discount_infos = $this->get_info_by_ids($discount_ids);

		$now = time();
		if($discount_infos){
			foreach($discount_infos as $k => $v){
				if($v['etime'] < $now){
					unset($discount_infos[$k]);
					continue;
				}

				// $v['shop_type'] == 1 && $discount_type==1
				if($discount_type==1){
					unset($discount_infos[$k]);
					continue;	
				}
			}
		}

		if(!$discount_infos){
			return false;
		}
		foreach($discount_infos as $k => $v){
			if(!$v['etime'] || $v['etime'] > $now){
				return $v['id'];
			}
		}
		return false;
		
	}

	public function get_last_discount_by_uid($uid){
		#从do层获取结果
		$re = $this->do_discount->get_last_discount_by_uid($uid);
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		return isset($format_re[0])?$format_re[0]:array();
	}

	#foradmin
	public function get_discount_list_for_admin($page, $pagesize, $params = array()){
		$this->load->model("mo_shop");

		$list = $this->do_discount->get_discount_list_for_admin($page, $pagesize, $params);

		#渲染商店信息
		if ($list) {
			$tmp = $shop_ids = array();
			foreach ($list  as $key => $value) {
				$shop_ids[] = $value['shop_id'];
				$list[$key]['clean_body'] = $this->tool->clean_all($value['body'], 200);
			}
			$citys = $this->do_city->get_all_citys();
			$countrys = $this->do_country->get_all_countrys();
			$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
			foreach ($list as $key => $value) {
				$shop_info = array();
				if ($value['shop_id'] && isset($shop_infos[$value['shop_id']]) && $shop_infos[$value['shop_id']]) {
					$shop_info = $shop_infos[$value['shop_id']];
				}
				
				$list[$key]['shop_info'] = $shop_info;
				
				$city_info = array();
				if ($value['city'] && isset($citys[$value['city']])) {
					$city_info = $citys[$value['city']];
				}
				$list[$key]['city_info'] = $city_info;

				$country_info = array();
				if ($value['country'] && isset($countrys[$value['country']])) {
					$country_info = $countrys[$value['country']];
				}
				$list[$key]['country_info'] = $country_info;

			}
		}

		return $list;
	}
	
	#foradmin
	public function get_discount_cnt_for_admin($params = array()){
		return $this->do_discount->get_discount_cnt_for_admin($params);
	}


	public function get_all_discount_ids_list($type=0, $select="id", $use_status=1){

		return $this->do_discount->get_all_discount_ids_list($type, $select, $use_status);
	}

	public function get_discount_ids_by_city($shop_ids){

	}
	public function get_discount_cnt_by_city($shop_ids){

	}

}