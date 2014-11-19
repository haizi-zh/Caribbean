<?php
#地理信息
class Mo_geography extends ZB_Model {
	const KEY_COUNTRYS_AREA = "%s_1_%s";
	const KEY_CITY_INFOS= "%s_2_%s";
	const KEY_CITYS_AREA= "%s_3_%s_%s_%s";

	const CACHA_TIME = 864000;

	const KEY_ALL_AREA = "%s_4";

	function __construct(){
		parent::__construct();
		$this->load->model('do/do_area');
		$this->load->model('do/do_country');
		$this->load->model('do/do_city');
	}
	#添加一个地域
	public function add_area($data){
		return $this->do_area->add($data);
	}
	#添加一个国家
	public function add_country($data){
		return $this->do_country->add($data);
	}
	#添加一个城市
	public function add_city($data){
		return $this->do_city->add($data);
	}
	#更新一个商家
	public function update_city($data){
		return $this->do_city->update($data);
	}

	#根据地域id获取城市列表
	public function get_cities_by_area($area_id, $status=0, $order_by="level"){
		$re = $this->get_simple_cache(self::KEY_CITYS_AREA, "mo_geography", array($area_id, $status, $order_by), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		$format_re = $this->do_city->get_cities_by_area($area_id, $status, $order_by);
		$this->get_simple_cache(self::KEY_CITYS_AREA, "mo_geography", array($area_id, $status, $order_by), self::CACHA_TIME, $format_re);
		return $format_re;
	}

	#获取全部地域
	public function get_all_areas(){
		$re = $this->get_simple_cache(self::KEY_ALL_AREA, "mo_geography", array(), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}

		$format_re = $this->do_area->get_all_areas();
		#只要id
		$return = array();
		foreach($format_re as $each){
			$return[$each['id']] = $each;
		}
		$this->get_simple_cache(self::KEY_ALL_AREA, "mo_geography", array(), self::CACHA_TIME, $return);

		return $return;
	}
	public function get_all_citys(){
		$format_re = $this->do_city->get_all_citys();
		return $format_re;
	}

	public function get_all_cityinfos(){
		$area_ids = self::get_all_areas();
		$return = array();
		foreach($area_ids as $area_id=>$vv){
			$re = self::get_cities_by_area($area_id);
			foreach($re as $v){
				$return[$v['id']] = $v;
			}
		}
		return $return;		
	}
    public function get_city_by_lowername($city_lower_name){
    	$city = $this->do_city->get_city_by_lowername($city_lower_name);
        return $city;
    }
    public function get_city_by_name($city_name){
    	$city = $this->do_city->get_city_by_name($city_name);
        return $city;
    }

	#根据地域id获取城市列表
	public function get_all_cities($status=0, $order_by="level"){
		$area_ids = self::get_all_areas();

		$return = array();
		foreach($area_ids as $area_id=>$vv){
			$return[$area_id] = self::get_cities_by_area($area_id,$status,$order_by);
		}
		
		return $return;
	}
	
	#批量根据id获取名称
	public function get_name_by_ids($ids){
		$format_re = $this->do_city->get_name_by_ids($ids);
		#返回
		$return = array();
		foreach($format_re as $each){
			$return[$each['id']] = $each['name'];
		}
		return $return;
	}

	public function get_name_by_id($id){
		$city_name = "";
		$cityinfos = $this->get_all_cityinfos();
		if(!$cityinfos || !isset($cityinfos[$id])){
			return $city_name;
		}
		$city_info = $cityinfos[$id];
		$city_name = $city_info['name'];
		return $city_name;
	}


	public function get_city_lower_name($id){
		$info = $this->get_city_info_by_id($id);
		if(!$info){
			return "";
		}
		return $info['lower_name'];
	}
	public function get_city_info_by_id($id){
		$re = $this->get_city_info_by_ids(array($id));
		if (isset($re[$id])) {
			return $re[$id];
		}
		return array();
	}
	public function get_country_info_by_id($id){
		$re = $this->do_country->get_country_info_by_id($id);
		return $re;
	}
	public function get_all_countrys(){
		$re = $this->do_country->get_all_countrys();
		return $re;
	}
	
	public function get_country_name_list(){
		$countrys = $this->get_all_countrys();
		$list = array();
		foreach($countrys as $v){
			$list[$v['name']] = $v;
			$list[$v['english_name']] = $v;
		}
		return $list;
	}

	public function get_country_by_name($name){
		$countrys = $this->get_country_name_list();
		if(isset($countrys[$name])){
			return $countrys[$name];
		}
		return array();
	}

	#批量根据id获取城市信息
	public function get_country_info_by_ids($ids){
		$re = $this->do_country->get_country_info_by_ids($ids);
		#格式化成数组
		#返回
		$return = array();
		foreach($re as $each){
			$return[$each['id']] = $each;
		}
		return $return;
	}

	#批量根据id获取城市信息
	public function get_city_info_by_ids($ids){
		if(!$ids){
			return array();
		}
		$data = array();
		//缓存的key

		$re = $this->get_multi_cache("%s_cityinfo_%s", "city_infos_pre", $ids, array());
		$data = $re['data'];
		$diff_ids = $re['diff_ids'];
		if(!$diff_ids){
			return $data;
		}
		$format_re = $this->do_city->get_city_info_by_ids($diff_ids);
		#返回
		$return = array();
		foreach($format_re as $each){
			$return[$each['id']] = $each;
		}

		$re = $this->get_multi_cache("%s_cityinfo_%s", "city_infos_pre", $ids, array(), self::CACHA_TIME, $return);
		$data = $re['data'];
		
		if($data){
			foreach($data as $v){
				$return[$v['id']] = $v;
			}
		}

		return $return;
	}
	
	#根据地域id获取国家列表
	public function get_countries_by_area($area_id){
		$re = $this->get_simple_cache(self::KEY_COUNTRYS_AREA, "mo_geography", array($area_id), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		$format_re = $this->do_country->get_countries_by_area($area_id);
		#返回
		$return = array();
		foreach($format_re as $each){
			$return[$each['id']] = $each['name'];
		}
		$this->get_simple_cache(self::KEY_COUNTRYS_AREA, "mo_geography", array($area_id), self::CACHA_TIME, $return);

		return $return;
	}
	
	#根据国家id获取城市列表
	public function get_cities_by_country($country_id){
		$format_re = $this->do_city->get_cities_by_country($country_id);
		return $format_re;
	}
	#根据国家id获取城市列表
	public function get_cities_by_country_formadmin($country_id){
		$format_re = $this->do_city->get_cities_by_country_foradmin($country_id);
		return $format_re;
	}
}









