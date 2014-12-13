<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class city extends ZB_Controller {
		
	const PAGE_ID = 'city';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_geography");
		$this->load->model("mo_count");
		$this->load->model("mo_dianping");
		$this->load->model("mo_shop");
		$this->load->model("mo_baidu");


	}
	// type: 2city,3shop,6dianping,10discount,9tips,26shop_download,18coupon_download,

	public function index(){
		$data = array();
		$areas = $this->mo_geography->get_all_areas();
		$countrys = $this->mo_geography->get_all_countrys();
		$citys = $this->mo_geography->get_all_citys();
		
		$data['areas'] = $areas;
		$data['countrys'] = $countrys;
		$data['citys'] = $citys;
		$data['pageid'] = "city";
		$this->load->admin_view('admin/city/index', $data);
	}

	public function city_list(){
		$stime = $this->input->get("stime", true, "20140101");
		$etime = $this->input->get("etime", true, date("y-m-d", strtotime("tomorrow")) );
		$stime = strtotime($stime);
		$etime = strtotime($etime);
		$order = $this->input->get("order",true, 1);

		$data = array();
		$areas = $this->mo_geography->get_all_areas();
		$countrys = $this->mo_geography->get_all_countrys();
		$citys = $this->mo_geography->get_all_citys();
		$city_ids = array_keys($citys);
		$city_count = $this->mo_count->get_count_by_sids(2, $city_ids, $stime, $etime);
		$n = $c = array();
		$i = 0;
		foreach($citys as $v){
			$cnt = 0;
			if(isset($city_count[$v['id']])){
				$cnt = $city_count[$v['id']];
			}
			$n[] = $v['name'];
			$c[] = intval($cnt);
		}
		$n_json = json_encode($n);
		$c_json = json_encode($c);
		$data['n_json'] = $n_json;
		$data['c_json'] = $c_json;

		$old_citys = $citys;
		if($order==1){
		}elseif ($order==2) {
			arsort($city_count, true);
			$tmp=array();
			foreach($city_count as $k=>$v){
				$tmp[$k] = $citys[$k];
			}
			$citys = $tmp;

		}elseif ($order==3) {
			asort($city_count, true);
			$tmp=array();
			foreach($city_count as $k=>$v){
				$tmp[$k] = $citys[$k];
			}
			$citys = $tmp;
		}

		$data['order'] = $order;
		$data['stime'] = date("Y-m-d", $stime);
		$data['etime'] = date("Y-m-d", $etime);

		$data['type'] = 2;
		$data['city_count'] = $city_count;
		$data['areas'] = $areas;
		$data['countrys'] = $countrys;
		$data['citys'] = $citys;
		$data['pageid'] = "city";
		$this->load->admin_view('admin/city/city', $data);
	}

	public function dianping(){
		$stime = $this->input->get("stime", true, "20140101");
		$etime = $this->input->get("etime", true, date("y-m-d", strtotime("tomorrow")) );
		$stime = strtotime($stime);
		$etime = strtotime($etime);
		$order = $this->input->get("order",true, 1);

		$data = array();
		$dianpings = $this->mo_dianping->get_all_dianpings_info();
		$shops = $this->mo_shop->get_all_shop(true);
		$shops = tool::format_array_by_key($shops, "id");
		
		$dianping_ids = array_keys($dianpings);
		$count = $this->mo_count->get_count_by_sids(6, $dianping_ids, $stime, $etime);

		arsort($count, true);

		$n = $c = array();
		$i = 0;
		foreach($count as $k => $v){
			$i++;
			if($i > 200){
				break;
			}
			$cnt = 0;
			if(isset($count[$k])){
				$cnt = $count[$k];
			}
			$n[] = $dianpings[$k]['id'];
			$c[] = intval($cnt);
		}
		$n_json = json_encode($n);
		$c_json = json_encode($c);
		$data['n_json'] = $n_json;
		$data['c_json'] = $c_json;

		if($order==1){
		}elseif ($order==2) {
			arsort($count, true);
			$tmp=array();
			foreach($count as $k=>$v){
				$tmp[$k] = $dianpings[$k];
			}
			$dianpings = $tmp;

		}elseif ($order==3) {
			asort($count, true);
			$tmp=array();
			foreach($count as $k=>$v){
				$tmp[$k] = $dianpings[$k];
			}
			$dianpings = $tmp;
		}
		$data['order'] = $order;
		$data['stime'] = date("Y-m-d", $stime);
		$data['etime'] = date("Y-m-d", $etime);

		$data['type'] = 6;
		$data['count'] = $count;
		$data['shops'] = $shops;
		$data['list'] = $dianpings;
		$data['pageid'] = "city";
		$this->load->admin_view('admin/city/dianping', $data);
	}

	public function shoptips(){
		$stime = $this->input->get("stime", true, "20140101");
		$etime = $this->input->get("etime", true, date("y-m-d", strtotime("tomorrow")) );
		$stime = strtotime($stime);
		$etime = strtotime($etime);
		$order = $this->input->get("order",true, 1);


		$data = array();
		$list = $this->mo_discount->get_all_discount_ids_list(2, '*', 0);
		$list = tool::format_array_by_key($list, "id");
		foreach($list as $k => $v){
			if($v['status']==1){
				unset($list[$k]);
			}
		}
		$shoptips_ids = array_keys($list);
		//$list = $this->mo_discount->get_info_by_ids($shoptips_ids);
		
		$count = $this->mo_count->get_count_by_sids(9, $shoptips_ids, $stime, $etime);

		$baidu_list = $this->mo_baidu->get_tips_baidu();

		$n = $c = array();
		$i = 0;
		foreach($list as $k => $v){
			$cnt = 0;
			if(isset($count[$v['id']])){
				$cnt = $count[$v['id']];
			}
			$n[] = $v['title'];
			$c[] = intval($cnt);
		}
		$n_json = json_encode($n);
		$c_json = json_encode($c);
		$data['n_json'] = $n_json;
		$data['c_json'] = $c_json;

		if($order==1){
		}elseif ($order==2) {
			arsort($count, true);
			$tmp=array();
			foreach($count as $k=>$v){
				$tmp[$k] = $list[$k];
			}
			$list = $tmp;

		}elseif ($order==3) {
			asort($count, true);
			$tmp=array();
			foreach($count as $k=>$v){
				$tmp[$k] = $list[$k];
			}
			$list = $tmp;
		}
		$data['baidu_list'] = $baidu_list;
		$data['order'] = $order;
		$data['stime'] = date("Y-m-d", $stime);
		$data['etime'] = date("Y-m-d", $etime);

		$data['type'] = 9;
		$data['count'] = $count;
		$data['list'] = $list;
		$data['pageid'] = "city";
		$this->load->admin_view('admin/city/shoptips', $data);
	}
	public function discount(){

		$stime = $this->input->get("stime", true, "20140101");
		$etime = $this->input->get("etime", true, date("y-m-d", strtotime("tomorrow")) );
		$stime = strtotime($stime);
		$etime = strtotime($etime);
		$order = $this->input->get("order",true, 1);


		$now = time();
		$data = array();
		$list = $this->mo_discount->get_all_discount_ids_list(1);
		$list = tool::format_array_by_key($list, "id");
		$shoptips_ids = array_keys($list);
		$list = $this->mo_discount->get_info_by_ids($shoptips_ids);
		
		$count = $this->mo_count->get_count_by_sids(10, $shoptips_ids, $stime, $etime);
		arsort($count, true);

		$n = $c = array();
		$i = 0;
		foreach($list as $v){
			$cnt = 0;
			if(isset($count[$v['id']])){
				$cnt = $count[$v['id']];
			}
			$n[] = $v['title'];
			$c[] = intval($cnt);
		}
		$n_json = json_encode($n);
		$c_json = json_encode($c);
		$data['n_json'] = $n_json;
		$data['c_json'] = $c_json;


		if($order==1){
		}elseif ($order==2) {
			arsort($count, true);
			$tmp=array();
			foreach($count as $k=>$v){
				$tmp[$k] = $list[$k];
			}
			$list = $tmp;

		}elseif ($order==3) {
			asort($count, true);
			$tmp=array();
			foreach($count as $k=>$v){
				$tmp[$k] = $list[$k];
			}
			$list = $tmp;
		}
		$data['order'] = $order;
		$data['stime'] = date("Y-m-d", $stime);
		$data['etime'] = date("Y-m-d", $etime);

		$data['type'] = 10;
		$data['now'] = $now;
		$data['count'] = $count;
		$data['list'] = $list;
		$data['pageid'] = "city";
		$this->load->admin_view('admin/city/discount', $data);
	}

	public function shops(){

		$stime = $this->input->get("stime", true, "20140101");
		$etime = $this->input->get("etime", true, date("y-m-d", strtotime("tomorrow")) );
		$stime = strtotime($stime);
		$etime = strtotime($etime);
		$order = $this->input->get("order",true, 1);




		$shops = $this->mo_shop->get_all_shop(true);
		$shops = tool::format_array_by_key($shops,'id');
		$countrys = $this->mo_geography->get_all_countrys();
		$citys = $this->mo_geography->get_all_citys();
		$shop_ids = array();
		foreach($shops as $v){
			$shop_ids[$v['id']] = $v['id'];
		}

		$count = $this->mo_count->get_count_by_sids(3, $shop_ids, $stime, $etime);

		$n = $c = array();
		$i = 0;
		foreach($shops as $v){
			$cnt = 0;
			if(isset($count[$v['id']])){
				$cnt = $count[$v['id']];
			}
			$n[] = $v['name'];
			$c[] = intval($cnt);
		}
		$n_json = json_encode($n);
		$c_json = json_encode($c);
		$data['n_json'] = $n_json;
		$data['c_json'] = $c_json;
		
		if($order==1){
		}elseif ($order==2) {
			arsort($count, true);
			
			$tmp=array();
			foreach($count as $k=>$v){
				$tmp[$k] = $shops[$k];
			}
			
			$shops = $tmp;

		}elseif ($order==3) {
			asort($count, true);
			$tmp=array();
			foreach($count as $k=>$v){
				$tmp[$k] = $shops[$k];
			}
			$shops = $tmp;
		}


		$data['order'] = $order;
		$data['stime'] = date("Y-m-d", $stime);
		$data['etime'] = date("Y-m-d", $etime);

		$data['type'] = 3;
		$data['shop_count'] = $count;
		$data['countrys'] = $countrys;
		$data['citys'] = $citys;
		$data['shops'] = $shops;
		$data['pageid'] = "shop";
		$data['offset'] = 0;
		$this->load->admin_view("admin/city/shops", $data);

	}

	public function item(){
		$data = array();
		$stime = $this->input->get("stime", true, "20140101");
		$etime = $this->input->get("etime", true, date("y-m-d", strtotime("tomorrow")) );
		$stime = strtotime($stime);
		$etime = strtotime($etime);

		$title = $this->input->get("title", true, '');
		$sid = $this->input->get("sid", true, 0);
		$type = $this->input->get("type", true, 0);

		$list = $this->mo_count->get_list_by_sid($type, $sid, $stime, $etime);
		$data['stime'] = date("Y-m-d", $stime);
		$data['etime'] = date("Y-m-d", $etime);

		$count_list = count($list);
		$width = ceil($count_list * 1.6);


		$a = array();
		$i = 0;
		foreach($list as $day=>$cnt){
			$d = date("Ymd", $day);
			$cnt = intval($cnt);
			$tmp = array();
			$tmp[] = $d;
			$tmp[] = $cnt;
			$a[] = $tmp;
		}
		$a_json = json_encode($a);
		$data['a_json'] = $a_json;

		$data['width'] = $width;
		$data['title'] = $title;
		$data['sid'] = $sid;
		$data['type'] = $type;
		$data['pageid'] = "city";
		
		$this->load->admin_view("admin/city/item", $data);
	}


}