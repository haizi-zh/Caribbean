<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends ZB_Controller {

	public function index()
	{
		$source_url = $this->input->get("source_url", true, '/');
		if($source_url == "/fav/"){
			$source_url = "/";
		}
		$this->session->unset_userdata('user_info');
		
		header("Location: {$source_url}");
	}
}