<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class links extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_link');
	}
	public function del_cat(){
		$this->config->load('errorcode',TRUE);
		$id = $this->input->post("id", true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}

		$re = $this->mo_link->del_cat($id);
		if($re){
			$code = 200;
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
		}else{
			$code = '204';
			echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
		}
	}
	public function del_link(){
		$this->config->load('errorcode',TRUE);
		$id = $this->input->post("id", true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}

		$re = $this->mo_link->del_link($id);
		if($re){
			$code = 200;
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
		}else{
			$code = '204';
			echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
		}
	}
}