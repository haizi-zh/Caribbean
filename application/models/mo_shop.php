<?php
#商家操作类
class Mo_shop extends ZB_Model {
	# 默认2条，目前使用5条，则提供一定的冗余
	const MAX_DIANPING_INDEX = 20;#最大点评索引数，用户商家的最新n条点评用
	const CACHA_TIME = 86400;
	const KEY_SHOPS_LIMIT = "%s_3_%s";
	const KEY_BRANDS_SHOP = "%s_14_%s";
	//shops_by_brand_property_city
	const KEY_SHOPS_PROPERTY_CITY_LIST = "%s_5_%s_%s";
	const KEY_SHOPS_PROPERTY_CITY_COUNT = "%s_6_%s_%s";

	//get_all_shop_reserve
	const KEY_GET_ALL_SHOP_RESERVE = "%s_7_%s";
	//get_all_shop_lowernames
	const KEY_GET_ALL_SHOP_LOWERNAMES = "%s_8";
	
	const KEY_GET_ALL_LOWERNAMES = "%s_9";

	//get_shop_ids_nearby
	const KEY_GET_SHOP_IDS_NEARBY = "%s_10_%s";

	function __construct(){
		parent::__construct();
		$this->load->model("do/do_shop");
		
		$this->load->model('do/do_index_brand_shop');
		$this->load->model('do/do_dianping');
		$this->load->model('do/do_brand');
		$this->load->model('do/do_attention_shop');
		$this->load->model('do/do_shop_nearby');
		$this->load->model('do/do_shop_photo');
		$this->load->model('do/do_index_shop_lastdianping');
		$this->load->model('do/do_attention_shop');

	}

	#添加一个商家
	public function add($data){
		return $this->do_shop->add($data);
	}
	public function update_info($data){
		$this->load->model("mo_dianping");
		if(!isset($data['id']) || !$data['id']){
			return false;
		}
		$re = $this->do_shop->update_info($data);
		//清理缓存
		$this->mo_dianping->modify_shop_cache($data['id']);

		return $re;
	}
	#更新一个商家
	public function update($data){
		$this->load->model("mo_dianping");
		//清理缓存
		$this->mo_dianping->modify_shop_cache($data['id']);
		
		return $this->do_shop->update($data);
	}

	public function get_shopinfo_by_id($id, $ext=false){
		$shop_infos = $this->get_shopinfo_by_ids(array($id), $ext);
		if(isset($shop_infos[$id])){
			return $shop_infos[$id];
		}
		return array();
	}
	
	#根据id获取商家信息
	public function get_shopinfo_by_ids($ids,$ext = false){
		if(!$ids){
			return array();
		}
		$ext  = true;
		if($ext){
			$ext_tag = 1;
		}
		
		#从do层获取结果
		$data = array();
		//缓存的key
		$re = $this->get_multi_cache("%s_sinfo1_%s_%s", "mo_shop", $ids, array($ext_tag));
		$data = $re['data'];
		$diff_ids = $re['diff_ids'];
		if(!$diff_ids){
			$sorted = $this->sort_list($ids, $data);
			return $sorted;
		}
		$this->load->model("mo_geography");
		$this->load->model("mo_directions");
		$all_directions_shopids = $this->mo_directions->get_all_shop_ids();
		//状态的过滤放到数据库外部计算。
		
		$format_re = $this->do_shop->get_shopinfo_by_ids_nostatus($diff_ids);
		#变成key value
		$return = array();
		foreach($format_re as $each){
			$short_desc = mb_substr($each['desc'], 0, 150);
			$each['short_desc'] = ($short_desc == $each['desc']) ? $short_desc : $short_desc.'...';
			$each['pic'] = upimage::format_brand_up_image($each['pic']);
			$have_directions = 0;
			if($all_directions_shopids && isset($all_directions_shopids[$each['id']])){
				$have_directions = 1;
			}
			$each['have_directions'] = $have_directions;
			$each['lower_name'] = $each['lower_name'];
			$return[$each['id']] = $each;
		}
		#附加信息
		if($ext){
			$domain = context::get('domain', "");
			foreach($return as $shop_id=>$shop){
				$city = $shop['city'];
				$city_lower_name = $this->mo_geography->get_city_lower_name($city);
				$shop_url = $domain."/".$city_lower_name."/".$shop['id']."/";
				$ext = array();
				$ext['shop_url'] = $shop_url;
				$ext['dianping_cnt'] = self::get_dianping_cnt($shop_id);
				$shop['ext'] = $ext;
				$return[$shop_id] = $shop;
			}
		}

		
		

		$re = $this->get_multi_cache("%s_sinfo1_%s_%s", "mo_shop", $ids, array($ext_tag), self::CACHA_TIME, $return);
		$data = $re['data'];
		if($data){
			foreach($data as $v){
				$return[$v['id']] = $v;
			}
		}
		#调整顺序
		$sorted = $this->sort_list($ids, $return);
		return $sorted;
	}
	// KEY_GET_ALL_LOWERNAMES
	public function get_id_by_lowername($lower_name){
		if(!$lower_name){
			return 0;
		}
		$data = $this->get_simple_cache(self::KEY_GET_ALL_LOWERNAMES, "mo_shop", array());
		if($data !== false){
			if(isset($data[$lower_name])){
				return $data[$lower_name];
			}
			return 0;
		}

		$all_shop_infos = $this->mo_shop->get_all_shop(true);
		$re = array();
		foreach($all_shop_infos as $v){
			$re[$v['lower_name']] = $v['id'];
		}
		$this->get_simple_cache(self::KEY_GET_ALL_LOWERNAMES, "mo_shop", array(), self::CACHA_TIME, $re);

		if(isset($re[$lower_name])){
			return $re[$lower_name];
		}
		return 0;
	}
	public function sort_list($ids, $sort){
		$sorted = array();
		foreach($ids as $id){
			if(isset($sort[$id]) && $sort[$id]['status'] == 0){
				$sorted[$id] = $sort[$id];
			}
		}
		return $sorted;
	}
	
