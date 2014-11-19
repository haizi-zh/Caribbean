<?php
#评论操作类
class Mo_comment extends ZB_Model {
	const CACHA_TIME = 86400;
	const KEY_DIANPING_COMMENT_CNT = "%s_1_%s";

	function __construct(){
		parent::__construct();
		$this->load->model('do/do_comment');
	}

	#添加一个评论
	public function add($data){
		#插入评论
		$re = $this->do_comment->add($data);
		if($re){
			$dianping_id = $data['dianping_id'];
			$type = $data['type'];
			$this->get_comment_cnt_by_dianping($dianping_id, $type, true);
		}
		return $re;
	}		
	
	#删除一个评论
	public function delete($comment_id){
		$comment_info = $this->get_comment_by_id($comment_id);
		if($comment_info){
			$dianping_id = $comment_info['dianping_id'];
			$type = $comment_info['type'];
			$this->get_comment_cnt_by_dianping($dianping_id, $type, true);
		}
		return $this->do_comment->delete($comment_id);
	}
	#恢复一个评论
	public function recover($comment_id){
		$comment_info = $this->get_comment_by_id($comment_id);
		if($comment_info){
			$dianping_id = $comment_info['dianping_id'];
			$type = $comment_info['type'];
			$this->get_comment_cnt_by_dianping($dianping_id, $type, true);
		}
		return $this->do_comment->recover($comment_id);
	}


	#根据商家id获取点评信息
	public function get_commentinfo_by_dianpingid($dianpingid, $type=0, $page=1,$pagesize=10){
		if(!$dianpingid){
			return array();
		}
		#从do层获取结果
		$re = $this->do_comment->get_commentinfo_by_dianpingid($dianpingid, $type, $page,$pagesize);
		
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		
		#加入评论原作者信息
		foreach($format_re as $k=>$comment){
			#获取原点评id
			$ocid = $comment['reserve_1'];
			

			$ori_comment = self::get_comment_by_ids(array($ocid));

			$comment_uid = $comment['uid'];
			$user_info = $this->mo_user->get_simple_userinfos(array($comment_uid));
			$comment['user'] = $user_info[$comment_uid];

			#加入原点评作者信息
			if(isset($ori_comment[$ocid])){
				$ouid = $ori_comment[$ocid]['uid'];
				$this->load->model('mo_user');
				$ouser = $this->mo_user->get_simple_userinfos(array($ouid));
				$comment['ouser'] = $ouser[$ouid];
			}

			$format_re[$k] = $comment;
		}
		
		return $format_re;
	}
	
	#根据商家id获取回复条数 KEY_DIANPING_COMMENT_CNT
	public function get_comment_cnt_by_dianping($dianpingid, $type=0, $unset_cache = false){
		if(!$dianpingid){
			return 0;
		}
		if(!$unset_cache){
			$re = $this->get_simple_cache(self::KEY_DIANPING_COMMENT_CNT, "mo_comment", array($dianpingid), self::CACHA_TIME);
			if($re !== false){
				return $re;
			}
		}

		#从do层获取结果
		$re = $this->do_comment->get_comment_cnt_by_dianping($dianpingid, $type);
		$this->get_simple_cache(self::KEY_DIANPING_COMMENT_CNT, "mo_comment", array($dianpingid), self::CACHA_TIME, $re);

		return $re;
	}


	
	public function get_comment_cnts_by_dianpings($dianping_ids, $type=0){
		if(!$dianping_ids || !is_array($dianping_ids)){
			return array();
		}
		#从do层获取结果
		$re = $this->do_comment->get_comment_cnts_by_dianpings($dianping_ids, $type);
		
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		$tmp = array();
		foreach ($format_re as $key => $value) {
			$tmp[$value['dianping_id']] = $value['cnt'];
		}
		
		$re = array();
		foreach ($dianping_ids as $key => $dianping_id) {
			$re[$dianping_id] = 0;
			if (isset($tmp[$dianping_id])) {
				$re[$dianping_id] = $tmp[$dianping_id];
			}
		}

		return $re;
	}

	public function get_comment_by_id($id){
		if(!$id){
			return array();
		}
		$id = intval($id);
		$re = $this->get_comment_by_ids(array($id));
		if (isset($re[$id])) {
			return $re[$id];
		}
		return array();
	}
	
	#根据id批量获取回复信息
	public function get_comment_by_ids($ids){
		if(!$ids||!is_array($ids)){
			return array();
		}
		$format_re = $this->do_comment->get_comment_by_ids($ids);
		
		$re = array();

		#加入评论原作者信息
		foreach($format_re as $k=>$comment){
			#获取原点评id
			$ocid = $comment['reserve_1'];
			$ori_comment = self::get_comment_by_ids(array($ocid));
			$comment_uid = $comment['uid'];
			$user_info = $this->mo_user->get_simple_userinfos(array($comment_uid));
			$comment['user'] = $user_info[$comment_uid];
			#加入原点评作者信息
			if(isset($ori_comment[$ocid])){
				$ouid = $ori_comment[$ocid]['uid'];
				$this->load->model('mo_user');
				$ouser = $this->mo_user->get_simple_userinfos(array($ouid));
				$comment['ouser'] = $ouser[$ouid];
			}

			$re[$comment['id']] = $comment;
		}

		arsort($re);
		return $re;
	}
	
	#根据回复id批量渲染(准备废弃)
	private function render_comment($ids){
		if(!$ids||!is_array($ids)){
			return array();
		}
		#获取回复信息
		$comments_info = self::get_comment_by_ids($ids);
	
		#获取用户信息
		$uids = array();
		foreach($comments_info as $comment){
			$uids[] = $comment['uid'];
		}
		$this->load->model('mo_user');
		$userinfos_re = $this->mo_user->get_simple_userinfos($uids);
	
		$html = '';
		$basic_html = '<div class="list clearfix"><a href="/myprofile?uid=%s" target="_blank" class="avatar" ><img src="%s" width="30" height="30"/></a><div class="right_comment"><a href="/myprofile?uid=%s" target="_blank"  class="linkb">%s：</a><span>%s</span></div></div>';
		foreach($comments_info as $comment){
			#拼数据
			$segment_data = array();
			$segment_data[] = $comment['uid'];
			$segment_data[] = $userinfos_re[ $comment['uid']]['image'];
			$segment_data[] = $comment['uid'];
			$segment_data[] = $userinfos_re[ $comment['uid']]['uname'];
			$segment_data[] = $comment['content'];
			$html .= vsprintf($basic_html, $segment_data);
		}
		
		return $html;
	}
	
	#根据评论id获取评论id
	public function get_commentid_by_dianpingid($dianpingid, $type=0, $page=1,$pagesize=10){
		if(!$dianpingid){
			return array();
		}

		#从do层获取结果
		$re = $this->do_comment->get_commentid_by_dianpingid($dianpingid, $type, $page,$pagesize);
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		$ids = array();
		foreach($format_re as $each){
			$ids[] = $each['id'];
		}
		
		return $ids;
	}
	
	#根据uid获取回复条数
	public function get_comment_cnt_by_uid($uid){
		if(!$uid){
			return 0;
		}
		#从do层获取结果
		$re = $this->do_comment->get_comment_cnt_by_uid($uid);
		
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		

		return isset($format_re[0]['count(*)'])?$format_re[0]['count(*)']:0;
	}

	#获取用户的几条评论
	public function get_last_comment_by_uid($uid, $page=1, $pagesize=10){
		if(!$uid){
			return array();
		}
		#从do层获取结果
		$re = $this->do_comment->get_last_comment_by_uid($uid, $page, $pagesize);
		return $re;
	}
}