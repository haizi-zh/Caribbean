<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends ZB_Controller {

	const PAGE_ID = 'help';

	public function index()
	{
		$this->load->model('mo_brand');
 		$re = $this->mo_brand->get_hot_brand_by_city_id(1);
 		
		#header
		//$this->load->view('header',array('pageid'=>self::PAGE_ID));
		$tab = $this->input->get("tab", true, 1);
        $tab = intval($tab);

		#用户信息
        $uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
	    $userinfo_re = array();
		if(!is_null($uid) && $uid != 0) {
			$this->load->model('mo_user');
			$userinfo_re = $this->mo_user->get_middle_userinfos(array($uid));
			
			if(isset($userinfo_re[$uid])) {
				$userinfo_re = $userinfo_re[$uid];
			}
			else {
				$userinfo_re = array();
			}
		}
	   
		//$this->load->view('help',array('userinfo'=>$userinfo_re));

		#footer
		$jsplugin_list = array('imgClip');#需要用到的js插件
		//$this->load->view('footer',array('pageid'=>self::PAGE_ID,'jsplugin_list'=>$jsplugin_list));
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['userinfo'] = $userinfo_re;
		$data['tab'] = $tab;
		$data['jsplugin_list'] = $jsplugin_list;
		$this->get_adv_data();
		
		$this->load->web_view('help', $data);
		
	}
}
