<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cron extends ZB_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model("mo_dianping");
		$this->load->model("mo_ana");
		$this->load->model("mo_baidu");
		$this->load->model("mo_count");
	}
	// zan.com/cron/create_all_count
	public function create_all_count(){
		$now = time();
		$stime = "20140101";
		//$stime = "20140727";
		$stime = strtotime($stime);
		$etime = strtotime("tomorrow");
		/*
		$citys = $this->mo_geography->get_all_cityinfos();
		$shops = $this->mo_shop->get_all_shop(true);
		$discount_list = $this->mo_discount->get_all_discount_ids_list(1);
		$shoptips_list = $this->mo_discount->get_all_discount_ids_list(2);
		$dianpings = $this->mo_dianping->get_all_dianpings();
		$coupons = $this->mo_coupon->get_list(array(), 1, 100000);
		*/
		// type: 2city,3shop,6dianping,10discount,9tips,26shop_download,18coupon_download,
		$list = array(2,3,6,10,9,26,18);
		for($day=$stime; $day<=$etime; $day+=86400){
			foreach($list as $k=>$type){
				$add_data = array();
				$add_data['type'] = $type;
				$add_data['day'] = $day;
				$add_data['ctime'] = $now;
				$this->mo_count->add_day($add_data);
			}
		}
	}

	// zan.com/cron/all_count
	public function all_count(){
		$list = $this->mo_count->get_all_count_day(0,1,250);
		if($list){
			foreach($list as $k => $v){
				$re = $this->all_count_item($v['type'], $v['day']);
				if($re){
					$add_data = array();
					$add_data['id'] = $v['id'];
					$add_data['status'] = 1;
					$this->mo_count->update_day($add_data);
				}
			}
		}
	}

	// type: 2city,3shop,6dianping,10discount,9tips,26shop_download,18coupon_download,
	public function all_count_item($to_type, $day){
		$now = time();
		$sid = 'url_id';
		switch ($to_type) {
			case '2':$sid = 'city_id';break;
			case '3':$sid = 'shop_id';break;
			case '26':$sid = 'shop_id';break;
			default:
				break;
		}
		$select = "count(id) as cnt, {$sid} as sid ";
		$where = "to_type = {$to_type} and day=".$day;
		$group_by = " {$sid} ";
		$order_by = "";
		$select = urlencode($select);
		$where = urlencode($where);
		$group_by = urlencode($group_by);
		$order_by = urlencode($order_by);

		$data_domain = context::get("data_domain", "");
		$data_domain = "http://data.zanbai.com:8080";
		$url = $data_domain."/aj/ana/get_ana_new_where/?select=".$select."&where=".$where."&group_by=".$group_by."&order_by=".$order_by;
		
		$content = tool::curl_get($url);
		
		if($content == "error"){
			continue;
		}
		$content_json = json_decode($content, true);
		if($content_json){
			foreach($content_json as $v){
				$cnt = $v['cnt'];
				$sid = $v['sid'];
				if(!$sid){
					continue;
				}
				$add_data = array();
				$add_data['sid'] = $sid;
				$add_data['type'] = $to_type;
				$add_data['day'] = $day;
				$add_data['count'] = $cnt;
				$add_data['ctime'] = $now;
				$this->mo_count->add_count($add_data);
			}
		}
		return true;
	}

	// zan.com/cron/create_baidu
	public function create_baidu(){
		$now = time();
		$shoppingtips_detail_template_simple = "http://zanbai.com/shoptipsinfo/%s/";
		$shoptips_list = $this->mo_discount->get_all_discount_ids_list(2, "id,status", 0);
		foreach ($shoptips_list as $k=>$v) {
			$shoptips_info = $this->mo_discount->get_info_by_id($v['id']);
			$shoppingtips_detail_line_simple = sprintf($shoppingtips_detail_template_simple, $v['id']);
			$add_data = array();
			$add_data['type'] = 1;
			$add_data['url_id'] = $v['id'];
			$add_data['status'] = $v['status'];
			$add_data['url'] = $shoppingtips_detail_line_simple;
			$add_data['ctime'] = $now;
			$this->mo_baidu->add($add_data);
		}
		echo "ok";
	}

	// zan.com/cron/baidu_rand_100
	public function baidu_rand_100(){
		$url = "http://zan.com/cron/baidu_new/?rand=";
		$urls = array();
		for ($i=0; $i < 10; $i++) { 
			$urls[] = $url.$i;
		}

		//tool::async_get_url($urls);
	}

	// zan.com/cron/baidu_new
	public function baidu_new(){
        set_time_limit(3000);
        ini_set('memory_limit', '1G');

		$now = time();
		$last_time = $now - 1000;
		$last_time = 0;
		$limit = 310;
		//$url_id = 
		$list = $this->mo_baidu->get_all_baidu(1,0, $last_time, $limit);
		shuffle($list);
		
		$i = 0;
		if($list){
			$tmp = array();
			foreach ($list as $key => $value) {
				if($i > 33){
					break;
				}
				$i += 1;
				$tmp[$value['id']] = $value;
			}
			$list = $tmp;
		}
		
		if($list){
			$tmp = array();
			foreach ($list as $key => $value) {
				$tmp[$value['url_id']] = $value['url_id'];
			}
		}
		
		if(!$list){
			return;
		}
		$citys = $this->mo_geography->get_all_citys();
		$shops = $this->mo_shop->get_all_shop(true);
		$shop_citys = array();
		$shop_countrys = array();
		foreach($shops as $v){
			$shop_citys[$v['city']][$v['id']] = $v;
			$shop_countrys[$v['country']][$v['id']] = $v;

			$shop_citys[$v['city']][0] = array('id'=>0, 'city'=>$v['city']);
			$shop_countrys[$v['country']][0] = array('id'=>0, 'city'=>$v['city']);
		}

		$url_template1 = "http://www.zanbai.com/discount/shoptips_detail?shop_id=%s&city=%s&id=%s";
		$url_template2 = "http://www.zanbai.com/discount/shoptips_detail?id=%s&shop_id=%s&city_id=%s";
		$url_template3 = "http://www.zanbai.com/discount/shoptips_detail?city=%s&id=%s&shop_id=%s";

		$city_template = "http://www.zanbai.com/shoptipsinfo/%s/%s";

		foreach($list as $v){
			$url_list = array();
			$url_id = $v['url_id'];
			if($url_id != 331){
				//continue;
			}

			$url = $v['url'];
			$url_s  = substr($url, 0,-1);
			$url_list[] = $url;
			$url_list[] = $url_s;

			$discount_info = $this->mo_discount->get_info_by_id($url_id);

			$city_id = $discount_info['city'];
			$country = $discount_info['country'];
			if($country){
				if(is_numeric($country)){
					$tmp_shops = $shop_countrys[$country];
					foreach($tmp_shops as $shop_id=>$item){
						$s_id = $shop_id;
						$c_id = $item['city'];
						$t_id = $url_id;
						$city_url = sprintf($city_template, $c_id, $t_id);
						$url_list[md5($city_url)] = $city_url;

						$url_list[] = sprintf($url_template1, $s_id, $c_id, $t_id);
						$url_list[] = sprintf($url_template2, $t_id, $s_id, $c_id);
						$url_list[] = sprintf($url_template3, $c_id, $t_id, $s_id);

					}
				}else{
					$tmp = explode(",", $country);
					foreach($tmp as $vv){
						if(!$vv){
							continue;
						}
						$tmp_shops = $shop_countrys[$vv];
						foreach($tmp_shops as $shop_id=>$item){
							$s_id = $shop_id;
							$c_id = $item['city'];
							$t_id = $url_id;
							$city_url = sprintf($city_template, $c_id, $t_id);
							$url_list[md5($city_url)] = $city_url;
							$url_list[] = sprintf($url_template1, $s_id, $c_id, $t_id);
							$url_list[] = sprintf($url_template2, $t_id, $s_id, $c_id);
							$url_list[] = sprintf($url_template3, $c_id, $t_id, $s_id);

						}
					}
				}
			}elseif($city_id){
				if(is_numeric($city_id)){
					$tmp_shops = $shop_citys[$city_id];
					foreach($tmp_shops as $shop_id=>$item){
						$s_id = $shop_id;
						$c_id = $item['city'];
						$t_id = $url_id;
						$city_url = sprintf($city_template, $c_id, $t_id);
						$url_list[md5($city_url)] = $city_url;

						$url_list[] = sprintf($url_template1, $s_id, $c_id, $t_id);
						$url_list[] = sprintf($url_template2, $t_id, $s_id, $c_id);
						$url_list[] = sprintf($url_template3, $c_id, $t_id, $s_id);

					}
				}else{
					$tmp = explode(",", $city_id);
					foreach($tmp as $vv){
						if(!$vv){
							continue;
						}
						$tmp_shops = $shop_citys[$vv];
						foreach($tmp_shops as $shop_id=>$item){
							$s_id = $shop_id;
							$c_id = $item['city'];
							$t_id = $url_id;
							$city_url = sprintf($city_template, $c_id, $t_id);
							$url_list[md5($city_url)] = $city_url;

							$url_list[] = sprintf($url_template1, $s_id, $c_id, $t_id);
							$url_list[] = sprintf($url_template2, $t_id, $s_id, $c_id);
							$url_list[] = sprintf($url_template3, $c_id, $t_id, $s_id);

						}
					}
				}
			}
			

			//var_dump($url_list);die;
			foreach($url_list as $k_tmp => $v_tmp){
				$url_list[$k_tmp] = urlencode($v_tmp);
			}
			

			foreach($url_list as $url_item){
				$re = $this->baidu($url_item);
				//$re = false;
				if($re ){
					$nstime = strtotime($re);
					
					$add_data = array();
					$add_data['nstime'] = $nstime;
					if(!$v['stime']){
						$add_data['stime'] = $nstime;
					}
					$add_data['id'] = $v['id'];
					$old_content = $v['content'];
					$new_content = array();
					if($old_content){
						$new_content = json_decode($old_content, true);
					}
					$new_content[$nstime]["domain"] = $url_item;
					$add_data['content'] = json_encode($new_content);
					$add_data['mtime'] = time();
					$this->mo_baidu->update($add_data);
					break;
				}
			}
			unset($url_list);
			$url_list = null;

			$last_data = array();
			$last_data['id'] = $v['id'];
			$last_data['last_time'] = $now;
			$this->mo_baidu->update($last_data);
			//var_dump($re, $url_item);die;
			//$url = "http://zanbai.com/shoptipsinfo/249/";
			//var_dump($re);die;
			//var_dump($re);die;
		}
		//var_dump($list);
		echo "ok";

	}


	// zan.com/cron/baidu
	public function  baidu($domain){
		//return 0;

        $today = date("Ymd", time());
		//echo $this->convert(memory_get_usage(true))."  "; 
		require_once (APPPATH."/third_party/simple_html_dom-master/"."simple_html_dom.php");

		//$domain = "zanbai.com/newyork/";
		//$domain = "zanbai.com";
        $url="http://www.baidu.com/s?wd=".$domain;
        //$url = "http://www.126.com/";
        $url_md5 = "tipsbaidu".$today.md5($url);
        $save_path = "/tmp/baidu/".$url_md5;
        $save_path = "/home/long/".$url_md5;//var_dump(urldecode($domain), $save_path);
        unlink($save_path);
        if(!file_exists($save_path)){
        	//var_dump(123);die;
        	$content = file_get_contents($url);
        	file_put_contents($save_path, $content);
        }else{
        	//$html = file_get_html($url);
        }

        $format_time = 0;
        $content = file_get_contents($save_path);
        //您的访问出错了
        if(strlen($content)<10000){
        	unlink($save_path);
        	echo "路由出错";
        	return 0;
        }

        if(strstr($content, "没有找到")){
        	unset($content);
        	$content = null;
        }else{
	        $html = new simple_html_dom();
	        $html->load_file($save_path);
			foreach($html->find('div .f13 span') as $element){
				//echo $element . '<br>';
				$element = strip_tags($element);
				//var_dump($element);
				$tmp = explode("&nbsp;", $element);
				$format_url = $tmp[0];
				$format_time = $tmp[1];
				break;
				//var_dump($tmp);
				//die;
			}
			unset($html);
			$html = null;

        }


        return $format_time;
	}


//echo $this->convert(memory_get_usage(true))."  "; 
function convert($size){ 
$unit=array('b','kb','mb','gb','tb','pb'); 
return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i]; 
} 

}