<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	const PAGE_ID = 'logout';

	#后台退出
	public function index()
	{
		$this->session->set_userdata(array('admin_login'=>0));
		header("Location: /admin");
	}
}