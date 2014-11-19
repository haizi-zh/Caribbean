<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class dianping extends ZB_Controller {

	# http://zan.com/mobile/dianping/get_strategy?city_id=1
	#获取攻略
	public function get_strategy(){
		$city_id = $this->input->get("city_id", true, 0);
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		$page = $this->input->get("page", true, 1);
		$pagesize = $this->input->get("pagesize", true , 10);
		$this->load->model("mo_discount");
		$shop_id = 0;
		$this->load->model("mo_geography");
		$city_info = $this->mo_geography->get_city_info_by_id($city_id);
		

		$list = array();
		$total_number = 0;
		if ($city_info) {
			$country = $city_info['country_id'];
			$total_number = $this->mo_discount->get_discount_cnt_by_shopid($country, $city_id, $shop_id, 2);	
			$list = $this->mo_discount->get_info_by_shopid($country, $city_id, $shop_id, 2, $page, $pagesize);

			if ($list) {
				$tmp = array();
				$i=0;
				foreach ($list as $key => $value) {
					$strategy_info = array();
					$strategy_info['id'] = $value['id'];
					$strategy_info['title'] = $value['title'];
					$strategy_info['clean_body'] = $value['clean_body'];
					$strategy_info['pics'] = $value['pics'];
					$strategy_info['has_pic'] = $value['has_pic'];
					$tmp[$i] = $strategy_info;
					$i++;
				}
				$list = $tmp;
			}
		}
		
		$data['total_number'] = $total_number;
		$data['list'] = $list;
		
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
		return;
	}
	# http://zan.com/mobile/dianping/get_strategy_info?id=252
	public function get_strategy_info(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
			$id = $this->input->get('id', TRUE, 0);
			if(!$id){
				$code = '201';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit;
			}

			#获取点评信息
			$this->load->model('mo_discount');
			$dianping_info = $this->mo_discount->get_info_by_id($id);

			$re = array();
			if ($dianping_info) {
				$re['id'] = $dianping_info['id'];
				$re['body'] = $dianping_info['body'];
				$re['body'] = $this->tool->clear_jing($re['body']);
				$re['has_pic'] = $dianping_info['has_pic'];
				$re['pics'] = $dianping_info['pics'];
				$re['ctime'] = $dianping_info['ctime'];
			}
			#返回
			$code = '200';
			$this->config->load('errorcode',TRUE);
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>$re));
			
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}

	}

	# http://zan.com/mobile/dianping/del_dianping?id=2594
	public function del_dianping(){
		#当前登录用户是否是该页面的拥有者
		if(!isset($this->session->userdata['user_info']['uid']) ) {
			echo $this->mobile_json_encode(array('code'=>'201','msg'=>"请登录"));
			return ;
		}
		$dianping_id = $this->input->post('dianping_id', true, 0);
		
		if($dianping_id == FALSE) {
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>''));
			return ;
		}
		$login_uid = $this->session->userdata['user_info']['uid'];
		//
		$this->load->model("mo_dianping");
		$dianping_info = $this->mo_dianping->get_dianpinginfo_by_ids(array($dianping_id));
		if(!$dianping_info) {
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'无此点评信息'));
			return;
		}
		$dianping_uid = $dianping_info[$dianping_id]['uid'];
		if($dianping_uid == $login_uid) {
			//删除晒单，减去晒单数量
			$data = array();
			$data['dianping_id'] = $dianping_info[$dianping_id]['id'];
			$data['uid'] = $dianping_info[$dianping_id]['uid'];
			$data['shop_id'] = $dianping_info[$dianping_id]['shop_id'];
			$res = $this->mo_dianping->delete($data);
			if($res) {
				echo $this->mobile_json_encode(array('code'=>'200','msg'=>'删除成功'));
				return;
			}
		}
		echo $this->mobile_json_encode(array('code'=>'206','msg'=>'无删除权限'));
		return;
	}
	public function add_dianping(){
		$this->config->load('errorcode',TRUE);
		
		try{
			#获取参数
			$score = $this->input->post('score', true, 0);
			$body = $this->input->post('body', true, "");
			$pics = $this->input->post('pics', true, "");
			$has_pic = 0;
			if ($pics) {
				$has_pic = 1;
				$pics = $this->mobile_json_encode(explode(",",$_POST['pics']));
			}
			$shop_id = $this->input->post('shop_id', true, 0);

			$user_info=$this->session->userdata('user_info');
			$this->config->load('env',TRUE);
			
			if(!$user_info){
				$code = '202';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			$pics_post = $this->input->post('pics', true, "");
			if ($pics_post) {
				$pics_post = explode(",",$_POST['pics']);
				foreach ($pics_post as $key => $pic) {
					$body .= ' <img src="'.$pic.'!popup"> ';
				}
			}
			
			if($body == '' || $shop_id == 0){
				$code = '201';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			
			#拼装
			$dianpingdata = array(
					'score' => $score,
					'body' => $body,
					'pics' => $pics,
					'has_pic' => $has_pic,
					'score' => $score,
					'uid' => $user_info['uid'],
					'shop_id' => $shop_id,
					);
			
			#入库
			$this->load->model('mo_dianping');
			$dianping_id = $this->mo_dianping->add($dianpingdata);
			
			#返回
			$code = '200';
			$this->config->load('errorcode',TRUE);
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>array()));
			
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	# http://zan.com/mobile/dianping/get_dianpings_by_shop_id?shop_id=1
	public function get_dianpings_by_shop_id(){
		try{
			$this->load->model("mo_user");
			$this->load->model("mo_social");
			$this->load->model('mo_shop');
			#获取参数
			$shop_id = isset($_GET['shop_id'])?$_GET['shop_id']:0;
			$page = isset($_GET['page'])?$_GET['page']:1;
			$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:5;

			//$uid = $this->input->get("uid", true, 0);
			$user_info=$this->session->userdata('user_info');
			$uid = 0;
			if ($user_info && isset($user_info['uid'])) {
				$uid = $user_info['uid'];
			}

			$shop_id = $this->input->get("shop_id", true, 0);
			
			#获取商家信息
			//$this->load->model('mo_shop');
			//$dianping = $this->mo_shop->get_lastdianping_by_shopids(array($shop_id));

			$this->load->model("mo_dianping");
			$dianpings = $this->mo_dianping->get_dianpinginfo_by_shopid($shop_id, $page, $pagesize);
			$count = $this->mo_shop->get_dianping_cnt($shop_id);
			$re = array();
			if ($dianpings) {
				$uids = array();
				foreach ($dianpings as $key => $value) {
					$uids[] = $value['uid'];
				}
				$user_infos = $this->mo_user->get_simple_userinfos($uids);
				$attentions = array();
				if ($uid) {
					$attentions = $this->mo_social->check_attention_for_uids($uid, $uids);
				}
				$i=0;
				foreach ($dianpings as $key => $value) {
					$info = array();
					$info['id'] = $value['id'];
					$info['shop_id'] = $value['shop_id'];
					$info['score'] = $value['score'];
					$info['clean_body'] = $value['clean_body'];

					$info['pics'] = $this->format_pic($value['pics']);
					$info['has_pic'] = $value['has_pic'];
					$info['uid'] = $value['uid'];

					$tmp_userinfo = $user_infos[$value['uid']];
					$user_info = array();
					$user_info['uid'] = $tmp_userinfo['uid'];
					$user_info['uname'] = $tmp_userinfo['uname'];
					$user_info['image'] = $tmp_userinfo['image'];
					$is_attention = 0;
					if ($attentions && isset($attentions[$value['uid']])) {
						$is_attention = 1;
					}
					$user_info['is_attention'] = $is_attention;
					$info['user_info'] = $user_info;
					$re[$i] = $info;
					$i++;
				}
			}

			$data['list'] = $re;
			$data['total_number'] = $count;
			
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	# http://zan.com/mobile/dianping/get_dianpings_by_to_uid?to_uid=1372887815
	public function get_dianpings_by_to_uid(){
		try{
			$this->load->model("mo_user");
			$this->load->model("mo_social");

			$page = isset($_GET['page'])?$_GET['page']:1;
			$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;

			//$uid = $this->input->get("uid", true, 0);
			$user_info=$this->session->userdata('user_info');
			$uid = 0;
			if ($user_info && isset($user_info['uid'])) {
				$uid = $user_info['uid'];
			}

			$shop_id = $this->input->get("shop_id", true, 0);
			$to_uid = $this->input->get("to_uid", true, 0);
			#获取商家信息
			//$this->load->model('mo_shop');
			//$dianping = $this->mo_shop->get_lastdianping_by_shopids(array($shop_id));

			$this->load->model("mo_dianping");
			
			$dianping_ids = $this->mo_dianping->get_dianpingids_by_uid($to_uid, $page, $pagesize);
			$dianpings = $this->mo_dianping->get_dianpinginfo_by_ids($dianping_ids);
			$count = $this->mo_user->get_dianping_cnt_by_uid($to_uid);

			$re = array();
			if ($dianpings) {
				$uids = array();
				foreach ($dianpings as $key => $value) {
					$uids[] = $value['uid'];
				}
				$user_infos = $this->mo_user->get_simple_userinfos($uids);
				$attentions = array();
				if ($uid) {
					$attentions = $this->mo_social->check_attention_for_uids($uid, $uids);
				}
				$i=0;

				$shop_ids = array();
				foreach ($dianpings as $key => $value) {
					$shop_ids[] = $value['shop_id'];
				}
				$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
				foreach ($dianpings as $key => $value) {
					$info = array();
					$info['id'] = $value['id'];
					$info['shop_id'] = $value['shop_id'];
					$shop_name = "";
					if (isset($shop_infos[$value['shop_id']])) {
						$shop_name = $shop_infos[$value['shop_id']]['name'];
					}
					$info['shop_name'] = $shop_name;
					$info['score'] = $value['score'];
					$info['clean_body'] = $value['clean_body'];
					$info['pics'] = $this->format_pic($value['pics']);
					$info['has_pic'] = $value['has_pic'];
					$info['uid'] = $value['uid'];

					$tmp_userinfo = $user_infos[$value['uid']];
					$user_info = array();
					$user_info['uid'] = $tmp_userinfo['uid'];
					$user_info['uname'] = $tmp_userinfo['uname'];
					$user_info['image'] = $tmp_userinfo['image'];
					$is_attention = 0;
					if ($attentions && isset($attentions[$value['uid']])) {
						$is_attention = 1;
					}
					$user_info['is_attention'] = $is_attention;
					$info['user_info'] = $user_info;
					$re[$i] = $info;
					$i++;
				}
			}

			$data['list'] = $re;
			$data['total_number'] = $count;
			
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	# http://zan.com/mobile/dianping/get_dianpings_my_friends
	public function get_dianpings_my_friends(){
		try{
			$this->load->model("mo_user");
			$this->load->model("mo_social");
			$this->load->model("mo_shop");
			$this->load->model("mo_discount");
			#获取参数
			$page = isset($_GET['page'])?$_GET['page']:1;
			$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;

			//$uid = $this->input->get("uid", true, 0);
			$user_info=$this->session->userdata('user_info');
			$uid = 0;
			if ($user_info && isset($user_info['uid'])) {
				$uid = $user_info['uid'];
			}

			#获取商家信息
			//$this->load->model('mo_shop');
			//$dianping = $this->mo_shop->get_lastdianping_by_shopids(array($shop_id));


			$this->load->model("mo_dianping");
			$count = $this->mo_social->get_user_feed_cnt($uid);
			$dianping_ids = $this->mo_social->get_user_feed($uid, $page, $pagesize);
			$dianpings = $this->mo_dianping->get_dianpinginfo_by_ids($dianping_ids);

			$re = array();
			$i=0;


			/*
			
			$shop_ids = $this->mo_shop->get_attention_shop($uid);
			$discount_ids = $discount_infos = array();

			if($shop_ids){
				$discount_list = $this->mo_discount->get_discount_ids_by_shopids($shop_ids,1,200);
				$discount_count = $this->mo_discount->get_discount_cnt_by_shopids($shop_ids);
				
				var_dump($discount_list);
				$offset = ($page - 1) * 3;
				if($discount_count > $offset){
					$discount_ids = array_slice($discount_list, $offset, 3, true);
				}
				$discount_infos = $this->mo_discount->get_info_by_ids($discount_ids);
			}
			var_dump($discount_infos);
			
			if ($discount_ids) {
				foreach ($discount_ids as $key => $discount_id) {
					$info = array();
					$info['id'] = $value['id'];
					$info['shop_id'] = $value['shop_id'];
					$shop_name = "";
					if (isset($shop_infos[$value['shop_id']])) {
						$shop_name = $shop_infos[$value['shop_id']]['name'];
					}
					$info['shop_name'] = $shop_name;
					
					$info['score'] = $value['score'];
					$info['clean_body'] = $value['clean_body'];
					$info['pics'] = $this->format_pic($value['pics']);
					$info['has_pic'] = $value['has_pic'];
					$info['uid'] = $value['uid'];

					$tmp_userinfo = $user_infos[$value['uid']];
					$user_info = array();
					$user_info['uid'] = $tmp_userinfo['uid'];
					$user_info['uname'] = $tmp_userinfo['uname'];
					$user_info['image'] = $tmp_userinfo['image'];
					$is_attention = 0;
					if ($attentions && isset($attentions[$value['uid']])) {
						$is_attention = 1;
					}
					$user_info['is_attention'] = $is_attention;
					$info['user_info'] = $user_info;
					$re[$i] = $info;
					$i++;
				}
			}
			*/

			if ($dianpings) {
				$uids = array();
				foreach ($dianpings as $key => $value) {
					$uids[] = $value['uid'];
				}
				$user_infos = $this->mo_user->get_simple_userinfos($uids);
				$attentions = array();
				if ($uid) {
					$attentions = $this->mo_social->check_attention_for_uids($uid, $uids);
				}
				
				$shop_ids = array();
				foreach ($dianpings as $key => $value) {
					$shop_ids[] = $value['shop_id'];
				}
				$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);

				foreach ($dianpings as $key => $value) {
					$info = array();
					$info['id'] = $value['id'];
					$info['shop_id'] = $value['shop_id'];
					$shop_name = "";
					if (isset($shop_infos[$value['shop_id']])) {
						$shop_name = $shop_infos[$value['shop_id']]['name'];
					}
					$info['shop_name'] = $shop_name;
					
					$info['score'] = $value['score'];
					$info['clean_body'] = $value['clean_body'];
					$info['pics'] = $this->format_pic($value['pics']);
					$info['has_pic'] = $value['has_pic'];
					$info['uid'] = $value['uid'];

					$tmp_userinfo = $user_infos[$value['uid']];
					$user_info = array();
					$user_info['uid'] = $tmp_userinfo['uid'];
					$user_info['uname'] = $tmp_userinfo['uname'];
					$user_info['image'] = $tmp_userinfo['image'];
					$is_attention = 0;
					if ($attentions && isset($attentions[$value['uid']])) {
						$is_attention = 1;
					}
					$user_info['is_attention'] = $is_attention;
					$info['user_info'] = $user_info;
					$re[$i] = $info;
					$i++;
				}
			}

			$data['list'] = $re;
			$data['total_number'] = $count;
			
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	#根据商家id，获取最新的晒单
	public function get_dianpings(){
		try{
			$this->load->model("mo_user");
			$this->load->model("mo_social");
			#获取参数
			$shop_id = isset($_GET['shop_id'])?$_GET['shop_id']:0;
			$page = isset($_GET['page'])?$_GET['page']:1;
			$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;

			//$uid = $this->input->get("uid", true, 0);
			$user_info=$this->session->userdata('user_info');
			$uid = 0;
			if ($user_info && isset($user_info['uid'])) {
				$uid = $user_info['uid'];
			}

			$shop_id = $this->input->get("shop_id", true, 0);
			$to_uid = $this->input->get("");
			#获取商家信息
			//$this->load->model('mo_shop');
			//$dianping = $this->mo_shop->get_lastdianping_by_shopids(array($shop_id));

			$this->load->model("mo_dianping");
			$dianpings = $this->mo_dianping->get_dianpinginfo_by_shopid($shop_id, $page, $pagesize);

			$re = array();
			if ($dianpings) {
				$uids = array();
				foreach ($dianpings as $key => $value) {
					$uids[] = $value['uid'];
				}
				$user_infos = $this->mo_user->get_simple_userinfos($uids);
				$attentions = array();
				if ($uid) {
					$attentions = $this->mo_social->check_attention_for_uids($uid, $uids);
				}
				$i=0;
				foreach ($dianpings as $key => $value) {
					$info = array();
					$info['id'] = $value['id'];
					$info['shop_id'] = $value['shop_id'];
					$info['score'] = $value['score'];
					$info['clean_body'] = $value['clean_body'];
					$info['pics'] = $this->format_pic($value['pics']);
					$info['has_pic'] = $value['has_pic'];
					$info['uid'] = $value['uid'];

					$tmp_userinfo = $user_infos[$value['uid']];
					$user_info = array();
					$user_info['uid'] = $tmp_userinfo['uid'];
					$user_info['uname'] = $tmp_userinfo['uname'];
					$user_info['image'] = $tmp_userinfo['image'];
					$is_attention = 0;
					if ($attentions && isset($attentions[$value['uid']])) {
						$is_attention = 1;
					}
					$user_info['is_attention'] = $is_attention;
					$info['user_info'] = $user_info;
					$re[$i] = $info;
					$i++;
				}
			}

			$count = 100;
			$data['list'] = $re;
			$data['total_number'] = $count;
			
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	public function get_comment_info(){

	}
	# http://zan.com/mobile/dianping/get_dianping_info?id=489
	public function get_dianping_info(){
		$this->config->load('errorcode',TRUE);
		$this->load->model("mo_comment");
		try{
			#获取参数
			$id = $this->input->get('id', TRUE, 0);
			if(!$id){
				$code = '201';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit;
			}

			#获取点评信息
			$this->load->model('mo_dianping');
			$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($id);

			$re = array();
			if ($dianping_info) {
				$re['id'] = $dianping_info['id'];
				$re['score'] = $dianping_info['score'];
				$body = $dianping_info['body'];
				if($body){
					$pics = $dianping_info['pics'];
					$pics_list = json_decode($pics, true);
					if($pics_list){
						foreach($pics_list as $v){
							$tmp['"'.$v.'"'] = '"'.$v.'!pingpreview"';
						}
						foreach($pics_list as $v){
							$tmp2["'".$v."'"] = "'".$v."!pingpreview'";
						}
						$body = str_replace(array_keys($tmp), array_values($tmp), $body);
						$body = str_replace(array_keys($tmp2), array_values($tmp2), $body);
					}
					$body = str_replace("!popup", "!pingpreview", $body);
				}
				$re['body'] = $body;
				$re['has_pic'] = $dianping_info['has_pic'];
				$re['pics'] = $this->format_pic($dianping_info['pics']);


				$re['ctime'] = $dianping_info['ctime'];
				$re['shop_id'] = $dianping_info['shop_id'];

				//$re['mobile_image'] = $dianping_info['mobile_image'];
				//$re['mobile_image'] = "http://zanbai.b0.upaiyun.com/dianping/678a1491514b7f1006d605e9161946b1.jpg";


				$comment_total = $this->mo_comment->get_comment_cnt_by_dianping($id, 0);
				$comment_list = $this->mo_comment->get_commentinfo_by_dianpingid($id, 0, 1, 10);
				$comments['total_number'] = $comment_total;
				$comments['list'] = $comment_list;
				$re['comments'] = $comments;
				//var_dump($re);

			}
			#返回
			$code = '200';
			$this->config->load('errorcode',TRUE);
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>$re));
			
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}

	}

	public function get_dianping(){
		$this->config->load('errorcode',TRUE);
		
		try{
			#获取参数
			$uid = $this->input->get('uid', TRUE);
			$page = $this->input->get('page', TRUE);
			$pagesize = $this->input->get('pagesize', TRUE);
			
			if(!$uid){
				$code = '201';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit;
			}
			
			if(!$page) $page = 1;
			if(!$pagesize) $pagesize = 10;
			
			#获取点评信息
			$this->load->model('mo_dianping');
			$ids = $this->mo_dianping->get_dianpingids_by_uid($uid,$page,$pagesize);
			$dianpings = array();
			if($ids) $dianpings = $this->mo_dianping->get_dianpinginfo_by_ids($ids);			
			
			#返回
			$code = '200';
			$this->config->load('errorcode',TRUE);
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>$dianpings));
			
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	public function add_comment(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
			$user_info=$this->session->userdata('user_info');
			$uid = $user_info['uid'];
			$dianping_id = $this->input->post('dianping_id', true, 0);
			$this->load->model("mo_dianping");
			$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($dianping_id);
			$shop_id = 0;
			if ($dianping_info && isset($dianping_info['shop_id'])) {
				$shop_id = $dianping_info['shop_id'];
			}
			$content = $this->input->post('body', true, '');
			$ocid = $this->input->post('ocid', true, 0);
			$this->config->load('env',TRUE);
			if(!$user_info){
				$code = '202';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit;
			}
			$comment_data = array(
					'uid' => $uid,
					'shop_id' => $shop_id,
					'dianping_id' => $dianping_id,
					'content' => $content,
					'reserve_1' => $ocid,
			);
			$this->load->model('mo_comment');
			$comment_id = $this->mo_comment->add($comment_data);
			$code = 200;
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>array()));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	public function del_comment(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
			$user_info=$this->session->userdata('user_info');
			$uid = $user_info['uid'];
			$comment_id = $this->input->post('comment_id', true, 0);
			$this->load->model("mo_comment");
			$comment_info = $this->mo_comment->get_comment_by_id($comment_id);
			if(!$user_info){
				$code = '202';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit;
			}
			if (!$comment_info || $comment_info['uid'] != $uid) {
				echo $this->mobile_json_encode(array('code'=>201,'msg'=>$this->config->item($code,'errorcode')));
				exit;
			}
			$re = $this->mo_comment->delete($comment_id);
			$code = 200;
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>array()));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	# http://zan.com/mobile/dianping/create_image
	public function create_image(){
		$save_path =  FCPATH.'tmp/ss2.jpg';
		$this->load->library("common/image");
		$yp_path = $this->image->upload_dianping_image( $save_path, 1127 );
		var_dump($yp_path);
		die;
		$this->load->model("mo_dianping");
		$id = 1127;
		$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($id);
		$body = $dianping_info['body'];
		$pics = $dianping_info['pics'];
		$this->_image2($body, $pics);
	}

	

	# http://zan.com/mobile/basic/image2
	public function _image2($body, $pics){
		set_time_limit(600);
		ini_set('memory_limit', '1G');

		$explode = "8c5f5ccda43f1b2d3c73e785c5055126";
		preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', $body, $out);
		$format_body = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', $explode, $body);
		$re = array();
		$i=0;

		if($out[0]){
			$list = explode($explode, $format_body);
			$out0 = $out[0];
			$out2 = $out[2];
			$image_count = count($out2);
			$count_list = count($list);
			
			foreach ($list as $key => $value) {
				$value = $this->tool->clean_all_2($value, 0);
				$re[] = array('txt'=>$value);

				if(isset($out2[$key]) && $i < 10){
					$img_str = $out2[$key];
					$img_str = str_replace("popup", "pingbody", $img_str);
					$re[] = array('img' => $img_str);
					$i++;
				}
			}
		}else{
			$tmp = $this->tool->clean_all_2($body, 0);
			$re[] = array('txt'=>$tmp);
		}

		$re[] = array('txt'=>"更多图片信息请查看 www.zanbai.com                 ZANBAI出境购物指南全球百货攻略");
		$re[] = array('txt'=>"");

		$dele_file_paths = array();
		$img_path = array();
		$imgs = array();
		foreach($re as $k => $v){
			if (isset($v['txt'])) {
				if(!$v['txt']){
					continue;
				}
				$img = new text2img();
				$str = $v['txt'];
				$file_path = md5($k.$str);
				$file_path = FCPATH.'tmp/'.$file_path.'.jpg';
				$img->text2Img($str, $file_path);
				unset($img);
				$re[$k]['img'] = $file_path;
				$imgs[] = $file_path;

				$dele_file_paths[] = $file_path;
			}else{
				$imgs[] = $v['img'];
			}
		}

		$target = FCPATH.'images/ss.jpg';//背景图片
		$dele_file_paths[] = $target;
		$source = array();
		$height = 0;
		foreach ($imgs as $k=>$v){
			$source[$k]['source'] = Imagecreatefromjpeg($v);
			$source[$k]['size'] = getimagesize($v);
			$height += $source[$k]['size'][1];
		}
		$height += 30;
		$width = 440;

		$target_img = ImageCreateTrueColor($width, $height);
		$white = ImageColorAllocate ($target_img, 255, 255, 255);
		ImageFill($target_img, 0, 0, $white);
		$re = Imagejpeg($target_img, $target);
		
		$target_img = Imagecreatefromjpeg($target);

		$num1=0;
		$num=1;
		$tmp=2;
		$tmpy=5;//图片之间的间距
		$leng = count($source);
		for ($i=0; $i<$leng; $i++){
			imagecopy($target_img,$source[$i]['source'],$tmp,$tmpy,0,0, $width, $source[$i]['size'][1]);
			$tmp = $tmp + $source[$i]['size'][0];

			$tmp = $tmp + 5;
			//if($i==$num){
				$tmpy = $tmpy + $source[$i]['size'][1];
				$tmpy = $tmpy + 2;
				
				$tmp=2;
				$num=$num+3;
			//}
		}
		
		$save_path =  FCPATH.'tmp/ss2.jpg';
		$re = Imagejpeg($target_img, $save_path);

		if($dele_file_paths){
			foreach ($dele_file_paths as $key => $file) {
				unlink($file);
			}
		}
		$this->load->library("common/image");
		$yp_path = $this->image->upload_dianping_image( $save_path );
		var_dump($yp_path);
		return FCPATH.'tmp/ss2.jpg';
	}


	public function format_pic($pics){
		if(!$pics){
			return $pics;
		}
		
		$tmp = json_decode($pics, true);
		
		foreach ($tmp as $key => $value) {
			$tmp[$key] = $value."!pingpreview";
		}

		$pics = json_encode($tmp);
		return $pics;
					
	}

}





