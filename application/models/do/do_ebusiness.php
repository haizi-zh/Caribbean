<?php
#电商相关
class Do_ebusiness extends CI_Model {
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	#添加一个点评
	public function add($data){
		//// name logo description web_site country tags pay_type type
		$add_data = array(
				'name' => isset($data['name'])?$data['name']:'',
				'logo' => isset($data['logo'])?$data['logo']:'',
				'description' => isset($data['description'])?$data['description']:'',
				'web_site' => isset($data['web_site'])?$data['web_site']:'',
				'country' => isset($data['country'])?$data['country']:0,
				'tags' => isset($data['tags'])?$data['tags']:'',
				'pay_type' => isset($data['pay_type'])?$data['pay_type']:'',
				'ctime' => time(),
		);
		$this->db->insert('zb_ebusiness', $add_data);
		return $this->db->insert_id();
	}
	#编辑
	public function modify($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_ebusiness', $data);
		if ($re) {
			return $id;
		}
		return $re;
	}

	#删除一个点评
	public function delete($ping_id){
		$data = array(
			'status' => self::PING_STATUS_DELETE,
		);
		$this->db->where('id', $ping_id);
		return $this->db->update('zb_dianping', $data);
	}
	public function get_info($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('zb_ebusiness');
		$info = $query->row_array();
		return $info;
	}

	public function get_list($status =0){
		$this->db->select("*");
		$this->db->where('status', $status);
		$query = $this->db->get("zb_ebusiness");
		$list = $query->result_array();
		return $list;
	}
	public function get_list_count($status =0){
		$this->db->select("count(id) as cid");
		$this->db->where('status', $status);
		$query = $this->db->get("zb_ebusiness");
		$list = $query->row_array();
		$count = $list['cid'];
		return $count;
	}

}




