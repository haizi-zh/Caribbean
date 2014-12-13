<?php

class Do_coupon extends CI_Model {
	const DISCOUNT_STATUS_NORMAL = 0;
	const DISCOUNT_STATUS_DELETE = 1;
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	#添加一个地域
	public function add($data){
		$data = array(
				'level' => isset($data['level'])?$data['level']:0,
				'title' => isset($data['title'])?$data['title']:'',
				'city' => isset($data['city'])?$data['city']:'',
				'country' => isset($data['country'])?$data['country']:'',
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:'',
				'body' => isset($data['body'])?$data['body']:'',
				'pics' => isset($data['pics'])?$data['pics']:'',
				'has_pic' => isset($data['has_pic'])?$data['has_pic']:0,
				'uid' => isset($data['uid'])?$data['uid']:0,
				'type' => isset($data['type'])?$data['type']:1,
				'status' => isset($data['status'])?$data['status']:0,
				'ctime' => isset($data['ctime'])?$data['ctime']: time(),
				'mtime' => isset($data['mtime'])?$data['mtime']:time(),
				'ip' => isset($data['ip'])?$data['ip']:0,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
				'share_content' => isset($data['share_content'])?$data['share_content']:'',
				'brand_id' => isset($data['brand_id'])?$data['brand_id']:'',
				'country_ids' => isset($data['country_ids'])?$data['country_ids']:'',
				'img_size'=>isset($data['img_size'])?$data['img_size']:0,
				'template_order'=>isset($data['template_order'])?$data['template_order']:0,
		);
		$this->db->insert('zb_coupon', $data);
		return $this->db->insert_id();
	}
	public function update($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_coupon', $data);
		return $re;
	}

	public function increace_download($id){
		$sql = "update `zb_coupon` set `download_count` = `download_count` + 1 where id={$id}";
		$query = $this->db->query($sql);

	}


	public function get_info($id){
		$infos = $this->get_info_by_ids(array($id));
		if(isset($infos[$id])){
			return $infos[$id];
		}
		return array();
	}



	public function delete($discount_id){
		$data = array(
			'status' => self::DISCOUNT_STATUS_DELETE,
		);
		$this->db->where('id', $discount_id);
		$re = $this->db->update('zb_coupon', $data);
		return $re;
	}

	public function recover($discount_id){
		$data = array(
			'status' => self::DISCOUNT_STATUS_NORMAL,
		);
		$this->db->where('id', $discount_id);
		return $this->db->update('zb_coupon', $data);
	}

	public function get_info_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$this->db->order_by("id", "desc");
		$query = $this->db->get("zb_coupon");
		$list = $query->result_array();
		$tmp = array();
		if($list){
			foreach($list as $v){
				$tmp[$v['id']] = $v;
			}
			$list = $tmp;
		}
		return $list;
		
	}

	public function get_coupon_by_shop_brand($shop_id, $brand_ids=array()){
		if($brand_ids){
			foreach($brand_ids as $k => $v){
				if(!$v){
					unset($brand_ids[$k]);
				}
			}
		}
		if($brand_ids){
			foreach($brand_ids as $brand_id){
				$str[] =  " brand_id like '%,{$brand_id},%'";
			}
			$str_str = implode(" or ", $str);
			$sql = "select * from zb_coupon where (shop_id like '%,{$shop_id},%' or shop_id = {$shop_id} or ({$str_str})) and status=0 order by level asc";
		}else{
			$sql = "select * from zb_coupon where ( shop_id like '%,{$shop_id},%' or shop_id = {$shop_id} ) and status=0 order by level asc";
		}

		$query = $this->db->query($sql);
		$list = $query->result_array();
		/*
		$this->db->select("*");
		
		if($brand_ids){
			//$this->db->or_where_in("brand_id", $brand_ids);
			foreach($brand_ids as $brand_id){
				$this->db->or_like("reserve_1", ",".$brand_id.",");
			}
		}
		$this->db->or_where("shop_id", $shop_id);
		$this->db->where("status", 0);
		$this->db->order_by("level", "asc");

		$query = $this->db->get("zb_coupon");
		$list = $query->result_array();
		var_dump($this->db->last_query());
		*/

		if($list){
			foreach($list as $k => $v){
				if($v['status'] != 0){
					unset($list[$k]);
				}
			}
		}
		
		return $list;
	}
	
	public function get_list($where=array(), $page=1, $pagesize=10){
		$offset = ($page - 1) * $pagesize;
		$this->db->limit($pagesize, $offset);
		$this->db->select('*');
		if($where){
			foreach($where as $key=>$value){
				$this->db->where("{$key}", $value);
			}
		}
		$this->db->order_by("id", "desc");
		$query = $this->db->get('zb_coupon');
		$result = $query->result_array();
		return $result;
	}

	public function get_list_count($where=array()){
		$this->db->select("count(*) as cid");
		if($where){
			foreach($where as $key=>$value){
				$this->db->where("{$key}", $value);
			}
		}
		$query = $this->db->get('zb_coupon');
		$re = $query->row_array();
		return $re['cid'];
	}

	public function get_last_coupon_by_uid($uid){
		$this->db->select("body");
		$this->db->where("uid", $uid);
		$this->db->where("status", 0);
		$this->db->order_by("id", "desc");
		$this->db->limit(1);

		$query = $this->db->get("zb_coupon");

		return $query->result();

	}



}



