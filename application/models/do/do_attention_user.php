<?php
#用户间的关注关系表
class Do_attention_user extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	#增加一条用户关注关系
	function add_user_attention($data){
		$data = array(
				'from_uid'=> isset($data['from_uid'])?$data['from_uid']:'',
				'to_uid'=>isset($data['to_uid'])?$data['to_uid']:'',
				'ctime' =>time(),
				'reserve_1'=>isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2'=>isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3'=>isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		return $this->db->insert('zb_attention_user', $data);
	}
	
	function del_user_attention($data){
		$this->db->where('from_uid', $data['from_uid']);
		$this->db->where('to_uid', $data['to_uid']);
		return $this->db->delete('zb_attention_user'); 
	}

	
	#获取一个人的粉丝列表
	function get_fans($uid){
		$this->db->select('from_uid');
		$this->db->where('to_uid',$uid);
		$query = $this->db->get('zb_attention_user');
		return $query->result();
	}
	
	#获取一个人的关注列表
	function get_attentions($uid){
		$this->db->select('to_uid');
		$this->db->where('from_uid',$uid);
		$query = $this->db->get('zb_attention_user');
		return $query->result();
	}

	#判断是否关注过
	function check_attention($from_uid,$to_uid){
		$this->db->select('*');
		$this->db->where('from_uid',$from_uid);
		$this->db->where('to_uid',$to_uid);
		$query = $this->db->get('zb_attention_user');
		return $query->row_array();
	}
	
	public function check_attention_for_uids($from_uid, $to_uids){
		if(!$to_uids){
			return array();
		}
		$this->db->select("to_uid");
		$this->db->where("from_uid", $from_uid);
		$this->db->where_in("to_uid", $to_uids);
		$query = $this->db->get("zb_attention_user");
		$re = $query->result_array();
		if ($re) {
			$tmp = array();
			foreach ($re as $key => $value) {
				$tmp[$value['to_uid']] = $value['to_uid'];
			}
			$re = $tmp;
		}
		return $re;
	}
	#获取粉丝数
	function get_fans_cnt($uid){
		$this->db->select('count(*)');
		$this->db->where('to_uid',$uid);
		$query = $this->db->get('zb_attention_user');
		return $query->result();
	}
	
	#获取关注数
	function get_attention_cnt($uid){
		$this->db->select('count(*)');
		$this->db->where('from_uid',$uid);
		$query = $this->db->get('zb_attention_user');
		return $query->result();
	}
}