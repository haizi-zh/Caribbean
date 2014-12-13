<?php

class Do_attention_shop extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}
	
	#增加一条用户关注关系
	function add_shop_attention($uid, $shop_id){
		$this->load->database();
		$data['uid'] = $uid;
		$data['shop_id'] = $shop_id;
		$data['ctime'] = time();
		return $this->db->insert('zb_attention_shop', $data);
	}
	
	function del_shop_attention($uid, $shop_id){
		$this->load->database();
		$this->db->where('uid', $uid);
		$this->db->where('shop_id', $shop_id);
		return $this->db->delete('zb_attention_shop'); 
	}
	
	#判断是否关注过
	function check_shop_attention($uid,$shop_id){
		$this->load->database();
		$this->db->select('*');
		$this->db->where('uid',$uid);
		$this->db->where('shop_id', $shop_id);
		$query = $this->db->get('zb_attention_shop');
		return $query->result();
	}

	function get_attentions($uid){
		$this->load->database();
		$this->db->select('shop_id');
		$this->db->where('uid', $uid);
		$query = $this->db->get("zb_attention_shop");
		//$sql = "SELECT shop_id FROM zb_attention_shop WHERE uid={$this->db->escape_str($uid)} ";
		//$query = $this->db->query($sql);
		return $query->result_array();
	}

}