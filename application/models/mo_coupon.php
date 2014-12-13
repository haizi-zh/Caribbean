<?php
class Mo_coupon extends ZB_Model {
// get_coupon_by_shop_brand
	const CACHA_TIME = 86400;
	const KEY_GET_COUPON_BY_SHOP_BRAND = "%s_5_%s_%s";
	const KEY_GET_COUPON_INFOS_BY_IDS = "%s_4_%s";

	function __construct(){
		parent::__construct();
		$this->load->model("do/do_coupon");
		$this->load->model('do/do_discount');
		$this->load->model("do/do_city");
		$this->load->model("do/do_country");
	}
	public function add($data){
		$re = $this->do_coupon->add($data);
		return $re;
	}
	public function update($data, $id){
		$re = $this->do_coupon->update($data, $id);
		return $re;
	}
	public function increace_download($id){
		$re = $this->do_coupon->increace_download($id);
		//缓存
		$ids = array($id=>$id);
		$infos = $this->get_coupon_infos($ids);
		$infos[$id]['download_count'] =  $infos[$id]['download_count']+1;

		$this->get_multi_cache(self::KEY_GET_COUPON_INFOS_BY_IDS, "mo_coupon", $ids, array(), self::CACHA_TIME, $infos );

		return $re;
	}

	public function delete_coupon($data){
		$discount_id = isset($data['id'])?$data['id']:0;
		$res = $this->do_coupon->delete($discount_id) ;
		return $res;
		
	}

	public function recover_coupon($data){
		$discount_id = isset($data['id'])?$data['id']:0;
		return $this->do_coupon->recover($discount_id);
	}

	public function get_coupon_infos($ids){
		
		if(!$ids){
			return array();
		}
		$re = $this->get_multi_cache(self::KEY_GET_COUPON_INFOS_BY_IDS, "mo_coupon", $ids, array());
		$data = $re['data'];
		$diff_ids = $re['diff_ids'];
		

		if(!$diff_ids){
			return $data;
		}
		$infos = $this->do_coupon->get_info_by_ids($diff_ids);
		if($infos){
			foreach($infos as $k => $v){
				$body = $v['body'];
				//$body = nl2br($v['body']);
				$infos[$k]['body'] = $body;
			}
		}
		$infos = $this->format_coupon_infos($infos);
		$re = $this->get_multi_cache(self::KEY_GET_COUPON_INFOS_BY_IDS, "mo_coupon", $ids, array(), self::CACHA_TIME, $infos );
		
		$data = $re['data'];
		$diff_ids = $re['diff_ids'];

		return $data;
	}
	


	public function format_coupon_infos($infos){
		if(!$infos){
			return array();
		}
		$domain = context::get('domain', "");
		foreach($infos as $k => $v){
			$id = $v['id'];
			$body = $v['body'];
			$body = tool::clean_file_version($body, "!pingbody");
			$infos[$k]['body'] = $body;
			$infos[$k]['pics_list'] = array();
			$infos[$k]['mobile_pics_list'] = array();
			if($v['pics']){
				$tmp = array();
				$pics_decode = json_decode($v['pics'], true);
				foreach($pics_decode as $kk=>$vv){
					$tmp[$kk] = upimage::format_brand_up_image($vv);
				}
				$tmp_encode = json_encode($tmp);
				$infos[$k]['pics_list'] = $tmp;
				$infos[$k]['pics'] = $tmp_encode;
			}
			if($v['mobile_pics']){
				$mobile_pics_list = json_decode($v['mobile_pics'], true);
				$infos[$k]['mobile_pics_list'] = $mobile_pics_list;
			}
			if($v['shop_id']){
				$tmp = explode(",", $v['shop_id']);
				foreach($tmp as $shop_id){
					if($shop_id){
						break;
					}
				}
			}else{
				$shop_id = 1;
			}
			$shareurl = $domain."/coupon_info/{$id}/".$shop_id."/";
			$infos[$k]['shareurl'] = $shareurl;
		}
		return $infos;
	}

	public function get_info($id){
		if(!$id){
			return array();
		}
		$list = $this->get_coupon_infos(array($id));
		if(isset($list[$id])){
			return $list[$id];
		}
		return array();
	}

