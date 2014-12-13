<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');

class adminuser extends ZB_Controller {
	public function add_user(){
		
		$this->load->model('basemodel');
		$this->load->model('mo_adminuser');
		$id = $this->input->post("id", true, 0);
		$username = $this->input->post("username", true, 0);
		$password = $this->input->post("password", true, 0);
		$nikename = $this->input->post("nikename", true, 0);
		$power = $this->input->post("power", true, 0);
		if(!$username || !$password || !$nikename){
			echo json_encode(array('code'=>'201','msg'=>'输入字段缺失'));
			exit;
		}

		$data['username'] = $username;
		$data['password'] = md5($password);
		$data['nikename'] = $nikename;
		$data['power'] = $power;
		$passwd = $this->mo_adminuser->get_passwd($username);

		if ($id) {
			if($passwd && $passwd['id'] == $id){
				$this->basemodel->updates('admin_info', array('id'=>$id), $data);
			}else{
				echo json_encode(array('code'=>'201','msg'=>'用户名重复'));
				exit;
			}
			
		} else { // add
			$passwd = $this->mo_adminuser->get_passwd($username);
			if($passwd){
				echo json_encode(array('code'=>'201','msg'=>'用户名重复'));
				exit;
			}
			$this->basemodel->add('admin_info', $data);
		}
		
		echo json_encode(array('code'=>'200','msg'=>'succ'));

	}
}