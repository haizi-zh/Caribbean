<?php
#评论操作类
class Do_comment extends CI_Model {

	#评论状态
	const COMMENT_STATUS_NORMAL = 0;
	const COMMENT_STATUS_DELETE = 1;
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	#添加一个评论
	public function add($data){
		$comment_data = array(
				'uid' => isset($data['uid'])?$data['uid']:0,
				'type' => isset($data['type'])?$data['type']:0,
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:0,
				'dianping_id' => isset($data['dianping_id'])?$data['dianping_id']:0,
				'content' => isset($data['content'])?$data['content']:'',
				'ctime' => time(),
				'status' => isset($data['status'])?$data['status']:0,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		$this->db->insert('zb_comment', $comment_data);
		return $this->db->insert_id();
	}
	
	#删除一个评论
	public function delete($comment_id){
		$data = array(
				'status' => self::COMMENT_STATUS_DELETE,
		);
		$this->db->where('id', $comment_id);
		return $this->db->update('zb_comment', $data);
	}
	#根据点评，删除回复
	public function delete_by_dianpingid($dianping_id){
		$data = array(
				'status' => self::COMMENT_STATUS_DELETE,
		);
		$this->db->where('dianping_id', $dianping_id);
		return $this->db->update('zb_comment', $data);
	}
	#恢复一个评论
	public function recover($comment_id){
		$data = array(
				'status' => self::COMMENT_STATUS_NORMAL,
		);
		$this->db->where('id', $comment_id);
		return $this->db->update('zb_comment', $data);
	}
	#获取comment总数
	public function get_comment_cnt_all(){
		$this->db->select('count(*) as cnt');
		$query = $this->db->get('zb_comment');
		return $query->row_array();
	}
	
	
	#根据评论id获取评论信息
	public function get_commentinfo_by_dianpingid($dianpingid, $type=0, $page=1,$pagesize=10){
		$offset = ($page - 1) * $pagesize;

		$this->db->select("*");
		$this->db->where("dianping_id", $dianpingid);
		$this->db->where("type", $type);
		$this->db->where("status", self::COMMENT_STATUS_NORMAL);
		$this->db->order_by("ctime", "desc");
		$this->db->limit($pagesize,$offset);

		$query = $this->db->get("zb_comment");
		return $query->result();
	}
	
	#根据评论id获取评论id
	public function get_commentid_by_dianpingid($dianpingid, $type=0, $page=1,$pagesize=10){
		$offset = ($page - 1) * $pagesize;

		$this->db->select("id");
		$this->db->where("dianping_id", $dianpingid);
		$this->db->where("type", $type);
		$this->db->where("status", self::COMMENT_STATUS_NORMAL);
		$this->db->order_by("ctime", "desc");
		$this->db->limit($pagesize,$offset);

		$query = $this->db->get("zb_comment");
		return $query->result();
	}
	
	#获取点评的评论总数
	public function get_comment_cnt_by_dianping($dianping_id, $type=0){
		$this->db->select('count(*) as cnt');
		$this->db->where('dianping_id', $dianping_id);
		$this->db->where('type', $type);
		$this->db->where('status', self::COMMENT_STATUS_NORMAL);
		$query = $this->db->get('zb_comment');
		$re = $query->row_array();
		if($re && $re['cnt']){
			return $re['cnt'];
		}
		return 0;
	}

	public function get_comment_cnts_by_dianpings($dianping_ids, $type=0){
		if(!$dianping_ids){
			return array();
		}
		$dianping_ids_list = implode(",", $dianping_ids);

		$this->db->select("count(id) as cnt, dianping_id");
		$this->db->where_in("dianping_id", $dianping_ids);
		$this->db->where("status", self::COMMENT_STATUS_NORMAL);
		$this->db->where("type", $type);
		$this->db->group_by("dianping_id");
		$query = $this->db->get("zb_comment");
		return $query->result();
	}
	
	#获取点评的评论总数
	public function get_comment_cnt_by_uid($uid){
		$this->db->select('count(*)');
		$this->db->where('uid', $uid);
		$this->db->where('status', self::COMMENT_STATUS_NORMAL);
		$query = $this->db->get('zb_comment');
		return $query->result();
	}
	
	#批量获取回复信息
	public function get_comment_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$query = $this->db->get("zb_comment");
		return $query->result_array();
	}
	
	
	#获取评论信息foradmin
	public function get_comment_list_for_admin($page, $pagesize, $params = array()){
		$offset = ($page - 1) * $pagesize;
		$where = "";
		if($params){
			$where = " WHERE " .implode(" and ", $params);
		}
		$sql = "SELECT * FROM zb_comment {$where} order by ctime desc LIMIT ".$offset.",".$pagesize;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	#获取用户的几条评论
	public function get_last_comment_by_uid($uid, $page, $pagesize){
		$offset = ($page - 1) * $pagesize;
		
		$this->db->select("*");
		$this->db->where("uid", $uid);
		$this->db->where("status", 0);
		$this->db->order_by("ctime", "desc");
		$this->db->limit( $pagesize, $offset);
		$query = $this->db->get("zb_comment");

		return $query->row_array();
	}


}





