<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class shop extends ZB_Controller {
	# http://zan.com/mobile/shop/get_city_info?city_id=1

	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model('mo_tag');
		$this->load->model('mo_fav');
		$this->load->model('mo_directions');
	}
	// http://zan.com/mobile/shop/get_license
	
	public function get_license(){
		$content = '<div class="info_content">
						<p>在使用赞佰网之前，请您务必仔细阅读本网站条款。您的使用行为将被视为对本声明的认可。</p>
						<p><b>所有权和版权</b></p>
						<p>北京赞佰千华网络科技有限公司（赞佰网）拥有本站内容版权和其它相关知识产权。</p>
						<p>未经本公司书面许可，任何人不得复制或以其他任何方式使用本站内容。对不遵守本声明或其他违法、恶意使用本网站内容者，本公司保留追究其法律责任的权利。</p>
						<p><b>免责声明</b></p>
						<p>如果您向赞佰网发布内容，您需要保证，</p>
						<p>1. 拥有您上传到本网站的所有内容的版权或拥有内容所有者的上传许可。<br/>
							2. 能够授予赞佰网相关的权利。<br/>
							3. 不得利用本站制作、复制、查阅和传播下列信息：<br/>
							&nbsp;&nbsp;a.煽动抗拒、破坏宪法和法律、行政法规实施的；<br/>
   &nbsp;&nbsp;b.煽动颠覆国家政权，推翻社会主义制度的；<br/>
   &nbsp;&nbsp;c.煽动分裂国家、破坏国家统一的；<br/>
   &nbsp;&nbsp;d.煽动民族仇恨、民族歧视，破坏民族团结的；<br/>
   &nbsp;&nbsp;e.捏造或者歪曲事实，散布谣言，扰乱社会秩序的；<br/>
   &nbsp;&nbsp;f.宣扬封建迷信、淫秽、色情、赌博、暴力、凶杀、恐怖，教唆犯罪的；<br/>
   &nbsp;&nbsp;g.公然侮辱他人或者捏造事实诽谤他人的；<br/>
   &nbsp;&nbsp;h.损害国家机关信誉的；<br/>
   &nbsp;&nbsp;i.其他违反宪法和法律、行政法规的。<br/>
						</p>
						<p>对于因不满足上述要求所引起的法律传唤、指控、诉讼等，以及因此导致的一切损失、赔偿和费用，赞佰网将不负担任何法律责任。</p>
						<p>赞佰网的部分信息取自互联网，或由第三方和网友提供。赞佰网不保证其准确性。<br/>
赞佰网对使用本站信息造成的一切后果不做任何形式的保证，亦不承担任何法律责任。<br/>
赞佰网可以随时修改或中断服务而不通知用户，亦不承担任何法律责任。<br/>
赞佰网保留删除站内内容而不通知用户的权利。
						</p>
						<p><b>版权投诉</b></p>
						<p>任何单位或个人认为，赞佰网提供的内容侵犯了您的版权，需要赞佰网采取删除、屏蔽等必要措施的。请提供如下所要求的通知书。<br/>
						版权投诉通知书应包含下列内容：<br/>
a.权利人的姓名及联系方式和地址。<br/>
b.明确指出声称被侵权的内容。<br/>
c.构成侵权的证明材料。<br/>
d.纳入如下声明：“本人本着诚信原则，认为被侵犯版权的材料未获得版权所有人、其代理或法律的授权。本人承诺投诉全部信息真实、准确，否则自愿承担一切后果。”
						</p>
						<p>邮寄地址：北京市海淀区北四环西路9号2104-145      邮 编：100080</p>
						<p>客服信箱：<a href=mailto:support@zanbai.com><span class="spetex">support@zanbai.com</span></a></p>
						<p>任何法律问题，将依照中华人民共和国的法律予以处理。</p>
					</div>';

		$data['content'] = $content;
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'','data'=>$data));
	}

	// http://zan.com/mobile/shop/check_version/?version=2
	// http://zanbai.com/mobile/shop/check_version/?versionCode=1.2&versionName=1.0
	// http://zanbai.com/mobile/shop/check_version/?versionCode=1&versionName=1.0
	// 返回code＝200说明有版本更新。
	public function check_version(){
		$new_versionCode = "6";
		$new_versionName = "1.0";
		$versionCode = $this->input->get("versionCode", true, 1);
		$versionName = $this->input->get("versionName", true, '1.0');
		$data = array();
		$data['have_update'] = 0;
		if($versionCode < $new_versionCode){
			$data['have_update'] = 1;
			$data['download_url'] = "http://zbfile.b0.upaiyun.com/ak/zanbai_v1.05.apk";
			$data['msg'] = "新版本功能:1修复了bug 2增加了筛选功能";

			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'pleace update new version','data'=>$data));
			exit();
		}
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'not new version', 'data'=>$data ));
		exit();
	}

	# http://zan.com/mobile/shop/get_nearby_shop?shop_id=1
	public function get_nearby_shop(){
		$data = array();
		$data['list'] = array();

		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}

		$shop_id = $this->input->get('shop_id', true, "");
		$nearby_shop_infos = $this->mo_shop->get_shop_ids_nearby($shop_id);
		if(!$nearby_shop_infos){
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
			return;
		}

		$shop_infos = array_slice($nearby_shop_infos, 0, 10);
		if($shop_infos){
			$shop_ids = array();
			foreach($shop_infos as $v){
				$shop_ids[$v['shop_id']] = $v['shop_id'];
			}
			$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
		}
		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
		$location = $shop_info['location'];
		$lon = 0; $lat = 0;
		if($location){
			$locations = explode(',',$location);
			$lon = trim($locations[0]);
			$lat = trim($locations[1]);
		}
		$tmp = $this->format_shop_infos($shop_infos, $uid, $lon, $lat);
		$data['list'] = $tmp;
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
	}

	public function get_city_info(){
		try{
			$this->load->model("mo_geography");
			#获取参数
			$city_id = $this->input->get('city_id', true, "");
			$city_info = $this->mo_geography->get_city_info_by_id($city_id);
			$data = $city_info;
			if (isset($city_info['reserve_3']) && $city_info['reserve_3'] ) {
				$reserve_3 = $city_info['reserve_3'];
			}else{
				$reserve_3 = "http://zanbai.b0.upaiyun.com/2013/05/31bed01c589f0fee.jpg!shoppic";
			}
			$reserve_3 = substr($reserve_3, 0, strpos($reserve_3, "!"));
			$reserve_3 .= "!shoppic";
			$data['pic'] = $reserve_3;
			
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
		
	}
	# http://zan.com/mobile/shop/search_shop?q=123
	public function search_shop(){
		try{
			#获取参数
			$q = $this->input->get('q', true, "");
			$page = $this->input->get("page", true, 1);
			$pagesize = $this->input->get("pagesize", true, 10);
		
			#获取商家信息
			$this->load->model('mo_shop');
			$total_number = 0;
			$shop_list = array();

			if ($q) {
				$total_number = $this->mo_shop->search_shop_cnt($q);
				$shop_list = $this->mo_shop->search_shop($q, $page, $pagesize);
				if ($shop_list) {
					$i=0;
					foreach ($shop_list as $key => $value) {
						$info = array();
						$info['id'] = $value['id'];
						$info['name'] = $value['name'];
						$info['english_name'] = $value['english_name'];
						$info['pic'] = $value['pic'];
						$shop_list[$i] = $info;
						$i++;
					}
				}
			}
			$data['total_number'] = $total_number;
			$data['list'] = $shop_list;
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}

	}
	# http://zan.com/mobile/shop/attention_del?type=add
	public function attention_del(){
		$data = array();
		$this->load->model("mo_shop");
		$shop_id = $this->input->post("shop_id", true, "");
		$type = $this->input->post("type", true, 'add');
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		if ($uid && $shop_id) {
			$this->mo_shop->del_shop_attention($uid, $shop_id);

		}
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'操作成功', 'data'=>$data));
	}
	# http://zan.com/mobile/shop/attention_add
	public function attention_add(){
		$data = array();
		$this->load->model("mo_shop");
		$shop_id = $this->input->post("shop_id", true, "");
		$type = $this->input->post("type", true, 'add');
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		if ($uid && $shop_id) {
			$this->mo_shop->add_shop_attention($uid, $shop_id);
		}
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'操作成功', 'data'=>$data));
	}

	# http://zan.com/mobile/shop/attention?type=add
	public function attention(){
		$data = array();
		$this->load->model("mo_shop");
		$shop_id = $this->input->post("shop_id", true, "");
		$type = $this->input->post("type", true, 'add');
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		if ($uid && $shop_id) {
			if ($type == 'add') {
				$this->mo_shop->add_shop_attention($uid, $shop_id);
			}else{
				$this->mo_shop->del_shop_attention($uid, $shop_id);
			}
		}
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'操作成功', 'data'=>$data));
	}

	# /mobile/shop/get_all_citys
	public function get_all_citys(){
		$this->load->model('mo_geography');
		$cities = $this->mo_geography->get_all_cities();

		$tmp = array();
		$list = array(1=>'北美','2'=>'欧洲', '3'=>'亚太');
		foreach ($cities as $key => $value) {

			foreach($value as $kk => $vv){

				if (isset($value[$kk]['reserve_3']) && $value[$kk]['reserve_3'] ) {
					$reserve_3 =  $value[$kk]['reserve_3'];
				}else{
					$reserve_3  = "http://zanbai.b0.upaiyun.com/2013/05/31bed01c589f0fee.jpg!shoppic";
				}
				$reserve_3 = substr($reserve_3, 0, strpos($reserve_3, "!"));
				$reserve_3 .= "!shoppic";
				$value[$kk]['pic'] = $reserve_3;
			}

			$tmp[$key]['name'] = $list[$key];
			$tmp[$key]['list'] = $value;
		}
		$country_code = array('1'=>'amc','2'=>'eup','3'=>'asia');

		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'', 'data'=>$tmp));

	}
	// sort_type 0是默认排序。1是距离排序。2是奢侈程度排序
	# http://zan.com/mobile/shop/get_shops_by_city?city_id=1&page=1&pagesize=2&latitude=1&longitude=1&distance_sort=1
	public function get_shops_by_city(){
		try{
			$user_info=$this->session->userdata('user_info');
			$uid = 0;
			if ($user_info && isset($user_info['uid'])) {
				$uid = $user_info['uid'];
			}
			#获取参数
			$city = isset($_GET['city_id'])?$_GET['city_id']:1;
			$page = isset($_GET['page'])?$_GET['page']:1;
			$property = isset($_GET['property'])?$_GET['property']:0;
			$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;
			$latitude = $this->input->get("latitude", true, "");
			$longitude = $this->input->get("longitude", true, "");
			//是否按照距离排序 0否，1是
			$distance_sort = $this->input->get("distance_sort", true, 0);
			$sort_type = $this->input->get("sort_type", true, 0);
			#获取商家信息
			$this->load->model('mo_shop');
			if ($distance_sort) {
				$shops = $this->mo_shop->get_shops_by_brand_property_city(0,$property,$city,1,1000);
			}else{
				$shops = $this->mo_shop->get_shops_by_brand_property_city(0,$property,$city,$page,$pagesize);
			}
			if($sort_type == 1){
				$shops = $this->mo_shop->get_shops_by_brand_property_city(0,$property,$city,1,1000);
			}

			$count = $this->mo_shop->get_shopcnt_by_brand_property_city(0, $property, $city);

			$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shops,true);
			$this->load->model("mo_geography");
			$this->load->model("mo_discount");
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			
			$country_id = $city_info['country_id'];
			
			$tmp = array();

			if ($distance_sort || $sort_type == 1) {
				$tmp = array();
				$distance_list = array();
				foreach ($shop_infos as $key => $value) {
					$tmp[$key] = $value;
					if ($value['location']) {
						$lati_longi = explode(",", $value['location']);
						$tmp[$key]['latitude'] = $lati_longi[0];
						$tmp[$key]['longitude'] = $lati_longi[1];
					}else{
						$tmp[$key]['latitude'] = "";
						$tmp[$key]['longitude'] = "";
					}
					if($latitude && $longitude && $value['location']){
						$distance = $this->tool->getDistance_good($latitude, $longitude, $tmp[$key]['latitude'], $tmp[$key]['longitude']);
						#车程
						$tmp[$key]['drive'] = $distance;
						#距离
						$tmp[$key]['distance'] = $distance;
						$distance_list[$key] = $distance;
					}
				}
				array_multisort($distance_list,SORT_ASC, $tmp);
				$offset = ($page - 1) * $pagesize;
				$shop_infos = array_slice($tmp, $offset, $pagesize);
			}



			$tmp = $this->format_shop_infos($shop_infos, $uid, $latitude, $longitude);
			$data['total_number'] = $count;
			$data['list'] = $tmp;
			$data['have_strategy'] = 1;
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	# http://zan.com/mobile/shop/get_shopinfo?shop_id=1
	public function get_shopinfo(){
		try{
			#获取参数
			$shop_id = $this->input->get("shop_id", true, 0);
			$user_info=$this->session->userdata('user_info');
			$latitude = $this->input->get("latitude", true, "");
			$longitude = $this->input->get("longitude", true, "");
			$uid = 0;
			if ($user_info && isset($user_info['uid'])) {
				$uid = $user_info['uid'];
			}
			$this->config->load('env',TRUE);
			$brand_domain = $this->config->item('brand_domain','env');

			#获取商家信息
			$this->load->model('mo_shop');
			$this->load->model('mo_discount');
			$shop_infos = $this->mo_shop->get_shopinfo_by_ids(array($shop_id),true);
			$shop_info = array();
			if (isset($shop_infos[$shop_id])) {
				$shop_info = $shop_infos[$shop_id];
			}
			if($shop_info['location']){
				$lati_longi = explode(",", $shop_info['location']);
				$shop_info['latitude'] = $lati_longi[0];
				$shop_info['longitude'] = $lati_longi[1];
			}else{
				$shop_info['latitude'] = "";
				$shop_info['longitude'] = "";
			}
			$brand_ids = $this->mo_shop->get_brands_by_shop($shop_id);
			$this->load->model('mo_brand');
			$brands = $this->mo_brand->get_brands_by_ids($brand_ids);
			if($brands){
				foreach($brands as $k => $v){
					if($v['name'] != $v['english_name']){
						$brands[$k]['name'] = $v['name']."(".$v['english_name'].")";
					}
				}
			}
			
			$tmp = array();
			if($brands){
				$i=0;
				foreach ($brands as $key => $value) {
					$brand_info = array();
					$brand_info['id'] = $value['id'];
					$brand_info['name'] = $value['name'];
					$brand_info['first_char'] = $value['first_char'];
					$brand_info['english_name'] = $value['english_name'];
					if ($value['big_pic']) {
						$brand_info['pic'] = $value['big_pic'];
					}else{
						$brand_info['pic'] = $brand_domain.'brand_'.$value['id'].".jpg";
					}
					$tmp[$i] = $brand_info;
					$i++;
				}
			}
			$brands = $tmp;

			$discount_cnt = $this->mo_discount->get_discount_ids_cnt_by_shopid($shop_id);
			$discount_list = array();
			$have_discount = 0;
			if ($discount_cnt) {
				$discount_ids = $this->mo_discount->get_discount_ids_by_shopid($shop_id);

				$tmp = array();
				if($discount_ids){
					$discount_list = $this->mo_discount->get_info_by_ids($discount_ids);
					$discount_list = array_slice($discount_list, 0, 2);
					$have_discount = 1;
					$i=0;
					foreach ($discount_list as $key => $value) {
						$discount_info = array();
						$discount_info['id'] = $value['id'];
						$discount_info['title'] = $value['title'];
						$discount_info['body'] = $value['body'];
						$discount_info['clean_body'] = $value['clean_body'];
						$discount_info['has_pic'] = $value['has_pic'];
						$discount_info['pics'] = $value['pics'];
						$tmp[$i] = $discount_info;
						$i++;
					}
					$discount_list = $tmp;
				}
			}

			$is_attention=0;
			$is_fav_shop = 0;
			if($uid){
				$attention = $this->mo_shop->check_shop_attention($uid, $shop_id);
				if ($attention) {
					$is_attention = 1;
				}
				$shop_favs = array();
				$coupon_favs = array();
				$re = $this->mo_fav->get_fav_list($uid, 0);
				if($re){
					foreach($re as $v){
						$shop_favs[$v['favorite_id']] = $v['favorite_id'];
					}
				}
				$re = $this->mo_fav->get_fav_list($uid, 1);
				if($re){
					foreach($re as $v){
						$coupon_favs[$v['favorite_id']] = $v['favorite_id'];
					}
				}

				if($shop_favs && isset($shop_favs[$shop_id])){
					$is_fav_shop = 1;
				}
			}

			$have_coupon = 0;
			$coupon_list = array();
			$brand_ids = $this->mo_shop->get_brands_by_shop($shop_id);
			$coupon_list = $this->mo_coupon->get_coupon_by_shop_brand($shop_id, $brand_ids);
			if($coupon_list){
				$have_coupon = 1;
				$tmp = array();
				$i=0;
				foreach($coupon_list as $k => $v){
					$is_fav_coupon = 0;
					if($uid && isset($coupon_favs[$v['id']])){
						$is_fav_coupon = 1;
					}
					$tmp[$i] = array('id'=>$v['id'], 'title'=>$v['title'], 'is_fav'=>$is_fav_coupon);
					$i++;
				}
				$coupon_list = $tmp;
			}

			//
			$get_direction = $this->get_direction($shop_id);


			$re = array();

			$re['is_fav'] = $is_fav_shop;
			$re['id'] = $shop_id;
			$re['pic'] = $shop_info['pic'];
			$re['name'] = $shop_info['name'];
			$re['english_name'] = $shop_info['english_name'];
			$re['shareurl'] = $shop_info['ext']['shop_url'];
			$re['have_discount'] = $have_discount;
			$re['have_coupon'] = $have_coupon;
			//$re['coupon_title'] = "超值优惠券,可能2行文字";
			$re['coupon_list'] = $coupon_list;
			$re['discount_list'] = $discount_list;
			$re['latitude'] = $shop_info['latitude'];
			$re['longitude'] = $shop_info['longitude'];
			$re['desc'] = $shop_info['desc'];
			$re['short_desc'] = $shop_info['short_desc'];
			$re['address'] = $shop_info['address'];
			$re['business_hour'] = $shop_info['business_hour'];
			$re['brands'] = $brands;
			$re['is_attention'] = $is_attention;
			$re['score'] = $shop_info['score'];


			$how_come = "";
			if($shop_info['reserve_3']){
				$how_come = $shop_info['reserve_3'];
				$re['how_come'] = $how_come;
				$re['subway'] = $how_come;
			}
			
			
			$distance = "";
			if($latitude && $longitude && $shop_info['location']){
				$distance = $this->tool->getDistance_good($latitude, $longitude, $shop_info['latitude'], $shop_info['longitude']);
				$re['drive'] = $distance;
			}
			
			$re['have_direction'] = $get_direction['have_direction'];
			$re['direction_list'] = $get_direction['direction_list'];

			//var_dump($data);die;
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data' => $re));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	// zan.com/direction/index2?shop_id=4
	public function get_direction($shop_id){
		//$shop_id = $this->input->get("shop_id", true, 0);
		$type_lists = array('1'=>'巴士','2'=>'火车','3'=>'地铁','4'=>'电车','5'=>'班车/购物快车','6'=>'观光旅游巴士(观光车)','7'=>'船');
		$re = $this->mo_directions->get_directions_list($shop_id);
		$have_direction = 0;
		$direction_list = array();
		if($re){
			foreach($re as $k => $direction){
				$direction_type  = $direction['type'];
				$direction_type_name = $type_lists[$direction_type];
				$direction_id = $direction['id'];
				$lines = $this->mo_directions->get_line_infos($direction_id);
				$content = $direction['description']."\n";
				if($lines){
					foreach($lines as $line_key => $line_value){
						$have_value = 0;
						foreach($line_value as $item){
							if($item['title'] || $item['description']){
								$have_value = 1;
							}
						}
						if(!$have_value){
							unset($lines[$line_key]);
						}
					}
				}
				if($lines){
					foreach($lines as $line_key => $line){
						$line_number = ($line_key+1);
						$content .= "路线 ".$line_number."\n";
						foreach($line as $item){
							if($item['item_type'] == 1){
								if($item['title']){
									$content .= $item['title']."\n";
								}
								if($item['description']){
									$content .= $item['description']."\n";
								}
							}else{
								if($item['title'] || $item['description']){
									$content .= $item['title']."\n";
									$content .= $item['description']."\n";
								}
							}
						}
					}
				}
				$direction_list[] = array('direction_type'=>$direction_type, "direction_type_name"=>$direction_type_name, "content"=>$content);  
			}
			$have_direction = 1;
		}
		return array('have_direction'=>$have_direction, "direction_list"=>$direction_list);
	}

	

	#根据商家id，获取最新的晒单
	public function get_lastdianping_by_shopid(){
		try{
			#获取参数
			$shop_id = isset($_GET['shop_id'])?$_GET['shop_id']:0;
			$page = isset($_GET['page'])?$_GET['page']:1;
			$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;
			#获取商家信息
			//$this->load->model('mo_shop');
			//$dianping = $this->mo_shop->get_lastdianping_by_shopids(array($shop_id));

			$this->load->model("mo_dianping");
			$dianpings = $this->mo_dianping->get_dianpinginfo_by_shopid($shop_id, $page, $pagesize);
			$count = 100;
			$data['list'] = $dianpings;
			$data['total_number'] = $count;
			
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$dianpings));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	public function get_brands_by_shop(){
		try{
			#获取参数
			$shop_id = isset($_GET['shop_id'])?$_GET['shop_id']:0;
		
			#获取商家信息
			$this->load->model('mo_shop');
			$brand_ids = $this->mo_shop->get_brands_by_shop($shop_id);
			$this->load->model('mo_brand');
			$brands = $this->mo_brand->get_brands_by_ids($brand_ids);
			
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$brands));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	public function get_strategy(){

	}
	# http://dev.zanbai.com/mobile/shop/get_shop_by_latlng?latlng=-73.974849,40.762321
	# http://zan.com/mobile/shop/get_shop_by_latlng?latlng=-73.974849,40.762321
	public function get_shop_by_latlng(){
		try{
			$this->load->model('mo_operation');
			$this->load->model('mo_shop');
			$latitude = $this->input->get("latitude", true, "");
			$longitude = $this->input->get("longitude", true, "");

			$shops = $this->mo_shop->get_all_shop(true);
			$list = array();
			foreach ($shops as $key => $shop) {
				if(!$shop['location']){
					continue;
				}
				$location =  $shop['location'];
				$location_tmp  = explode(',', $location);
				$lat = $location_tmp[0];
				$lng = $location_tmp[1];

				$distance = $this->tool->getDistance_good($latitude, $longitude, $lat, $lng);
				$list[$shop['id']] = $distance;
			}
			
			$shop_infos = $shop_ids = $tmp = array();
			$i=0;
			if($list){
				asort($list);
				$list = array_slice($list, 0, 10, true);
				$shop_ids = array_keys($list);
				$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids, true);
				
				foreach ($shop_infos as $key => $value) {
					if($value['country'] == 14 && !in_array($value['city'], array(44,45,49,50,59))){
						continue;
					}
					$tmp[$i]['id'] = $value['id'];
					$tmp[$i]['name'] = $value['name'];
					$tmp[$i]['english_name'] = $value['english_name'];
					$tmp[$i]['shareurl'] = $value['ext']['shop_url'];
					$i++;
				}
			}

			$data['total_number'] = count($tmp);
			$data['list'] = $tmp;

			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$data));
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}



	# http://zanbai.com/mobile/shop/add_favorite?id=4
	// http://zan.com/mobile/shop/add_favorite?id=4
	public function add_favorite(){
		$id = isset($_POST['id'])?$_POST['id']:0;
		//$id = isset($_GET['id'])?$_GET['id']:0;
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		$data['user_id'] = $uid;
		$data['id'] = $id;
		$data['type'] = 0;
		$data['mobile'] = 0;
		$data['ctime'] = time();
		$re = $this->mo_fav->add_favorite($data);

		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
		return;

	}

	# http://zanbai.com/mobile/shop/delete_favorite?id=4
	public function delete_favorite(){
		$favorite_id = isset($_POST['id'])?$_POST['id']:0;
		//$id = isset($_GET['id'])?$_GET['id']:0;
		$user_info=$this->session->userdata('user_info');
		$uid = 0;

		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		if(!$uid){
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
			return;
		}
		$type = 0;
		$exist = $this->mo_fav->get_exist($uid, $favorite_id, $type);
		if($exist && $exist['id']){
			$id = $exist['id'];
			$this->mo_fav->delete_favorite($id, $exist['uid']);
		}
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
		return;
	}


	# http://zan.com/mobile/shop/get_favorite_list
	public function get_favorite_list(){
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		$page = isset($_GET['page'])?$_GET['page']:1;
		$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;
		$city = 0;

		$re = $this->mo_fav->get_fav_shops($uid, 0, $page, $pagesize);
		$count = $re['count'];
		$shop_infos = $re['list'];
		$city_infos = $re['city_infos'];
		
		$shop_infos = $this->format_shop_infos($shop_infos);
		$list = array();
		foreach($shop_infos as $v){
			$this_city = $v['city'];
			
			$list[$this_city]['city'] = $city_infos[$this_city];
			$list[$this_city]['list'][] = $v;
		}

		$data = array();
		$data['total_number'] = $count;
		$data['list'] = $list;
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
		return;
	}

	public function format_shop_infos($shop_infos, $uid=0, $latitude=0, $longitude=0){
		$i=0;
		$shop_tags = $tag_list = array();
		if($shop_infos){
			$shops = array();
			foreach($shop_infos as $v){
				$shops[$v['id']] = $v['id'];
			}
			$shop_tags = $this->mo_tag->get_shoptagids($shops);
			$shop_infos_full = $this->mo_shop->get_shopinfo_by_ids($shops);
			$tag_list = $this->mo_tag->get_tag_list();
		}

		if($uid){
			$shop_favs = array();
			$coupon_favs = array();
			$re = $this->mo_fav->get_fav_list($uid, 0);
			if($re){
				foreach($re as $v){
					$shop_favs[$v['favorite_id']] = $v['favorite_id'];
				}
			}
			$re = $this->mo_fav->get_fav_list($uid, 1);
			if($re){
				foreach($re as $v){
					$coupon_favs[$v['favorite_id']] = $v['favorite_id'];
				}
			}
		}


		foreach ($shop_infos as $key => $value) {
			$discount_ids = $this->mo_discount->get_discount_ids_by_shopid($value['id']);
			$have_discount = 0;
			$discount_list = array();
			if ($discount_ids) {
				$discount_list = $this->mo_discount->get_info_by_ids($discount_ids);
				$discount_list = array_slice($discount_list, 0, 2);
				if($discount_list){
					$have_discount = 1;
				}
			}
			
			$have_coupon = 0;
			$coupon_list = array();
			$shop_id = $value['id'];
			$brand_ids = $this->mo_shop->get_brands_by_shop($shop_id);
			$coupon_list = $this->mo_coupon->get_coupon_by_shop_brand($shop_id, $brand_ids);
			if($coupon_list){
				$have_coupon = 1;
				$coupon_tmp = array();
				$j=0;
				foreach($coupon_list as $k => $v){
					$is_fav_coupon = 0;
					if($uid && $coupon_favs && isset($coupon_favs[$v['id']]) ){
						$is_fav_coupon = 1;
					}
					$coupon_tmp[$j] = array('id'=>$v['id'], 'title'=>$v['title'], 'is_fav'=>$is_fav_coupon);
					$j++;
				}
				$coupon_list = $coupon_tmp;
			}

			$tmp[$i]['id'] = $value['id'];
			$tmp[$i]['name'] = $value['name'];
			$tmp[$i]['city'] = $value['city'];
			$tmp[$i]['english_name'] = $value['english_name'];
			$tmp[$i]['pic'] = $value['pic'];
			$tmp[$i]['have_discount'] = $have_discount;
			$tmp[$i]['discount_list'] = $discount_list;
			$tmp[$i]['have_coupon'] = $have_coupon;
			$tmp[$i]['coupon_list'] = $coupon_list;
			$tmp[$i]['score'] = $value['score'];

			$tmp[$i]['shareurl'] = $shop_infos_full[$value['id']]['ext']['shop_url'];
			$my_tag = array();
			if(isset($shop_tags[$shop_id])){
				$my_tag = array();
				foreach($shop_tags[$shop_id] as $tag_id){
					$my_tag[] = array("id"=>$tag_id, "name"=>$tag_list[$tag_id]['name']);
				}
			}
			$tmp[$i]['tags'] = $my_tag;

			//$tmp[$key]['location'] = $value['location'];
			if ($value['location']) {
				$lati_longi = explode(",", $value['location']);
				$tmp[$i]['latitude'] = $lati_longi[0];
				$tmp[$i]['longitude'] = $lati_longi[1];
			}else{
				$tmp[$i]['latitude'] = "";
				$tmp[$i]['longitude'] = "";
			}

			$tmp[$i]['desc'] = $value['desc'];
			$tmp[$i]['short_desc'] = $value['short_desc'];
			$tmp[$i]['address'] = $value['address'];

			$is_attention=0;
			if($uid){
				$attention = $this->mo_shop->check_shop_attention($uid, $value['id']);
				if ($attention) {
					$is_attention = 1;
				}
			}
			$tmp[$i]['is_attention'] = $is_attention;
			$distance = "";
			//$longitude = "-71.974849";$latitude = "40.762321";

			if($latitude && $longitude && $value['location']){
				$distance = $this->tool->getDistance_good($latitude, $longitude, $tmp[$i]['latitude'], $tmp[$i]['longitude']);
				#车程
				$tmp[$i]['drive'] = $distance;
				#距离
				$tmp[$i]['distance'] = $distance;
			}
			$is_fav = 0;
			if($uid && $shop_favs && isset($shop_favs[ $value['id']])){
				$is_fav = 1;
			}
			$tmp[$i]['is_fav'] = $is_fav;
			
			$i++;
		}
		return $tmp;
	}
}





