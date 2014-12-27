<?php
#省份
class Do_countrysql extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	#根据地域id获取省份'5'列表
	public function get_countries_by_area($area_id){

		$this->db->select('id');
		$this->db->select('name');
		$this->db->where('abroad', $area_id);
		if($area_id==0){
			$this->db->where('distType', '5');
		}else{
			$this->db->where('distType', '3');
		}
		
		$query = $this->db->get('locality');
		return $query->result_array();
	}
	

}