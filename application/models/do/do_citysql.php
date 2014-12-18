<?php
#城市
class Do_citysql extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

    #根据省份获取城市列表
	public function get_cities_by_country_foradmin($country_id){

		$sql = "SELECT * FROM locality WHERE ";
		$sql .= " (shortDistrictId like '%{$country_id}%') ";
		$sql .= " and distType=6";
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}

}





