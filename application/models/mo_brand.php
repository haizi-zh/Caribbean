<?php
#品牌操作类
class Mo_brand extends ZB_Model {
	
	const NORMAL = 0;
	const DEPARTMENT = 1;
	const CACHA_TIME = 86400;
	const KEY_CITY_HOT_BRANDS = "%s_1";
	// get_brands_by_ids
	const KEY_GET_BRANDS_BY_IDS = "%s_2_%s";
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_index_brand_shop');
		$this->load->model('do/do_brand');
	}
	
	#添加一个品牌
	public function add_brand($data){
		return $this->do_brand->add($data);
	}
	
	#编辑一个品牌
	public function update_brand($data){
		return $this->do_brand->update($data);
	}
	public function update_info($data){
		if(!isset($data['id']) || !$data['id']){
			return false;
		}
		$re = $this->do_brand->update_info($data);
		return $re;
	}
	
	#删除一个品牌
	public function delete($data){
		# 删除关联表
		$re1 = $this->do_index_brand_shop->delete_brand($data);
		# 删除实体表
		$re = $this->do_brand->delete($data);
		return $re;
	}
	#获得所有品牌
	public function get_all_brand(){
		#获取返回值
		$re = $this->do_brand->get_all_brand();
		return $re;
	}


	#根据首字母获取品牌列表
	public function get_brands_by_first_char($first_char, $size=10){
		if(!$first_char){
			return array();
		}
		#获取返回值
		$re = $this->do_brand->get_brands_by_first_char($first_char, $size);
	
		#格式化成数组
		return $re;
	}
	
	public function get_brand_by_id($id, $format=false){
		if(!$id){
			return array();
		}
		$brand_infos = $this->get_brands_by_ids(array($id), $format);
		if ( $brand_infos && isset($brand_infos[$id])) {
			return $brand_infos[$id];
		}
		return array();
	}
	#根据id取品牌信息
	// KEY_GET_BRANDS_BY_IDS

	public function get_brands_by_ids($ids, $format = false){
		if(!$ids || !is_array($ids)){
			return array();
		}

		$ids = array_unique($ids);
		$re = $this->get_multi_cache(self::KEY_GET_BRANDS_BY_IDS, "mo_brand", $ids, array());

		$data = $re['data'];
		$diff_ids = $re['diff_ids'];

		if(!$diff_ids){
			foreach($data as $k => $brand){
				if($brand['status'] != 0 ){
					unset($data[$k]);;
				}
			}
			if($format){
				$result = array();
				foreach($data as $k => $brand){
					$result[strtoupper($brand['first_char'])][] = $brand;
				}
				$data = $result;
			}
			return $data;
		}


		$format_re = $this->do_brand->get_brands_by_ids($diff_ids);
		
		if($format_re){
			foreach($format_re as $k => $v){
				if( $v && $v['big_pic']){
					$format_re[$k]['big_pic'] = upimage::format_brand_up_image($v['big_pic']);
					$format_re[$k]['first_char'] = strtoupper($v['first_char']);
				}
			}
		}
		
		$re = $this->get_multi_cache(self::KEY_GET_BRANDS_BY_IDS, "mo_brand", $ids, array(), self::CACHA_TIME, $format_re);
		$format_re = $re['data'];
		if($format_re){
			foreach($format_re as $k => $brand){
				if($brand['status'] != 0 ){
					unset($format_re[$k]);;
				}
			}
		}
		
		if($format){
			$result = array();
			foreach($format_re as $brand){
				$result[strtoupper($brand['first_char'])][] = $brand;
				
			}
			$format_re = $result;
		}
		
		return $format_re;
	}

	public function get_id_by_name_foradmin($name){
		if(!$name){
			return array();
		}
		$format_re = $this->do_brand->get_id_by_name_foradmin($name);
		$result = array();
		foreach($format_re as $each){
			$result[$each['name']]  = array('brand_id'=>$each['id'], 'property'=>$each['property']);
		}
		return $result;
	}
	public function get_id_by_englishname_foradmin($name){
		if(!$name){
			return array();
		}
		$format_re = $this->do_brand->get_id_by_englishname_foradmin($name);

		$result = array();
		foreach($format_re as $each){
			$result[$each['english_name']]  = array('brand_id'=>$each['id'], 'property'=>$each['property']);
		}
		return $result;
	}
	public function get_id_by_reserve1_foradmin($name){
		if(!$name){
			return array();
		}
		$format_re = $this->do_brand->get_id_by_reserve1_foradmin($name);

		$result = array();
		foreach($format_re as $each){
			$result[$each['reserve_1']]  = array('brand_id'=>$each['id'], 'property'=>$each['property']);
		}
		return $result;
	}

	#根据品牌名称，获得品牌id
	public function get_id_by_name($brand_names){
		if(!$brand_names){
			return array();
		}
		$format_re = $this->do_brand->get_id_by_name($brand_names);
		
		$result = array();
		foreach($format_re as $each){
			$result[$each['name']]  = array('brand_id'=>$each['id'], 'property'=>$each['property']);
		}
		
		return $result;
	}

	#根据城市id获取热门品牌
	//KEY_CITY_HOT_BRANDS
	public function get_hot_brand_by_city_id($city_id){
		if(!$city_id){
			return array();
		}
		$re = $this->get_simple_cache(self::KEY_CITY_HOT_BRANDS, "mo_brand", array($city_id), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		$this->load->model("mo_shop");
		$shop_ids = $this->mo_shop->get_shops_by_brand_property_city(0,0,$city_id,1, 10000);
		if(!$shop_ids){
			return array();
		}
		$this->load->database();

		$this->db->select('brand_id');
		$this->db->where_in('shop_id', $shop_ids);
		$this->db->where('city', $city_id);
		$this->db->group_by("brand_id");
		$this->db->order_by('count(*)', 'desc');
		$query = $this->db->get("zb_index_brand_shop");
		$brand_ids = $query->result_array();
		#格式化
		$format_brand_ids_re = $brand_ids;	
		$format_brand_ids = array();
		foreach($format_brand_ids_re as $format_brand_id){
			$format_brand_ids[] = $format_brand_id['brand_id'];
		}

		$first_char_array = $this->tool->get_first_chars();
		$result = array();
		if($format_brand_ids){
			foreach($first_char_array as $first_char){
				$this->db->select('*');
				$this->db->where_in('id', $format_brand_ids);
				$this->db->where('first_char', $first_char);
				$query = $this->db->get('zb_brand');
				$brand_ids = $query->result_array();
				if ($brand_ids) {
					$result[$first_char] = $brand_ids;
				}
			}
		}
		$this->get_simple_cache(self::KEY_CITY_HOT_BRANDS, "mo_brand", array($city_id), self::CACHA_TIME, $result);

		return $result;
	}

	public function get_brands_by_shopids($shop_ids=array()){
		if(!$shop_ids){
			return array();
		}
		$re = $this->do_index_brand_shop->get_brands_by_shopids($shop_ids);
		return $re;
	}


	public function get_shops_by_brand($brand_id){
		if(!$brand_id){
			return array();
		}
		$re = $this->do_index_brand_shop->get_shops_by_brand($brand_id);

		$shop_ids = array();
		if($re){
			$re = $this->tool->std2array($re);
			foreach ($re as $key => $value) {
				$shop_ids[] = $value['shop_id'];
			}
		}
		return $shop_ids;
	}

	public function get_brand_countrys($brand_id){
		$this->load->model('mo_shop');
		$this->load->model('mo_geography');
		#获取 此brand对应的国家
		$shop_ids = $this->get_shops_by_brand($brand_id);
		$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
		$countrys = array();
		$re = array();
		if($shop_infos){
			foreach($shop_infos as $v){
				$countrys[$v['country']] = $v['country'];
			}
			$country_infos = $this->mo_geography->get_country_info_by_ids($countrys);
			if($country_infos){
				foreach($country_infos as $v){
					$re[$v['id']] = $v['name'];
				}
			}
		}
		return $re;
	}

}







