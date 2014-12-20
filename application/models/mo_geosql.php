<?php
#地理信息
class Mo_geosql extends ZB_Model {
	const KEY_COUNTRYS_AREA = "%s_1_%s";
	const KEY_CITY_INFOS= "%s_2_%s";
	const KEY_CITYS_AREA= "%s_3_%s_%s_%s";
	const KEY_ALL_AREA = "%s_4";

	function __construct(){
		parent::__construct();
		$this->load->model('do/do_areasql');
		$this->load->model('do/do_countrysql');
		$this->load->model('do/do_citysql');
	}

    #获取全部地域
	public function get_all_areas(){

		$format_re = $this->do_areasql->get_all_areas();
		#只要id
		$return = array();
		foreach($format_re as $each){
			$return[$each['id']] = $each;
		}
		
		return $return;
	}

	#根据地域id获取省份列表
	public function get_countries_by_area($area_id){
		
		$format_re = $this->do_countrysql->get_countries_by_area($area_id);
		#返回
		$return = array();
		foreach($format_re as $each){
			$return[$each['id']] = $each['name'];
		}
		
		return $return;
	}

	#根据省份id获取城市列表
	public function get_cities_by_country_formadmin($country_id){
		$format_re = $this->do_citysql->get_cities_by_country_foradmin($country_id);
		return $format_re;
	}

	#根据省份id获取城市mid
	public function get_cities_mid_by_country($country_id){
		$format_re = $this->do_citysql->get_cities_mid_by_country($country_id);
		return $format_re;
	}


}









