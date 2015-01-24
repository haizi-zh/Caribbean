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

	#根据省份获取城市mid
	public function get_cities_mid_by_country($country_id){

		$sql = "SELECT mid FROM locality WHERE ";
		$sql .= " (shortDistrictId like '%{$country_id}%') ";
		$sql .= " and distType=6";
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}

	#根据省份,城市,编辑状态,获取信息
	public function get_viewspot_foradmin($area, $country, $city){
        
        //城市
        if( $city ){
			$sql = " SELECT * FROM locality WHERE ";
			$sql .= " (shortDistrictId like '%{$city}%') ";
			$sql .= " and distType=6";
		}else{
			if( $country ){
				$sql = " SELECT * FROM locality WHERE ";
			    $sql .= " (shortDistrictId like '%{$country}%') ";
			    if( $area ){
			    	$sql .= " and distType=3 ";
			    }else{
			    	$sql .= " and distType=5 ";
			    }

			}
		}
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}

}





