<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sorry extends ZB_Controller {

	const PAGE_ID = 'sign';

	public function index()
	{
		$check_mobile = context::get("check_mobile", false);
		if($check_mobile){
			$this->index_h5();
			return;
		}

		#header
		//$this->load->view('header',array('pageid'=>self::PAGE_ID));
		$tab = $this->input->get("tab", true, 1);
		//$this->load->view('help',array('userinfo'=>$userinfo_re));

		#footer
		$jsplugin_list = array('imgClip');#需要用到的js插件
		//$this->load->view('footer',array('pageid'=>self::PAGE_ID,'jsplugin_list'=>$jsplugin_list));
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['body_class'] ="404";
		$data['tab'] = $tab;
		$data['jsplugin_list'] = $jsplugin_list;
		$data['tj_id'] = "sorry";

		$this->load->web_view('sorry', $data);
		
	}
	public function index_h5(){
		$data = array();
		$data['body_class'] = "shop_list";
		$data['page_css'] = array("/css/h5/page/city_list.css");
		$this->load->h5_view("h5/sorry", $data);
	}

}
