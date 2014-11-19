<?php

class Mo_ana extends ZB_Model {
	const CACHA_TIME = 3600;
	const KEY_GET_STREAM_LINE = "%s_1_%s_%s";
	// get_simple_from_where
	const KEY_SIMPLE_FROM_WHERE = "%s_2_%s_%s_%s_%s_%s";
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_ana');
	}
	public function check_exist($content_md5){
		$check = $this->do_ana->check_exist($content_md5);
		return $check;
	}

	public function add_ana($data){
		$content_md5 = $data['content_md5'];
		$check = $this->do_ana->check_exist($content_md5);
		if($check){
			return true;
		}
		return $this->do_ana->add($data);
	}
	// {"city":{"name":"\u57ce\u5e02\u9875","pointStart":1390752000000,"pointInterval":86400000,
	// "data":[365,457],"unit":"\u6b21\uff0f\u5929"}}

	public function get_stream_line($to_type){
		$end_time = strtotime("tomorrow");
		$re = $this->get_simple_cache(self::KEY_GET_STREAM_LINE, "mo_ana", array($to_type, $end_time), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}

		$re = $this->do_ana->get_stream_line($to_type);
		$data = array();
		$pointStart = 0;
		$pointInterval = 86400000;
		if($re){
			$pointStart=time()."000";
			
			$pointStart = $re[0]['day']."000";

			$pointStart = intval($pointStart);
			$data = array();
			$start_day = $re[0]['day'];
			$end_day = $re[count($re)-1]['day'];
			$tmp = array();
			foreach($re as $v){
				$tmp[$v['day']] = $v;
			}
			for($i = $start_day ; $i<= $end_day; $i=$i+86400){
				$cnt = 0;
				if(isset($tmp[$i])){
					$cnt = intval($tmp[$i]['cnt']);
				}
				$data[] = $cnt;
			}
		}
		$result = array();
		$result['pointStart'] = $pointStart;
		$result['pointInterval'] = $pointInterval;
		$result['data'] = $data;
		
		$this->get_simple_cache(self::KEY_GET_STREAM_LINE, "mo_ana", array($to_type, $end_time), self::CACHA_TIME, $result);

		return $result;
	}

	public function add_ana_file($data){
		$re = $this->do_ana->add_ana_file($data);
		return $re;
	}
	public function update_nam_file($data, $id){
		$re = $this->do_ana->update_nam_file($data, $id);
		return $re;
	}
	public function get_anafile_by_filenamemd5($file_name_md5){
		$re = $this->do_ana->get_anafile_by_filenamemd5($file_name_md5);
		return $re;
	}

	//KEY_SIMPLE_FROM_WHERE
	public function get_simple_from_where($select, $where, $group_by='', $order_by=''){
		$end_time = strtotime("tomorrow");
		$re = $this->get_simple_cache(self::KEY_SIMPLE_FROM_WHERE, "mo_ana", array($select, $where, $group_by, $order_by, $end_time), self::CACHA_TIME);
		if($re !== false){
			//return $re;
		}

		$re = $this->do_ana->get_simple_from_where($select, $where,$group_by, $order_by);
		$this->get_simple_cache(self::KEY_SIMPLE_FROM_WHERE, "mo_ana", array($select, $where, $group_by, $order_by, $end_time), self::CACHA_TIME, $re);

		return $re;

	}

	public function get_sql($sql){
		$end_time = strtotime("tomorrow");
		$re = $this->get_simple_cache(self::KEY_GET_SQL, "mo_ana", array($sql), self::CACHA_TIME);
		if($re !== false){
			
			return $re;
		}

		$re = $this->do_ana->get_sql($sql);
		$this->get_simple_cache(self::KEY_GET_SQL, "mo_ana", array($sql), self::CACHA_TIME, $re);

		return $re;
	}



}