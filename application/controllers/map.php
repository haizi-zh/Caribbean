<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends ZB_Controller {

	const PAGE_ID = 'map';

	public function index()
	{
		#header
		//$this->load->view('header',array('pageid'=>self::PAGE_ID));
		#load page
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		
		$jsplugin_list = array();#需要用到的js插件
		$data['pageid'] = self::PAGE_ID;
		$data['jsplugin_list'] = $jsplugin_list;
		$this->load->web_view('map', $data,false,true,false);
	}
}
