<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class addviewspot extends ZB_Controller {
		
	const PAGE_ID = 'addviewspot';
	const PAGESIZE = 100;
	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_viewspot");
	}

	public function index(){
		#load page
		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据
		
		$this->load->model('mo_geography');
		$countrys = $this->mo_geography->get_all_countrys();

		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['countrys'] = $countrys;
		$data['policy'] = $security['policy'];
		$data['signature'] = $security['signature'];
		$this->load->admin_view('admin/addviewspot', $data);
	}


	// 
	public function repair_score(){
		$shop_id = $this->input->get("shop_id", true, "");
		$repair_all = $this->input->get("repair_all", true, '');
		$this->load->model("mo_shop");
		$this->load->model("mo_dianping");
		$content = "";
		if($shop_id){
			$re = $this->mo_dianping->repair_score($shop_id);
			if($re){
				$content = "操作成功";
			}else{
				$content = "请稍后再试";
			}
		}else{
			$shops = $this->mo_shop->get_all_shop(true);
			foreach ($shops as $key => $value) {
				if($value['status'] != 0){
					continue;
				}
				$id = $value['id'];
			 	$re = $this->mo_dianping->repair_score($id);
			 }
			 $content = "操作成功";
		}
		#load page
		$data = array();
		$data['content'] = $content;
		$data['shop_id'] = $shop_id;
		$data['pageid'] = self::PAGE_ID;

		$this->load->admin_view('admin/addshop_repair_score', $data);
		

	}

}