<?php
#商家最新n条晒单操作
class Do_index_shop_lastdianping extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	#添加一个最新晒单
	public function add($data){
		$data = array(
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:0,
				'last_dianpings' => isset($data['last_dianpings'])?$data['last_dianpings']:'',
		);
		$this->db->insert('zb_index_shop_lastdianping', $data);
	}
	
	#根据商家id，获取最新的晒单
	public function get_lastdianping_by_shopids($shop_ids){
		if(!$shop_ids){
			return array();
		}

		$this->db->select("*");
		$this->db->where_in("shop_id", $shop_ids);
		$query = $this->db->get("zb_index_shop_lastdianping");
		return $query->result();
	}
	
	#更新一个最新晒单
	public function update($shop_id,$dianpings){
		$data = array(
				'last_dianpings' => $dianpings,
		);
		$this->db->where('shop_id', $shop_id);
		$this->db->update('zb_index_shop_lastdianping', $data);
	}
}