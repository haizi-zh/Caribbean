<?php
class Mo_ebusiness extends CI_Model {

	
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_ebusiness');
	}

	public function add($data){
		return $this->do_ebusiness->add($data);
	}

	public function modify( $data, $id){
		return $this->do_ebusiness->modify($data, $id);
	}


	public function get_list($status=0){
		return $this->do_ebusiness->get_list();
	}
	public function get_list_count($status=0){
		return $this->do_ebusiness->get_list_count();
	}	

	public function get_info($id){
		return $this->do_ebusiness->get_info($id);
	}

	public function delete_ebusiness($data){
		$id = $data['id'];
		return $this->modify(array('status'=>1),$id);
	}

	public function recover_ebusiness($data){
		$id = isset($data['id'])?$data['id']:0;
		return $this->modify(array('status'=>0),$id);
	}

}