<?php

class Do_ecommerce extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_cat_info($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("zb_ecommerce_cat");
		return $query->row_array();
	}
	public function add_cat($data){
		$re = $this->db->insert('zb_ecommerce_cat', $data);
		return $re;
	}
	public function update_cat($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_ecommerce_cat', $data);
		return $re;
	}
	public function get_cat_list(){
		$this->db->where("status", 0);
		$this->db->order_by("level","asc");
		$query = $this->db->get('zb_ecommerce_cat');
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach($result as $v){
				$tmp[$v['id']] = $v;
			}
			$result = $tmp;
		}
		return $result;
	}

	public function get_link_info($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("zb_ecommerce");
		return $query->row_array();
	}
	public function add_link($data){
		$re = $this->db->insert('zb_ecommerce', $data);
		return $re;
	}
	public function update_link($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_ecommerce', $data);
		return $re;
	}

	public function get_link_list($cat_id){
		$this->db->select("*");
		$this->db->where("status", 0);
		$this->db->where("cat_id", $cat_id);
		$this->db->order_by("level","asc");
		$query = $this->db->get('zb_ecommerce');
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach($result as $v){
				$tmp[$v['id']] = $v;
			}
			$result = $tmp;
		}
		return $result;
	}


}