<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Social extends ZB_Controller {

	public function attention(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
			$user_info=$this->session->userdata('user_info');
			$uid = $user_info['uid'];
			//$to_uid = isset($_POST['to_uid'])?$_POST['to_uid']:0;

			$to_uid = $this->input->post('to_uid', true, 0);
			
			$this->config->load('env',TRUE);
			
			if(!$user_info){
				$code = '202';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			
			$this->load->model('mo_social');
			
			$re = $this->mo_social->add_user_attention($uid,$to_uid);
			#更新关注的人feed
			$this->mo_social->update_user_feed($uid, $to_uid);

			#返回
			$code = '200';
			$this->config->load('errorcode',TRUE);
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>array()));
		
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}


	public function attention_del(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
			$user_info=$this->session->userdata('user_info');
			$uid = $user_info['uid'];
			//$to_uid = isset($_POST['to_uid'])?$_POST['to_uid']:0;

			$to_uid = $this->input->post('to_uid', true, 0);
			
			$this->config->load('env',TRUE);
			
			if(!$user_info){
				$code = '202';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			
			$this->load->model('mo_social');
			
			$re = $this->mo_social->del_user_attention($uid,$to_uid);
			#更新关注的人feed
			$this->mo_social->update_user_feed($uid, $to_uid);

			#返回
			$code = '200';
			$this->config->load('errorcode',TRUE);
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>array()));
		
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

}