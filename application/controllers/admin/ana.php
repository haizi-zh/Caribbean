<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class ana extends ZB_Controller {
	const PAGE_ID = 'ana';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_content");
		$this->load->model("mo_weixinevent");
	}

	public function index(){
		#图片信息
		$this->config->load('ana');
		$ana_urls = $this->config->item('ana_urls');
		
		$data['all_slugs'] = implode(',', array_keys($ana_urls));
		
		$data['ana_urls'] = $ana_urls;
		$data['pageid'] = self::PAGE_ID;
		#footer
		$this->load->admin_view('admin/ana/lists', $data);
	}
	
	// zan.com/admin/ana/coupon
	public function coupon(){
		$data = array();
		$show_type = $this->input->get('show_type', true, 0);
		$show_coupon_id = $this->input->get('show_coupon_id', true, 0);
		$data['show_type'] = $show_type;
		$data['show_coupon_id'] = $show_coupon_id;

		$data_domain = context::get("data_domain", "");
		$where = "(to_type=16 or to_type=18) and spider_type=0 ";
		$select = "url_id,day,to_type";
		$select = urlencode($select);
		$where = urlencode($where);

		$url = $data_domain."/aj/ana/get_ana_new_where/?select=".$select."&where=".$where;
		//var_dump($url);die;
		$content = tool::curl_get($url);
		
		$list = array();
		$days = array();
		$all_download = array();
		$all_coupon = array();
		$download = $coupon = array();
		if($content != 'error'){
			$content = json_decode($content, true);
			
			foreach($content as $v){
				$to_type = $v['to_type'];
				$day = $v['day'];
				$url_id = $v['url_id'];
				$days[$day] = $day;
				if($to_type == 16){
					if(isset($coupon[$day][$url_id])){
						$coupon[$day][$url_id] += 1;
					}else{
						$coupon[$day][$url_id] = 1;
					}
					if(isset($all_coupon[$day])){
						$all_coupon[$day] += 1;
					}else{
						$all_coupon[$day] = 1;
					}
				}elseif($to_type == 18){
					if(isset($download[$day][$url_id])){
						$download[$day][$url_id] += 1;
					}else{
						$download[$day][$url_id] = 1;
					}
					if(isset($all_download[$day])){
						$all_download[$day] += 1;
					}else{
						$all_download[$day] = 1;
					}
				}
			}
		}



		$ana_content = $this->mo_content->get_list(1);
		

		foreach($ana_content as $k => $v){
			$desc_content = $v['desc_content'];
			$desc_content_tmp = explode(",", $desc_content);
			$tmp = array();
			foreach($desc_content_tmp as $v){
				$tmp[$v] = $v;
			}

			$desc_content_tmp = $tmp;
			$tmp = array();

			foreach($download as $day=>$value){
				foreach($value as $coupon_id=>$count){
					if(isset($desc_content_tmp[$coupon_id])){
						if(isset($tmp[$day])){
							$tmp[$day] += $count;
							
						}else{
							$tmp[$day] = $count;
							
						}
					}
				}
			}
			$ana_content[$k]['download_list'] = $tmp;
			

			$tmp = array();
			foreach($coupon as $day=>$value){
				foreach($value as $coupon_id=>$count){
					if(isset($desc_content_tmp[$coupon_id])){
						if(isset($tmp[$day])){
							$tmp[$day] += $count;
						}else{
							$tmp[$day] = $count;
						}
					}
				}
			}
			$ana_content[$k]['coupon_list'] = $tmp; 
		}
		arsort($days);


		$data['ana_content'] = $ana_content;
		$data['days'] = $days;
		$data['pageid'] = self::PAGE_ID;
		$data['all_download'] = $all_download;
		$data['all_coupon'] = $all_coupon;

		$this->load->admin_view('admin/ana/coupon', $data);
	}

	// zan.com/admin/ana/show_out
	public function show_out(){
		$data = array();
		$day = $this->input->get('day', true, 0);
		if($day){
			$yesterday = strtotime($day);
		}else{
			$yesterday = strtotime("yesterday");
		}
		$day = date("Ymd", $yesterday);
		$data['day'] = $day;
		//var_dump(date("Y-m-d H:i:s", $yesterday));
		$select = "id, to_type, f_type";
		$where = "spider_type = 0 and day=".$yesterday;
		$group_by = "";
		$order_by = "";
		$select = urlencode($select);
		$where = urlencode($where);
		$group_by = urlencode($group_by);
		$order_by = urlencode($order_by);


		$data_domain = context::get("data_domain", "");
		$url = $data_domain."/aj/ana/get_ana_new_where/?select=".$select."&where=".$where."&group_by=".$group_by."&order_by=".$order_by;
		
		$content = tool::curl_get($url);
		$content_json = json_decode($content, true);
		$multi = $simple = array();
		$to_type_list = array();
		if($content_json){
			foreach($content_json as $v){
				if(isset($simple[$v['f_type']][$v['to_type']])){
					$simple[$v['f_type']][$v['to_type']] += 1;
				}else{
					$simple[$v['f_type']][$v['to_type']] = 1;
				}
				if(isset($to_type_list[$v['to_type']])){
					$to_type_list[$v['to_type']] += 1;
				}else{
					$to_type_list[$v['to_type']] = 1;
				}
			}
		}
		$data['to_type_list'] = $to_type_list;
		//var_dump($url, $content, $content_json);die;
		$data['simple'] = $simple;
		
		$this->config->load('ana');
		$ana_urls = $this->config->item('ana_urls');
		
		$data['ana_urls'] = $ana_urls;
		$data['pageid'] = self::PAGE_ID;
		$this->load->admin_view('admin/ana/show_out', $data);
	}

	public function weixin(){

		$types[100] = "text";
		$types[101] = "image";
		$types[102] = "voice";
		$types[103] = "video";
		$types[104] = "music";
		$types[105] = "news";
		$types[1] = "亚洲";
		$types[2] = "欧洲";
		$types[3] = "北美";
		$types[4] = "ios-app";
		$types[5] = "热门商家";
		$types[6] = "美国优惠券";
		$types[7] = "购物攻略";
		$types[8] = "取消关注";
		$types[9] = "关注";
		$data['types'] = $types;


		$list = $this->mo_weixinevent->get_all();
		$click = array();
		$words = array();
		foreach($list as $v){
			if(isset($click[$v['type']])){
				$click[$v['type']] +=1;
			}else{
				$click[$v['type']] = 1;
			}
			if($v['keyword']){
				if(isset($words[$v['keyword']])){
					$words[$v['keyword']] +=1;
				}else{
					$words[$v['keyword']] = 1;
				}
			}
			//$re[$v['day']][$v['type']] += 1;
		}
		arsort($click);
		arsort($words);

		$data['click'] = $click;
		$data['words'] = $words;

		$data['list'] = $list;
		$data['pageid'] = self::PAGE_ID;
		$this->load->admin_view('admin/ana/weixin', $data);
	}
}





