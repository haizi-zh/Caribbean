<?php

class Mo_tag extends ZB_Model {
	# 默认2条，目前使用5条，则提供一定的冗余
	const MAX_DIANPING_INDEX = 20;#最大点评索引数，用户商家的最新n条点评用
	const CACHA_TIME = 86400;
	const KEY_TAG_LIST = "%s_1";
	const KEY_CITY_TAGS_LIST = "%s_2_%s";
	const KEY_TAG_CAT_LIST = "%s_3";

	function __construct(){
		parent::__construct();
		$this->load->model("do/do_tag");
	}

	//获取一个城市的tag
	public function get_tags_by_city($city){

		$re = $this->get_simple_cache(self::KEY_CITY_TAGS_LIST, "mo_tag", array($city), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		$this->load->model("mo_shop");
		$shop_ids = $this->mo_shop->get_shops_by_brand_property_city(0,0,$city,1,1000);
		$tag_ids = $this->do_tag->get_tag_ids_by_shops($shop_ids);
		$tmp = array();
		if($tag_ids){
			$tag_list = $this->do_tag->get_tag_infos($tag_ids);
			foreach($tag_list as $v){
				$tmp[$v['type']][$v['id']] = $v['name'];
			}
		}
		$re = $this->get_simple_cache(self::KEY_CITY_TAGS_LIST, "mo_tag", array($city), self::CACHA_TIME, $tmp);

		return $tmp;
	}

	public function get_tag_cat_list(){
		$re = $this->get_simple_cache(self::KEY_TAG_CAT_LIST, "mo_tag", array(), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}

		$tag_cat_list = $this->do_tag->get_cat_list();
		$tags = $this->get_tag_list();
		foreach($tags as $v){
			$tag_cat_list[$v['type']]['children'][$v['id']] = $v;
		}

		$re = $this->get_simple_cache(self::KEY_TAG_CAT_LIST, "mo_tag", array(), self::CACHA_TIME, $tag_cat_list);
		return $tag_cat_list;
	}


	public function get_tag_list(){
		$re = $this->get_simple_cache(self::KEY_TAG_LIST, "mo_tag", array(), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		$tag_infos = $this->do_tag->get_tag_list();
		$re = $this->get_simple_cache(self::KEY_TAG_LIST, "mo_tag", array(), self::CACHA_TIME, $tag_infos);
		return $tag_infos;
	}
	
	public function get_shop_ids_by_tagids($tag_ids, $shop_ids){
		$re = $this->do_tag->get_shop_ids_by_tagids($tag_ids, $shop_ids);
		if($re){
			$tmp = array();
			foreach($re as $v){
				$tmp[$v['shop_id']] = $v['shop_id'];
			}
			$re = $tmp;
		}

		$re = $this->sort_list($shop_ids, $re);

		return $re;
	}
	public function sort_list($ids, $sort){
		$sorted = array();
		foreach($ids as $id){
			if(isset($sort[$id])){
				$sorted[$id] = $sort[$id];
			}
		}
		return $sorted;
	}

	// zb_index_tag_shop
	public function get_shoptagids($shop_ids){
		$tag_infos = $this->do_tag->get_shoptagids($shop_ids);
		return $tag_infos;
	}

}