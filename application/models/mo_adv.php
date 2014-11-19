<?php

class Mo_adv extends ZB_Model {
	const CACHA_TIME = 3600;
	const KEY_GET_ADV_BY_CCS = "%s_1_%s_%s_%s_%s";
	// get_simple_from_where
	const KEY_SIMPLE_FROM_WHERE = "%s_2_%s_%s_%s";
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_adv');
	}

	public function add($data){
		$re = $this->do_adv->add($data);
		return $re;
	}
	public function update($data, $id){
		$re = $this->do_adv->update($data, $id);
		return $re;
	}
	public function delete($id){
		$data = array();
		$data['status'] = 1;
		$re = $this->do_adv->update($data, $id);
		return $re;
	}
	public function recover($id){
		$data = array();
		$data['status'] = 0;
		$re = $this->do_adv->update($data, $id);
		return $re;
	}

	public function get_info($id){
		$re = $this->do_adv->get_info($id);
		return $re;
	}

	public function get_list($status=0, $page=1, $pagesize=10){
		$re = $this->do_adv->get_list($status, $page, $pagesize);
		return $re;
	}
	public function get_list_count($status=0){
		$re = $this->do_adv->get_list_count($status);
		return $re;
	}

	public function get_adv_by_country_city_shop($country_id=0, $city_id=0, $shop_id=0, $type=1){
		$re = $this->get_simple_cache(self::KEY_GET_ADV_BY_CCS, "mo_adv", array($country_id, $city_id, $shop_id, $type), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}

		$re = $this->do_adv->get_adv_by_country_city_shop($country_id, $city_id, $shop_id, $type);
		$result = $this->get_simple_cache(self::KEY_GET_ADV_BY_CCS, "mo_adv", array($country_id, $city_id, $shop_id, $type), self::CACHA_TIME, $re);
		
		return $re;
	}
}