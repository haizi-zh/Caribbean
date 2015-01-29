<?php

class Mo_adminuser extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->model('do/do_adminuser');
	}
	public function get_list(){
		
		$list = $this->do_adminuser->get_list();
		return $list;
	}
	public function get_passwd($uname){
		$list = $this->do_adminuser->get_passwd($uname);
		return $list;
	}
	public function get_user_info($id){
		$list = $this->do_adminuser->get_user_info($id);
		return $list;
	}

}