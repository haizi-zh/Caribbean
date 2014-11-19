<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class delete extends ZB_Controller {
	
	public function delete_ping(){
		//$ping_id = isset($_POST['ping_id'])?$_POST['ping_id']:'';
		$ping_id = $this->input->post('ping_id', true, '');
		#删除点评
		$this->load->model('mo_dianping');
		$re = $this->mo_dianping->delete(array('dianping_id' => $ping_id));
		
		if($re) echo 1;
		else echo 0;
	}
	
	public function delete_comment(){
		//$comment_id = isset($_POST['comment_id'])?$_POST['comment_id']:'';
		$comment_id = $this->input->post('comment_id', true, '');
		#删除评论
		$this->load->model('mo_comment');
		$re = $this->mo_comment->delete($comment_id);
	
		if($re) echo 1;
		else echo 0;
	}
}