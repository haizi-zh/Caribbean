<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class addviewspot extends ZB_Controller {
	
	#添加景点
	public function add_viewspot(){
		try{
			$data = array();
			$data['name'] = $this->input->post('name', true, '');
			$data['english_name'] = $this->input->post('english_name', true, '');
			$data['desc'] = $this->input->post('desc', true, '');

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
				
			$this->load->model('do/do_viewspot');
			$re = $this->do_viewspot->add($data);
			
			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	#编辑景点
	public function edit_viewspot(){
		try{
			$data = array();
			$data['shop_id'] = $this->input->post('id', true, '');
			$data['name'] = $this->input->post('name', true, '');
			$data['english_name'] = $this->input->post('english_name', true, '');
			$data['desc'] = $this->input->post('desc', true, '');
			
			$this->load->model("do/do_viewspot");
            $re = $this->do_viewspot->update($data);
	
			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}

?>