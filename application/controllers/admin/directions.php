<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class directions extends ZB_Controller {
		
	const PAGE_ID = 'directions';
	const PAGESIZE = 50;
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_user');
		$this->load->model('mo_shop');
		$this->load->model('do/do_dianping');
		$this->load->model('mo_dianping');
		$this->load->model('mo_directions');
	}
	// zan.com/admin/directions/d_list/?shop_id=1
	//交通方式和简介
	public function d_list(){
		$type_lists = array('1'=>'巴士','2'=>'火车','3'=>'地铁','4'=>'电车','5'=>'班车/购物快车','6'=>'观光旅游巴士(观光车)','7'=>'船');
		$status_list = array("0"=>"正常","1"=>"删除");
		$data = array();
		$shop_id = $this->input->get("shop_id", true, 0);
		$status = $this->input->get("status", true, 0);
		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);

		$list = $this->mo_directions->get_directions_list($shop_id, $status);
		$directions_ids = array();
		if($list){
			$tmp = array();
			foreach($list as $v){
				$directions_ids[$v['id']] = $v['id'];
				$tmp[$v['type']] = $v;
			}
			$list = $tmp;
		}

		$data['list'] = $list;
		$data['type_lists'] = $type_lists;
		$data['status_list'] = $status_list;
		$line_list = array();
		//获取 line
		if($directions_ids){
			$line_list = $this->mo_directions->get_directions_line_list($directions_ids, $status);
			if($line_list){
				$tmp = array();
				foreach($line_list as $v){
					$tmp[$v['directions_id']][$v['id']] = $v; 
				}
				$line_list = $tmp;
			}
		}

		$data['shop_id'] = $shop_id;
		$data['line_list'] = $line_list;
		$data['pageid'] = self::PAGE_ID;
		$data['shop_info'] = $shop_info;
		$this->load->admin_view('admin/directions/list', $data);
	}

	//线路信息
	public function add_line(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$id = $this->input->get("id", true, 0);
		$directions_id = $this->input->get("directions_id", true, 0);
		$shop_id = $this->input->get("shop_id", true, 0);
		$info = $this->mo_directions->get_line_info($id);
		if($info){
			$directions_id = $info['directions_id'];
		}
		$data['directions_id'] = $directions_id;
		$data['shop_id'] = $shop_id;

		$data['info'] = $info;
		$data['id'] = $id;

		$this->load->admin_view('admin/directions/add_line', $data);
	}

	public function add_type(){
		$type_lists = array('1'=>'巴士','2'=>'火车','3'=>'地铁','4'=>'电车','5'=>'班车/购物快车','6'=>'观光旅游巴士(观光车)','7'=>'船');
		// 介绍，时刻表，票价，乘车贴士，预定。咨询电话
		$item_type = array(1=>'介绍',2=>'时刻表',3=>'票价',4=>'乘车贴士',5=>'预定',6=>'咨询电话',);
		$data = array();
		$data['item_type'] = $item_type;
		$data['pageid'] = self::PAGE_ID;
		$shop_id = $this->input->get("shop_id", true, 0);
		$directions_id = $this->input->get("id", true, 0);
		$type = $this->input->get("type", true, 0);

		$directions_info = array();
		$line_items = array();
		if($directions_id){
			$directions_info = $this->mo_directions->get_info($directions_id);
			$line_items = $this->mo_directions->get_line_infos($directions_id);
		}else{
			$line_items = array(array(),array());
		}

		$data['directions_info'] = $directions_info;
		$data['line_items'] = $line_items;
		$data['type'] = $type;
		$data['shop_id'] = $shop_id;
		$data['directions_info'] = $directions_info;
		$data['id'] = $directions_id;
		$data['type_lists'] = $type_lists;
		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);

		$data['shop_info'] = $shop_info;

		$this->load->admin_view('admin/directions/add_type', $data);
	}
}