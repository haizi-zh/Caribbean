<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class user extends ZB_Controller {

	// zan.com/mobile/user/add_user/?email=1@126.com&uname=123&passwd=232
	public function add_user(){
		$this->config->load('errorcode',TRUE);
		try{
			$this->load->model('mo_user');
			$email = $this->input->post('email', true, '');
			$uname = $this->input->post('uname', true, '');
			$passwd = $this->input->post('passwd', true, '');

			//$email = $this->input->get('email', true, '');
			//$uname = $this->input->get('uname', true, '');
			//$passwd = $this->input->get('passwd', true, '');
			
			if (!$uname){
				$uname = '';
				$code = "201";
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>"请输入用户名"));
				exit();
			}
			
			if (!$passwd){
				$passwd = '';
				$code = "201";
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>"请输入密码"));
				exit();
			}
			if (!$email){
				$email = '';
				$code = "201";
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>"请输入邮箱"));
				exit();
			}


			$check_uname = $this->mo_user->get_user_info_by_params(array('uname'=>$uname));
			$check_email = $this->mo_user->get_user_info_by_params(array('email'=>$email));
			if ($check_uname) {
				$code = "201";
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>"昵称重复"));
				exit();
			}
			if ($check_email) {
				$code = "201";
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>"此邮箱已经注册过了"));
				exit();
			}

			#拼装
			$userinfo = array(
					'email' => $email,
					'uname'=>$uname,
					'pwd'=> md5($passwd),
					'source' => 'zanbai',
					'image' => 'http://zanbai.b0.upaiyun.com/2013/07/9b797ef43bbb1a34.gif'				
			);
			#入库
			
			$uid = $this->mo_user->add_user($userinfo);
			$user_info = $this->mo_user->get_simple_userinfos(array($uid));
			
			#设置session
			$this->load->library('session');
			$this->session->set_userdata(array('user_info'=>$user_info[$uid]));
			
			#返回
			$code = '200';
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	# http://zan.com/mobile/user/login
	# http://zanbai.com/mobile/user/login
	public function login(){
		$this->config->load('errorcode',TRUE);
		try{
			$email = $this->input->post('email', true, '');
			$passwd = $this->input->post('passwd', true, '');

			//$email = "habaishi@126.com";
			//$passwd = "chunjiang";
			if (!$passwd){
				$passwd = '';
			}
			#入库
			$this->load->model('mo_user');
			$user_info = $this->mo_user->login($email,md5($passwd));
			
			if(!$user_info){
				$code = '203';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit;
			}
		
			#设置session
			$this->load->library('session');
			$this->session->set_userdata(array('user_info'=>$user_info));
			$re = $this->session->all_userdata();
			
			#返回
			$code = '200';
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'), 'data'=>$re['user_info']));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	# http://zan.com/mobile/user/check
	# http://zanbai.com/mobile/user/check
	public function check(){
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		echo $this->mobile_json_encode(array('code'=>200,'msg'=>'succ', 'data'=>$uid));
	}

	public function register(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
/* 			$email = isset($_POST['email'])?$_POST['email']:'';
			$uname = isset($_POST['uname'])&&!empty($_POST['uname'])?$_POST['uname']:'';
			$passwd = isset($_POST['passwd'])&&!empty($_POST['passwd'])?$_POST['passwd']:''; */
			$this->load->model('mo_user');

			$email = $this->input->post('email', true, '');
			$uname = $this->input->post('uname', true, '');
			$image = $this->input->post('image', true, '');
			if (!$uname){
				$uname = '';
				$code = "201";
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>"请输入用户名"));
				exit();
			}
			$passwd = $this->input->post('passwd', true, '');
			if (!$passwd){
				$passwd = '';
				$code = "201";
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>"请输入密码"));
				exit();
			}
			if (!$email){
				$email = '';
				$code = "201";
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>"请输入邮箱"));
				exit();
			}


			$check_uname = $this->mo_user->get_user_info_by_params(array('uname'=>$uname));
			$check_email = $this->mo_user->get_user_info_by_params(array('email'=>$email));
			if ($check_uname) {
				$code = "201";
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>"昵称重复"));
				exit();
			}
			if ($check_email) {
				$code = "201";
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>"此邮箱已经注册过了"));
				exit();
			}

			#拼装
			$userinfo = array(
					'email' => $email,
					'uname'=>$uname,
					'image'=>$image,
					'pwd'=> md5($passwd),
					'source' => 'zanbai',
					'image' => 'http://zanbai.b0.upaiyun.com/2013/07/9b797ef43bbb1a34.gif'				
			);
			#入库
			
			$uid = $this->mo_user->add_user($userinfo);
			$user_info = $this->mo_user->get_simple_userinfos(array($uid));
			
			#设置session
			$this->load->library('session');
			$this->session->set_userdata(array('user_info'=>$user_info[$uid]));
			
			#返回
			$code = '200';
			$data['uid'] = $uid;
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'), 'data'=>$data));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	public function get_user_info(){
		try{
			#获取参数
			$this->config->load('errorcode',TRUE);
			$uid = $this->input->get('uid', TRUE);
			if(!$uid){
				$code = '201';
				throw new Exception($this->config->item($code,'errorcode'), $code);
			}

			#获取品牌
			$this->load->model('mo_user');
			$user_info = $this->mo_user->get_simple_userinfos(array($uid));
			
			#去掉key
			$users = array();
			foreach($user_info as $user){
				$users[] = $user;
			}
			
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$users));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	public function get_userinfo(){
		try{
			$this->load->model("mo_social");
			$user_info=$this->session->userdata('user_info');
			$uid = 0;
			if ($user_info && isset($user_info['uid'])) {
				$uid = $user_info['uid'];
			}

			#获取参数
			$this->config->load('errorcode',TRUE);
			$uids = $this->input->get('uids', TRUE);
			if(!$uids){
				$code = '201';
				throw new Exception($this->config->item($code,'errorcode'), $code);
			}
			$this->load->model('mo_user');
			$uids_array = explode(",", $uids);
			$user_infos = $this->mo_user->get_simple_userinfos( $uids_array );
			$attentions = array();
			if ($uid) {
				$attentions = $this->mo_social->check_attention_for_uids($uid, $uids_array);
			}
			#去掉key
			$users = array();
			foreach($user_infos as $user){
				$is_attention = 0;
				if ($attentions && isset($attentions[$user['uid']])) {
					$is_attention = 1;
				}
				$user_info = array();
				$user_info['uid'] = $user['uid'];
				$user_info['uname'] = $user['uname'];
				$user_info['image'] = $user['image'];
				$user_info['is_attention'] = $is_attention;

				$users[] = $user_info;
			}

			echo $this->mobile_json_encode( array('code'=>'200','msg'=>'succ','data'=>$users, 'list'=>array()) );
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	# http://zanbai.com/mobile/user/feed_back
	# http://zan.com/mobile/user/feed_back?content=123
	public function feed_back(){
		try{
			$this->load->model("mo_feedback");
			$user_info=$this->session->userdata('user_info');
			$uid = 0;
			if ($user_info && isset($user_info['uid'])) {
				$uid = $user_info['uid'];
			}
			#获取参数
			$this->config->load('errorcode',TRUE);
			$content = $this->input->post('body', TRUE, "");

			$now = time();
			$data['uid'] = $uid;
			$data['content'] = $content;
			$data['ctime'] = $now;
			$data['type'] = 4;
			$data['ip'] = context::get_client_ip(true);
			$data['email'] = '';
			$re = $this->mo_feedback->add( $data );
			echo $this->mobile_json_encode( array('code'=>'200','msg'=>'succ','data'=>$users, 'list'=>array()) );
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}