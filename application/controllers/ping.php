<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ping extends ZB_Controller {

	const PAGE_ID = 'ping';
	function __construct(){
		parent::__construct();
		$this->load->model('mo_dianping');
		$this->load->model('mo_shop');
		$this->load->model('mo_user');
		$this->load->model('mo_comment');
		$this->load->model('mo_geography');
		$this->load->model('mo_common');
		$this->load->model('mo_module');
		$this->load->model('mo_social');
	}

	public function index(){
		#load page
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		#点评信息
		$check_mobile = context::get("check_mobile", false);
		if($check_mobile){
			$this->index_h5();
			return;
		}

		$dianping_id = $this->input->get("id",true,0);
		$page = $this->input->get("page",true,1);

		$dianping_id = intval($dianping_id);
		$page = intval($page);
		
		$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($dianping_id);

		if(!$dianping_info || $dianping_info['status'] != 0){
			$this->tool->sorry();
		}
		#商家名
		$shop_id = $dianping_info['shop_id'];
		$shopinfo_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		$shop_info = $shopinfo_re[$shop_id];
		#用户信息
		$uid = $dianping_info['uid'];
		$userinfo_re = $this->mo_user->get_middle_userinfos(array($uid));
		
		#评论信息

		$vuid = context::get('vuid', 0);
		$data['vuid'] = $vuid;
		$comment_re = $this->mo_module->get_comment_html($vuid, $dianping_id, 0, 1, 10);
		$comment_list_html = $comment_re['comment_list_html'];
		$page_cnt = $comment_re['page_cnt'];
		$users = $comment_re['users'];

		/*
		$comments = $this->mo_comment->get_commentid_by_dianpingid($dianping_id, 0);
		$comments_info = $this->mo_comment->get_comment_by_ids($comments);
		
		$users = array();
		if($comments_info){
			foreach($comments_info as $comment){
				$uids[] = $comment['uid'];
			}
			$users = $this->mo_user->get_middle_userinfos($uids);
		}

		#回复总数
		$total = $this->mo_comment->get_comment_cnt_by_dianping($dianping_id, 0);
		$page_cnt = ceil($total/10);
		
		
		

		$comment_data = array("comments"=>$comments_info,'users'=>$users,'dianping_id'=>$dianping_id,'shop_id'=>$shop_id,'login_uid'=>$login_uid);
		$comment_data['type'] = 0;
		$comment_list_html = $this->load->view("template/comment_card",$comment_data,true);
		*/
		#footer
		$jsplugin_list = array('popup','drag');#需要用到的js插件
		#城市信息
		$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		$city_id = $shop_re[$shop_id]['city'];
		
		$city_name = "";
		$city_lower_name = "";
		$country_id = 0;

		$city_info = $this->mo_geography->get_city_info_by_id($city_id);
		if($city_info){
			$city_name = $city_info['name'];
			$country_id = $city_info['country_id'];
			$city_lower_name = $city_info['lower_name'];
		}
		
		$body = $dianping_info['body'];
		$pics = $dianping_info['pics'];
		$pics_list = json_decode($pics, true);
		if($pics_list){
			foreach($pics_list as $v){
				$tmp['"'.$v.'"'] = '"'.$v.'!pingbody"';
			}
			foreach($pics_list as $v){
				$tmp2["'".$v."'"] = "'".$v."!pingbody'";
			}
			foreach($pics_list as $v){
				$tmp3[$v] = upimage::format_brand_up_image($v);
			}

			$body = str_replace(array_keys($tmp), array_values($tmp), $body);
			$body = str_replace(array_keys($tmp2), array_values($tmp2), $body);
			$body = str_replace(array_keys($tmp3), array_values($tmp3), $body);
		}

		$dianping_info['body'] = $body;
		$data = array('page'=>$page,
			'page_cnt'=>$page_cnt,
			'dianping'=>$dianping_info,
			'shop'=>$shop_info,
			'user'=>isset($userinfo_re[$uid])?$userinfo_re[$uid]:array(),
			'comment_list_html'=>$comment_list_html,
			'users'=>$users);
		
		$data['country_id'] = $country_id;
		$data['pageid'] = self::PAGE_ID;
		$data['city_id'] = $city_id;
		$data['city_name'] = $city_name;
		$data['city_info'] = $city_info;
		$data['shop_id'] = $shop_id;
		$data['shop_name'] = $shop_re[$shop_id]['name'];
		$data['jsplugin_list'] = $jsplugin_list;

		$city = $city_id;
		
		$data['city_id'] = $city;
		$area_cities = $this->mo_geography->get_all_cities();
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');
		$data['area_cities'] = $area_cities;
		$data['country_code'] = $country_code;

		$share_content = $dianping_info['clean_body'];
		$share_content = $this->tool->clean_quotes($share_content);
		
		$shop_name = $shop_info['name'];

		$share_content = "#{$shop_name}最新点评/晒单#".trim($share_content);
		$share_content=preg_replace("/[\r\n]+/","\\n",$share_content);
		$share_content = $this->tool->substr_cn2($share_content, 100);
		$share_content .= " 更多请访问赞佰网(zanbai.com)";
		$data['share_content'] = $share_content;
		
		$domain = context::get('domain', '');
		$share_url = $domain.$_SERVER['REQUEST_URI'];
		$data['share_url'] = $share_url;
			
		$share_img = "";
		if($dianping_info['pics_list']){
			$share_img = upimage::format_brand_up_image($dianping_info['pics_list'][0]);
		}
		$data['share_img'] = $share_img;

		if($dianping_info['clean_body']){
			$data['page_title_single'] = $dianping_info['clean_body']."－赞佰网";
		}else{
			$data['page_title_single'] = $data['shop_name']."晒单－赞佰网";
		}
		

		$right_user_html = $this->mo_module->right_user_info($login_uid, $uid);
		$data['right_user_html'] = $right_user_html;
	

		$data['ios_contact_html'] = $this->mo_common->get_ios_contact();
		
		$right_discount_html = $this->mo_module->shop_right_discount($shop_id);
		$data['right_discount_html'] = $right_discount_html;

		$data['city_right_discount_html'] = $this->mo_module->city_right_discount($city_id);
		
		$right_tips_html = $this->mo_module->get_city_tips($country_id, $city_id, $shop_id);
		$data['right_tips_html'] = $right_tips_html;

		$nearby_shop_html = $this->mo_module->nearby_shop($shop_id);
		$data['nearby_shop_html'] = $nearby_shop_html;

		$right_shop_ping_html = $this->mo_module->right_shop_ping($shop_id, $dianping_id);

		$data['login_uid'] = $login_uid;
		$data['tj_id'] = "shaidan";

		$data['macys_html'] = $this->mo_module->format_macys($data['country_id']);

		context::set("city_id", $city_id);
		context::set("country_id", $country_id);
		context::set("shop_id", $shop_id);
		
		$pre_next = $this->mo_dianping->get_dianping_pre_next($dianping_id, $shop_id);
		$data['pre_next'] = $pre_next;
		
		//写入计数
		$this->get_adv_data();
		
		$dianping_pic = $this->mo_dianping->get_dianpingpic_by_shopid($shop_id,10000000);
		$all_pics = array();

		if($dianping_pic){
			$tmp = array();
			foreach($dianping_pic as $k => $v){
				if($k == $dianping_id){
					continue;
				}
				
				$all_pics[$k] = json_decode($v, true);
			}
			$keys = array_keys($all_pics);
			shuffle($keys);
			foreach($keys as $v){
				$tmp[$v] = $all_pics[$v];
			}
			$all_pics = $tmp;
		}
		$data['all_pics'] = $all_pics;

		$this->load->web_view('ping', $data);
	}
	private function get_data(){

	}
	public function index_h5(){
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;

		$dianping_id = $this->input->get("id",true,0);
		$dianping_id = intval($dianping_id);
		$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($dianping_id);

		if(!$dianping_info || $dianping_info['status'] != 0){
			$this->tool->sorry();
		}

		$data['dianping_info'] = $dianping_info;
		$data['body_class'] = "discount";
		$data['page_css'] = array("/css/h5/page/city_list.css");
		$this->load->h5_view("h5/dianping_detail", $data);
	}
}
