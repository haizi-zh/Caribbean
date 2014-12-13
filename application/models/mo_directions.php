<?php
class Mo_directions extends ZB_Model {
	const CACHA_TIME = 86400;
	// get_directions_list
	const KEY_GET_DIRECTIONS_LIST= "%s_1_%s_%s";
	// get_line_infos
	const KEY_GET_LINE_INFOS = "%s_4_%s_%s";
	// get_directions_line_list
	const KEY_GET_DIRECTIONS_LINE_LIST = "%s_3_%s_%s";
	// get_all_shop_ids
	const KEY_GET_DIRECTIONS_ALL_SHOP_IDS = "%s_5";

	function __construct(){
		parent::__construct();
		$this->load->model("do/do_directions");
	}
	public function get_all_shop_ids(){
		$re = $this->get_simple_cache(self::KEY_GET_DIRECTIONS_ALL_SHOP_IDS, "mo_directions", array(), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		$re = $this->do_directions->get_all_shop_ids();
		$this->get_simple_cache(self::KEY_GET_DIRECTIONS_ALL_SHOP_IDS, "mo_directions", array(), self::CACHA_TIME, $re);
		return $re;
	}

	public function add($data){
		$re = $this->do_directions->add($data);
		return $re;
	}
	public function update($data, $id){
		$re = $this->do_directions->update($data, $id);
		return $re;
	}

	public function delete_type($data){
		$id = isset($data['id'])?$data['id']:0;
		$res = $this->do_directions->delete($id) ;
		return $res;
	}

	public function recover_type($data){
		$id = isset($data['id'])?$data['id']:0;
		return $this->do_directions->recover($id);
	}
	public function get_info_by_shopid($shop_id){
		if(!$shop_id){
			return array();
		}
		$re = $this->do_directions->get_info_by_shopid($shop_id);
		return $re;
	}
	public function get_info($id){
		if(!$id){
			return array();
		}
		$re = $this->do_directions->get_info($id);
		return $re;
	}

	public function get_exist_type($shop_id, $type){
		if(!$shop_id){
			return false;
		}
		$re = $this->do_directions->get_exist_type($shop_id, $type);
		return $re;
	}
	//KEY_GET_DIRECTIONS_LIST
	//
	public function get_directions_list($shop_id, $status=0){
		$re = $this->get_simple_cache(self::KEY_GET_DIRECTIONS_LIST, "mo_directions", array($shop_id, $status), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}

		$list = $this->do_directions->get_directions_list($shop_id, $status);
		if($list){
			foreach($list as $k => $v){
				if($v['description_url']){
					$description = $v['description'];
					$description_url = $v['description_url'];
					$description_url = explode("|", $description_url);
					$re = tag::tag_to_link($description, $description_url);
					$list[$k]['description'] = $re;
				}
			}
		}
		$this->get_simple_cache(self::KEY_GET_DIRECTIONS_LIST, "mo_directions", array($shop_id, $status), self::CACHA_TIME, $list);
		return $list;
	}

	public function get_line_info($id){
		if(!$id){
			return array();
		}
		$re = $this->do_directions->get_line_info($id);
		return $re;
	}
	public function get_all_lines($directions_id){
		$list = $this->get_directions_line_list(array($directions_id));
		return $list;
	}
	//KEY_GET_LINE_INFOS
	public function get_line_infos($directions_id, $status = 0){
		$re = $this->get_simple_cache(self::KEY_GET_LINE_INFOS, "mo_directions", array($directions_id, $status), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}

		$list = $this->do_directions->get_directions_line_list(array($directions_id));
		if($list){
			foreach($list as $k => $v){
				if($v['title_url']){
					$title = $v['title'];
					$title_url = $v['title_url'];
					$title_url = explode("|", $title_url);
					$re = tag::tag_to_link($title, $title_url);
					$list[$k]['title'] = $re;
				}
				if($v['description_url']){
					$description = $v['description'];
					$description_url = $v['description_url'];
					$description_url = explode("|", $description_url);
					$re = tag::tag_to_link($description, $description_url);
					$list[$k]['description'] = $re;
				}
			}
		}
		
		$level_list = array();
		if($list){
			foreach ($list as $key => $value) {
				$level_list[$value['level']][$value['item_type']]= $value;
			}
		}
		$this->get_simple_cache(self::KEY_GET_LINE_INFOS, "mo_directions", array($directions_id, $status), self::CACHA_TIME, $level_list);
		return $level_list;
	}

	// KEY_GET_DIRECTIONS_LINE_LIST
	public function get_directions_line_list($directions_ids, $status=0){
		$list = $this->do_directions->get_directions_line_list($diff_ids, $status);
		return $list;
	}

	public function add_line($data){
		$re = $this->do_directions->add_line($data);
		return $re;
	}
	public function update_line($data, $id){
		$re = $this->do_directions->update_line($data, $id);
		return $re;
	}


	public function delete_line($data){
		$id = isset($data['id'])?$data['id']:0;
		$res = $this->do_directions->delete_line($id) ;
		return $res;
	}

	public function recover_line($data){
		$id = isset($data['id'])?$data['id']:0;
		return $this->do_directions->recover_line($id);
	}



}