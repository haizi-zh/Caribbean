<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class addoperation extends ZB_Controller {

	#添加运营内容
	public function add_operation(){
		try{
			$data = array();

			$data['title'] = $this->input->post('title', true, '');
			$data['cover'] = $this->input->post('cover', true, '');
			$data['link'] = $this->input->post('link', true, '');
            $data['content'] = $this->input->post('content', true, '');

			if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}
			if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}
			if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}
				
			$this->load->model('do/do_operation');
			$re = $this->do_operation->add($data);
			
			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	#编辑运营内容
	public function edit_operation(){
		try{

			$data = array();
            $data['operation_id'] = $this->input->post('id', true, '');
			$data['title'] = $this->input->post('title', true, '');
			$data['cover'] = $this->input->post('cover', true, '');
			$data['link'] = $this->input->post('link', true, '');
			$data['content'] = $this->input->post('content', true, '');


			if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}
			if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}
			if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}
            

            $this->load->model('do/do_operation');
			$re = $this->do_operation->operation_update($data);


			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}

?>