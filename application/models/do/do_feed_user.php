<?php
#用户间的关注feed表
class Do_feed_user extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	#增加一条用户关注feed
	function add_user_feed($data){
		$data = array(
				'content'=> isset($data['ping_id'])?json_encode(array($data['ping_id'])):'',
				'uid'=>isset($data['uid'])?$data['uid']:'',
				'uptime' =>time(),
				'reserve_1'=>isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2'=>isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3'=>isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		return $this->db->insert('zb_feed_user', $data);
	}
	
	#更新一条用户关注feed
	function update_user_feed($uid,$content){
		$data = array(
				'content' => $content,
				'uptime' => time(),
		);
		$this->db->where('uid', $uid);
		$re = $this->db->update('zb_feed_user', $data);

		return $re;
	}
	
	#获取一条用户关注feed
	function get_user_feed($uid){
		$this->db->select('content');
		$this->db->where('uid',$uid);
		$query = $this->db->get('zb_feed_user');
		return $query->result();
	}
}