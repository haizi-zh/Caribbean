<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends ZB_Controller {

	const PAGE_ID = 'setting';

	public function index()
	{
		
		#用户信息
        $uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		if(is_null($uid) ||$uid == 0) {
			header("Location:http://zanbai.com");
			return false;
			//是否需要跳转到某一页？
		}
	    $this->load->model('mo_user');
		$userinfo_re = $this->mo_user->get_middle_userinfos(array($uid));

		if(isset($userinfo_re[$uid])) {
			$userinfo_re = $userinfo_re[$uid];
		}
		else {
			$userinfo_re = array();
		}

		#footer
		$jsplugin_list = array('imgClip');#需要用到的js插件
		//$this->load->view('footer',array('pageid'=>self::PAGE_ID,'jsplugin_list'=>$jsplugin_list));
		
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['userinfo'] = $userinfo_re;
		$data['jsplugin_list'] = $jsplugin_list;
		$this->load->web_view('setting', $data);
		
	}
}
