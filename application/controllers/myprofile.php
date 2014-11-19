<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myprofile extends ZB_Controller {

	const PAGE_ID = 'profile';

	public function index(){
		$this->load->model('mo_module');
		$this->load->model('mo_user');
		$this->load->model('mo_dianping');
		$this->load->model('mo_social');
		$this->load->model('mo_user');
		$this->load->model('mo_module');

		$data = array();
		#load page
		#判断是用户的feed，还是他人的profile,type为myprofile时显示晒单，type为myfeed时显示关注人的信息
		$type = $this->input->get("type",true,"myprofile");
		$uid = $this->input->get("uid",true);
		$shaidan = $this->input->get("shaidan",true);
		$page = $this->input->get("page",true,1);

		$uid = intval($uid);
		$shaidan = intval($shaidan);
		$page = intval($page);

		$suid = 0;
		if (isset($this->session->userdata['user_info']['uid'])) {
			$suid = $this->session->userdata['user_info']['uid'];
		}
		

		if( isset($this->session->userdata['user_info']['uid']) && $uid == $this->session->userdata['user_info']['uid']){#如果是已登录用户查看自己的feed
			$uid = $this->session->userdata['user_info']['uid'];
			$type = 'myfeed';
		}elseif($uid){#如果是查看别人的profile页
			$type = 'myprofile';
		}else{
			$uid = $this->session->userdata['user_info']['uid'];
			$type= 'myfeed';
		}
		if($shaidan && $shaidan==1) {
			$type = 'myprofile';
		}

		#获取用户信息
		
		$userinfo_re = $this->mo_user->get_middle_userinfos(array($uid));
		if(!$userinfo_re){
			$this->tool->sorry();
		}

		if($type == 'myfeed'){
			#用户的feed
			$dianping_ids = $this->mo_social->get_user_feed($uid);
			#用户feed数
			$total = $this->mo_social->get_user_feed_cnt($uid);
			$page_cnt = ceil($total/10);
		}elseif($type == 'myprofile'){
			#用户的点评
			$dianping_ids = $this->mo_dianping->get_dianpingids_by_uid($uid);

			#用户点评数
			$total = $this->mo_user->get_dianping_cnt_by_uid($uid);
			$page_cnt = ceil($total/10);
		}

		$dianping_infos = $this->mo_dianping->get_dianpinginfo_by_ids($dianping_ids);
		if($dianping_infos){
			foreach ($dianping_infos as $key => $value) {
				if($value['status'] != 0){
					unset($dianping_infos[$key]);
				}
			}
		}
		
		$user_info = isset($userinfo_re[$uid])?$userinfo_re[$uid]:array();
		$data = array();
		$data['dianpings'] = $dianping_infos;
		$data['page'] = $page;
		$data['page_cnt'] = $page_cnt;
		$data['type'] = $type;
		$data['user_info'] = $user_info;
		
		$data['show_shop_title'] = 1;
		$data['login_uid'] = $user_info['uid'];
		$dianping_html = $this->load->view('template/shaidan_card', $data, true);


		$data = array('page'=>$page,'page_cnt'=>$page_cnt,'user_info'=>$user_info,'dianping_html'=>$dianping_html);
		$data['pageid'] = self::PAGE_ID;
		$data['ouid'] = $uid;
		$data['suid'] = $suid;
		$right_user_html = $this->mo_module->right_user_info($suid, $uid);
		$data['right_user_html'] = $right_user_html;

		$data['jsplugin_list'] = array('drag','popup', 'rating', 'richEditor');
		$data['tj_id'] = "profile";

		$data['macys_html'] = $this->mo_module->format_macys( );

		$this->get_adv_data();
		
		$this->load->web_view($type, $data);


	}
}
