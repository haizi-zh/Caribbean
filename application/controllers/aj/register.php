<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Register extends ZB_Controller {

	#增加注册用户
	#插入正确返回 1
	public function adduser()
	{
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
/* 			$email = isset($_POST['email'])?$_POST['email']:'';
			$uname = isset($_POST['uname'])&&!empty($_POST['uname'])?$_POST['uname']:'';
			$passwd = isset($_POST['passwd'])&&!empty($_POST['passwd'])?$_POST['passwd']:''; */
			$this->load->model('mo_user');

			$email = $this->input->post('email', true, '');
			$uname = $this->input->post('uname', true, '');
			if (!$uname){
				$uname = '';
				$code = "201";
				echo json_encode(array('code'=>$code,'msg'=>"请输入用户名"));
				exit();
			}
			$passwd = $this->input->post('passwd', true, '');
			if (!$passwd){
				$passwd = '';
				$code = "201";
				echo json_encode(array('code'=>$code,'msg'=>"请输入密码"));
				exit();
			}
			if (!$email){
				$email = '';
				$code = "201";
				echo json_encode(array('code'=>$code,'msg'=>"请输入邮箱"));
				exit();
			}


			$check_uname = $this->mo_user->get_user_info_by_params(array('uname'=>$uname));
			$check_email = $this->mo_user->get_user_info_by_params(array('email'=>$email));
			if ($check_uname) {
				$code = "201";
				echo json_encode(array('code'=>$code,'msg'=>"昵称重复"));
				exit();
			}
			if ($check_email) {
				$code = "201";
				echo json_encode(array('code'=>$code,'msg'=>"此邮箱已经注册过了"));
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
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	public function login()
	{
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
/* 			$email = isset($_POST['email'])?$_POST['email']:'';
			$passwd = isset($_POST['passwd'])&&!empty($_POST['passwd'])?$_POST['passwd']:''; */
			
			$email = $this->input->post('email', true, '');
			$passwd = $this->input->post('passwd', true, '');
			if (!$passwd){
				$passwd = '';
			}
			#入库
			$this->load->model('mo_user');
			$user_info = $this->mo_user->login($email,md5($passwd));
			
			if(!$user_info){
				$code = '203';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit;
			}
		
			#设置session
			$this->load->library('session');
			$this->session->set_userdata(array('user_info'=>$user_info));
		
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}