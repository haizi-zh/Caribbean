<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class article extends ZB_Controller {

	#添加运营内容
	public function add_article(){
		try{
			$data = array();
			$data['title'] = $this->input->post('title', true, '');
			$data['source'] = $this->input->post('source', true, '');
			$data['authorName'] = $this->input->post('authorName', true, '');
            $data['publishTime'] = $this->input->post('publishTime', true, '');
			$data['desc'] = $this->input->post('desc', true, '');
			$data['image'] = $this->input->post('image', true, '');
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

			$this->load->model('do/do_article');
			$re = $this->do_article->add($data);
			
			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	#编辑运营内容
	public function edit_article(){
		try{
			$data = array();
            $data['article_id'] = $this->input->post('id', true, '');
			$data['title'] = $this->input->post('title', true, '');
			$data['source'] = $this->input->post('source', true, '');
			$data['authorName'] = $this->input->post('authorName', true, '');
			$data['desc'] = $this->input->post('desc', true, '');
			$data['image'] = $this->input->post('image', true, '');
			$data['publishTime'] = $this->input->post('publishTime', true, '');
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

            $this->load->model('do/do_article');
			$re = $this->do_article->article_update($data);
			var_dump($re);
			// echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}

?>