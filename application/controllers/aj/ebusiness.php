<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class ebusiness extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model('mo_ebusiness');
	}

	public function add(){

		$this->config->load('errorcode',TRUE);
		try{
			$id = $this->input->post("id", true, "");
			$name =  $this->input->post("name", true, "");
			$logo = $this->input->post("logo", true, 0);
			$description = $this->input->post("description", true, "");
			$web_site = $this->input->post("web_site", true, "");
			$country = $this->input->post("country", true, "");
			$tags = $this->input->post("tags", true, "");
			$pay_type = $this->input->post("pay_type", true, "");
			$type = $this->input->post("type", true, "");

			if($name){
				$add_data['name'] = $name;
				if($logo){
					$add_data['logo'] = $logo;
				}
				$add_data['description'] = $description;
				$add_data['web_site'] = $web_site;
				$add_data['country'] = $country;
				$add_data['tags'] = $tags;
				$add_data['pay_type'] = $pay_type;
				$add_data['type'] = $type;

				if (!$id) {
					$add_data['ctime'] = time();
					$re = $this->mo_ebusiness->add($add_data);
				} else {
					$re = $this->mo_ebusiness->modify($add_data, $id);
				}

				$code = '200';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				return;
			}
		}catch(Exception $e){
			$code = '204';
			echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
		}
	}

	public function delete_ebusiness(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$re = $this->mo_ebusiness->delete_ebusiness(array('id' => $id));

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

	public function recover_ebusiness(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$re = $this->mo_ebusiness->recover_ebusiness(array('id' => $id));

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}
	public function get_brand_countrys(){
		$brand_id = $this->input->get('brand_id', true, 0);
		$re = $this->mo_brand->get_brand_countrys($brand_id);
		echo json_encode($re);
	}

	public function get_anchor_layer(){
		$id = $this->input->get("id", true, '');
		$html = "";
		if($id){
			$info = $this->mo_ebusiness->get_info($id);
			$data['info'] = $info;
			$html = $this->load->view("template/ebusiness_layer", $data, true);
		}
		echo json_encode(array('code'=>'200','msg'=>'succ','data'=>array('html'=>$html)));
		return;

	}


}