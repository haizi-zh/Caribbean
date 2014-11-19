<?php
class Mo_cdn extends ZB_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_cdn');
	}
	public function add($data){
		$re = $this->do_cdn->add($data);
		return $re;
	}
	public function update($data, $id){
		$re = $this->do_cdn->update($data, $id);
		return $re;
	}
	public function get_info_by_filenamemd5($file_name_md5){
		$re = $this->do_cdn->get_info_by_filenamemd5($file_name_md5);
		return $re;
	}
}