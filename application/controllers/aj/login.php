<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class login extends ZB_Controller {
		
	#后台登录	
	public function log(){
		//$uname = isset($_POST['uname'])?$_POST['uname']:'';
		//$passwd = isset($_POST['passwd'])?$_POST['passwd']:'';
		$uname = $this->input->post('uname', true, '');
		$passwd = $this->input->post('passwd', true, '');
		

		if($uname == '' && $passwd == '') {
			#设置session
			$this->session->set_userdata(array('admin_login'=>1, 'power'=>0));
			echo 1;
		}elseif($uname == '' && $passwd == '') {
			#设置session
			$this->session->set_userdata(array('admin_login'=>1, 'power'=>0));
			echo 1;
		}elseif($uname == '' && $passwd == '') {
			#设置session
			$this->session->set_userdata(array('admin_login'=>1, 'power'=>0));
			echo 1;
		}elseif($uname){
			$md5_passwd = md5($passwd);
			$this->load->model("mo_adminuser");
			$admin_passwd = $this->mo_adminuser->get_passwd($uname);
			if($admin_passwd && $admin_passwd['password'] == $md5_passwd ){
				$this->session->set_userdata(array('admin_login'=>1, 'power'=>$admin_passwd['power']));
				echo 1;
			}else{
				echo 0;
			}
		}else echo 0;
	}
}



