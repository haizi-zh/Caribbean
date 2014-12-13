<?php
#社交操作类
class Mo_social extends CI_Model {

	const FEED_SIZE = 200;
	
	#关注关系
	const NO_RELATION = 0;
	const ATTENTION = 1;
	const MYSELF = 2;
	
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_attention_user');
		$this->load->model('do/do_feed_user');
	}

	public function update_user_feed($uid, $to_uid){
		
		$this->load->model("mo_dianping");
		
		$follows = $this->do_attention_user->get_attentions($uid);

		$follows_uids = array();

		if($follows){
			foreach ($follows as $key => $value) {
				$follows_uids[$value->to_uid] = $value->to_uid;
			}
		}
		
		#获取关注人的点评列表
		
		$follows_uids = array_unique($follows_uids);
		$dianping_ids = $this->mo_dianping->get_dianpingids_by_uids($follows_uids);
		
		$re = $this->do_feed_user->get_user_feed($uid);
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		
		#如果之前没有feed
		if(empty($format_re)){
			$data = array();
			$data['uid'] = $uid;
			$data['ping_id'] = '';
			$this->do_feed_user->add_user_feed($data);
		}
		/*
		$ori_content = array();
		if($format_re && $format_re[0] && json_decode($format_re[0]['content'], true)){
			$ori_content = json_decode($format_re[0]['content'], true); #获取原feed数组
		}
		var_dump($ori_content);die;
		$content = array_merge($dianping_ids,$ori_content); #插入新内容
		$content = array_unique($content);
		*/
		$content = $dianping_ids;
		if(count($content) > self::FEED_SIZE){ #如果大于上限
			$re = array_chunk($content,self::FEED_SIZE);
			$content = $re[0];
		}

		$this->do_feed_user->update_user_feed($uid,json_encode($content));
		
	}
	public function check_attention($from_uid, $to_uid){
		return $this->do_attention_user->check_attention($from_uid, $to_uid);
	}
	#添加一个关注
	function add_user_attention($from_uid,$to_uid){
		$exist = $this->check_attention($from_uid, $to_uid);
		if($exist){
			return $exist;
		}
		return $this->do_attention_user->add_user_attention(array('from_uid'=>$from_uid,'to_uid'=>$to_uid));
	}

	function del_user_attention($from_uid,$to_uid){
		return $this->do_attention_user->del_user_attention(array('from_uid'=>$from_uid,'to_uid'=>$to_uid));
	}

	#获取一个人的粉丝列表
	function get_fans($uid){
		$re = $this->do_attention_user->get_fans($uid);
		
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		
		$fans = array();
		foreach($format_re as $each){
			$fans[] = $each['from_uid'];
		}
		
		return $fans;
	}
	
	#获取一个人的关注列表
	function get_attentions($uid){
		$re = $this->do_attention_user->get_attentions($uid);
	
		#格式化成数组
		$format_re = $this->tool->std2array($re);
	
		$attentions = array();
		foreach($format_re as $each){
			$attentions[] = $each['to_uid'];
		}
	
		return $attentions;
	}
	
	#某人发点评，为其粉丝更新索引
	function update_fans_ping($uid,$ping_id){
		$fans = self::get_fans($uid);
		foreach($fans as $uid){
			self::update_user_ping($uid, $ping_id);
		}		
	}
	
	#为一个用户更新feed
	function update_user_ping($uid,$ping_id){
		#获取用户的feed
		$re = $this->do_feed_user->get_user_feed($uid);
		
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		#如果之前没有feed
		if(empty($format_re)){
			$data = array();
			$data['uid'] = $uid;
			$data['ping_id'] = $ping_id;
			$this->do_feed_user->add_user_feed($data);
		}else{#如果有feed，则插入
			$ori_content = json_decode($format_re[0]['content'], true); #获取原feed数组
			if($ori_content == null){
				$ori_content = array();
			}
			$content = array_merge(array($ping_id),$ori_content); #插入新内容
			if(count($content) > self::FEED_SIZE){ #如果大于上限
				$re = array_chunk($content,self::FEED_SIZE);
				$content = $re[0];
			}
			$this->do_feed_user->update_user_feed($uid,json_encode($content));
		}
	}
	
	#获取用户的feed列表
	function get_user_feed($uid,$page=1,$pagesize=10){
		#获取用户的feed
		$re = $this->do_feed_user->get_user_feed($uid);
		
		#格式化成数组
		$re = $this->tool->std2array($re);
		
		#取出结果
		if(isset($re[0]['content'])){
			$contents = json_decode($re[0]['content'], true);
		}else{
			return array();
		}
		
		#根据page pagesize分割
		$chunk = array_chunk($contents,$pagesize);
		if (isset($chunk[$page-1])) {
			return $chunk[$page-1];
		}
		return array();
	}
	
	#获取用户的feed计数
	function get_user_feed_cnt($uid){
		#获取用户的feed
		$re = $this->do_feed_user->get_user_feed($uid);
		#格式化成数组
		$re = $this->tool->std2array($re);
		
		#取出结果
		if(isset($re[0]['content'])){
			$contents = json_decode($re[0]['content'], true);
			return count($contents);
		}else{
			return 0;
		}
	}
	
	#获取某用户和登录用户的关注关系
	function get_relation($uid){
		if(!isset($this->session->userdata['user_info']['uid'])) return self::NO_RELATION;
		elseif($this->session->userdata['user_info']['uid'] == $uid) return self::MYSELF;
		else{
			$re = $this->do_attention_user->check_attention($this->session->userdata['user_info']['uid'],$uid);
		
			if(!empty($re)) return self::ATTENTION;
			else return self::NO_RELATION;
		}
	}
	
	function check_attention_for_uids($uid, $to_uids){
		$re = $this->do_attention_user->check_attention_for_uids($uid,$to_uids);
		return $re;
	}
	#获取粉丝数
	function get_fans_cnt($uid){
		$re = $this->do_attention_user->get_fans_cnt($uid);
		
		#格式化成数组
		$re = $this->tool->std2array($re);
	
		return $re?$re[0]['count(*)']:0;
	}
	
	#获取关注数
	function get_attention_cnt($uid){
		$re = $this->do_attention_user->get_attention_cnt($uid);
		
		#格式化成数组
		$re = $this->tool->std2array($re);
		
		return $re?$re[0]['count(*)']:0;
	}
}



