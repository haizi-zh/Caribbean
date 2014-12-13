<?php

class Do_cronweixin extends CI_Model {
	const STATUS_NORMAL = 0;
	const STATUS_DELETE = 1;
	
	function __construct(){
		parent::__construct();
		//$this->load->database("weixin", true);
		$this->db = $this->load->database("zanbaiana", true);
	}

	public function add($data){
		$this->db->insert('zb_weixin_user', $data);
		return $this->db->insert_id();
	}

	public function update($data, $id){
		$this->db->where('id', $id);
		return $this->db->update('zb_weixin_user', $data);
	}
	public function get_info_by_nick($nick){
		$this->db->select("*");
		$this->db->where("nick", $nick);
		$this->db->where("wkey", '');
		$query = $this->db->get("zb_weixin_user");
		$list = $query->row_array();
		//var_dump($this->db->last_query());
		return $list;
	}

	public function get_info_by_wkey($wkey){
		$this->db->select("*");
		$this->db->where("wkey", $wkey);
		$query = $this->db->get("zb_weixin_user");
		$list = $query->row_array();
		return $list;
	}

	public function get_user($spider_time = 0, $page = 1, $pagesize=1000){
		$offset = ($page - 1) * $pagesize;
		$this->db->limit($pagesize, $offset);
		$this->db->select("*");
		if($spider_time){
			$this->db->where('spider_time <= ', $spider_time);
		}
		$this->db->where("status", 0);
		$this->db->order_by("id", "desc");
		$query = $this->db->get("zb_weixin_user");
		$list = $query->result_array();
		return $list;
	}
	public function get_user_infos($uids){
		$this->db->select("*");
		$this->db->where_in("id", $uids);
		$query = $this->db->get("zb_weixin_user");
		$list = $query->result_array();
		$list = tool::format_array_by_key($list, 'id');
		return $list;
	}
	public function get_weixin_user($spider_time=0){
		$this->db->select("*");
		//$this->db->where("status", 0);
		$this->db->where('spider_time <= ', $spider_time);
		//$this->db->where('sogou_url !=', "");
		$this->db->where('total_pages >', 0);
		$this->db->order_by("id", "asc");
		$this->db->like("type_name", "旅游");
		$this->db->or_like("type_name", "购物");
		$query = $this->db->get("zb_weixin_user");
		//var_dump($this->db->last_query());
		$list = $query->result_array();
		return $list;
	}
	public function get_weixin_by_titlemd5_uid($uid, $title_md5){
		$this->db->select("*");
		$this->db->where("uid", $uid);
		$this->db->where("title_md5", $title_md5);
		$query = $this->db->get("zb_weixin");
		$list = $query->row_array();
		return $list;
	}

	public function add_weixin($data){
		$this->db->insert('zb_weixin', $data);
		return $this->db->insert_id();
	}

	public function update_weixin($data, $id){
		$this->db->where('id', $id);
		return $this->db->update('zb_weixin', $data);
	}

	public function get_weixin_list($page=1, $pagesize=10){
		$offset = ($page - 1) * $pagesize;
		$this->db->limit($pagesize, $offset);
		$this->db->select('*');
		$this->db->order_by("wtime", "desc");
		$query = $this->db->get('zb_weixin');
		$result = $query->result_array();
		return $result;
	}

	public function get_weixin_count(){
		$this->db->select("count(*) as cid");
		$query = $this->db->get('zb_weixin');
		$re = $query->row_array();
		return $re['cid'];
	}

	public function get_proxy_ip_port($ip, $port){
		$this->db->select("*");
		$this->db->where("ip", $ip);
		$this->db->where("port", $port);
		$query = $this->db->get("my_proxy");
		$list = $query->row_array();
		return $list;
	}
	//add_proxy
	public function add_proxy($data){
		$this->db->insert('my_proxy', $data);
		return $this->db->insert_id();
	}
	//modify_proxy
	public function modify_proxy($data, $id){
		$this->db->where('id', $id);
		return $this->db->update('my_proxy', $data);
	}
	//get_rand_proxy
	public function get_all_proxy($where=array()){
		$this->db->select('*');
		if($where){
			foreach($where as $k=>$v){
				$this->db->where($k, $v);
			}
		}
		$query = $this->db->get('my_proxy');
		$result = $query->result_array();
		return $result;
	}


}






