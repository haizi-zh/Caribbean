<?php
#用户信息表
class Do_user extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	#根据时间戳获取用户id
	private function get_uid(){
		return time();
	}
	#根据来源（source）和id(sid)查询用户信息
	function get_userinfo_by_source_sid($source,$sid){
		$this->db->select('uid,email,uname,image,gender,reserve_1,source,sid');
		$this->db->where('source', $source);
		$this->db->where('sid', $sid);
		$query = $this->db->get('zb_user');
		return $query->result();
	}
   	public function get_user_info_by_params($params){
   		$this->db->select('uid');
   		foreach ($params as $key => $value) {
   			$this->db->where($key, $value);
   		}
		$query = $this->db->get('zb_user');
		return $query->result();
   	}
	#插入一个用户
	function add_user($data){
		$data = array(
				'uid'=> self::get_uid(),
				'email'=>isset($data['email'])?$data['email']:'',
				'uname'=>isset($data['uname'])?$data['uname']:'',
				'pwd'=>isset($data['pwd'])?$data['pwd']:'',
				'image'=>isset($data['image'])?$data['image']:'',
				'age'=>isset($data['age'])?$data['age']:'',
				'birth'=>isset($data['birth'])?$data['birth']:'',
				'gender'=>isset($data['gender'])?$data['gender']:0,
				'phone'=>isset($data['phone'])?$data['phone']:'',
				'desc'=>isset($data['desc'])?$data['desc']:'',
				'city'=>isset($data['city'])?$data['city']:'',
				'country'=>isset($data['country'])?$data['country']:'',
				'addr'=>isset($data['addr'])?$data['addr']:'',
				'source'=>isset($data['source'])?$data['source']:'',
				'sid'=>isset($data['sid'])?$data['sid']:'',
				'reserve_1'=>isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2'=>isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3'=>isset($data['reserve_3'])?$data['reserve_3']:'',
				'ctime'=>time(),
		);
		$this->db->insert('zb_user', $data);
		return $this->db->insert_id();
	}
	
	#修改用户的基本信息
	function modify_userinfo($data) {
		$uid = $data['uid'];
		if(!isset($data['uid'])) return false;
		unset($data['uid']);
		try {
			$this->db->where('uid', $uid);
			$re = $this->db->update('zb_user', $data);
			return $re;
		}catch(Exception $e) {
			return false;
		}
	}
	
	#批量获取简要用户信息
	function get_simple_userinfos($uids){
		if(!$uids){
			return array();
		}
		$this->db->select("uid,uname,image,gender");
		$this->db->where_in("uid", $uids);
		$query = $this->db->get("zb_user");
		return $query->result_array();
	}

	
	#批量获取简要用户信息
	function get_rich_userinfos($uids){
		if(!$uids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("uid", $uids);
		$query = $this->db->get("zb_user");
		return $query->result();
	}

	# 根据登录邮箱/密码获取用户id
	function get_uid_by_email_passwd($email, $password){
		$this->db->select('uid');
		$this->db->where('email', $email);
		$this->db->where('pwd', $password);
		$this->db->where('source', 'zanbai');
		$query = $this->db->get('zb_user');
		return $query->result();
	}

	public function search_nick($name, $page=1, $pagesize=10){
		$offset = ($page - 1) * $pagesize;
		$sql = "select * from zb_user where uname like '%{$this->db->escape_like_str($name)}%'  limit {$offset}, {$pagesize}";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function add_zb_click($data){
		$this->db->insert('zb_click', $data);
		return $this->db->insert_id();
	}

}




