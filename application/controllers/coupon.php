<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class coupon extends ZB_Controller {
	const PAGE_ID = 'discount_list';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_coupon");
		$this->load->model("mo_geography");
		$this->load->model("mo_brand");
		$this->load->model("mo_common");
		$this->load->model("mo_fav");
		$this->load->model("mo_module");
	}
	# http://zan.com/coupon/info
	public function info(){
		$check_mobile = context::get("check_mobile", false);
		if($check_mobile){
			$this->info_h5();
			return;
		}

		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		$id = $this->input->get('id', true, 0);
		$shop_id = $this->input->get('shop_id', true, 0);
		$coupon_info = array();
		$shop_info = array();
		$pic = "";
		$pics = array();
		$img_size = 0;
		$country_id = 0;
		if($id){
			$coupon_info = $this->mo_coupon->get_info($id);
			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
			$pics = $coupon_info['pics'];
			$pics = json_decode($pics, true);
			$pic = $pics[0];
			$img_size = $coupon_info['img_size'];
		}
		$is_fav = $this->mo_fav->check_exist($login_uid, $id, 1);

		$coupon_info['is_fav'] = $is_fav;

		$data = array();
		$data['pics'] = $pics;
		$data['img_size'] = $img_size;
		$data['page_css'] = "ZB_coupon_print.css";
		$data['pageid'] = "profile";
		$data['coupon_info'] = $coupon_info;
		$data['shop_info'] = $shop_info;
		$data['pic'] = $pic;
		$login_type = "";
		if (isset($this->session->userdata['user_info'])) {
			$user_info = $this->session->userdata['user_info'];
			if(isset($user_info['source']) && $user_info['source'] == 'weibo'){
				$login_type = "weibo";
			}
		}
		$city_id = $shop_info['city'];
		$data['city_id'] = $city_id;
		$city_info = $this->mo_geography->get_city_info_by_id($shop_info['city']);

		$data['country_id'] = $city_info['country_id'];
		$data['city_name'] = $city_info['name'];
		$data['city_info'] = $city_info;
		$data['login_type'] = $login_type;
		//去掉了微博的登录验证
		$data['login_type'] = 1;

		$data['id'] = $id;
		$data['shop_id'] = $shop_id;
		

		$ios_contact_html = $this->mo_common->get_ios_contact();
		$data['ios_contact_html'] = $ios_contact_html;

		$data['tj_id'] = "coupon_info";

		if($coupon_info['seo_title']){
			$data['page_title'] = $coupon_info['seo_title'];
		}else{
			$data['page_title'] = $coupon_info['title']."优惠券｜";
		}

		if($coupon_info['seo_keywords']){
			$data['seo_keywords'] = $coupon_info['seo_keywords'];
		}

		if($coupon_info['seo_description']){
			$data['seo_description'] = $coupon_info['seo_description'];
		}

		$data['macys_html'] = $this->mo_module->format_macys($data['country_id'],0,0, $id);
		
		$right_coupon_html = $this->mo_module->get_right_coupon($city_id, $id);
		$data['right_coupon_html'] = $right_coupon_html;
		
		$recommend_shop_html = $this->mo_module->recomment_shop($city_id);
		$data['recommend_shop_html'] = $recommend_shop_html;
		$right_tips_html = $this->mo_module->get_city_tips($country_id, $city_id, $shop_id);
		$data['right_tips_html'] = $right_tips_html;

		$this->get_adv_data();
		
		$this->load->web_view("coupon/info", $data);
		
	}
	public function info_h5(){
		$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
		$id = $this->input->get('id', true, 0);
		$shop_id = $this->input->get('shop_id', true, 0);
		$coupon_info = array();
		$shop_info = array();
		$pic = "";
		$pics = array();
		$img_size = 0;
		$country_id = 0;
		if($id){
			$coupon_info = $this->mo_coupon->get_info($id);
			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
			$pics = $coupon_info['pics'];
			$pics = json_decode($pics, true);
			$pic = $pics[0];
			$img_size = $coupon_info['img_size'];
		}

		$data['coupon_info'] = $coupon_info;
		$data['body_class'] = "shop_list";
		$data['page_css'] = array("/css/h5/page/city_list.css");
		$this->load->h5_view("h5/coupon_info", $data);
	}

	public function print_coupon(){

       	require_once APPPATH .'third_party/weibo/weibo_authv2.php';
		require_once APPPATH .'config/env.php';
		if (isset($this->session->userdata['user_info']['token'])) {
			$token = $this->session->userdata['user_info']['token'];
		}
		//$o = new SaeTClientV2( $config['weibo']['WB_AKEY'] , $config['weibo']['WB_SKEY'], $token);

		$shop_id = $this->input->get("shop_id", true, '');
		$id = $this->input->get("id", true, '');
		$coupon_info = $this->mo_coupon->get_info($id);

		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
		$shop_name = $shop_info['name'];
		$city_id = $shop_info['city'];
		$country_id = $shop_info['country'];
		$city_info = $this->mo_geography->get_city_info_by_id($city_id);
		$country_info = $this->mo_geography->get_country_info_by_id($country_id);
		$city_name = $city_info['name'];
		$country_name = $country_info['name'];
		$content = "我从赞佰网打印了{$shop_name}的优惠劵,前往购物使用可以享受更多更低的折扣,{$country_name}购物攻略,{$city_name}购物攻略尽在赞佰网 http://zanbai.com/city/".$city_id;
		
		//$re = $o->update($content);
		

		$pdf_file = $coupon_info['pdf_name'];
		if($pdf_file){
			$file = "http://zanbai.com/public/coupon/".$pdf_file;
			$this->tool->header_normal($file);
			exist();
		}else{
			echo "打印失败.<a href='http://zanbai.com'>返回</a>";
		}

	}

	public function download_coupon(){
		
       	//require_once APPPATH .'third_party/weibo/weibo_authv2.php';
		//require_once APPPATH .'config/env.php';
		//if (isset($this->session->userdata['user_info']['token'])) {
		///	$token = $this->session->userdata['user_info']['token'];
		//	}
		//$o = new SaeTClientV2( $config['weibo']['WB_AKEY'] , $config['weibo']['WB_SKEY'], $token);

		$id = $this->input->get("id", true, '');
		$shop_id = $this->input->get("shop_id", true, '');
		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
		$shop_name = $shop_info['name'];
		
		/*
		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
		$shop_name = $shop_info['name'];
		$city_id = $shop_info['city'];
		$country_id = $shop_info['country'];
		$city_info = $this->mo_geography->get_city_info_by_id($city_id);
		$country_info = $this->mo_geography->get_country_info_by_id($country_id);
		$city_name = $city_info['name'];
		$country_name = $country_info['name'];
		$content = "我从赞佰网下载了{$shop_name}的优惠劵,前往购物使用可以享受更多更低的折扣,{$country_name}购物攻略,{$city_name}购物攻略尽在赞佰网 http://zanbai.com/city/".$city_id;
		*/

		$coupon_info = $this->mo_coupon->get_info($id);
		$this->mo_coupon->increace_download($id);
		//$re = $o->update($content);

		$pdf_file = $coupon_info['pdf_name'];
		//
		//$file = "http://zanbai.com/public/coupon/".$pdf_file;
		$file = FCPATH."public/coupon/".$pdf_file;
		$file = "http://zbfile.b0.upaiyun.com/coupon/".$pdf_file;

		//header('Content-type: application/pdf');
		// It will be called downloaded.pdf
		//header('Content-Disposition: attachment; filename="'.$download_name.'"');
		//readfile($file);
		//exit();
		$filename = '/tmp/coupon_pdf_'.$id.".pdf";
		if(!file_exists($filename) || filesize($filename) < 10000){
			$content=file_get_contents($file);
			if(!$content){
				$this->tool->sorry();
				exit();
			}
			file_put_contents($filename, $content);//存盘
		}

		if($coupon_info && isset($coupon_info['title']) && $coupon_info['title']){
			$download_name = $coupon_info['title'].".pdf";
		}else{
			$download_name = $shop_name."优惠券.pdf";
		}
		
		$clientprober = tool::check_clientprober();
		if(!$clientprober){
			$download_name = $id."youhuiquan.pdf";
		}
		
		header('Content-type: application/pdf');
		// It will be called downloaded.pdf
		header('Content-Disposition: attachment; filename="'.$download_name.'"');
		readfile($filename);
		exit();
	    // http headers 
	    header('Content-Type: application-x/force-download'); 
	    header('Content-Disposition: attachment; filename="' . $download_name .'"'); 
	    header('Content-length: ' . filesize($filename)); 
	    // for IE6 
	    if (false === strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) { 
	        header('Cache-Control: no-cache, must-revalidate'); 
	    } 
	    header('Pragma: no-cache'); 
	         
	    // read file content and output 
	    return readfile($filename);; 


		//$download_name = $shop_name."优惠券.pdf";
		//$this->forceDownload($file, $download_name);
		
	}

	function forceDownload($filename, $download_name) { 
	    if (false == file_exists($filename)) { 
	        return false; 
	    } 

	    // http headers 
	    header('Content-Type: application-x/force-download'); 
	    header('Content-Disposition: attachment; filename="' . ($download_name) .'"'); 
	    header('Content-length: ' . filesize($filename)); 
	 
	    // for IE6 
	    if (false === strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) { 
	        header('Cache-Control: no-cache, must-revalidate'); 
	    } 
	    header('Pragma: no-cache'); 
	         
	    // read file content and output 
	    return readfile($filename);; 
	} 
	
	//锦囊
	public function detail(){
		$guide_id = $this->input->get("guide_id", true, 0);
		//210纽约，213洛杉矶，214旧金山
		$all_desc = array(
			'210'=>array('size'=>'17.1M', 'page'=>'18', 'time'=>'2014-08-14'),
			'213'=>array('size'=>'14.5M', 'page'=>'16', 'time'=>'2014-08-14'),
			'214'=>array('size'=>'14.5M', 'page'=>'33', 'time'=>'2014-08-14'),
			);
		$coupon_info = $this->mo_coupon->get_info($guide_id);
		if(!$coupon_info){
			$this->tool->sorry();
		}
		$guide_img = $coupon_info['pics_list'][0];

		$data = array();
		$data['guide_img'] = $guide_img;
		$desc = $all_desc[$guide_id];
		$data['desc'] = $desc;
		unset($all_desc[$guide_id]);
		$more_guide_ids = array_keys($all_desc);
		$more_guide = $this->mo_coupon->get_coupon_infos($more_guide_ids);
		$data['more_guide'] = $more_guide;
		
		$city = $this->input->get('city',true,1); #城市
		$city_info = $this->mo_geography->get_city_info_by_id($city);
		$country_id = $city_info['country_id'];
		$city_name = $city_info['name'];
		$city_lower_name = $city_info['lower_name'];
		$data['city_name'] = $city_name;
		$data['city_lower_name'] = $city_lower_name;

		$vuid = context::get('vuid', 0);
		$data['vuid'] = $vuid;
		$data['guide_id'] = $guide_id;

		$dianping_id = $guide_id;
		$comment_re = $this->mo_module->get_comment_html($vuid, $dianping_id, 2, 1, 10);

		$data['coupon_info'] = $coupon_info;
		$data['comment_list_html'] = $comment_re['comment_list_html'];
		$data['page'] = $comment_re['page'];
		$data['page_cnt'] = $comment_re['page_cnt'];
		$data['users'] = $comment_re['users'];


		$data['page_css'] = "ZB_guide.css";
		$data['pageid'] = "guide";
		$data['city'] = 1;
		$more = 0;

		$data['page_title'] = $coupon_info['title']."";
		if($coupon_info['seo_keywords']){
			$data['seo_keywords'] = $coupon_info['seo_keywords'];
		}

		if($coupon_info['seo_description']){
			$data['seo_description'] = $coupon_info['seo_description'];
		}

		$this->load->web_view("coupon/detail", $data);
	}
}