	#添加品牌商家关联
	public function add_index_brand_shop($data){
		#判断是否已经加入
		$exist = $this->do_index_brand_shop->get_brand_exist($data['shop_id'], $data['brand_id']);
		if ($exist) {
			return true;
		}
		#获取商家属性
		$shop_id = $data['shop_id'];
		if(!isset($data['shop_property'])){
			$re = self::get_property_by_ids(array($shop_id));
			$data['shop_property'] = $re[$shop_id];
		}	
		
		#获取返回值
		return $this->do_index_brand_shop->add($data);
	}

	#添加品牌商家关联
	public function delete_index_brand_shop($data){
		#获取返回值
		return $this->do_index_brand_shop->delete($data);
	}
	
	#根据品牌获取商家id列表
	public function get_shops_by_brand_property_city($brand_id,$property=0,$city=0,$page=1,$pagesize=10){
		#如果没有选择品牌，则是直接找商家
		$offset = ($page - 1) * $pagesize;
		if($brand_id == 0){
			$data = $this->get_simple_cache(self::KEY_SHOPS_PROPERTY_CITY_LIST, "mo_shop", array($property, $city), self::CACHA_TIME);
			if($data !== false){
				$data = array_slice($data, $offset, $pagesize);
				return $data;
			}

			$re = $this->do_shop->get_shops_by_city_property($city,$property,1,1000);
			$result = array();
			foreach($re as $each){
				$result[] = $each['id'];
			}

			$re = $this->get_simple_cache(self::KEY_SHOPS_PROPERTY_CITY_LIST, "mo_shop", array($property, $city), self::CACHA_TIME, $result);
			$result = array_slice($result, $offset, $pagesize);

			return $result;
		}else{
			#获取返回值
			$re = $this->do_index_brand_shop->get_shops_by_brand_property_city($brand_id,$property,$city,$page,$pagesize);
			$result = array();
			foreach($re as $each){
				$result[] = $each->shop_id;
			}
			return $result;
		}
	}

	#根据品牌，城市，属性获取商家总数(分页用)
	public function get_shopcnt_by_brand_property_city($brand_id,$property=0,$city=0){
		#如果没有选择品牌，则是直接找商家
		if($brand_id == 0){
			$data = $this->get_simple_cache(self::KEY_SHOPS_PROPERTY_CITY_COUNT, "mo_shop", array($property, $city), self::CACHA_TIME);
			if($data !== false){
				return $data;
			}

			$re = $this->do_shop->get_shopcnt_by_property_city($city,$property);
			$re = $this->tool->std2array($re);
			$data = isset($re[0]['count(*)'])?$re[0]['count(*)']:0;
			$this->get_simple_cache(self::KEY_SHOPS_PROPERTY_CITY_COUNT, "mo_shop", array($property, $city), self::CACHA_TIME, $data);

			return $data;
		}else{
			#获取返回值
			$re = $this->do_index_brand_shop->get_shopcnt_by_brand_property_city($brand_id,$property,$city);
			$re = $this->tool->std2array($re);
			return isset($re[0]['count(*)'])?$re[0]['count(*)']:0;
		}
	}

