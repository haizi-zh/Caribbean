<?php
#国家
class Do_country extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->library('cimongo');
	}

	#添加一个国家
	public function add($data){
		$data = array(
				'name' => isset($data['name'])?$data['name']:'',
				'english_name' => isset($data['english_name'])?$data['english_name']:'',
				'area_id' => isset($data['area_id'])?$data['area_id']:'',
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		$this->db->insert('zb_country', $data);
	}
	
	#根据地域id获取国家列表
	public function get_countries_by_area($area_id){
		$this->db->select('id');
		$this->db->select('name');
		$this->db->where('area_id', $area_id);
		$query = $this->db->get('zb_country');
		return $query->result_array();
	}
	public function get_all_countrys(){
		$this->db->select('*');
		$query = $this->db->get('zb_country');
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
	public function get_country_info_by_id($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("zb_country");
		$re = $query->row_array();
		return $re;
	}
	#批量根据id获取名称
	public function get_country_info_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$query = $this->db->get("zb_country");
		return $query->result_array();
	}

}