	public function get_info_formadmin($id){
		if(!$id){
			return array();
		}
		$re = $this->do_coupon->get_info($id);
		return $re;
	}

	
	// KEY_GET_COUPON_BY_SHOP_BRAND
	public function get_coupon_by_shop_brand($shop_id, $brand_ids=array()){
		$this->load->model("mo_shop");
		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
		if(!$shop_info){
			return array();
		}
		$brand_ids_str = json_encode($brand_ids);

		$re = $this->get_simple_cache(self::KEY_GET_COUPON_BY_SHOP_BRAND, "mo_coupon", array($shop_id, $brand_ids_str), self::CACHA_TIME);
		if($re !== false){
			$ids = tool::format_key_by_key($re, "id");
			$re = $this->get_coupon_infos($ids);
			return $re;
		}
		
		$shop_country = $shop_info['country'];
		$re = $this->do_coupon->get_coupon_by_shop_brand($shop_id, $brand_ids);

		if($re){
			foreach($re as $k => $v){
				$shop_ids = $v['shop_id'];
				if($shop_ids){
					$shop_ids_list = explode(",", $shop_ids);
					if(in_array($shop_id, $shop_ids_list)){
						//这个coupon满足条件
						continue;
					}
				}
				$v_brand_id = $v['brand_id'];
				$v_country_ids = $v['country_ids'];
				if($v_brand_id){
					$v_brand_id = substr($v_brand_id, 1, -1);
					$v_brand_id_list = explode(",", $v_brand_id);
					$v_country_ids_list = explode("|", $v_country_ids);
					$count_v_brand_id_list = count($v_brand_id_list);
					$i = 0;
					foreach($v_brand_id_list as $kk => $v_brand){
						if($v_brand && !$v_country_ids_list[$kk]){
							$i=1;
							break;
						}
						if($v_brand){
							$tmp_country = explode( ",", $v_country_ids_list[$kk] );
							if(in_array($shop_country, $tmp_country)){
								$i = 1;
								break;
							}
						}
					}
					
					if(!$i){
						unset($re[$k]);
					}
				}

			}
		}
		
		$re = $this->format_coupon_infos($re);

		$this->get_simple_cache(self::KEY_GET_COUPON_BY_SHOP_BRAND, "mo_coupon", array($shop_id, $brand_ids_str), self::CACHA_TIME, $re);

		return $re;
	}
	public function get_coupons_by_shopids($shop_ids){
		$this->load->model("mo_shop");
		$brand_ids = $this->mo_shop->get_brands_by_shops($shop_ids);
		$re_coupons = array();
		foreach($shop_ids as $shop_id){
			$shop_re = $this->get_coupon_by_shop_brand($shop_id, $brand_ids[$shop_id]);
			//存在coupon
			if($shop_re){
				foreach($shop_re as $v){
					$v['shop_id'] = $shop_id;
					$re_coupons[$v['id']] = $v;
				}
			}
		}
		return $re_coupons;
	}

	public function sort_coupon($list){
		if(!$list){
			return array();
		}
		$download = array();
		foreach($list as $k => $v){
			$download[$k] = $v['download_count'];
		}
		arsort($download);
		array_multisort($list,SORT_ASC, $download,SORT_DESC);
		return $list;
	}

	public function get_have_coupon_shopids($shop_ids){
		//获取shops 对应的brand id
		$this->load->model("mo_shop");
		$brand_ids = $this->mo_shop->get_brands_by_shops($shop_ids);
		$re_shop_ids = array();
		foreach($shop_ids as $shop_id){
			$shop_re = $this->get_coupon_by_shop_brand($shop_id, $brand_ids[$shop_id]);
			//存在coupon
			if($shop_re){
				$re_shop_ids[$shop_id] = $shop_id;
			}
		}
		return $re_shop_ids;
	}

	public function get_list($where=array(), $page=1, $pagesize=10){
		$this->load->model("mo_shop");
		$list = $this->do_coupon->get_list($where, $page, $pagesize);
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
		$list = $this->format_coupon_infos($list);
		return $list;
	}
	public function get_list_count($where=array()){
		$count = $this->do_coupon->get_list_count($where);
		return $count;
	}
	
	public function get_last_coupon_by_uid($uid){
		#从do层获取结果

		$re = $this->do_coupon->get_last_coupon_by_uid($uid);
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		return isset($format_re[0])?$format_re[0]:array();
	}

}