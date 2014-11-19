<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class search extends ZB_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
	}
	// zan.com/weixinapi/search/get_by_word?keyword=s
	public function get_by_word(){
		
		$word = $this->input->get("keyword", true, '');
		$list = $this->mo_shop->search_shop($word);
		$data = array();
		if($list){
			$list = array_slice($list, 0, 3);
			foreach($list as $v){
				$item = array();
				$item['id'] = $v['id'];
				$item['name'] = $v['name'];
				$item['pic'] = $v['pic'];
				$item['desc'] = $v['desc'];
				$data[$v['id']] = $item;
			}
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
		}else{
			echo $this->mobile_json_encode(array('code'=>'201','msg'=>'搜索不存在'));
		}
		

	}

}