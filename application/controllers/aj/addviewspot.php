<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class addviewspot extends ZB_Controller {
	
	#添加景点
	public function add_viewspot(){
		try{
			$data = array();
			$data['name'] = $this->input->post('name', true, '');
				
			$this->load->model('do/do_viewspot');
			$re = $this->do_viewspot->add($data);
			
			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
}

?>