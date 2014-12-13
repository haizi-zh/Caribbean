<?php

class Mo_link extends CI_Model {

	const MAX_DIANPING_INDEX = 20;
	const STATUS_NORMAL = 0;
	const STATUS_DELETE = 1;
	
	function __construct(){
		parent::__construct();
		$this->load->model("do/do_link");
	}

	public function get_cat_list(){
		$cat_list = $this->do_link->get_cat_list();
		return $cat_list;
	}
	public function get_cat_info($id){
		$tag_infos = $this->do_link->get_cat_info($id);
		return $tag_infos;
	}
	public function add_cat($data){
		$re = $this->do_link->add_cat($data);
		return $re;
	}
	public function update_cat($data, $id){
		$re = $this->do_link->update_cat($data, $id);
		return $re;
	}
	public function del_cat($id){
		$data = array();
		$data['status'] = self::STATUS_DELETE;
		$re = $this->do_link->update_cat($data, $id);
		return $re;
	}

	public function get_link_list($cat_id){
		$cat_list = $this->do_link->get_link_list($cat_id);
		return $cat_list;
	}
	public function get_link_info($id){
		$tag_infos = $this->do_link->get_link_info($id);
		return $tag_infos;
	}


	public function add_link($data){
		$re = $this->do_link->add_link($data);
		return $re;
	}
	public function update_link($data, $id){
		$re = $this->do_link->update_link($data, $id);
		return $re;
	}
	public function del_link($id){
		$data = array();
		$data['status'] = self::STATUS_DELETE;
		$re = $this->do_link->update_link($data, $id);
		return $re;
	}

}