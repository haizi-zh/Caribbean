<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class discount extends ZB_Controller {
	public function add_discount(){
		$this->config->load('errorcode',TRUE);
		try{
			$body = $this->input->post('body', false, '');
			$has_pic = $this->input->post('pics', true, 0);
			$level = $this->input->post('level', true, 1000);
			$title = $this->input->post('title', true, '');
			$stime = $this->input->post('stime', true, '');
			$etime = $this->input->post('etime', true, '');
			$shop_type = $this->input->post('shop_type', true, 0);
			$share_content = $this->input->post('share_content', true, '');

			if ($has_pic){
				$has_pic = 1;
			}else{
				$has_pic = 0;
			}
			$pics = $this->input->post('pics', true, '');
			if ($pics){
				$pics = json_encode(explode(",",$_POST['pics']));
			}else{
				$pics = '';
			}
			$shop_id = $this->input->post('shop_id', true, 0);
			$brand_id = $this->input->post('brand_id', true, 0);
			$user_info=$this->session->userdata('user_info');
			$this->config->load('env',TRUE);
			
			if(!$user_info){
				//$code = '202';
				//echo json_encode(array('code'=>$code,'msg'=>$this->getPingHtmlconfig->item($code,'errorcode'),'html'=>''));
				//exit;
			}
			$this->load->model('mo_discount');
			#判断body是否重复
			//$uid = $user_info['uid'];
			$uid = 0;
			$last_body = $this->mo_discount->get_last_discount_by_uid($uid);
			if ($last_body && $last_body['body'] == $body) {
				$code = "210";
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>'33'));
				exit;
			}
			$type=1;
			$ctime = time();
			$status = 0;
			$ip = 0;
			#拼装
			$stime = strtotime($stime);
			$etime = strtotime($etime);
			$discount_data = array(
					'level' => $level,
					'title' => $title,
					'stime' => $stime,
					'etime' => $etime,
					'body' => $body,
					'pics' => $pics,
					'has_pic' => $has_pic,
					'type' => $type,
					'status'=>$status,
					'ctime'=>$ctime,
					'mtime'=>$ctime,
					'ip'=>$ip,
					'uid' => $uid,
					'shop_id' => $shop_id,
					'brand_id' => $brand_id,
					'share_content'=>$share_content,
					'shop_type'=>$shop_type,
					);
			
			#入库
			$discount_id = $this->mo_discount->add($discount_data);
			if (!$discount_id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($discount_id) && $discount_id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}
	}
	public function edit_discount_seo(){
		$this->config->load('errorcode',TRUE);
		try{
			$id = $this->input->post('id', true, '0');
			$seo_title = $this->input->post('seo_title', true, '');
			$seo_keywords = $this->input->post('seo_keywords', true, '');
			$seo_description = $this->input->post('seo_description', true, '');
			$this->config->load('env',TRUE);
			

			$this->load->model('mo_discount');
			#判断body是否重复
			#拼装

			$discount_data = array(
					'seo_title' => $seo_title,
					'seo_keywords' => $seo_keywords,
					'seo_description' => $seo_description,
					);
			#入库
			$discount_id = $this->mo_discount->edit($discount_data, $id);
			if (!$discount_id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($discount_id) && $discount_id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}

	}
	public function edit_discount(){
		$this->config->load('errorcode',TRUE);
		try{
			$body = $this->input->post('body', false, '');
			$has_pic = $this->input->post('pics', true, 0);
			$level = $this->input->post('level', true, 1000);
			$id = $this->input->post('id', true, '0');
			$stime = $this->input->post('stime', true, '');
			$etime = $this->input->post('etime', true, '');
			$title = $this->input->post('title', true, '');
			$title_mobile = $this->input->post('title_mobile', true, '');
			$share_content = $this->input->post('share_content', true, '');
			//$status = $this->input->post('status', true, 0);

			$shop_type = $this->input->post('shop_type', true, 0);

			if ($has_pic){
				$has_pic = 1;
			}else{
				$has_pic = 0;
			}
			$pics = $this->input->post('pics', true, '');
			if ($pics){
				$pics = json_encode(explode(",",$_POST['pics']));
			}else{
				$pics = '';
			}
			//$user_info=$this->session->userdata('user_info');
			$this->config->load('env',TRUE);
			
			//if(!$user_info){
				//$code = '202';
				///echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				//exit;
			//}
			$this->load->model('mo_discount');
			#判断body是否重复
			#拼装
			$now = time();
			$stime = strtotime($stime);
			$etime = strtotime($etime);
			$discount_data = array(
					'level' => $level,
					'title' => $title,
					'title_mobile' => $title_mobile,
					'stime' => $stime,
					'etime' => $etime,
					'mtime' => $now,
					'body' => $body,
					'pics' => $pics,
					'has_pic' => $has_pic,
					'share_content'=>$share_content,
					//'status' => $status,
					'shop_type'=>$shop_type,
					);
			#入库
			$discount_id = $this->mo_discount->edit($discount_data, $id);
			if (!$discount_id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($discount_id) && $discount_id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}
	}

	public function add_brand_discount(){
		$this->config->load('errorcode',TRUE);
		try{
			$body = $this->input->post('body', false, '');
			$has_pic = $this->input->post('pics', true, 0);
			$title = $this->input->post('title', true, '');
			$stime = $this->input->post('stime', true, '');
			$etime = $this->input->post('etime', true, '');
			$share_content = $this->input->post('share_content', true, '');
			$shop_type = $this->input->post('shop_type', true, 0);
			if ($has_pic){
				$has_pic = 1;
			}else{
				$has_pic = 0;
			}
			$pics = $this->input->post('pics', true, '');
			if ($pics){
				$pics = json_encode(explode(",",$_POST['pics']));
			}else{
				$pics = '';
			}
			$brand_id = $this->input->post('brand_id', true, 0);
			$shop_ids = $this->input->post('shop_ids', true, "");
			if ($shop_ids) {
				$shop_ids = explode(",", $shop_ids);
			}

			//$user_info=$this->session->userdata('user_info');
			$this->config->load('env',TRUE);
			if (!$brand_id) {
				$code = '202';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			$this->load->model("mo_brand");
			$brand_info = $this->mo_brand->get_brand_by_id($brand_id);
			if(!$brand_info){
				$code = '202';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			$this->load->model('mo_discount');
			#判断body是否重复
			//$uid = $user_info['uid'];
			$uid = 0;
			$last_body = $this->mo_discount->get_last_discount_by_uid($uid);
			if ($last_body && $last_body['body'] == $body) {
				$code = "210";
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>'33'));
				exit;
			}

			$type=1;
			$ctime = time();
			$status = 0;
			$ip = 0;
			#拼装
			$stime = strtotime($stime);
			$etime = strtotime($etime);
			$discount_data = array(
					'title' => $title,
					'stime' => $stime,
					'etime' => $etime,
					'body' => $body,
					'pics' => $pics,
					'has_pic' => $has_pic,
					'type' => $type,
					'status'=>$status,
					'ctime'=>$ctime,
					'mtime'=>$ctime,
					'ip'=>$ip,
					'uid' => $uid,
					'brand_id' => $brand_id,
					'shop_ids' => $shop_ids,
					'share_content'=>$share_content,
					'shop_type'=>$shop_type,
					);
			#入库
			$discount_id = $this->mo_discount->add_brand($discount_data);
			if (!$discount_id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($discount_id) && $discount_id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}
	}

	public function delete_discount_foradmin(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('mo_discount');
		$re = $this->mo_discount->delete(array('id' => $id));

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}
	

	public function recover_discount_foradmin(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('mo_discount');
		$re = $this->mo_discount->recover(array('id' => $id));

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

	public function getPingHtml(){
		$this->config->load('errorcode',TRUE);
		try{
			$shop_id = $this->input->get('shop_id', true, 0);
			$page = $this->input->get('page', true, 1);
			$pagesize = $this->input->get('pagesize', true, 50);
			$city_id = $this->input->get("city", true, 0);

			$shop_id = intval($shop_id);
			$page = intval($page);
			$pagesize = intval($pagesize);
			$city_id = intval($city_id);

			if(!$shop_id && !$city_id){
				$code = '201';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}

			$this->load->model("mo_shop");
			$this->load->model("mo_discount");
			$this->load->model("mo_geography");

			if($shop_id){
				$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
				$city_id = $shop_info['city'];
				$country_id = $shop_info['country'];
				$city_name = $this->mo_geography->get_name_by_id($city_id);
				$brand_infos = array();
				$discount_ids = $this->mo_discount->get_discount_ids_by_shopid($shop_id, $page, $pagesize);
				$total = $this->mo_discount->get_discount_cnt_by_shopid($country_id, $city_id, $shop_id);
			}else{
				$city_name = $this->mo_geography->get_name_by_id($city_id);
				$shop_ids = $this->mo_shop->get_shops_by_brand_property_city(0, 0, $city_id, 1, 1000);
				$discount_re = $this->mo_discount->get_discount_ids_by_shopids($shop_ids, $page, $pagesize);
				$discount_ids = $discount_re['list'];
				$total = $discount_re['count'];
				//$total = $this->mo_discount->get_discount_cnt_by_shopids($shop_ids);
			}
			$page_cnt = ceil($total / $pagesize);
			
			$discount_list_html = "";
			if($discount_ids){
				$discount_infos = $this->mo_discount->get_info_by_ids($discount_ids);
				$discount_data = array();
				foreach ($discount_infos as $key => $value) {
					$value['clean_body'] = strip_tags($value['body']);
					$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],40);
					if($value['pics']){
						$pics = $value['pics'];
						$value['pics_list'] = json_decode($pics, true);
					}
					$discount_infos[$key] = $value;
				}
				
				$discount_shop_infos = $this->mo_discount->get_discount_shop_info_by_discountid($discount_ids);
				
				$shop_ids = $brand_ids = $brand_infos = $shop_infos = array();
				foreach($discount_shop_infos as $key => $value) {
					if($value['brand_id']){
						$brand_ids[] = $value['brand_id'];
					}
					if($value['shop_id']){
						$shop_ids[] = $value['shop_id'];
					}
				}
				$this->load->model("mo_brand");
				$brand_infos = $this->mo_brand->get_brands_by_ids($brand_ids);
				
				if($shop_ids){
					$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
				}

				foreach ($discount_infos as $discount_id => $value) {
					$discount_infos[$discount_id]['brand_id'] = $discount_shop_infos[$discount_id]['brand_id'];
					$discount_infos[$discount_id]['brand_info'] = $discount_shop_infos[$discount_id];
					$discount_shop_info = array();
					if($shop_infos){
						if( $value['shop_id'] && isset($shop_infos[$value['shop_id']])){
							$discount_shop_info = $shop_infos[$value['shop_id']];
						}
					}
					$discount_infos[$discount_id]['shop_info'] = $discount_shop_info;
				
				}
				$discount_data['brand_infos'] = $brand_infos;
				$discount_data['discount_infos'] = $discount_infos;
				$discount_data['page_cnt'] = $page_cnt;
				$discount_data['page'] = $page;
				$discount_data['shop_id'] = $shop_id;
				$discount_data['city_id'] = $city_id;
				$discount_list_html = $this->load->view("template/discount_card", $discount_data, true);
				//$total = count($discount_ids);
				

			}

			

			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>$discount_list_html));
		
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	public function add_shoptips(){
		$this->config->load('errorcode',TRUE);
		try{

			$body = $this->input->post('body', true, '');
	
			$has_pic = $this->input->post('pics', true, 0);
			$level = $this->input->post('level', true, 1000);
			$title = $this->input->post('title', true, '');
			$title_mobile = $this->input->post('title_mobile', true, '');

			$stime = $this->input->post('stime', true, '');
			$etime = $this->input->post('etime', true, '');
			$share_content = $this->input->post('share_content', true, '');
			$status = $this->input->post('status', true, 0);

			if ($has_pic){
				$has_pic = 1;
			}else{
				$has_pic = 0;
			}
			$pics = $this->input->post('pics', true, '');
			if ($pics){
				$pics = json_encode(explode(",",$_POST['pics']));
			}else{
				$pics = '';
			}
			$country = $this->input->post('country', true, 0);
			if($country){
				$country = ",{$country},";
			}
			$city = $this->input->post('city', true, 0);
			if($city){
				$city = ",{$city},";
			}
			$shop_id = $this->input->post('shop_id', true, 0);
			//$user_info=$this->session->userdata('user_info');
			$this->config->load('env',TRUE);
			
			//if(!$user_info){
				//$code = '202';
				//echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				//exit;
			//}
			$this->load->model('mo_discount');
			#判断body是否重复
			//$uid = $user_info['uid'];
			$uid = 0;
			$last_body = $this->mo_discount->get_last_discount_by_uid($uid);
			
			if ($last_body && $last_body['body'] == $body) {
				$code = "210";
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>'33'));
				exit;
			}
			$type=2;
			$ctime = time();
			$ip = 0;
			#拼装
			$stime = strtotime($stime);
			$etime = strtotime($etime);
			$shoptips_data = array(
					'level' => $level,
					'title' => $title,
					'title_mobile' => $title_mobile,
					'stime' => $stime,
					'etime' => $etime,
					'body' => $body,
					'pics' => $pics,
					'has_pic' => $has_pic,
					'type' => $type,
					'status'=>$status,
					'ctime'=>$ctime,
					'mtime'=>$ctime,
					'ip'=>$ip,
					'uid' => $uid,
					'country'=>$country,
					'city'=>$city,
					'shop_id' => $shop_id,
					'share_content'=>$share_content,
					);
			
			#入库
			$discount_id = $this->mo_discount->add_shoptips($shoptips_data);
			if (!$discount_id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($discount_id) && $discount_id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}


	}


	

	public function getPingHtml_shoptips(){
		$this->config->load('errorcode',TRUE);
		try{
			$shop_id = $this->input->get('shop_id', true, 0);
			$page = $this->input->get('page', true, 1);
			$pagesize = $this->input->get('pagesize', true, 9);
			$city = $this->input->get("city", true, 0);

			$shop_id = intval($shop_id);
			$page = intval($page);
			$pagesize = intval($pagesize);
			$city = intval($city);
			
			$this->load->model("mo_shop");
			$this->load->model("mo_discount");
			$this->load->model("mo_geography");

			$shop_info = array();
			if ($shop_id) {
				$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
				$city = $shop_info['city'];
				$country_id = $shop_info['country'];
			}

			if($city){
				$city_info = $this->mo_geography->get_city_info_by_id($city);
				$city_name = $city_info['name'];
				$country_id = $city_info['country_id'];
			}
			
			$list = $this->mo_discount->get_info_by_shopid($country_id, $city, $shop_id, 2, $page, $pagesize);
			$total = $this->mo_discount->get_discount_cnt_by_shopid($country_id, $city, $shop_id, 2);
			$page_cnt = ceil($total/9);
			$discount_list_html = "";
			if($list){
				foreach ($list as $key => $value) {
					$value['clean_body'] = strip_tags($value['body']);
					$value['clean_body'] = $this->tool->substr_cn2($value['clean_body'],40);
					if($value['pics']){
						$pics = $value['pics'];
						$value['pics_list'] = json_decode($pics, true);
					}
					$list[$key] = $value;
				}

				$shoptips_data = array();
				$shoptips_data['list'] = $list;
				$shoptips_data['page'] = $page;
				$shoptips_data['page_cnt'] = $page_cnt;
				$shoptips_data['city'] = $city;
				$shoptips_data['city_id'] = $city;
				$shoptips_data['shop_id'] = $shop_id;
				$shoptips_list_html = $this->load->view("template/shoptips_list", $shoptips_data, true);
			}
			

			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>$shoptips_list_html));
		
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}


}


