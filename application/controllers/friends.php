<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class friends extends ZB_Controller {

	const PAGE_ID = 'friends';

	public function index()
	{
		#header
		//$this->load->view('header',array('pageid'=>self::PAGE_ID));
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;

		#load page
		$uid = $this->input->get('uid',true);
		$type = $this->input->get("type",true,0);
        $uid = intval($uid);
        //$type = intval($type);

		if (!$uid) {
			$uid = $login_uid;
		}

		$this->load->model('mo_social');
		$this->load->model('mo_user');
		$this->load->model('mo_module');
		
		if($type == 'fans'){
			$uids = $this->mo_social->get_fans($uid);
		}elseif($type == 'attentions'){
			$uids = $this->mo_social->get_attentions($uid);
		}
		$user_infos = $this->mo_user->get_middle_userinfos($uids);
		if(!$user_infos){
			//$this->tool->sorry();
		}
		#判断关注关系
		foreach ($user_infos as $key => $value) {

			$relation = $this->mo_social->get_relation($key);
			
			$user_infos[$key]['relation'] = $relation;
			
		}


		$user_info = $this->mo_user->get_middle_userinfos(array($uid));
		$user_info = $user_info[$uid];
		
		//$this->load->view('friends',array('type'=>$type,'user_infos'=>$user_infos,'user_info'=>$user_info));

		#footer
		$jsplugin_list = array();#需要用到的js插件
		//$this->load->view('footer',array('pageid'=>self::PAGE_ID,'jsplugin_list'=>$jsplugin_list));
		
		$data = array();
		$data = array('type'=>$type,'user_infos'=>$user_infos,'user_info'=>$user_info);
		$data['pageid'] = self::PAGE_ID;
		$data['jsplugin_list'] = $jsplugin_list;
		$data['login_uid'] = $login_uid;

		$data['macys_html'] = $this->mo_module->format_macys();

		$this->get_adv_data();
		
		$this->load->web_view('friends', $data);
		
	}
}
