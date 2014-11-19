<?php
class Do_feedback extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function add($data){
		$data = array(
				'uid' => isset($data['uid'])?$data['uid']:'',
				'content' => isset($data['content'])?$data['content']:'',
				'ctime' => isset($data['ctime'])?$data['ctime']:'',
				'status' => isset($data['status'])?$data['status']:0,
				'link'	=> isset($data['link'])?$data['link']:'',
				'type'	=> $data['type'] ,
				'email'	=> isset($data['email'])?$data['email']:'',
				'ip' 	=> $data['ip'] ,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		return $this->db->insert('zb_feedback', $data);
	}

	public function get_feedback_list($page=1, $pagesize = 10){
		$offset = ($page - 1) * $pagesize;
		$this->db->limit($pagesize, $offset);
		$this->db->select('*');
		$this->db->order_by("id", "desc");
		$query = $this->db->get('zb_feedback');
		$result = $query->result_array();
		return $result;
	}

	public function get_feedback_count(){
		$this->db->select("count(distinct(id)) as cid");
		$query = $this->db->get("zb_feedback");
		$list = $query->row_array();

		$count = $list['cid'];
		
		return $count;
	}

}