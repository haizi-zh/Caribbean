<?php
class Do_weixinevent extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function add($data){
		$data = array(
			'type' => isset($data['type'])?$data['type']:0,
			'keyword' => isset($data['keyword'])?$data['keyword']:'',
			'fromusername' => isset($data['fromusername'])?$data['fromusername']:'',
			'ctime' => isset($data['ctime'])?$data['ctime']:time(),
			'day' => isset($data['day'])?$data['day']: strtotime(date("Y-m-d", time())) ,
			'from' => isset($data['from'])?$data['from']:'',
		);
		$this->db->insert('zb_weixin_event', $data);
	}

	public function get_all(){
		$this->db->select("*");
		$this->db->order_by("id","desc");
		$query = $this->db->get('zb_weixin_event');
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach($result as $v){
				$tmp[$v['id']] = $v;
			}
			$result = $tmp;
		}
		return $result;
	}
}