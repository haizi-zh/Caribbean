<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class city extends ZB_Controller {
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
	}

	# http://zan.com/aj/city/get_area_city?area=3&page=2
	public function get_area_city(){
		try{
			$this->config->load('errorcode',TRUE);
			$area = $this->input->get('area', true, 1);
			$page = $this->input->get('page', true, 1);

			$area = intval($area);
			$page = intval($page);

			$this->load->model('mo_geography');
			$cities = $this->mo_geography->get_all_cities();
			$city_list = $cities[$area];
			$count_city = count($city_list);
			$city_ids = array(1=>1,21=>21,22=>22,20=>20,23=>23,44=>44,2=>2,97=>97,49=>49,51=>51,3=>3,5=>5);
			$tmp_city = array_chunk($city_list, 18);
			$page = $page - 1;

			if (isset($tmp_city[$page])) {
				$city_list = $tmp_city[$page];
				if(isset($tmp_city[$page+1])){
					$page = $page+2;
				}else{
					$page = $page-1;
				}
			}else{
				$city_list = $tmp_city[$page-1];
				$page = $page;
			}
			if($page < 1){
				$page = 1;
			}


			$html = $this->load->view('template/home_city', array('city_list'=>$city_list,'city_ids'=>$city_ids), true);

			$data['html'] = $html;
			$data['page'] = $page;

			echo json_encode(array('code'=>'200','msg'=>'succ', 'data'=> $data));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	public function get_brand_html(){
		try{
			#获取参数
			$char = $this->input->get('char', true, '');
			$city = $this->input->get('city', true, '');

			$city = intval($city);
			if(!$char || !$city){
				$code = '201';
				throw new Exception($this->config->item($code,'errorcode'), $code);
			}
			#热门品牌
			$this->load->model('mo_brand');
			$brands = $this->mo_brand->get_hot_brand_by_city_id($city);
			//var_dump($brands);
			$this->config->load("recommend", true);
			$top_brands = $this->config->item("top_brands", "recommend");
			$top_brands = explode(",", $top_brands);
			$brands = $brands[$char];
			$pre_brands = $brands;
			foreach($brands as $k=>$v){
				if(!in_array($v['id'], $top_brands)){
					unset($brands[$k]);
				}
			}
			if(!$brands){
				$brands = $pre_brands;
			}
			$brand_html = $this->load->view('template/small_brand_card', array('brands'=>$brands, 'city_id'=>$city), true);
			$html = "<div class='all_brand' action-type='all_brand' action-data='property=0&city=".$city."' ><a href='javascript:;' action-type='all_brand_cur'>热门品牌</a></div><ul class='list_detail clearfix'> ".$brand_html."</ul>";

			echo json_encode(array('code'=>'200','msg'=>'succ','html'=>$html));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	public function get_shop_html(){
		try{
			$this->config->load('errorcode',TRUE);

			#获取参数
			$property = 0;
			//$city = isset($_GET['city'])?$_GET['city']:0;
			//$brand_id = isset($_GET['brand_id'])?$_GET['brand_id']:0;
			$city = $this->input->get('city', true, 0);
			$brand_id = $this->input->get('brand_id', true, 0);

			$city = intval($city);
			$brand_id = intval($brand_id);

			if($city == 0){
				$code = '201';
				throw new Exception($this->config->item($code,'errorcode'), $code);
			}

			#获取商家id
			$this->load->model('mo_shop');
			$shop_ids = $this->mo_shop->get_shops_by_brand_property_city($brand_id,$property,$city);
			$html = $this->mo_shop->render($shop_ids);

			echo json_encode(array('code'=>'200','msg'=>'succ','html'=>$html));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	public function get_shop_html_by_tab(){
		try{
			$this->config->load('errorcode',TRUE);
			#获取参数
			/* $property = isset($_GET['property'])?$_GET['property']:0;
			$city = isset($_GET['city'])?$_GET['city']:0;
			$brand_id = isset($_GET['brand_id'])?$_GET['brand_id']:0;
			$page = isset($_GET['page'])?$_GET['page']:1; */
			$property = $this->input->get('property', true, 0);
			$city = $this->input->get('city', true, 0);
			$brand_id = $this->input->get('brand_id', true, 0);
			$page = $this->input->get('page', true, 1);
			$pagesize = 15;
			$property = intval($property);
			$city = intval($city);
			$brand_id = intval($brand_id);
			$page = intval($page);

			if($city == 0){
				$code = '201';
				throw new Exception($this->config->item($code,'errorcode'), $code);
			}

			#获取商家id
			$this->load->model('mo_shop');
			$this->load->model("mo_discount");
			$shop_ids = $this->mo_shop->get_shops_by_brand_property_city($brand_id,$property,$city,$page,$pagesize);
			$shop_infos  = $this->mo_shop->provide_data($shop_ids);

			foreach($shop_infos as $key => $value){
				$exist_discount = $this->mo_discount->check_discount_for_shopid($value['id']);
				$shop_infos[$key]['exist_discount'] = $exist_discount;
				
				$brand_ids = $this->mo_shop->get_brands_by_shop($value['id']);


				$exist_coupon = $this->mo_coupon->get_coupon_by_shop_brand($value['id'], $brand_ids);
				$first = array();
				if($exist_coupon){
					$first = array_shift($exist_coupon);
					$exist_coupon = $first['id'];
				}else{
					$exist_coupon = false;
				}
				$shop_infos[$key]['exist_coupon'] = $exist_coupon;
				$shop_infos[$key]['exist_coupon_info'] = $first;
				#图片后缀替换
				$shop_pic = $value['pic'];
				$shop_pic = str_replace("!300", "!shopviewlist", $shop_pic);
				$shop_infos[$key]['pic'] = $shop_pic;
			}

			#分页总数
			$total = $this->mo_shop->get_shopcnt_by_brand_property_city($brand_id,$property,$city);
			$page_cnt = ceil($total/$pagesize);

			$data = array("shop_infos"=>$shop_infos);
			$data['page'] = $page;
			$data['page_cnt'] = $page_cnt;
			$data['city_id'] = $city;
			$data['property'] = $property;
			$content = "";
			if(!$brand_id && $property == 3){

				$this->config->load('pro',TRUE);
				$property_list = $this->config->item("property_list", "pro");
				$property_name = $property_list[$property];

				$content = "这个城市暂时还没有{$property_name}哟！";
			}
			$data['content'] = $content;

			$html = $this->load->view("template/shop_card",$data,true);



			echo json_encode(array('code'=>'200','msg'=>'succ','html'=>$html,'page_cnt'=>$page_cnt?$page_cnt:1));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}

	}

	public function get_shop_html_by_tab_new(){
		try{
			$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
			$this->config->load('errorcode',TRUE);
			#获取参数
			$city = $this->input->get('city', true, 0);
			$brand_id = $this->input->get('brand_id', true, 0);
			$page = $this->input->get('page', true, 1);
			$pagesize = 30;

			$search = $this->input->get('search', true, 0);
			$search = urldecode($search);
			$item = explode("|", $search);
			$tag_ids = array();
			$have_discount = 0;
			$property = 0;
			foreach($item as $v){
				if(!$v){
					continue;
				}
				$tmp = explode(":", $v);
				$cat = $tmp[0];
				$id = $tmp[1];
				$city = $tmp[2];
				if($cat && $id){
					if($cat == 1){
						if($id==1){
							$tag_ids[] = 1;
						}elseif($id==2){
							$have_discount = 1;
						}else{
							$tag_ids[] = $id;
						}
					}elseif($cat == 2){
						// 1商业中心，2超级市场 3百货商店
						// 1购物街区  2购物中心 3奥特莱斯
						// 4购物中心 5奥特莱斯 6购物街区
						if($id==4){
							$property = 2;
						}elseif($id == 5){
							$property = 3;
						}elseif($id == 6){
							$property = 1;
						}elseif($id==7){
							$tag_ids[] = 7;
						}
					}elseif($cat == 3){
						$tag_ids[] = $id;
					}elseif($cat == 4){
						$tag_ids[] = $id;
					}

				}
			}
			$brand_id = intval($brand_id);
			$page = intval($page);
			$property = intval($property);
			$city = intval($city);
			if($city == 0){
				//$code = '201';
				echo json_encode(array('code'=>'200','msg'=>'succ','html'=>'<div class="info_blank"><p>没有搜索到商家。请选择其他条件.</p></div>','page_cnt'=>1));
				return;
			}

			$shop_ids = $this->mo_shop->get_shops_by_brand_property_city($brand_id, $property, $city, 1,1000);
			$re_shop_ids = $shop_ids;

			if($have_discount){
				$discount_shop_ids = $this->mo_discount->get_have_dicount_shopids($shop_ids);
				//含有coupon的列表
				$coupon_shop_ids = $this->mo_coupon->get_have_coupon_shopids($shop_ids);
				$merge_shop_ids = array_merge($discount_shop_ids, $coupon_shop_ids);

				$re_shop_ids = array_intersect($merge_shop_ids, $re_shop_ids);
			}

			if($re_shop_ids && $tag_ids){
				$tag_shop_ids = $this->mo_tag->get_shop_ids_by_tagids($tag_ids, $re_shop_ids);

				$re_shop_ids = array_intersect($tag_shop_ids, $re_shop_ids);
			}
			$count = count($re_shop_ids);
			if(!$re_shop_ids){
				echo json_encode(array('code'=>'200','msg'=>'succ','html'=>'<div class="info_blank"><p>没有搜索到商家。请选择其他条件.</p></div>','page_cnt'=>1));
				return;
			}
			#分页总数
			//$total = $this->mo_shop->get_shopcnt_by_brand_property_city($brand_id,$property,$city);
			$total = count($re_shop_ids);
			$page_cnt = ceil($total/$pagesize);


			$shop_ids = $this->mo_shop->get_shops_list_by_shopids($re_shop_ids, $page, $pagesize);
			if(!$shop_ids){
				echo json_encode(array('code'=>'200','msg'=>'succ','html'=>'<div class="info_blank"><p>没有搜索到商家。请选择其他条件.</p></div>','page_cnt'=>1));
				return;
			}
			$shop_infos  = $this->mo_shop->provide_data($shop_ids);
			if(!$shop_infos){
				echo json_encode(array('code'=>'200','msg'=>'succ','html'=>'<div class="info_blank"><p>没有搜索到商家。请选择其他条件.</p></div>','page_cnt'=>1));
				return;
			}
			$shop_infos = $this->mo_fav->check_fav_shops($shop_infos, $login_uid);
			
			$shop_tags = $this->mo_tag->get_shoptagids($shop_ids);
			$tag_list = $this->mo_tag->get_tag_list();

			foreach($shop_infos as $key => $value){
				$exist_discount = $this->mo_discount->check_discount_for_shopid($value['id']);
				$shop_infos[$key]['exist_discount'] = $exist_discount;
				$brand_ids = $this->mo_shop->get_brands_by_shop($value['id']);
				$shop_id = $value['id'];
				$list = $this->mo_coupon->get_coupon_by_shop_brand($shop_id, $brand_ids);

				$first = array();
				$exist_coupon = $this->mo_coupon->get_coupon_by_shop_brand($value['id'], $brand_ids);
				if($exist_coupon){
					$first = array_shift($exist_coupon);
					$exist_coupon = $first['id'];
				}else{
					$exist_coupon = false;
				}
				$shop_infos[$key]['exist_coupon'] = $exist_coupon;
				$shop_infos[$key]['exist_coupon_info'] = $first;
				$shop_tag = array();
				if(isset($shop_tags[$value['id']])){
					$shop_tag = $shop_tags[$value['id']];
				}
				$shop_infos[$key]['tags'] = $shop_tag;

				#图片后缀替换
				$shop_pic = $value['pic'];
				$shop_pic = str_replace("!300", "!shopviewlist", $shop_pic);
				$shop_infos[$key]['pic'] = $shop_pic;

			}

			$data = array("shop_infos"=>$shop_infos);
			$data['tag_list'] = $tag_list;

			$data['page'] = $page;
			$data['page_cnt'] = $page_cnt;
			$data['city_id'] = $city;
			$data['property'] = $property;
			$content = "";
			if(!$brand_id && $property == 3){

				$this->config->load('pro',TRUE);
				$property_list = $this->config->item("property_list", "pro");
				$property_name = $property_list[$property];

				$content = "这个城市暂时还没有{$property_name}哟！";
			}
			$data['content'] = $content;
			$city_info = $this->mo_geography->get_city_info_by_id($city);
			$city_lower_name = $city_info['lower_name'];
			$data['city_lower_name'] = $city_lower_name;

			$html = $this->load->view("template/shop_card",$data,true);
			echo json_encode(array('code'=>'200','msg'=>'succ','html'=>$html,'page_cnt'=>$page_cnt?$page_cnt:1));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}

	}

	public function city_hidden_foradmin(){
		$id = $this->input->post('id', 0);

		$id = intval($id);

		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('do/do_city');
		$re = $this->do_city->update_foradmin(array('reserve_1'=>1, 'id'=>$id));
		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

	public function city_show_foradmin(){
		$id = $this->input->post('id', 0);
		$id = intval($id);

		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('do/do_city');
		$re = $this->do_city->update_foradmin(array('reserve_1'=>0, 'id'=>$id));
		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}


	public function set_city_level(){
		$id = $this->input->post('id', 0);
		$id = intval($id);

		$level = $this->input->post('level', true, 1000);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('do/do_city');
		$re = $this->do_city->update_foradmin(array('level'=>$level, 'id'=>$id));
		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}
	//set_city_level_top
	public function set_city_level_top(){
		$id = $this->input->post('id', 0);
		$id = intval($id);

		$level_top = $this->input->post('level_top', true, 1000);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('do/do_city');
		$re = $this->do_city->update_foradmin(array('level_top'=>$level_top, 'id'=>$id));
		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

	public function city_modify(){

		try{
			$data = array();
			$data['id'] = $this->input->post('id', true, '');
			$data['reserve_3'] = $this->input->post('img', true, '');
			$data['name'] = $this->input->post('name', true, '');
			$data['english_name'] = $this->input->post('english_name', true, '');

			$this->load->model('mo_geography');
			$re = $this->mo_geography->update_city($data);

			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}

	}


}