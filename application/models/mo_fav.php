<?php
class Mo_fav extends ZB_Model {

	const CACHA_TIME = 86400;
	const KEY_GET_FAV_LIST = "%s_3_%s_%s";


	function __construct(){
		parent::__construct();
		$this->load->model('do/do_fav');
		$this->load->model('do/do_coupon');
		$this->load->model('do/mo_geography');
	}
	public function check_fav_shops($shop_infos, $uid=0){
		$shop_favs = array();

		if($uid){
			$re = $this->get_fav_list($uid, 0);
			if($re){
				foreach($re as $v){
					$shop_favs[$v['favorite_id']] = $v['favorite_id'];
				}
			}
		}
		foreach($shop_infos as $k => $v){
			$is_fav = 0;
			if($shop_favs && isset($shop_favs[$v['id']])){
				$is_fav = 1;
			}
			$shop_infos[$k]['is_fav'] = $is_fav;
		}
		return $shop_infos;

	}

	public function check_fav_coupons($coupons, $uid=0){
		if(!$coupons){
			return array();
		}
		$favs = array();
		if($uid){
			$favs = $this->get_fav_ids($uid, 1);
		}

		foreach($coupons as $k => $v){
			$is_fav = 0;
			if($favs && isset($favs[$v['id']])){
				$is_fav = 1;
			}
			$coupons[$k]['is_fav'] = $is_fav;
		}
		return $coupons;
	}


	public function check_exist($uid, $favorite_id, $type){
		if(!$uid){
			return false;
		}
		
		$exist = $this->do_fav->get_exist($uid, $favorite_id, $type);
		if($exist){
			//恢复
			if($exist['status'] == 1){
				return false;
			}
			return true;
		}
		return false;
	}
	public function get_exist($uid, $favorite_id, $type){
		return $this->do_fav->get_exist($uid, $favorite_id, $type);
	}
	public function add_favorite($data){
		$favorite_id = isset($data['id'])?$data['id']:0;
		$user_id = isset($data['user_id'])?$data['user_id']:0;
		$type = isset($data['type'])?$data['type']:0;
		$mobile = isset($data['mobile'])?$data['mobile']:0;
		$ctime = isset($data['ctime'])?$data['ctime']:time();
		$exist = $this->get_exist($user_id, $favorite_id, $type);
		if($exist){
			//恢复
			if($exist['status'] == 1){
				$this->do_fav->recover($exist['id']);
				$this->delete_favorite_cache($user_id);
			}
			return true;
		}
		$insert = array();
		$insert['uid'] = $user_id;
		$insert['type'] = $type;
		$insert['favorite_id'] = $favorite_id;
		$insert['mobile'] = $mobile;
		$insert['ctime'] = $ctime;
		$insert['status'] = 0;
		$re = $this->do_fav->add_favorite($insert);

		$this->delete_favorite_cache($user_id);

		return $re;
	}

	public function delete_favorite($id, $uid){
		$res = $this->do_fav->delete($id) ;

		$this->delete_favorite_cache($uid);
		return $res;
	}



