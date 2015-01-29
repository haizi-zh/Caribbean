<?php

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

// CMS建表sql
// create table admin_info
// (
//     id INT(20) NOT NULL AUTO_INCREMENT,
//     username char(30) not null,
//     password char(100) not null,
//     power INT(20) not null,
//     info text(5000) not null,
//     PRIMARY KEY (id)
// );