<?php
#地域
class Do_area extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->library('cimongo');
	}

	#添加一个地域
	public function add($data){
		$data = array(
				'name' => isset($data['name'])?$data['name']:'',
				'english_name' => isset($data['english_name'])?$data['english_name']:'',
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		$this->db->insert('zb_area', $data);
	}
	
	public function get_all_areas(){
		$this->db->select('*');
		$query = $this->db->get('zb_area');
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
}