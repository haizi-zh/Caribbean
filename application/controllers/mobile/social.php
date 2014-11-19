<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class social extends ZB_Controller {
		
	# http://zan.com/mobile/social/get_frends?page=1
	public function get_frends(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;

		$user_info=$this->session->userdata('user_info');
		if(!$user_info){
			$code = '202';
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>''));
			exit;
		}
		$uid = $user_info['uid'];
		
		$this->load->model('mo_social');
		$this->load->model('mo_user');
		$fans = $this->mo_social->get_fans($uid); 
		$attentions = $this->mo_social->get_attentions($uid);

		$friends = array_merge($fans, $attentions);
		$friends = array_unique($friends);

		$intersect = array_intersect($fans, $attentions);
		//var_dump($fans, $attentions, $friends);
		$list = array();
		$list = $this->mo_user->get_simple_userinfos($friends);
		$offset = ($page - 1) * $pagesize;
		$list = array_slice($list, $offset, $pagesize, true);

		if ($list) {
			$i = 0;
			$tmp =  array();
			foreach($list as $key => $value){
				$tmp[$i] = $value;
				$i++;
			}
			$list = $tmp;
			foreach($list as $key => $value){
				$relation = 0;
				if (in_array($value['uid'], $intersect)) {
					$relation = 2;
				}elseif(in_array($value['uid'], $attentions)){
					$relation = 1;
				}
				$list[$key]['relation'] = $relation;
			}
		}


		$data['total_number'] = count($friends);
		$data['list'] = $list;
		
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
	}



	public function get_user_feed(){

		try{
			#获取参数
			$user_info=$this->session->userdata('user_info');
			$page = isset($_GET['page'])?$_GET['page']:1;
			$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;

			$dianping_ids = array();
			$this->load->model('mo_social');
			$this->load->model('mo_dianping');
			$this->load->model('do/do_dianping');

			if($user_info){ # 如果登陆，返回feed
				$uid = $user_info['uid'];
				$dianping_ids = $this->mo_social->get_user_feed($uid,$page,$pagesize);
				if (!$dianping_ids){
					$data = array('dianping'=> array());
					echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
					exit;
				}
			}else{
				$last_dianping_re = $this->do_dianping->get_last_dianping($page, $pagesize);
				$format_re = $this->tool->std2array($last_dianping_re);
				foreach($format_re as $each){
					$dianping_ids[] = $each['id'];
				}
			}
			
			#获取品牌
			$dianping_infos = $this->mo_dianping->get_dianpinginfo_by_ids($dianping_ids);
			
			#去掉key
			$dianpings = array();
			$dianpings = $dianping_infos;
			$this->load->model("mo_user");
			$this->load->model("mo_comment");
			$uids = array();

			foreach ($dianping_infos as $key => $value) {
				$uids[] = $value['uid'];
			}
			
			$user_infos = $this->mo_user->get_simple_userinfos($uids);
			$dianping_comment_cnts = $this->mo_comment->get_comment_cnts_by_dianpings($dianping_ids, 0);

			foreach ($dianpings as $key => $value) {
				$dianping_id = $value['id'];
				$dianpings[$dianping_id]['user'] = $user_infos[$value['uid']];

				$dianpings[$dianping_id]['comment']['total'] = $dianping_comment_cnts[$dianping_id];
				$comment_list = $this->mo_comment->get_commentinfo_by_dianpingid($dianping_id, 0, 1, 5);
				$dianpings[$dianping_id]['comment']['list'] = $comment_list;
			}
			$tmp = array();
			foreach($dianpings as $dianping){
				$tmp[] = $dianping;
			}
			$dianpings = $tmp;

			$re['dianping'] = $dianpings;

			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$re));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}

	}	
	# http://zan.com/mobile/social/attention_del?type=add
	public function attention_del(){
		$data = array();
		$this->load->model("mo_social");
		$to_uid = $this->input->post("to_uid", true, "");

		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		if ($uid && $shop_id) {
			$re = $this->mo_social->del_user_attention($uid,$to_uid);

		}
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
	}

	# http://zan.com/mobile/social/attention_add
	public function attention_add(){
		$data = array();
		$this->load->model("mo_social");
		$to_uid = $this->input->post("to_uid", true, "");
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		if ($uid && $to_uid) {
			$re = $this->mo_social->add_user_attention($uid,$to_uid);
		}
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
	}

	public function attention(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
			$user_info=$this->session->userdata('user_info');
			if(!$user_info){
				$code = '202';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			
			$uid = $user_info['uid'];
			$to_uid = $this->input->post('to_uid', true, 0);
			$type = $this->input->post('type', true, 'add');
			if(!$to_uid){
				$code = '201';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			
			$this->load->model('mo_social');
			if ($type == 'add') {
				$re = $this->mo_social->add_user_attention($uid,$to_uid);
			}else{
				$re = $this->mo_social->del_user_attention($uid,$to_uid);
			}
			
			#返回
			$code = '200';
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>array()));
		
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}