	public function get_shops_list_by_shopids($shop_ids, $page=1, $pagesize = 10){
		$re = $this->do_shop->get_shops_list_by_shopids($shop_ids,$page,$pagesize);
		$result = array();
		foreach($re as $each){
			$result[] = $each->id;
		}
		return $result;

	}
	
	#根据商家id获取属性信息
	public function get_property_by_ids($ids){
		#获取返回值
		$re = $this->do_shop->get_property_by_ids($ids);
		
		#格式化
		$re = $this->tool->std2array($re);
		
		#调整格式
		$return = array();
		foreach($re as $each){
			$return[$each['id']] = $each['property'];
		}
		
		return $return;
	}
	
	#根据商家id，获取最新的晒单
	public function get_lastdianping_by_shopids($shop_ids){
		$this->load->model('mo_dianping');
		$this->load->model('mo_user');

		#获取返回值
		$re = $this->do_index_shop_lastdianping->get_lastdianping_by_shopids($shop_ids);
		
		#格式化
		$re = $this->tool->std2array($re);

		#组装数据
		$return = array();
		$dianping_ids = array();
		foreach($re as $each){
			$last_dianpings = $each['last_dianpings'];
			$shop_id = $each['shop_id'];
			if($last_dianpings){
				$return[$shop_id] = json_decode($last_dianpings, true);
				$dianping_ids = array_merge($dianping_ids,json_decode($last_dianpings, true));
			}else{
				$return[$shop_id] = array();
			}
		}
		#获取点评信息
		$dianping_infos = $this->mo_dianping->get_dianpinginfo_by_ids($dianping_ids);
		
		
		#重新调整结构
		$uids = array();
		foreach($return as $shop_id=>$dianping_ids){
			$infos = array();
			foreach($dianping_ids as $dianping_id){
				$dianping = isset($dianping_infos[$dianping_id])?$dianping_infos[$dianping_id]:'';
				if($dianping){
					if($dianping['status'] == 1){
						continue;
					}
					$uids[] = $dianping['uid'];
					#点评文字内容为空的时候,不显示
					$clean_body = trim($dianping['clean_short_body']);
					if(empty($clean_body)) continue;
					$infos[] = $dianping;
				}
			}
			$infos = array_slice($infos,0,2);
			$return[$shop_id] = $infos;
		}
		#获取用户信息
		$userinfos_re = $this->mo_user->get_simple_userinfos($uids);
		
		#加入点评的用户信息
		foreach($return as $shop_id=>$dianpings){
			foreach($dianpings as $index=>$dianping){
				$dianping['user_info'] = isset($userinfos_re[$dianping['uid']])?$userinfos_re[$dianping['uid']]:array();
				$dianpings[$index] = $dianping;
			}
			$dianpings = array_slice($dianpings,0,Mo_shop::MAX_DIANPING_INDEX);
			$return[$shop_id] = $dianpings;
		}
		
		return $return;
	}
	
	#添加一个最新晒单
	public function add_last_dianping($shop_id,$dianping_id){		
		#获取已有的点评数据
		$re = $this->do_index_shop_lastdianping->get_lastdianping_by_shopids(array($shop_id));
		if(!isset($re[0]->last_dianpings) || empty($re[0]->last_dianpings)){
			$data = array('shop_id'=>$shop_id,'last_dianpings'=>json_encode(array($dianping_id)));
			$this->do_index_shop_lastdianping->add($data);
		}else{
			$dianpings = json_decode($re[0]->last_dianpings, true);
			if(count($dianpings) >= self::MAX_DIANPING_INDEX){#如果点评数大于最大值
				unset($dianpings[count($dianpings)-1]);#挪出最后一个
			}
			array_unshift($dianpings,$dianping_id);#在开头插入
			$this->do_index_shop_lastdianping->update($shop_id,json_encode($dianpings));#更新
		}
	}
	
