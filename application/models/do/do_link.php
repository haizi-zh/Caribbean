<?php

class Do_link extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_cat_info($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("zb_linkcat");
		return $query->row_array();
	}
	public function add_cat($data){
		$re = $this->db->insert('zb_linkcat', $data);
		return $re;
	}
	public function update_cat($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_linkcat', $data);
		return $re;
	}
	public function get_cat_list(){
		$this->db->where("status", 0);
		$this->db->order_by("level","asc");
		$query = $this->db->get('zb_linkcat');
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
		$query = $this->db->get("zb_link");
		return $query->row_array();
	}
	public function add_link($data){
		$re = $this->db->insert('zb_link', $data);
		return $re;
	}
	public function update_link($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_link', $data);
		return $re;
	}

	public function get_link_list($cat_id){
		$this->db->select("*");
		$this->db->where("status", 0);
		$this->db->where("cat_id", $cat_id);
		$this->db->order_by("level","asc");
		$query = $this->db->get('zb_link');
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