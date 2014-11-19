<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seting extends ZB_Controller {

	const PAGE_ID = 'Seting';

	public function index()
	{
		#header
		$this->load->view('header',array('pageid'=>self::PAGE_ID));
		/* $params = $this->input->get();
		$dianping_id = isset($params['id'])?$params['id']:0;
		$page = isset($params['page'])?$params['page']:1;
		$this->load->model('mo_dianping');
		$dianpinginfo_re = $this->mo_dianping->get_dianpinginfo_by_ids(array($dianping_id)); */
		#用户信息
		$uid = $this->session->userdata['user_info']['uid'];
		$this->load->model('mo_user');
		$userinfo_re = $this->mo_user->get_middle_userinfos(array($uid));
		
		$this->load->view('seting');

#footer
		$jsplugin_list = array();#需要用到的js插件
		$this->load->view('footer',array('pageid'=>self::PAGE_ID,'jsplugin_list'=>$jsplugin_list));
	}
}
