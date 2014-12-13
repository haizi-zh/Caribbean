<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Setting extends ZB_Controller {
		
	#修改用户的昵称或头像
	public function modify_userinfo(){
		$uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
/* 		$userinfo_img = isset($_POST['image'])?$_POST['image']:"";
		$userinfo_uname = isset($_POST['uname'])?$_POST['uname']:""; */
		
		$userinfo_img = $this->input->post('image', true, '');
		$userinfo_uname = $this->input->post('uname', true, '');
		$gender = $this->input->post('gender', true, 2);
		
		if($uid == 0 || ($userinfo_img == "" && $userinfo_uname=="")) {
			echo json_encode(array('code'=>'201','msg'=>$this->config->item('201','errorcode')));
			return false;
		}
		$this->load->model("mo_user");

		$newuser = array();
		if($userinfo_uname!="")  $newuser['uname'] = $userinfo_uname;
		
		$pre_uname = $this->session->userdata['user_info']['uname'];
		if($newuser['uname'] != $pre_uname ){
			$check_uname = $this->mo_user->get_user_info_by_params(array('uname'=>$newuser['uname']));
			if ($check_uname) {
				$code = "201";
				echo json_encode(array('code'=>$code,'msg'=>"昵称已存在,请重新输入"));
				exit();
			}
		}


		if($userinfo_img!="")  $newuser['image'] = $userinfo_img;
		$newuser['uid'] = $uid;
		$newuser['gender'] = $gender;
		
		$ret = $this->mo_user->modify_userinfo($newuser);
		if($ret) {
			//成功后重写下session里的昵称和头像
			$session_user = $this->session->userdata("user_info");
			if(is_array($session_user)) {
				//拿到图片用的尺寸
				$userinfo_img = $this->tool->clean_file_version($userinfo_img,"!settingimage");
				$session_user['uname'] = $userinfo_uname;
				$session_user['image'] = $userinfo_img;
				$this->session->set_userdata("user_info",$session_user);
			}
			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}
		else {
			echo json_encode(array('code'=>'201','msg'=>$this->config->item('201','errorcode')));
		}
	}

	public function add_click(){
		$this->load->model('do/do_user');
		$add_data = array();
		$ctime = time();
		$add_data['ctime'] = $ctime;
		$add_data['day'] = date("Y-m-d", $ctime);
		$add_data['ctime_format'] = date("Y-m-d H:i:s", $ctime);
		$ip = context::get_client_ip();
		$uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		$add_data['uid'] = $uid;
		if(!$ip){
			$ip="";
		}
		$add_data['ip'] = $ip;

		$this->do_user->add_zb_click($add_data);
	}
}