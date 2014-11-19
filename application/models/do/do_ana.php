<?php
class Do_ana extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->db = $this->load->database("zanbaiana", true);
	}

	public function add($data){
		$data = array(
				'ip' => isset($data['ip'])?$data['ip']:'0',
				'ip_read' => isset($data['ip_read'])?$data['ip_read']:'',
				'time' => isset($data['time'])?$data['time']:'0',
				'time_read' => isset($data['time_read'])?$data['time_read']:'',
				'hour' => isset($data['hour'])?$data['hour']:'0',
				'hour_read' => isset($data['hour_read'])?$data['hour_read']:'',
				'day' => isset($data['day'])?$data['day']:'0',
				'day_read' => isset($data['day_read'])?$data['day_read']:'',
				'to_url' => isset($data['to_url'])?$data['to_url']:'',
				'to_type' => isset($data['to_type'])?$data['to_type']:'0',
				'city_id' => isset($data['city_id'])?$data['city_id']:'0',
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:'0',
				'url_id' => isset($data['url_id'])?$data['url_id']:'0',
				
				'from_url' => isset($data['from_url'])?$data['from_url']:'',
				'f_type' => isset($data['f_type'])?$data['f_type']:'0',
				'f_city_id' => isset($data['f_city_id'])?$data['f_city_id']:'0',
				'f_shop_id' => isset($data['f_shop_id'])?$data['f_shop_id']:'0',
				'f_url_id' => isset($data['f_url_id'])?$data['f_url_id']:'0',

				'http_code' => isset($data['http_code'])?$data['http_code']:'0',
				'http_length' => isset($data['http_length'])?$data['http_length']:'0',
				'uid' => isset($data['uid'])?$data['uid']:'0',
				'browser_type' => isset($data['browser_type'])?$data['browser_type']:'0',
				'content' => isset($data['content'])?$data['content']:'',
				'content_md5' => isset($data['content_md5'])?$data['content_md5']:'',
				'spider' => isset($data['spider'])?$data['spider']:'',
				'spider_type' => isset($data['spider_type'])?$data['spider_type']:'0',
		);
		$this->db->insert('zb_ana_new', $data);
	}
	public function check_exist($content_md5){
		$this->db->select('id');
		$this->db->where("content_md5", $content_md5);
		$query = $this->db->get('zb_ana_new');
		$re = $query->row_array();
		return $re;
	}
	public function get_stream_line($to_type){
		$sql = "select count(id) as cnt, day from zb_ana_new where spider_type = 0 and to_type = {$to_type}  group by day order by day asc";
		$query = $this->db->query($sql);
		$re = $query->result_array();
		return $re;
	}


	public function get_all_areas(){
		$this->db->select('*');
		$query = $this->db->get('zb_ana_new');
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach ($result as $key => $value) {
				$tmp[$value['id']] = $value;
			}
			$result = $tmp;
		}
		return $result;
	}

	public function add_ana_file($data){
		$data = array(
			'file_name' => isset($data['file_name'])?$data['file_name']:'',
			'file_name_md5' => isset($data['file_name_md5'])?$data['file_name_md5']:'',
			'ctime' => isset($data['ctime'])?$data['ctime']:time(),
			'mtime' => isset($data['mtime'])?$data['mtime']:time(),
			'format_time' => isset($data['format_time'])?$data['format_time']:0,
		);
		$this->db->insert('zb_ana_file', $data);
	}
	
	public function update_nam_file($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_ana_file', $data);
		return $re;
	}

	public function get_anafile_by_filenamemd5($file_name_md5){
		$this->db->select("*");
		$this->db->where("file_name_md5", $file_name_md5);
		$query = $this->db->get("zb_ana_file");
		$list = $query->row_array();
		return $list;
	}

	public function get_simple_from_where($select, $where, $group_by='', $order_by=''){
		if($group_by){
			$group_by = " group by {$group_by}";
		}
		if($order_by){
			$order_by = " order by id desc {$order_by}";
		}
		$sql = "select {$select} from zb_ana_new where {$where} {$group_by} {$order_by} ";
		//var_dump($sql);
		$query = $this->db->query($sql);
		$re = $query->result_array();
		//var_dump($group_by,$this->db->last_query());
		return $re;
	}
	public function get_sql($sql){
		$query = $this->db->query($sql);
		$re = $query->result_array();
		return $re;
	}

}