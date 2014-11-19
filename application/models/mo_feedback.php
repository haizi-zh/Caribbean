<?php
class Mo_feedback extends CI_Model {

	
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_feedback');
	}

	public function add($data){
		return $this->do_feedback->add($data);
	}

	public  function get_feedback_list($page=1, $pagesize = 10){
		$list = $this->do_feedback->get_feedback_list($page, $pagesize);
		return $list;
	}
	public  function get_feedback_count(){
		$list = $this->do_feedback->get_feedback_count();
		return $list;
	}

}