	#获取商家的点评总数
	public function get_dianping_cnt($shop_id){
		$re = $this->do_dianping->get_dianping_cnt($shop_id);
		#格式化
		$re = $this->tool->std2array($re);
		return isset($re[0]['count(*)'])?intval($re[0]['count(*)']):0;
	}
	

	public function delete_cache_shop_brand($id){
		$cache_keys = context::get("cache_keys", false);
		$key = sprintf(self::KEY_BRANDS_SHOP, $cache_keys['mo_shop'], $id);
		$data =  $this->memcached_library->delete($key);
		
	}
//echo $this->convert(memory_get_usage(true))."  "; 
function convert($size){ 
$unit=array('b','kb','mb','gb','tb','pb'); 
return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i]; 
} 

	public function get_brands_by_shops($ids){
		$re = array();
		foreach($ids as $id){
			$data = array();
			$data = $this->get_simple_cache(self::KEY_BRANDS_SHOP, "mo_shop", array($id), self::CACHA_TIME);
			if($data !== false){
				$re[$id] = $data;
			}else{

				$format_re = $this->do_index_brand_shop->get_brands_by_shops(array($id));
				#格式化
				$return = array($id=>array());
				foreach($format_re as $each){
					if(!isset($return[$each['shop_id']][$each['brand_id']])){
						$return[$each['shop_id']][$each['brand_id']] = $each['brand_id'];
					}
				}

				$this->get_simple_cache(self::KEY_BRANDS_SHOP, "mo_shop", array($id), self::CACHA_TIME, $return[$id]);


				$re[$id] = $return[$id];
			}
		}
		return $re;
	}

	public function get_all_shop_ids(){
		$shops = $this->get_all_shop();
		$shop_ids = array();
		if($shops){
			foreach($shops as $v){
				$shop_ids[$v['id']] = $v['id'];
			}
		}
		return $shop_ids;
	}


	#根据商家id获取品牌列表
	public function get_brands_by_shop($shop_id){
		if(!$shop_id){
			return array();
		}
		$list = $this->get_brands_by_shops(array($shop_id));
		if(isset($list[$shop_id])){
			return $list[$shop_id];
		}
		return array();
	}
	
	public function get_shops_by_brand($brand_id){
		
		$re = $this->do_index_brand_shop->get_shops_by_brand($brand_id);
		#格式化
		$format_re = $this->tool->std2array($re);
		
		$result = array();
		foreach($format_re as $each){
			$result[] = $each['shop_id'];
		}
		return $result;
	}

	#获取全部品牌
	public function get_all_brand(){
		$this->load->model("mo_brand");
		$format_re = $this->mo_brand->get_all_brand();
		return $format_re;
	}
	
	#渲染商家（city页用到）
	public function render($shop_ids){
		$data = self::provide_data($shop_ids);
		return self::drawing($data);
	}
	
	#为渲染提供数据
	public function provide_data($shop_ids){
		#获取商家信息
		$shop_infos = $this->get_shopinfo_by_ids($shop_ids,true);
		
		#获取最新评论
		$dianping_infos = $this->get_lastdianping_by_shopids($shop_ids);

		foreach ($dianping_infos as $k => $v) {
			$tmp = $v;
			foreach ($tmp as $kk => $vv) {
				if(!$vv['status'] == 0){
					unset($tmp[$kk]);
				}
			}
			$dianping_infos[$k] = $tmp;
		}
		

		#组装数据
		$result = array();
		$uids = array();
		foreach($shop_ids as $shop_id){
			if(!isset($shop_infos[$shop_id])){
				continue;
			}
			$shop_info = $shop_infos[$shop_id];
			$shop_info['comments'] = isset($dianping_infos[$shop_id])?$dianping_infos[$shop_id]:array();
			$result[$shop_id] = $shop_info;
		}
		return $result;
	}
	
	#模板渲染(准备废弃)
	private function drawing($data){
		$html = '';
		//$shop_base_html = '<div class="comment_wrap" id="comment_list"><div class="comment clearfix"><div class="avatar fl"><div class="avatar_pic"><a href="/shop/%s" target="_blank"><img src="%s" width="170" height="128"/></a></div></div><div class="comment_info"><div class="title"><div class="rating_wrap_small fr"><span title="%s星商户" class="star star%s0"></span></div>%s</div><div><div class="avatar_comment fr"><a href="" target="_blank" class="linkb">%s条</a>点评</div><p><span class="textb">地址： </span>%s</p></div><div><span class="textb">营业时间： </span>%s</div><div class="bottom_comment">%s</div></div></div></div>';
		#去掉了营业时间
		$shop_base_html = '<div class="comment_wrap" id="comment_list"><div class="comment clearfix"><div class="avatar fl"><div class="avatar_pic"><a href="/shop/%s" target="_blank"><img src="%s" width="170" height="128"/></a></div></div><div class="comment_info"><div class="title"><div class="rating_wrap_small fr"><span title="%s星商户" class="star star%s0"></span></div>%s</div><div><div class="avatar_comment fr"><a href="" target="_blank" class="linkb">%s条</a>点评</div><p><span class="textb">地址： </span>%s</p></div><div class="bottom_comment">%s</div></div></div></div>';
		foreach($data as $shop_id=>$shop){
			$dianping_html = self::get_lastest_dianping_html(isset($shop['comments'])?$shop['comments']:array());
			$segment_data = array();
			$segment_data[] = $shop['id'];
			$segment_data[] = $shop['pic'];
			$score = $shop['score'];
			$segment_data[] = $score;
			$segment_data[] = $score;
			$segment_data[] = $shop['name'];
			$segment_data[] = $shop['ext']['dianping_cnt'];
			$segment_data[] = $shop['address'];
// 			$segment_data[] = $shop['business_hour'];
			$segment_data[] = $dianping_html;
			$html .= vsprintf($shop_base_html, $segment_data);
		}
		
		return $html;
	}
	
	#渲染最新的2条评论html(准备废弃)
	private function get_lastest_dianping_html($data){
		if(empty($data)) return ''; #没有评论
		
		#有评论
		$html= '';
		$dianping_base_html = '<div class="one_comment"><em>"%s"</em><span class="user">%s点评</span></div>';
		foreach($data as $comment){
			$segment_data = array();
			$segment_data[] = $comment['clean_short_body'];
			$segment_data[] = isset($comment['user_info']['uname'])?$comment['user_info']['uname']:'';
			$html .= vsprintf($dianping_base_html, $segment_data);
		}
		return $html;
	}
	
	#获取所有商家
	public function get_all_shop($show_all = false){
		$format_re = $this->do_shop->get_all_shop($show_all);
		return $format_re;
	}

	//get_all_shop_reserve
	//const KEY_GET_ALL_SHOP_RESERVE = "%s_7_s";

	public function get_all_shop_reserve($coutry=0){
		$re = $this->get_simple_cache(self::KEY_GET_ALL_SHOP_RESERVE, "mo_shop", array($coutry), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		$list = $this->get_all_shop(true);
		if($coutry){
			foreach($list as $k=> $v){
				$city = $v['city'];
				if($city >58 && $city != 97){
					unset($list[$k]);
				}
			}
		}
		$tmp = array();
		foreach($list as $k => $v){

			$name = $v['name'];
			$english_name = $v['english_name'];

			$name_nospace = str_replace(array(" "," ", "    ","（","）","(",")"), "", $name);
			$english_name_nospace = str_replace(array(" "," ", "    ","（","）","(",")"), "", $english_name);
		
			$tmp[$name_nospace] = $v['id'];
			$tmp[$english_name_nospace] = $v['id'];

			$tmp[$name] = $v['id'];
			$tmp[$english_name] = $v['id'];
			
			$name = trim($name);
			$english_name = trim($english_name);
			$tmp[$name] = $v['id'];
			$tmp[$english_name] = $v['id'];

			$name_lower = strtolower($name);
			$english_name_lower = strtolower($english_name);
			$tmp[$name_lower] = $v['id'];
			$tmp[$english_name_lower] = $v['id'];

  			$name_explode = explode("/", $name);
  			foreach($name_explode as $vv){
  				$tmp[$vv] = $v['id'];
  			}
			$english_name_explode = explode("/", $english_name);
  			foreach($english_name_explode as $vv){
  				$tmp[$vv] = $v['id'];
  			}
		}
		$re = $this->get_simple_cache(self::KEY_GET_ALL_SHOP_RESERVE, "mo_shop", array($coutry), self::CACHA_TIME, $tmp);
		return $tmp;
	}

	//get_all_shop_lowernames
	//const KEY_GET_ALL_SHOP_LOWERNAMES = "%s_8";
	public function get_all_shop_lowernames(){
		$re = $this->get_simple_cache(self::KEY_GET_ALL_SHOP_LOWERNAMES, "mo_shop", array(), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}

		$this->load->model("mo_geography");
		
		$list = $this->get_all_shop(true);
		$citys = $this->mo_geography->get_all_cityinfos();
		$re = array();
		foreach($list as $v){
			$shop_id = $v['id'];
			$city = $v['city'];
			if(isset($citys[$city])){
				$city_info = $citys[$city];
				$lower_name = $city_info['lower_name'];
				$re[$shop_id] = $lower_name;
			}
		}
		$this->get_simple_cache(self::KEY_GET_ALL_SHOP_LOWERNAMES, "mo_shop", array(), self::CACHA_TIME, $re);
		return $re;
	}
	#更新商家分数
	public function update_score($data){
		return $this->do_shop->update_score($data);
	}

	
	#foradmin
	public function get_shop_list_for_admin($page, $pagesize, $params = array()){
		return $this->do_shop->get_shop_list_for_admin($page, $pagesize, $params);
	}
	
	#foradmin
	public function get_shop_cnt_for_admin($params = array()){
		return $this->do_shop->get_shop_cnt_for_admin($params);
	}

	public function check_shop_attention($uid, $shop_id){
		return $this->do_attention_shop->check_shop_attention($uid, $shop_id);
	}
	public function add_shop_attention($uid, $shop_id){
		return $this->do_attention_shop->add_shop_attention($uid, $shop_id);
	}
	public function del_shop_attention($uid, $shop_id){
		return $this->do_attention_shop->del_shop_attention($uid, $shop_id);
	}


	public function search_shop($name, $page = 1, $pagesize = 10){
		return $this->do_shop->search_shop($name, $page, $pagesize);
	}
	public function search_shop_cnt($name){
		return $this->do_shop->search_shop_cnt($name);
	}


	public function add_shop_nearby($data){
		$id = $this->do_shop_nearby->add($data);
		if (!$id) {
			return false;
		}
		return  $id;
	}

	// KEY_GET_SHOP_IDS_NEARBY
	public function get_shop_ids_nearby($shop_id){
		$re = $this->get_simple_cache(self::KEY_GET_SHOP_IDS_NEARBY, "mo_shop", array($shop_id), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}

		$list = $this->do_shop_nearby->get_shop_ids_nearby($shop_id);
		if($list){
			$nearby_ids = array();
			foreach ($list as $key => $value) {
				$nearby_ids[] = $value['target_shop_id'];
			}
			$shop_infos = $this->get_shopinfo_by_ids($nearby_ids);

			foreach ($list as $key => $value) {
				$target_shop_id = $value['target_shop_id'];
				if(isset($shop_infos[$target_shop_id])){
					if($shop_infos[$target_shop_id]['status']){
						unset($list[$key]);
						continue;
					}
					$name = $shop_infos[$target_shop_id]['name'];
					$english_name = $shop_infos[$target_shop_id]['english_name'];
					$city = $shop_infos[$target_shop_id]['city'];

					$title = $name;
					if($name != $english_name){
						$title = $name .'-' . $english_name;
					}

					//$name = $this->tool->substr_cn2($name, 24);
					$list[$key]['city'] = $city;
					$list[$key]['name'] = $name;
					$list[$key]['english_name'] = $english_name;
					$list[$key]['title'] = $title;
					$list[$key]['shop_id'] = $target_shop_id;
					$list[$key]['pic'] = $shop_infos[$target_shop_id]['pic'];
				}else{
					unset($list[$key]);
					continue;
				}
			}
			$list = array_slice($list, 0, 10);
		}

		$this->get_simple_cache(self::KEY_GET_SHOP_IDS_NEARBY, "mo_shop", array($shop_id), self::CACHA_TIME, $list);

		return $list;
	}


	public function get_attention_shop($uid){
		
		$list = $this->do_attention_shop->get_attentions($uid);
		$shop_ids = array();
		if($list){
			$shop_ids = array();
			foreach ($list as $key => $value) {
				$shop_ids[] = $value['shop_id'];
			}
			$shop_ids = array_unique($shop_ids);
		}
		return $shop_ids;
	}
	

	public function add_shop_photo($data){
		$re = $this->do_shop_photo->add_shop_photo($data);
		return $re;
	}

	public function delete_shop_photo($id){
		$re = $this->do_shop_photo->delete_shop_photo($id);
		return $re;
	}

	public function modify_photo_desc($data, $id){
		$re = $this->do_shop_photo->modify_photo_desc($data, $id);
		return $re;
	}

	public function get_shop_photo($id){
		$re = $this->do_shop_photo->get_shop_photo($id);
		return $re;
	}

	public function get_shopphoto_by_shopid($shop_id, $page=1, $pagesize=10){
		$list = $this->do_shop_photo->get_shopphoto_by_shopid($shop_id, $page, $pagesize);
		return $list;
	}

	public function get_shopphoto_by_shopid_count($shop_id){
		$list = $this->do_shop_photo->get_shopphoto_by_shopid_count($shop_id);
		return $list;
	}

	public function delete_shop_cache($shop_id=0, $brand_id=0){
		$use_memcache = context::get('use_memcache', 0);

		if($use_memcache){
			$cache_keys = context::get("cache_keys", false);
			$cache_key_templage = "%s_shop_%s_%s";
			if($shop_id){
				$cache_key = sprintf($cache_key_templage, $cache_keys['shop_pre'], $shop_id, 0);
				$data = $this->memcached_library->delete($cache_key);
			}
			if($brand_id){
				$shops = $this->get_shops_by_brand($brand_id);
				foreach($shops as $shop_id){
					$cache_key = sprintf($cache_key_templage, $cache_keys['shop_pre'], $shop_id, 0);
					$data = $this->memcached_library->delete($cache_key);
				}
			}

		}

	}

	public function get_shop_info_by_limit($limit = 6000){
		$re = $this->get_simple_cache(self::KEY_SHOPS_LIMIT, "mo_shop", array($limit), self::CACHA_TIME);
		if($re !== false){
			return $re;
		}
		$result = $this->do_shop->get_shop_info_by_limit($limit);
		$this->get_simple_cache(self::KEY_SHOPS_LIMIT, "mo_shop", array($limit), self::CACHA_TIME, $result);
		return $result;
	}

	public function get_shops($page , $size){
		$this->load->database();
		return $this->db->get('zb_shop' , $size ,($page -1) * $size)->result_array() ;
	}

	public function batch_update($assoc , $field){
		$this->load->database();
		return $this->db->update_batch('zb_shop' , $assoc , $field) ;
	}

	public function get_bounds_shops($city_id ,$minlat , $maxlat ,$minlng , $maxlng , $page=1 , $size=20){
		$ret = array() ;
		$this->load->database() ;
		$this->db->select('id , name ,english_name ,address ,desc , lat , lng') ;
		$this->db->where('city' , $city_id ) ;
		$this->db->where('location !=' , '') ;
		$this->db->where('lat >=' , $minlat) ;
		$this->db->where('lat <=' , $maxlat) ;
		$this->db->where('lng >=' , $minlng) ;
		$this->db->where('lng <=' , $maxlng) ;
		$result = $this->db->get('zb_shop') ;
		$ret['count'] = $result->num_rows() ;
		if($ret['count'] > $size) {
			$this->db->select('id , name ,english_name ,address ,desc , lat , lng') ;
			$this->db->where('city' , $city_id ) ;
			$this->db->where('location !=' , '') ;
			$this->db->where('lat >=' , $minlat) ;
			$this->db->where('lat <=' , $maxlat) ;
			$this->db->where('lng >=' , $minlng) ;
			$this->db->where('lng <=' , $maxlng) ;
			$ret['rows'] = $this->db->get('zb_shop' , $size , ( $page - 1 )* $size )->result_array() ;
		} else {
			$ret['rows'] = $result->result_array() ;
		}
		return $ret ;
	}

	public function get_shops_by_city_property($city,$property,$page=1,$pagesize=10){
		$list = $this->do_shop->get_shops_by_city_property($city,$property,$page,$pagesize);
		return $list;
	}

	public function get_shopids_by_city($city_id){
		$list = $this->get_shops_by_city_property($city_id,0,1,10000);
		if(!$list){
			return array();
		}
		$shop_ids = array();
		foreach($list as $v){
			$shop_ids[$v['id']] = $v['id'];
		}
		return $shop_ids;
	}

	public function get_shopids_by_country($country_id){
		$list = $this->do_shop->get_shops_by_country($country_id);
		if(!$list){
			return array();
		}
		
		$shop_ids = array();
		foreach($list as $v){
			$shop_ids[$v['id']] = $v['id'];
		}
		return $shop_ids;
	}


}





