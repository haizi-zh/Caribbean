<?php

class Mo_content extends CI_Model {

	const MAX_DIANPING_INDEX = 20;
	const STATUS_NORMAL = 0;
	const STATUS_DELETE = 1;
	
	function __construct(){
		parent::__construct();
		$this->load->model("do/do_content");
	}
	public function get_list($type=0){
		$cat_list = $this->do_content->get_list($type);
		return $cat_list;
	}
	public function get_info($id){
		$info = $this->do_content->get_info($id);
		return $info;
	}
	public function add($data){
		$re = $this->do_content->add($data);
		return $re;
	}
	public function update($data, $id){
		$re = $this->do_content->update($data, $id);
		return $re;
	}
	public function del($id){
		$data = array();
		$data['status'] = self::STATUS_DELETE;
		$re = $this->do_content->update($data, $id);
		return $re;
	}

}