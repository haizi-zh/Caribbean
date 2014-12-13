<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class feedback extends ZB_Controller {
		
	public function add(){
		$this->config->load('errorcode',TRUE);
		
		try{
			#获取参数
			$content = $this->input->post('content', TRUE);
			
			if(!$content){
				$code = '201';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>''));
				exit;
			}
			
			#todo
			
			$code = 200;
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>array()));
			
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}
