<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class basetable extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model('mo_fav');
	}
	// http://zan.com/basetable/add_fav
	public function add_fav(){
		$shops = $this->mo_shop->get_all_shop(true);
		$uid = 1372887815;
		foreach($shops as $k=>$shop){
			if($shop['status'] == 1){
				continue;
			}
			$shop_id = $shop['id'];

			$data=array();
			$data['user_id'] = $uid;
			$data['id'] = $shop['id'];
			$data['type'] = 0;
			$re = $this->mo_fav->add_favorite($data);
			$brand_ids = $this->mo_shop->get_brands_by_shop($shop_id);
			$coupons = $this->mo_coupon->get_coupon_by_shop_brand($shop_id, $brand_ids);
			
			if($coupons){
				//var_dump($coupons);die;
				foreach($coupons as $coupon){
					$data=array();
					$data['user_id'] = $uid;
					$data['id'] = $coupon['id'];
					$data['type'] = 1;
					$re = $this->mo_fav->add_favorite($data);

				}
			}
		}

	}
	// http://zan.com/basetable/shop_time
	public function shop_time(){
		$this->load->database();
		$this->db->select('*');
		$this->db->where("status", 0);
		$this->db->where("type", 2);
		$query = $this->db->get('zb_discount');
		$list = $query->result_array();
		$urls = array();
		$shop_list = $this->mo_shop->get_all_shop(true);
		
		foreach($shop_list as $v){
			if( strlen($v['business_hour']) > 100){
				var_dump($v['id'], strlen($v['business_hour']));
			}
		}
	}
	// http://zan.com/basetable/brand_shop
	public function brand_shop(){
		$this->load->database();
		$sql = "select * from zb_index_brand_shop where shop_id in (select id from zb_shop where country=1) ";
		$query = $this->db->query($sql);
		$list = $query->result_array();
		$tmp = array();
		foreach($list as $v){
			$tmp[$v['brand_id']][$v['shop_id']] = $v['shop_id'];
		}
		$tt = array();
		foreach($tmp as $k=> $v){
			$tt[$k] = count($v);
		}

		$ss = arsort($tt);
		//var_dump(count($tt));
		$brands = $this->mo_brand->get_brands_by_ids(array_keys($tt));
		$str = "品牌id,名称,别名,商家数量\n";
		$str = iconv('utf-8','gb2312',$str);
		foreach($tt as $k=>$v){
			if(!isset($brands[$k])){
				continue;
			}
			$name = $brands[$k]['name'];
			$english_name = $brands[$k]['english_name'];
			$name = iconv('utf-8','gb2312',$name);
			$english_name = iconv('utf-8','gb2312',$english_name);

			$line = $k.",".$name.",".$english_name.",".$v."\n";
			$str .= $line;
		}
		
		$filename = "美国商户品牌排序.csv";

		$this->export_csv($filename,$str); //导出 
	}
	function export_csv($filename,$data) { 
	    header("Content-type:text/csv"); 
	    header("Content-Disposition:attachment;filename=".$filename); 
	    header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
	    header('Expires:0'); 
	    header('Pragma:public'); 
	    echo $data; 
	} 

	// http://zan.com/basetable/search_tag_new3
	public function search_tag_new3(){
		
		$this->load->database();
		$this->db->select('*');
		$this->db->where("status", 0);
		$this->db->where("type", 2);
		$query = $this->db->get('zb_discount');
		$list = $query->result_array();
		$urls = array();
		$shops = $this->mo_shop->get_all_shop_reserve(1);
		context::set('shop_list', $shops);
		$shop_city_lowernames = $this->mo_shop->get_all_shop_lowernames();
		context::set('shop_city_lowernames', $shop_city_lowernames);

		$tips_list = $this->mo_discount->get_all_tips_reserve();
		context::set('tips_list', $tips_list);

		$shop_list = $this->mo_shop->get_all_shop();
		foreach ($list as $key => $value) {
			$body = $value['body'];
			$body = $this->tool->clean_html_and_js($body);
			if(!$body){
				var_dump($body);
				continue;
			}
			$error = 0;
			foreach($shops as $print_word => $vv){
				if(false != ($start = mb_strpos($body, $print_word, 0, "utf-8"))){
					$tag_word = mb_substr($body, $start-1, mb_strlen($print_word, "UTF-8")+2, "utf-8");
					if($tag_word != "#{$print_word}#"){
						var_dump($print_word);
						$error = 1;
					}
				}
			}
			if($error){
				var_dump($value['id']);
			}
		}

		foreach ($list as $key => $value) {
			context::set('error', 0);
			$this->render_tag($value['body']);
			$error = context::get('error', 0);
			if($error){
				var_dump("id:",$value['id']);
			}
		}

		echo "ok";	
	}



	// http://zan.com/basetable/search_tag_new
	public function search_tag_new(){
		$this->load->database();
		$this->db->select('*');
		$this->db->where("status", 0);
		$this->db->where("type", 2);
		$query = $this->db->get('zb_discount');
		$list = $query->result_array();
		$urls = array();
		$shops = $this->mo_shop->get_all_shop_reserve();
		context::set('shop_list', $shops);
		$shop_city_lowernames = $this->mo_shop->get_all_shop_lowernames();
		context::set('shop_city_lowernames', $shop_city_lowernames);
		
		$tips_list = $this->mo_discount->get_all_tips_reserve();
		context::set('tips_list', $tips_list);

		$shop_list = $this->mo_shop->get_all_shop();
		
		foreach ($list as $key => $value) {
			context::set('error', 0);
			$this->render_tag($value['body']);
			$error = context::get('error', 0);
			if($error){
				var_dump("id:",$value['id']);
			}
		}

		echo "ok";	
	}

	public static function render_tag($content, $is_target=false) {
		$is_target = $is_target ? 1 : 0;
		$content = str_replace("＃", "#", $content);
		$content = str_replace ( '&#039;', '\'', $content );
		$content = str_replace ( '&#39;', '\'', $content );
		$str = preg_replace("/#([^#]+?)#/ise", "self::strip_tag('\\1','\\0', {$is_target})", $content);
		return $str;
	}
	

	public static function strip_tag($str, $link_word, $is_target=false ) {
		$str = trim($str);
		if($str == ""){
			return "##";
		}
		$shops = context::get('shop_list', array());
		$tips = context::get('tips_list', array());
		
		$target = $is_target ? ' target="_blank"' : '';
		$str = strip_tags($str);
		$link_word = strip_tags($link_word);
		
	    //增大字符的长度 
		if(mb_strwidth($str) > 80) {
	        $str = mb_strimwidth($str, 0, 80,'','UTF-8');
	    }
	    $shop_id = 0;
	    $tips_info = array();
	    $word = substr($link_word, 1, -1);
	    $word = strtolower($word);

	    if (isset( $shops[$word])) {
	    	 $shop_id = $shops[$word];
	   	}elseif(isset( $tips[$word])){
	   		$tips_info = $tips[$word];
	    }else{
	    	foreach ($shops as $key => $value) {
	    		if (strpos($key, $word)) {
	    			$shop_id = $value;
	    			break;
	    		}
	    	}
	    }
	   	if(!$shop_id && !$tips_info){
	   		var_dump($link_word);
	   		context::set('error', 1);
	   		return $str;
	   	}
	  
	    if($shop_id){
			//$url = sprintf(self::SHOP_URL, $shop_id);
	    }else{
	    	//$url = sprintf(self::TIPS_URL, $tips_info['city'], $tips_info['id']);
	    }
	    //$str = '<a href="'.$url.'"'.$target.'>'.$link_word.'</a>';

	    //$str = '<a style="color:#06C;" href="'.$url.'"'.$target.'>'.$word.'</a>';
		return $str;
	}

	// http://zan.com/basetable/search_tag
	public function search_tag(){
		$this->load->database();
		$this->db->select('id');
		$this->db->where("status", 0);
		$this->db->where("type", 2);
		$query = $this->db->get('zb_discount');
		$list = $query->result_array();
		$urls = array();
		foreach ($list as $key => $value) {
			$urls[] = "http://www.zanbai.com/shoptipsinfo/".$value['id']."\r\n\t";
		}
		var_dump(implode("", $urls));

		echo "ok";	
	}
	// http://zan.com/basetable/cityname
	public function cityname(){
		$this->load->database();
		$this->db->select('*');
		
		$query = $this->db->get('zb_city');
		$list = $query->result_array();
		foreach ($list as $key => $value) {
			$id = $value['id'];
			$english_name = $value['english_name'];
			$english_name = str_replace(" ", '', $english_name);
			$lower_name = strtolower($english_name);
			$add_data = array(
				'lower_name' => $lower_name,
			);
			$this->db->where('id', $id);
			$re =  $this->db->update('zb_city', $add_data);
		}
		echo "ok";
	}
	// http://zan.com/basetable/city_name_list

	public function city_name_list(){
		$this->load->database();
		$this->db->select('*');
		
		$city_query = $this->db->get('zb_city');
		$city_list = $city_query->result_array();
		$city_infos = array();
		$shopdiscount_list = array();
		$discount_list = array();
		$city_lists = array();
		$shop_urls = array();
		$shop_tips = array();
		$city_map_list = array();
		foreach ($city_list as $key => $value) {
			$city_lists[$value['id']] = $value;
			$city_infos[] = "\$route['".$value['lower_name']."'] = '/city/index/?city={$value['id']}';\r\n";
			$shopdiscount_list[] = "\$route['{$value['lower_name']}-shopdiscount'] = '/discount/index/?city={$value['id']}';\r\n";
			$shop_tips[] = "\$route['{$value['lower_name']}-shoppingtips'] = '/discount/shoptips_list/?city={$value['id']}';\r\n";
			$city_map_list[] = "\$route['{$value['lower_name']}-shoppingmap'] = '/city_map/index/?city={$value['id']}';\r\n";
			$shop_urls[] = "\$route['{$value['lower_name']}/(:num)'] = '/shop/index/?shop_id=\$1';\r\n";
		}
		$this->db->select('id,city');
		$this->db->where("status",0);
		$shop_query = $this->db->get('zb_shop');
		$shop_list = $shop_query->result_array();
		foreach($shop_list as $value){
			//$city = $city_lists[$value['city']];
			//$shop_urls[] = "\$route['{$city['lower_name']}/{$value['id']}'] = '/shop/index/?shop_id={$value['id']}';\r\n";
		}
		

		var_dump(implode("", $shop_urls));

	}

	// http://zan.com/basetable/get_caijie_brands
	public function get_caijie_brands(){
		$content = file("/var/www/htdocs/zan/brand.csv");
		var_dump(count($content));
		
		$brand_ids = array();
		foreach($content as $v){
			$tmp = explode(",", $v);
			$brand_name = $tmp[0];
			$english_name = $tmp[1];
			$brand_name = trim($brand_name);
			$english_name = trim($english_name);
			$all_brand = $this->mo_brand->get_id_by_name_foradmin($brand_name);

			if(isset($all_brand[$brand_name])){

				$brand_ids[] = $all_brand[$brand_name]['brand_id'];
			}else{
				
				
				$all_brand = $this->mo_brand->get_id_by_englishname_foradmin($english_name);
				
				if(isset($all_brand[$english_name])){

					$brand_ids[] = $all_brand[$english_name]['brand_id'];
				}else{
					var_dump($english_name);
				}
			}
		}
		var_dump(implode(",", $brand_ids));
		
		var_dump($brand_ids);
	}
	// http://10.11.12.13/basetable/brand_name
	# 处理 brandname ，去除空格，生成英文
	public function brand_name(){
		$this->load->model('do/do_brand');
		$list = $this->do_brand->get_brand_where_reserve_1();
		if($list){
			foreach ($list as $key => $value) {
				$name = $value['name'];
				$reserve_1 = tool::clean_blank($name);
				$data = array();
				$data['id'] = $value['id'];
				$data['reserve_1'] = $reserve_1;
				$this->do_brand->update_reserve_1($data);
			}
			echo 'ok';
		}
	}
	// http://10.11.12.13/basetable/sql
	public function sql(){
		$content = file_get_contents("/var/www/htdocs/zanbai.com/brand.csv");
		$tmp = explode("\r\n", $content);
		foreach ($tmp as $key => $value) {
			$line = explode(",", $value);
			
			$sql = "update `zb_index_brand_shop`  set brand_id = {$line[0]} where brand_id={$line[1]};\r\n";
			echo($sql);
		}
	}
