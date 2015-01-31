<?php

class Do_adminuser extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_list(){
		$query = $this->db->get('user');
		return $query->result_array();
	}
	public function get_passwd($uname){
		$this->db->select("id,power,password");
		$this->db->where("username", $uname);
		$query = $this->db->get("user");
		return $query->row_array();
	}
	public function get_user_info($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("user");
		return $query->row_array();
	}
}

// CMS建表sql
// create table user
// (
//     id INT(20) NOT NULL AUTO_INCREMENT,
//     username char(30) not null,
//     password char(100) not null,
//     power INT(20) not null,
//     info text(5000) not null,
//     PRIMARY KEY (id)
// )default charset 'utf8';
// INSERT INTO `user` (`id`, `username`, `password`, `power`, `info`) VALUES (NULL, 'keven', MD5('keven'), '0', '');
// INSERT INTO `user` (`id`, `username`, `password`, `power`, `info`) VALUES (NULL, 'cc', MD5('cc'), '0', '');
