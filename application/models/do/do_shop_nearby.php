<?php
class Do_shop_nearby extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function add($data){
		$data = array(
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:0,
				'target_shop_id' => isset($data['target_shop_id'])?$data['target_shop_id']:0,
				'simple_distance' => isset($data['simple_distance'])?$data['simple_distance']:0,
				'distance' => isset($data['distance'])?$data['distance']:0,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		$this->db->insert('zb_shop_nearby', $data);
		return $this->db->insert_id();
	}
	public function get_shop_ids_nearby($shop_id){
		$this->db->select("target_shop_id, simple_distance, distance");
		$this->db->where("shop_id", $shop_id);
		$query = $this->db->get("zb_shop_nearby");
		return $query->result_array();
	}
}