	public function get_fav_shops($uid, $city=0, $page=1, $page_size=10){
		$this->load->model('mo_shop');
		$count = 0;
		$shop_infos = array();
		$list = $this->get_fav_list($uid, 0);
		$city_infos = array();
		if($list){
			$offset = ($page - 1) * $page_size;
			$shop_ids = array();
			foreach($list as $v){
				$shop_ids[$v['id']] = $v['favorite_id'];
			}
			$all_shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids, true);
			$citys = array();
			if($all_shop_infos){
				foreach($all_shop_infos as $k=> $v){
					$citys[$v['city']] = $v['city'];
					if($city && $v['city'] != $city){
						unset($all_shop_infos[$k]);
					}
				}
			}
			$city_infos = $this->mo_geography->get_city_info_by_ids($citys);
			$count = count($all_shop_infos);
			$shop_infos = array_slice($all_shop_infos, $offset, $page_size);
			if($shop_infos){
				foreach($shop_infos as $k => $v){
					$shop_id = $v['id'];
					//$shop_id = 918;
					$discount_info = $this->mo_discount->get_last_discount($shop_id);

					$shop_infos[$k]['discount_info'] = $discount_info;
				}
			}
		}
		$re = array();
		$re['count'] = $count;
		$re['list'] = $shop_infos;
		$re['city_infos'] = $city_infos;
		return $re;
	}

	public function get_fav_coupons($uid, $city=0, $page=1, $page_size=10){
		$this->load->model('mo_shop');
		$this->load->model('mo_coupon');
		$this->load->model('mo_brand');
		$list = $this->get_fav_list($uid, 1);
		$city_infos = array();
		$count = 0;
		$all_coupon_infos = array();
		if($list){
			$offset = ($page - 1) * $page_size;
			$citys = array();
			$coupon_ids = array();
			foreach($list as $v){
				$coupon_ids[$v['id']] = $v['favorite_id'];
			}
			$all_coupon_infos = $this->mo_coupon->get_coupon_infos($coupon_ids);
			$all_shop_ids = array();


			foreach($all_coupon_infos as $k => $v){
				$shop_ids = array();
				// city shop_id  brand_id,country_ids
				if($v['city']){
					$citys[$v['city']] = $v['city'];
					if($city && $v['city'] != $city){
						unset($all_coupon_infos[$k]);
					}
				}
				if($v['shop_id']){
					$shop_ids[$v['shop_id']] = $v['shop_id'];
					$all_shop_ids[$v['shop_id']] = $v['shop_id'];
				}
				if($v['brand_id']){
					$brand_shop_infos = array();
					$shops = $this->mo_brand->get_shops_by_brand($v['brand_id']);
					if($v['country_ids']){
						$country_array = explode(",", $v['country_ids']);
						$country_check = array();
						foreach($country_array as $kk => $vv){
							if(!$vv){
								continue;
							}
							$country_check[$vv] = $vv;
						}
						if($country_check){
							$brand_shop_infos = $this->mo_shop->get_shopinfo_by_ids($shops);
							foreach($brand_shop_infos as $kkk=>$vvv){
								$country_id = $vvv['country'];
								if(isset($country_check[$country_id])){
									unset($brand_shop_infos[$kkk]);
								}
							}
						}
					}
					if($brand_shop_infos){
						foreach($brand_shop_infos as $kkkk=>$vvvv){
							$shop_ids[$vvvv['id']] = $vvvv['id'];
							$all_shop_ids[$vvvv['id']] = $vvvv['id'];
						}
					}
				}
				if($city){
					$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
					if($shop_infos){
						$no = 1;
						foreach($shop_infos as $v){
							if($v['city'] == $city){
								$no = 0;
								break;
							}
						}
						if($no){
							unset($all_coupon_infos[$k]);
						}
					}
				}
			}

			$all_shop_infos = $this->mo_shop->get_shopinfo_by_ids($all_shop_ids);
			if($all_shop_infos){
				foreach($all_shop_infos as $k=> $v){
					$citys[$v['city']] = $v['city'];
				}
			}

			$city_infos = $this->mo_geography->get_city_info_by_ids($citys);
			$count = count($all_coupon_infos);
			
			$all_coupon_infos = array_slice($all_coupon_infos, $offset, $page_size);
			
		}
		$re = array();
		$re['count'] = $count;
		$re['list'] = $all_coupon_infos;
		$re['city_infos'] = $city_infos;
		return $re;
	}
	public function delete_favorite_cache($uid){
		$re = $this->delete_simple_cache(self::KEY_GET_FAV_LIST, "mo_fav", array($uid, 0), self::CACHA_TIME);
		$re = $this->delete_simple_cache(self::KEY_GET_FAV_LIST, "mo_fav", array($uid, 1), self::CACHA_TIME);
	}
	// KEY_GET_FAV_LIST
	public function get_fav_list($uid, $type){
		$re = $this->get_simple_cache(self::KEY_GET_FAV_LIST, "mo_fav", array($uid, $type), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		
		$list = $this->do_fav->get_fav_list($uid, $type);
		$this->get_simple_cache(self::KEY_GET_FAV_LIST, "mo_fav", array($uid, $type), self::CACHA_TIME, $list);

		return $list;
	}


	public function get_fav_ids($uid, $type){
		$re = $this->get_fav_list($uid, $type);
		$favs = array();
		if($re){
			foreach($re as $v){
				$favs[$v['favorite_id']] = $v['favorite_id'];
			}
		}
		return $favs;
	}




	public function get_favorite_list($uid){
		$list = $this->do_fav->get_favorite_list($uid);
		if(!$list){
			return array();
		}
		foreach($list as $v){
			$ids[] = $v['favorite_id'];
		}
		$infos = $this->do_fav->get_info_by_ids($ids);

		return $infos;
	}

	public function get_favorite_count($uid){
		$list = $this->do_fav->get_favorite_count($uid);
		return $list;
	}



}