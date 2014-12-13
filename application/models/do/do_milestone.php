<?php
class Do_milestone extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function add($data){
		$data = array(
				'content' => isset($data['content'])?$data['content']:'',
				'ctime' => isset($data['ctime'])?$data['ctime']:'',
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		return $this->db->insert('zb_milestone', $data);
	}
	
	#foradmin
	public function get_milestone_list_for_admin($page, $pagesize, $params = array()){
		$offset = ($page - 1) * $pagesize;
		$where = "";
		if($params){
			$where = " WHERE " .implode(" and ", $params);
		}
		
		$sql = "SELECT * FROM zb_milestone {$where} order by id desc LIMIT ".$offset.",".$pagesize;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	#foradmin
	public function get_milestone_cnt_for_admin($params = array()){
		$where = "";
		if($params){
			$where = " WHERE " .implode(" and ", $params);
		}
		
		$sql = "SELECT count(id) as cnt FROM zb_milestone {$where} ";

		$query = $this->db->query($sql);
		$result = $query->row_array();
		$cnt = $result['cnt'];
		return $cnt;
	}


}