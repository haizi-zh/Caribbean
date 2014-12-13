<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class feedback extends ZB_Controller {

	const PAGE_ID = 'feedback';

	public function index()
	{
		//$this->load->view('header',array('pageid'=>self::PAGE_ID));
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;

		#load page
		$uid = $this->input->get('uid',true);
		$type = $this->input->get("type",true,0);
        $uid = intval($uid);
        $type = intval($type);


		if (!$uid) {
			$uid = $login_uid;
		}
		$user_info = array();
		$this->load->model('mo_user');
		if ($uid) {
			$user_info = $this->mo_user->get_middle_userinfos(array($uid));
			$user_info = $user_info[$uid];
		}


		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['userinfo'] = $user_info;
		$data['page_css'][] = "newlayer.css" ;
		$data['page_css'][] = "ZB_feedback.css" ;
		$this->load->web_view('feedback', $data);
	}
}