<?php
class Mo_weixinevent extends ZB_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_weixinevent');
	}
	public function add($data){
		$re = $this->do_weixinevent->add($data);
		return $re;
	}
	public function update($data, $id){
		$re = $this->do_weixinevent->update($data, $id);
		return $re;
	}
	public function get_all(){
		$re = $this->do_weixinevent->get_all();
		return $re;
	}
}