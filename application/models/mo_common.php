<?php
#评论操作类
class Mo_common extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	public function get_ios_contact(){

		return "";
		$data = array();
		$contact_html = $this->load->view('modules/ios_contact_module', $data, true);

		return $contact_html;
	}

}