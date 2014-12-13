<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	const PAGE_ID = 'login';

	public function index()
	{

		$data=array();

		$data['pageid'] = self::PAGE_ID;
		#load page
		$this->load->admin_view('admin/login', $data);		
			

	}
}