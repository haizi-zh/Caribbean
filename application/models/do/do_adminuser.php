<?php
#品牌操作类
class Do_adminuser extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_list(){
		$query = $this->db->get('admin_info');
		return $query->result_array();
	}
	public function get_passwd($uname){
		$this->db->select("id,power,password");
		$this->db->where("username", $uname);
		$query = $this->db->get("admin_info");
		return $query->row_array();
	}
	public function get_user_info($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("admin_info");
		return $query->row_array();
	}
}