<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class brandtag extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('do/do_brandtag');

	}
	public function delete_brandtag_foradmin(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$re = $this->do_brandtag->update_tag(array('status' => 1), $id);

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

	public function recover_brandtag_foradmin(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$re = $this->do_brandtag->update_tag(array('status' => 0), $id);

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

}