// http://10.11.12.13/basetable/brand_first_number

	// http://zan.com/basetable/brand_first_number
	public function brand_first_number(){
		$this->load->database();
		$this->db->select('*');
		
		$query = $this->db->get('zb_brand');
		$list = $query->result_array();
		$number_list = array(0=>'L',1=>'Y',2=>'E',3=>"S",4=>"S",5=>"W",6=>"L",7=>"Q",8=>'B',9=>'J');
		foreach ($list as $key => $value) {
			$id = $value['id'];
			if($value['first_char']){
				continue;
			}
			
			$name = $value['name'];
			$first_char = $this->tool->format_first_char($name);
			if(is_numeric($first_char)){
				$name = mb_substr($name, 1);
				$first_char = $number_list[$first_char];
			}elseif(!ctype_alpha($first_char)){
				$re = $this->tool->convertChineseToPinyin($name);
				if($re){
					$first_char = $re;
				}
			}
			if(!ctype_alpha($first_char)){
				$english_name = $value['english_name'];
				$first_char = $this->tool->format_first_char($english_name);
				if(is_numeric($first_char)){
					$english_name = mb_substr($english_name, 1);
					$first_char = $number_list[$first_char];
				}elseif(!ctype_alpha($first_char)){
					$re = $this->tool->convertChineseToPinyin($english_name);
					if($re){
						$first_char = $re;
					}
				}
			}

			if(!$first_char){
				$length = mb_strlen($name, "utf-8");
				for($i =0; $i<$length; $i++){
					$char = mb_substr($name, $i, 1, "utf-8");
					if(is_numeric($char)){
						$first_char = $number_list[$char];
						break;
					}elseif(ctype_alpha($char)){
						$first_char = $char;
						break;
					}
				}
			}



			if($first_char){
				$this->load->database();
				$brand_data = array(
					'first_char' => $first_char,
				);
				$this->db->where('id', $id);
				$re =  $this->db->update('zb_brand', $brand_data);
			}
		}
		echo "ok";
	}

	// http://zan.com/basetable/format_pinyin_file
	public function format_pinyin_file(){
		$file = "/var/www/htdocs/zan/pinyin";
		$list = file($file);
		$re = array();
		$i = 0;
		$re2 = "";
		$re2 = "array(";
		foreach($list as $line){
			$i++;
			if($i>100){
				//break;
			}
			$line = trim($line);
			if($line){
				$tmp = explode("\t", $line);
				$one = $tmp[0];
				$two = "";
				if(isset($tmp[1])){
					$two = $tmp[1];
				}
				$re[] = "\$pinyin['{$tmp[0]}']='{$two}'";
				$re2 .= "'{$one}'=>'{$two}',";
				//var_dump($line, $tmp, $re);die;
			}
		}
		$re2.=");";
		echo $re2;
		echo implode("\r\n", $re);

	}
	// zan.com/basetable/shop_lower_name

	public function shop_lower_name(){
		$this->load->model('do/do_shop');
		$list = $this->do_shop->get_all_shop(true);
		if($list){
			foreach ($list as $key => $value) {
				$english_name = $value['english_name'];
				
				$english_name = tool::clean_blank($english_name);
				$english_name = tool::clean_html_and_js_simple($english_name);
				$english_name = str_replace(array("?","'", "-", "&", "(", ")", "/", "——", " ", " ~ ", "~", "\t", "\r\t"," "," ", "    ","（","）","(",")"), "", $english_name);
				$lower_name = $this->tool->format_pinyin($english_name);
				$lower_name = str_replace(array("?","'", "-", "&", "(", ")", "/", "——", " ", " ~ ", "~", "\t", "\r\t"," "," ", "    ","（","）","(",")"), "", $lower_name);
				
				if(!$lower_name){
					$lower_name = $value['id'];
				}
				$data = array();
				$data['id'] = $value['id'];
				$data['lower_name'] = $lower_name;
				$this->do_shop->update_info($data);
			}
			echo 'ok';
		}
	}




}