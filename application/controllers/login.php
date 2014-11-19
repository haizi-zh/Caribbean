<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends ZB_Controller {

	const PAGE_ID = 'login';

	public function index()
	{
		#header
		//$this->load->view('header',array('pageid'=>self::PAGE_ID));
		
		#load page
		//$this->load->view('login');
		
		#footer
		//$this->load->view('footer',array('pageid'=>self::PAGE_ID));
	
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$this->load->web_view('login', $data);
	}
}