<?php
#地域
class Do_areasql extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all_areas(){
		$this->db->select('*');
		$query = $this->db->get('locality');
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach ($result as $key => $value) {
				$tmp[$value['id']] = $value;
			}
			$result = $tmp;
		}
		return $result;
	}

	#根据地域id获取国家列表
	public function get_countries_by_area($area_id){
		$this->db->select('id');
		$this->db->select('name');
		$this->db->where('area_id', $area_id);
		$query = $this->db->get('zb_country');
		return $query->result_array();
	}
}