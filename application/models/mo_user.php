<?php
#用户操作类
class Mo_user extends ZB_Model {

	const WB = 'weibo';
	const QQ = 'qq';
	const CACHA_TIME = 86400;
	const KEY_SIMPLE_USERS = "%s_1_%s";
	
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_user');
		$this->load->model('do/do_dianping');
	}

	#插入一个用户
	function add_user($data){
		return $this->do_user->add_user($data);
	}
	
	#修改用户的基本信息
	function modify_userinfo($data) {
		return $this->do_user->modify_userinfo($data);
	}
	public function get_user_info_by_params($params){
		return $this->do_user->get_user_info_by_params($params);
	}
	
	#根据来源（source）和id(sid)查询用户信息
	function get_userinfo_by_source_sid($source,$sid){
		#从do层获取结果
		$re = $this->do_user->get_userinfo_by_source_sid($source,$sid);
		
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		
		if($format_re) $format_re = $format_re[0];
		return $format_re;
	}
	#!只为 get_local_userinfo 准备
	public function check_uname($data){
		$uname = $data['uname'];
		$check_uname = $this->get_user_info_by_params(array('uname'=>$uname));
		if ($check_uname) {
			$uname .= mt_rand(0,9);
			$data['uname'] = $uname;
			$len = mb_strlen($uname, 'utf-8');
			if ($len > 100) {
				return $data;
			}
			return $this->check_uname($data);
		}
		return $data;
	}
	#获取赞佰本地的用户信息
	function get_local_userinfo($data){
		
		#从数据库获取用户信息
		$user_info = self::get_userinfo_by_source_sid($data['source'], $data['sid']);
		if($user_info) {
			if($user_info['source'] == 'weibo' && isset($data['token'])){
				$re = $this->modify_userinfo(array('uid'=>$user_info['uid'],'token'=>$data['token']));
				
				$user_info['token'] = $data['token'];
			}
			return $user_info;
		}
		
		#如果没有用户信息则为用户创建一条记录
		#监测用户昵称
		$data = $this->check_uname($data);
		
		self::add_user($data);
		
		#在上下文里设置用户信息
		$user_info = self::get_userinfo_by_source_sid($data['source'], $data['sid']);
		
		return $user_info;
	}
	public function get_simple_userinfo($uid){
		$infos = $this->get_simple_userinfos(array($uid));
		if($infos && isset($infos[$uid])){
			return $infos[$uid];
		}
		return array();
	}
	
	#批量获取简要用户信息
	// KEY_SIMPLE_USERS
	function get_simple_userinfos($ids){
		if(!$ids){
			return array();
		}
		$tmp = array();
		foreach($ids as $uid){
			if($uid){
				$tmp[$uid] = $uid;
			}
		}
		$ids = $tmp;
		if(!$ids){
			return array();
		}
		#从do层获取结果
		$data = array();
		//缓存的key
		$re = $this->get_multi_cache(self::KEY_SIMPLE_USERS, "mo_user", $ids, array());
		$data = $re['data'];
		$diff_ids = $re['diff_ids'];
		if(!$diff_ids){
			return $data;
		}


		#从do层获取结果
		$format_re = $this->do_user->get_simple_userinfos($diff_ids);
		foreach($format_re as $k => $each){
			$format_re[$k]['id'] = $each['uid'];
		}
		
		#转化为kv结构
		$return = array();
		$this->load->model("mo_comment");
		$this->load->model("mo_social");
		foreach($format_re as $each){
			#头像 图片大小处理
			// 2013/07/9b797ef43bbb1a34.gif
			// 2014/04/c45d8614b2a0e4db.jpg
			if($each['image'] == "http://zanbai.b0.upaiyun.com/2013/07/9b797ef43bbb1a34.gif"){
				if($each['gender'] == 1){
					$each['image'] = "http://zanbai.b0.upaiyun.com/2013/07/9b797ef43bbb1a34.gif";
				}elseif($each['gender'] == 0){
					$each['image'] = "http://zanbai.b0.upaiyun.com/2014/04/c45d8614b2a0e4db.jpg";
				}
			}
			if(!$each['image']){
				$each['image'] = "http://zanbai.b0.upaiyun.com/2013/07/9b797ef43bbb1a34.gif";
			}
			$each['image'] = $each['image']."!head80";
			$uid = $each['uid'];
			//头像处理

			$each['dianping_cnt'] = self::get_dianping_cnt_by_uid($uid);
			$each['comment_cnt'] = $this->mo_comment->get_comment_cnt_by_uid($uid);
			$each['fans_cnt'] = $this->mo_social->get_fans_cnt($uid);
			$each['attention_cnt'] = $this->mo_social->get_attention_cnt($uid);
			$each['image'] = upimage::format_brand_up_image($each['image']);
			
			$return[$each['uid']] = $each;
		}
		
		$re = $this->get_multi_cache(self::KEY_SIMPLE_USERS, "mo_user", $ids, array(), self::CACHA_TIME, $return );
		
		$data = $re['data'];
		$diff_ids = $re['diff_ids'];
		$return = array();
		if($data){
			foreach($data as $v){
				$return[$v['uid']] = $v;
			}
		}

		return $return;
	}

	public function format_user_infos($user_infos){
		if(!$user_infos){
			return array();
		}
		$uids = array();
		foreach($user_infos as $v){
			$uids[] = $v['uid'];
		}

		//关注数量。关注列表，粉丝数量。粉丝列表。
		// 收藏列表
		// 评论列表

	}
	
	#批量获取简要用户信息
	function get_rich_userinfos($uids){
		#从do层获取结果
		$re = $this->do_user->get_rich_userinfos($uids);

		#格式化成数组
		$format_re = $this->tool->std2array($re);
		#转化为kv结构
		$return = array();
		foreach($format_re as $each){
			#头像 图片大小处理
			$each['image'] = $each['image']."!head80";
			$return[$each['uid']] = $each;
		}
		
		return $return;
	}
	public function get_middle_userinfo($uid){
		if(!$uid){
			return array();
		}
		$user_infos = $this->get_middle_userinfos(array($uid));
		if($user_infos && isset($user_infos[$uid]) && $user_infos[$uid]){
			return $user_infos[$uid];
		}
		return array();
	}

	#批量获取简要用户信息
	function get_middle_userinfos($uids){
		$this->load->model('mo_comment');
		$this->load->model('mo_social');

		$simple_re = self::get_simple_userinfos($uids);
		
		#添加点评数/评论/关注数/粉丝数
		foreach($simple_re as $uid=>$user){

		}
		
		return $simple_re;
	}
	
	#获取用户点评数
	public function get_dianping_cnt_by_uid($uid){
		#从do层获取结果
		$re = $this->do_dianping->get_dianping_cnt_by_uid($uid);
		#格式化
		$re = $this->tool->std2array($re);
		
		return isset($re[0]['count(*)'])?intval($re[0]['count(*)']):0;
	}
	
	#login
	public function login($email, $password){
		#从do层获取结果
		$re = $this->do_user->get_uid_by_email_passwd($email, $password);
		if(!$re) return null;
		
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		$uid = $format_re[0]['uid'];
		$user_info = self::get_simple_userinfos(array($uid));
		return $user_info[$uid];
	}
	public function search_nick($name, $page = 1, $pagesize = 10){
		return $this->do_user->search_nick($name, $page, $pagesize);
	}

}


