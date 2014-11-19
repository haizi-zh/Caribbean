<?php
#点评操作类
class Do_dianping extends CI_Model {

	#点评状态
	const PING_STATUS_NORMAL = 0;
	const PING_STATUS_DELETE = 1;
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	#添加一个点评
	public function add($data){
		$now = time();
		$data = array(
				'score' => isset($data['score'])?$data['score']:0,
				'body' => isset($data['body'])?$data['body']:'',
				'pics' => isset($data['pics'])?$data['pics']:'',
				'has_pic' => isset($data['has_pic'])?$data['has_pic']:0,
				'uid' => isset($data['uid'])?$data['uid']:0,
				'status' => isset($data['status'])?$data['status']:0,
				'ctime' => $now,
				'source_time' => $now,
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:0,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		$this->db->insert('zb_dianping', $data);
		return $this->db->insert_id();
	}
	#编辑
	public function modify($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_dianping', $data);
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
	#恢复一个dianping
	public function recover($ping_id){
		$data = array(
			'status' => self::PING_STATUS_NORMAL,
		);
		$this->db->where('id', $ping_id);
		return $this->db->update('zb_dianping', $data);
	}

	#根据id获取点评信息
	public function get_dianpinginfo_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$query = $this->db->get("zb_dianping");
		return $query->result_array();
	}
	
	#根据商家id获取点评信息,has_pic表示只返回有图片的
	public function get_dianpinginfo_by_shopid($shopid,$page=1,$pagesize=10,$has_pic=false,$max_id=0){
		$offset = ($page - 1) * $pagesize;

		$this->db->select("*");
		$this->db->where("shop_id", $shopid);
		$this->db->where("status", 0);
		if($has_pic) {
			$this->db->where("has_pic", 1);
		}
		if($max_id != 0) {
			$max_id = intval($max_id);
			$this->db->where("id <", $max_id);
		}
		$this->db->order_by("top", "desc");
		$this->db->order_by("ctime", "desc");
		
		$this->db->limit($pagesize, $offset);
		$query = $this->db->get("zb_dianping");
		return $query->result_array();
	}
	#根据商家id获取点评ids ,has_pic表示只返回有图片的
	public function get_dianping_ids_by_shopid($shopid,$page=1,$pagesize=10,$has_pic=false,$max_id=0){
		$offset = ($page - 1) * $pagesize;

		$this->db->select("id");
		$this->db->where("shop_id", $shopid);
		$this->db->where("status", 0);
		if($has_pic) {
			$this->db->where("has_pic", 1);
		}
		if($max_id != 0) {
			$max_id = intval($max_id);
			$this->db->where("id <", $max_id);
		}
		$this->db->order_by("top", "desc");
		$this->db->order_by("ctime", "desc");
		
		$this->db->limit($pagesize, $offset);
		$query = $this->db->get("zb_dianping");
		return $query->result_array();
	}

	#获取点评总数
	public function get_dianping_cnt_all(){
		$this->db->select('count(*) as cnt');
		$query = $this->db->get('zb_dianping');
		return $query->row_array();
	}
	
	#获取商家的点评总数
	public function get_dianping_cnt($shop_id){
		$this->db->select('count(*)');
		$this->db->where('shop_id', $shop_id);
		$this->db->where('status', self::PING_STATUS_NORMAL);
		$query = $this->db->get('zb_dianping');
		return $query->result();
	}
	
	#获取最新点评
	public function get_last_dianping($page=1, $pagesize=10){
		$offset = ($page - 1) * $pagesize;
		$this->db->select("id");
		$this->db->where("has_pic", 1);
		$this->db->where("status", 0);
		$this->db->order_by("ctime", 'desc');
		$this->db->limit($pagesize, $offset);
		$query = $this->db->get("zb_dianping");
		return $query->result_array();
	}
	#获取最新点评 for  madin
	public function get_last_dianping_admin($num,$offset=0, $params = array()){
		$where = "";
		if($params){
			$where = " WHERE " .implode(" and ", $params);
			//$where = " WHERE ";
			//foreach ($params as $k => $v){
			//	$where .= " {$k} = {$v} ";
			//}
		}
		$sql = "SELECT * FROM zb_dianping {$where} order by ctime desc LIMIT {$offset},".$num;
		$query = $this->db->query($sql);
		$list = $query->result_array();
		if($list){
			$tmp = array();
			foreach($list as $k=>$v){
				$clean_body = $this->tool->clean_all($v['body'], 200);
				$v['clean_body'] = $clean_body;
				$tmp[$k] = $v;
			}
			$list = $tmp;
		}
		return $list;
	}

	public function get_last_dianping_admin_cnt($params= array()){
		$where = "";
		if($params){
			$where = " WHERE " .implode(" and ", $params);
			//$where = " WHERE ";
			//foreach ($params as $k => $v){
			//	$where .= " {$k} = {$v} ";
			//}
		}
		$sql = "SELECT count(*) as cnt FROM zb_dianping {$where} ";
		$query = $this->db->query($sql);
		$list = $query->row_array();
		return $list;
	}

	#获取用户点评数
	public function get_dianping_cnt_by_uid($uid){
		$this->db->select('count(*)');
		$this->db->where('uid', $uid);
		$this->db->where('status',self::PING_STATUS_NORMAL);
		$query = $this->db->get('zb_dianping');
		return $query->result();
	}
	
	#根据用户id获取点评信息
	public function get_dianpingids_by_uid($uid,$page=1,$pagesize=10){
		$offset = ($page - 1) * $pagesize;

		$this->db->select("id");
		$this->db->where("uid", $uid);
		$this->db->where("status", 0);
		$this->db->order_by("ctime", "desc");
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get("zb_dianping");

		return $query->result_array();
	}
	#根据用户id获取点评信息
	public function get_dianpingids_by_uids($uids){
		if(!$uids){
			return array();
		}
		$this->db->select("id");
		$this->db->where_in("uid", $uids);
		$this->db->where("status", 0);
		$this->db->order_by("ctime", "desc");
		$this->db->limit(200, 0);
		$query = $this->db->get("zb_dianping");
		return $query->result_array();
	}

	#有效点评数
	public function get_valid_dianping_cnt($shop_id){
		$this->db->select("count(*)");
		$this->db->where("shop_id", $shop_id);
		$this->db->where("status", 0);
		$this->db->where("score > ", 0);
		$query = $this->db->get("zb_dianping");
		return $query->result();
	}

	public function get_value_dianping_score($shop_id){
		$this->db->select(" SUM(score) as sum ");
		$this->db->where("shop_id", $shop_id);
		$this->db->where("status", 0);
		$this->db->where("score > ", 0);
		$query = $this->db->get("zb_dianping");
		return $query->result();
	}

	public function get_last_dianping_by_uid($uid){
		$this->db->select(" body ");
		$this->db->where("uid", $uid);
		$this->db->where("status", 0);
		$this->db->order_by("id", "desc");
		$this->db->limit(1);
		$query = $this->db->get("zb_dianping");
		return $query->row_array();

	}

	public function get_all_dianpings(){
		$this->db->select("id");
		$this->db->where("status", 0);
		$query = $this->db->get("zb_dianping");
		return $query->result_array();
	}
	public function get_all_dianpings_info(){
		$this->db->select("*");
		$this->db->where("status", 0);
		$query = $this->db->get("zb_dianping");
		$re = $query->result_array();
		$re = tool::format_array_by_key($re, "id");
		return $re;
	}

}




