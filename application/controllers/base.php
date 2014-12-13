<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model("mo_dianping");
		$this->load->model("mo_count");
	}
	//coupon下载次数统计
	# http://zan.com/base/format_coupon_down_count
	# http://zan.com/base/format_coupon_down_count
	public function format_coupon_down_count(){
		$list = $this->mo_coupon->get_list(array(), 1, 100000);
		foreach($list as $v){
			$sid = $v['id'];
			$count = $this->mo_count->get_all_count_by_sid(18, $sid);
			$count = $count * 2 + 1;
			$count = 3000  + $count;
			$download_count = $v['download_count'];
			if($count > $download_count){
				$add_data = array();
				$add_data['download_count'] = $count;
				$this->mo_coupon->update($add_data, $sid);
			}
		}
		echo "ok";
	}

	# http://zan.com/base/phpinfo
	public function phpinfo(){
		phpinfo();
	}
	# http://zan.com/base/phpinfo2
	public function phpinfo2(){
		phpinfo();
	}

	# http://zan.com/base/site_map_xml
	# http://zanbai.com/base/site_map_xml
	public function site_map_xml(){
		$file = "sitemap.xml";
		$template = "<url>
<loc>%s</loc>
<lastmod>%s</lastmod>
<changefreq>%s</changefreq>
</url>\r\n";
		$first = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\r\n";
		$end = '</urlset>';
		$list = array();

		$citys = $this->mo_geography->get_all_cityinfos();
		$city_template = "http://www.zanbai.com/%s/";
		$shopdiscount_template = "http://www.zanbai.com/%s-shopdiscount/";
		$shoppingtips_template = "http://www.zanbai.com/%s-shoppingtips/";
		$shoppingtips_detail_template = "http://www.zanbai.com/shoptipsinfo/%s/";
		$shoppingmap_template = "http://www.zanbai.com/%s-shoppingmap/";
		$shop_template = "http://www.zanbai.com/%s/%s/";
		$brand_template = "http://www.zanbai.com/brandstreet/%s/";

		$lines = array();
		$lines[] = "http://www.zanbai.com/home/more/";
		$lines[] = "http://www.zanbai.com/sitemap/";
		foreach($citys as $kk=>$city){
			$city_line = sprintf($city_template, $city['lower_name']);
			$lines[] = $city_line;
		}
		foreach($citys as $kk=>$city){
			$shopdiscount_line = sprintf($shopdiscount_template, $city['lower_name']);
			$lines[] = $shopdiscount_line;
		}
		foreach($citys as $kk=>$city){
			$shoppingtips_line = sprintf($shoppingtips_template, $city['lower_name']);
			$lines[] = $shoppingtips_line;
		}
		foreach($citys as $kk=>$city){
			$shoppingmap_line = sprintf($shoppingmap_template, $city['lower_name']);
			$lines[] = $shoppingmap_line;
		}
		
		$shops = $this->mo_shop->get_all_shop(true);
		foreach($shops as $k=>$shop){
			if($shop['status'] == 1){
				continue;
			}
			if(isset($citys[$shop['city']])){
				$city = $citys[$shop['city']];
				$shop_line = sprintf($shop_template, $city['lower_name'], $shop['id']);
				$lines[] = $shop_line;
			}else{
			}
		}
		foreach($shops as $k=>$shop){
			if($shop['status'] == 1){
				continue;
			}
			$brand_ids = $this->mo_shop->get_brands_by_shop($shop['id']);
			if($brand_ids){
				$brand_line = sprintf($brand_template, $shop['id']);
				$lines[] = $brand_line;
			}
		}

		$shoptips_list = $this->mo_discount->get_all_discount_ids_list(2, 'id,status', 0);
		foreach ($shoptips_list as $k=>$v) {
			$shoptips_info = $this->mo_discount->get_info_by_id($v['id']);
			
			if( ($shoptips_info['city'] && $shoptips_info['city']>19) || ($shoptips_info['country'] && $shoptips_info['country']>2) ){
				//continue;
			}
			if($v['status']==1){
				continue;
			}
			$shoppingtips_detail_line = sprintf($shoppingtips_detail_template, $v['id']);
			$lines[] = $shoppingtips_detail_line;
		}

		$discount_info_template = "http://www.zanbai.com/discount/%s/";
		$discount_list = $this->mo_discount->get_all_discount_ids_list(1);
		foreach ($discount_list as $k=>$v) {
			$discount_info_line = sprintf($discount_info_template, $v['id']);
			$lines[] = $discount_info_line;
		}

		$dianping_template = "http://www.zanbai.com/ping/%s/";
		$dianpings = $this->mo_dianping->get_all_dianpings();
		foreach ($dianpings as $k=>$v) {
			$dianping_line = sprintf($dianping_template, $v['id']);
			$lines[] = $dianping_line;
		}
		$line_input = "";
		foreach($lines as $v){
			$line_input .= sprintf($template, $v, "2014-05-22T06:47:00+00:00", "daily");
		}
		$content = $first.$line_input.$end;
		//var_dump($content);die;

		file_put_contents($file,"{$content}\r\n");
		echo "ok";
	}
	# http://zan.com/base/all_city
	public function all_city(){
		$citys = $this->mo_geography->get_all_cityinfos();
		foreach($citys as $city){
			$city_id = $city['id'];
			$name = $city['name'];
			echo "城市id:".$city_id."\r\n";
			echo $name."\r\n";
			$list = $this->mo_discount->get_info_by_shopid($city['country_id'], $city_id, 0, 2, 1, 10000);
			
			foreach($list as $v){
				// /shoptipsinfo/1966
				echo "http://www.zanbai.com/shoptipsinfo/".$v['id']."\r\n";
			}

			echo  "\r\n\r\n";

			
		}
	}
	# http://zanbai.com/base/site_url
	# http://zan.com/base/site_url

	public function site_url(){
		$list = array();

		$citys = $this->mo_geography->get_all_cityinfos();
		$city_template = "http://www.zanbai.com/%s/";
		$shopdiscount_template = "http://www.zanbai.com/%s-shopdiscount/";
		$shoppingtips_template = "http://www.zanbai.com/%s-shoppingtips/";
		$shoppingtips_detail_template = "http://www.zanbai.com/shoptipsinfo/%s/";
		$shoppingmap_template = "http://www.zanbai.com/%s-shoppingmap/";
		$shop_template = "http://www.zanbai.com/%s/%s/";
		$brand_template = "http://www.zanbai.com/brandstreet/%s/";

		$lines = array();
		$lines[] = "http://www.zanbai.com/home/more/";
		$lines[] = "http://www.zanbai.com/sitemap/";
		$str = "";
		/*
		foreach($citys as $kk=>$city){
			$city_line = sprintf($city_template, $city['lower_name']);
			$shoppingtips_line = sprintf($shoppingtips_template, $city['lower_name']);
			$shoppingmap_line = sprintf($shoppingmap_template, $city['lower_name']);
			$line = $city['name'].",".$city['lower_name'].",".$city_line.",".$shoppingtips_line.",".$shoppingmap_line."\n";
			$str .= $line;
		}
		$filename = "城市.csv";

		$this->export_csv($filename,$str); //导出 

		die;
		*/
		/*

		foreach($citys as $kk=>$city){
			$shopdiscount_line = sprintf($shopdiscount_template, $city['lower_name']);
			$lines[] = $shopdiscount_line;
		}

		foreach($citys as $kk=>$city){
			$city_line = sprintf($city_template, $city['lower_name']);
			$lines[] = $city_line;
		}
		foreach($citys as $kk=>$city){
			$shoppingtips_line = sprintf($shoppingtips_template, $city['lower_name']);
			$lines[] = $shoppingtips_line;
		}
		foreach($citys as $kk=>$city){
			$shoppingmap_line = sprintf($shoppingmap_template, $city['lower_name']);
			$lines[] = $shoppingmap_line;
		}
		
		$shops = $this->mo_shop->get_all_shop(true);
		foreach($shops as $k=>$shop){
			if($shop['status'] == 1){
				continue;
			}
			if(isset($citys[$shop['city']])){
				$city = $citys[$shop['city']];
				$shop_line = sprintf($shop_template, $city['lower_name'], $shop['id']);
				$lines[] = $shop_line;
			}else{
			}
		}
		foreach($shops as $k=>$shop){
			if($shop['status'] == 1){
				continue;
			}
			$brand_ids = $this->mo_shop->get_brands_by_shop($shop['id']);
			if($brand_ids){
				$brand_line = sprintf($brand_template, $shop['id']);
				$lines[] = $brand_line;
			}
		}
		*/



		$shoptips_list = $this->mo_discount->get_all_discount_ids_list(2);

		$str = "链接,title\n";

		$shops = $this->mo_shop->get_all_shop(true);
		foreach($shops as $k=>$shop){
			if($shop['status'] == 1){
				continue;
			}
			if(isset($citys[$shop['city']])){
				$city = $citys[$shop['city']];
				$shop_line = sprintf($shop_template, $city['lower_name'], $shop['id']);
				
				$line = $shop_line.",".$shop['name'].",".$shop['english_name']."\n";
				$str .= $line;
			}else{
			}
		}

		//$str = iconv('utf-8','gb2312',$str);
		$shoptips_ids = array();
		foreach ($shoptips_list as $k=>$v) {
			$shoptips_ids[$v['id']] = $v['id'];
		}
		$shoptips_infos = $this->mo_discount->get_info_by_ids($shoptips_ids);
		//var_dump(count($shoptips_infos));die;
		foreach ($shoptips_list as $k=>$v) {
			if(!isset($shoptips_infos[$v['id']])){
				continue;
			}
			$shoptips_info = $shoptips_infos[$v['id']];
			
			if( ($shoptips_info['city'] && $shoptips_info['city']>19) || ($shoptips_info['country'] && $shoptips_info['country']>2) ){
				//($shoptips_info);die;
				//continue;
			}
			$shoppingtips_detail_line = sprintf($shoppingtips_detail_template, $v['id']);

			$title = $shoptips_info['title'];
			$body = $shoptips_info['body'];
			$body = str_replace(",", " ", $body);
			$body = tool::clean_html_and_js_simple($body);
			//$title = iconv('utf-8','gb2312//ignore',$title);
			//$body = iconv('utf-8','gb2312//ignore',$body);
			//$line = $shoppingtips_detail_line.",".$title.",".$body."\n";
			$line = $shoppingtips_detail_line.",".$title."\n";
			$str .= $line;
		}
		
		$filename = "攻略.csv";

		$this->export_csv($filename,$str); //导出 

		die;

		$discount_info_template = "http://www.zanbai.com/discount/%s/";
		$discount_list = $this->mo_discount->get_all_discount_ids_list(1);
		foreach ($discount_list as $k=>$v) {
			$discount_info_line = sprintf($discount_info_template, $v['id']);
			$lines[] = $discount_info_line;
		}

		$dianping_template = "http://www.zanbai.com/ping/%s/";
		$dianpings = $this->mo_dianping->get_all_dianpings();
		foreach ($dianpings as $k=>$v) {
			$dianping_line = sprintf($dianping_template, $v['id']);
			$lines[] = $dianping_line;
		}

	}
	function export_csv($filename,$data) { 
	    header("Content-type:text/csv"); 
	    header("Content-Disposition:attachment;filename=".$filename); 
	    header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
	    header('Expires:0'); 
	    header('Pragma:public'); 
	    echo $data; 
	} 

	# http://zanbai.com/base/site_map
	# http://zan.com/base/site_map
	# http://www.zanbai.com/sitemap.txt
	public function site_map(){

		$file = "sitemap.txt";

		file_put_contents($file,"http://www.zanbai.com\r\n");

		$lines[] = "http://www.zanbai.com/home/index?step=2";

		$area_citys = $this->mo_geography->get_all_cities();
		$city_templte = "http://www.zanbai.com/city/%s";
		$discount_tips_template = "http://www.zanbai.com/shoptips/%s/";
		$discount_city_template = "http://www.zanbai.com/discountcity/%s/";
		foreach($area_citys as $k=>$area){
			foreach($area as $kk=>$city){
				$city_line = sprintf($city_templte, $city['id']);
				$lines[] = $city_line;
			}
		}
		foreach($area_citys as $k=>$area){
			foreach($area as $kk=>$city){
				$discount_tips_line = sprintf($discount_tips_template, $city['id']);
				$lines[] = $discount_tips_line;
			}
		}
		foreach($area_citys as $k=>$area){
			foreach($area as $kk=>$city){
				$discount_city_line = sprintf($discount_city_template, $city['id']);
				$lines[] = $discount_city_line;
			}
		}
		$this->write_site_map($file, $lines);
		$lines = array();
		
		$shop_template = "http://www.zanbai.com/shop/%s";
		$discount_shop_template = "http://www.zanbai.com/discountshop/%s/";
		$shops = $this->mo_shop->get_all_shop(true);
		foreach($shops as $k=>$shop){
			if($shop['status'] == 1){
				continue;
			}
			$shop_line = sprintf($shop_template, $shop['id']);
			$lines[] = $shop_line;
		}
		foreach($shops as $k=>$shop){
			if($shop['status'] == 1){
				continue;
			}
			$discount_shop_line = sprintf($discount_shop_template, $shop['id']);
			$lines[] = $discount_shop_line;
		}
		$this->write_site_map($file, $lines);
		$lines = array();

		$brand_template = "http://www.zanbai.com/brandstreet/%s/";
		foreach($shops as $k=>$shop){
			if($shop['status'] == 1){
				continue;
			}
			$brand_ids = $this->mo_shop->get_brands_by_shop($shop['id']);
			if($brand_ids){
				$brand_line = sprintf($brand_template, $shop['id']);
				$lines[] = $brand_line;
			}
		}
		$this->write_site_map($file, $lines);
		$lines = array();


		$discount_info_template = "http://www.zanbai.com/discount/%s/";
		$discount_list = $this->mo_discount->get_all_discount_ids_list();
		foreach ($discount_list as $k=>$v) {
			$discount_info_line = sprintf($discount_info_template, $v['id']);
			$lines[] = $discount_info_line;
		}

		$this->write_site_map($file, $lines);
		$lines = array();

		$dianping_template = "http://www.zanbai.com/ping/%s/";
		$dianpings = $this->mo_dianping->get_all_dianpings();
		foreach ($dianpings as $k=>$v) {

			$dianping_line = sprintf($dianping_template, $v['id']);
			$lines[] = $dianping_line;
		}

		$this->write_site_map($file, $lines);
		$lines = array();

	}

	private function write_site_map($file, $lines){
		foreach ($lines as $key => $line) {
			file_put_contents($file,"{$line}\r\n", FILE_APPEND);
		}
		return;
	}
	# http://zan.com/base/discount_stime
	# http://dev.zanbai.com/base/discount_stime
	public function discount_stime(){
		$this->load->database();
		$sql = "select id,stime,etime from zb_discount where status=0 and type=1";
		$query = $this->db->query($sql);
		$list = $query->result_array();
		foreach($list as $v){
			$id = $v['id'];
			$stime = $v['stime'];
			$etime = $v['etime'];
			//$etime = $etime + mt_rand(1,20);
			$sql = "update zb_discount_shop set stime={$stime},etime={$etime} where discount_id={$id}";
			$query = $this->db->query($sql);
		}
		echo "ok";
	}
	
	# http://zanbai.b0.upaiyun.com/shop/shop_1.jpg
	# http://zan.com/base/shop_small_map
	# http://zanbai.com/base/shop_small_map
	# http://admin.zanbai.com/base/shop_small_map
	public function shop_small_map(){
		set_time_limit(3000);
		ini_set('memory_limit', '3G');

		$this->load->library("common/image");
		// http://ditu.google.cn/maps/api/staticmap?center=$lon,$lat&zoom=13&size=220x200&maptype=roadmap&markers=color:blue%7Clabel:o%7C$lon,$lat&sensor=false
		$this->load->model("mo_shop");
		$shop_re = $this->mo_shop->get_all_shop(true);
		
		foreach($shop_re as $shop){
			if($shop['status']!=0){
				continue;
			}
			if($shop['reserve_4']){
				continue;
			}
			$pic_url = "http://zanbai.b0.upaiyun.com/shop/shop_{$shop['id']}.jpg";
			$exist = getimagesize($pic_url);
			if($exist){
				$shop_data = array();
				$shop_data['id'] = $shop['id'];
				$shop_data['reserve_4'] = $pic_url;
				$re = $this->mo_shop->update_info($shop_data);
				continue;
			}
			$lat = 0;$lon=0;
			//var_dump($shop);
			$location = isset($shop['location'])?$shop['location']:'';
			//var_dump($location);
			$shop_id = $shop['id'];
			if(!$location){
				continue;
			}
			if($location){
				$locations = explode(',',$location);
				$lon = trim($locations[0]);
				$lat = trim($locations[1]);
				$url = "http://ditu.google.cn/maps/api/staticmap?center=$lon,$lat&zoom=13&size=220x200&maptype=roadmap&markers=color:blue%7Clabel:o%7C$lon,$lat&sensor=false";
				$content = file_get_contents($url);
				$file_path = $url;
				$save_path = "/shop/shop_{$shop_id}.jpg";
				try{
					$re = $this->image->upload_image_by_content( $content, $save_path );
				}catch(Exception $e){
					$re = $this->image->upload_image_by_content( $content, $save_path );
				}
			}
			 var_dump($shop['id']) ."<br/>";
			//var_dump($url,$re,  $content, $shop);
			//die;
		}
		echo 'ok';
	}

	# http://zanbai.b0.upaiyun.com/shop/shop_1.jpg
	# http://zan.com/base/shop_small_map
	# http://zanbai.com/base/shop_small_map
	# http://admin.zanbai.com/base/shop_small_map
	public function shop_big_map(){
		set_time_limit(3000);
		ini_set('memory_limit', '3G');

		$this->load->library("common/image");
		// http://ditu.google.cn/maps/api/staticmap?center=$lon,$lat&zoom=13&size=220x200&maptype=roadmap&markers=color:blue%7Clabel:o%7C$lon,$lat&sensor=false
		$this->load->model("mo_shop");
		$shop_re = $this->mo_shop->get_all_shop(true);
		
		foreach($shop_re as $shop){
			if($shop['status']!=0){
				continue;
			}
			if($shop['reserve_5']){
				continue;
			}
			$pic_url = "http://zanbai.b0.upaiyun.com/shop/shop_big_{$shop['id']}.jpg";
			$exist = getimagesize($pic_url);
			if($exist){
				$shop_data = array();
				$shop_data['id'] = $shop['id'];
				$shop_data['reserve_5'] = $pic_url;
				$re = $this->mo_shop->update_info($shop_data);
				continue;
			}
			$lat = 0;$lon=0;
			//var_dump($shop);
			$location = isset($shop['location'])?$shop['location']:'';
			//var_dump($location);
			$shop_id = $shop['id'];
			if(!$location){
				continue;
			}
			if($location){
				$locations = explode(',',$location);
				$lon = trim($locations[0]);
				$lat = trim($locations[1]);
					 //http://ditu.google.cn/maps/api/staticmap?center=40.762321,-73.974849&zoom=13&size=640x640&maptype=roadmap&markers=color:blue%7Clabel:o%7C40.762321,-73.974849&sensor=false
				$url = "http://ditu.google.cn/maps/api/staticmap?center=$lon,$lat&zoom=13&size=640x640&maptype=roadmap&markers=color:blue%7Clabel:o%7C$lon,$lat&sensor=false";
				$content = file_get_contents($url);
				$file_path = $url;
				$save_path = "/shop/shop_big_{$shop_id}.jpg";
				try{
					$re = $this->image->upload_image_by_content( $content, $save_path );
				}catch(Exception $e){
					$re = $this->image->upload_image_by_content( $content, $save_path );
				}
			}
			 var_dump($shop['id']) ."<br/>";
			//var_dump($url,$re,  $content, $shop);
			//die;
		}
	}
	# http://zanbai.com/base/pdf_create
	# http://zan.com/base/pdf_create
	public function pdf_create(){
		
		set_time_limit(3000);
		ini_set('memory_limit', '3G');
		//ALTER TABLE  `zb_shop` ADD  `pdf_file` VARCHAR( 100 ) NOT NULL DEFAULT  '';
		$this->load->library("common/image");
		// http://ditu.google.cn/maps/api/staticmap?center=$lon,$lat&zoom=13&size=220x200&maptype=roadmap&markers=color:blue%7Clabel:o%7C$lon,$lat&sensor=false
		$this->load->model("mo_shop");
		$shop_re = $this->mo_shop->get_all_shop(true);
		$i=0;
		foreach($shop_re as $shop){
			if($shop['status']!=0){
				continue;
			}
			if($shop['pdf_file']){
				continue;
			}
			$pdf_url = "http://zbfile.b0.upaiyun.com/shop/{$shop['id']}.pdf";
			$exist = file_get_contents($pdf_url,0,null,0,1);

			if($exist){
				$shop_data = array();
				$shop_data['id'] = $shop['id'];
				$shop_data['pdf_file'] = $pdf_url;
				$re = $this->mo_shop->update_info($shop_data);
				continue;
			}
			$i++;
			if($i>100){
				exit();
			}

			$shop_id = $shop['id'];
			shell_exec("/opt/wkhtmltopdf/bin/wkhtmltopdf http://zanbai.com/shop/printd/?shop_id={$shop_id} /tmp/{$shop_id}.pdf");
			$content = file_get_contents("/tmp/{$shop_id}.pdf");
			
			$save_path = "/shop/{$shop_id}.pdf";

			try{
				$re = $this->image->upload_file_by_content( $content, $save_path );
			}catch(Exception $e){
				$re = $this->image->upload_file_by_content( $content, $save_path );
			}
			unset($pdf_url, $exist, $content, $save_path);
		}
	}

	//创建coupon的pdf
	# http://zanbai.com/base/pdf_coupon_create
	# http://zan.com/base/pdf_coupon_create
	public function pdf_coupon_create(){
		set_time_limit(3000);
		ini_set('memory_limit', '3G');
		$this->load->library("common/image");
		$this->load->model("mo_coupon");
		$coupon_list = $this->mo_coupon->get_list(array(), 1 ,1000);
		$coupon_list = array_reverse($coupon_list);
		$i=0;
		foreach($coupon_list as $coupon){
			$coupon_id = $coupon['id'];
			if(!$coupon['pdf_name']){
				continue;
			}
			if($coupon['pdf_name_new']){
				continue;
			}
			$pdf_url = "http://zbfile.b0.upaiyun.com/coupon/{$coupon_id}.pdf";
			$exist = fileinfo::check_exist($pdf_url);
			if($exist){
				$coupon_data = array();
				$coupon_data['pdf_name_new'] = $coupon['pdf_name'];
				$re = $this->mo_coupon->update($coupon_data, $coupon_id);
				continue;
			}
			$file_name = FCPATH."/public/coupon/".$coupon['pdf_name'];
			if(!file_exists($file_name)){
				continue;
			}
			
			//var_dump(FCPATH."/public/coupon/".$coupon['pdf_name']);
			$save_path = "/coupon/{$coupon_id}.pdf";
			try{
				$re = $this->image->upload_file_by_file( $file_name , $save_path );
			}catch(Exception $e){
				$re = $this->image->upload_file_by_file( $file_name , $save_path );
			}
			unset($save_path);
		}
	}


	public function city_img(){
		$city_pics = array('1'=>'niuyue.jpg','21'=>'lundun.jpg','22'=>'milan.jpg','20'=>'bali.jpg','23'=>'luoma.jpg','44'=>'xianggang.jpg',
			'2'=>'luoshanji.jpg','97'=>'shouer.jpg','49'=>'taibei.jpg','51'=>'dongjing.jpg','3'=>'zhijiage.jpg','5'=>'jiujinshan.jpg');
		
	}
	# http://zan.com/base/check_upload_brand_image
	public function check_upload_brand_image(){
		$this->load->library("common/image");
		#获取所有品牌
		$this->load->model("mo_brand");
		$list = $this->mo_brand->get_all_brand();
		$i = 0;
		foreach ($list as $key => $brand) {
			$i++;
			if($i >10){
				//die;
			}
			$brand_id = $brand['id'];
			//$re = $this->image->upload_brand( $brand_id );

			var_dump($brand['id']);
		}
		echo "ok";
		die;
	}
	
	public function index(){
		$handle = @fopen('/var/www/htdocs/zanbai.com/555.csv', "r");
		$i = 0;
		$this->load->model("mo_brand");


		if ($handle) {
			while (!feof($handle)) {
				$i++;
				if($i > 100){
					die;
				}
				$lines = fgets($handle, 4096);
				$tmp = explode(",", $lines);
				if ($tmp) {
					if (!$tmp[1]) {
						$name = $tmp[2];
						$back_name = $tmp[4];
						$name = trim($name);
						$back_name = trim($back_name);
						if($back_name=='checked'){
							$back_name = $name;
						}
						if (!$back_name) {
							$name = $back_name;
						}
						$branddata = array(
						'name' => $name,
						'english_name' => $back_name,
						);

						$exist = $this->mo_brand->get_id_by_name($name);
						//$this->mo_brand->add_brand($branddata);
					}
				}
				$data = array();
			}
		}

		echo 123;die;

	}
	// http://zan.com/base/grep_my
	public function grep_my(){
		$list = array("08", "09", "10");
		$brands['macys'] = array(201,202,203,204);
		$brands['布鲁明戴尔'] = array(196,197,198,199,200,207);
		
		foreach($list as $day){
			echo $day."\r\n";
			$types = array();
			$types[] = "/coupon_info/%s/";
			$types[] = "/download_coupon/?id=%s";
			foreach($types as $key => $type){
				echo $type ."\r\n";
				foreach($brands as $brand=>$brand_list){
					echo $brand."\r\n";
					$i = 0;
					foreach($brand_list as $brand_id){
						$template = sprintf($type, $brand_id);
						$res = array();
						$rc = 0;
						$expe = "";
						if($key == 0){
							$expe = " | grep -v download_coupon ";
						}
						if(!$template){
							//var_dump($brand, $brand_list, $type);die;
						}
						$str = ' grep  '.$template.'  /var/log/httpd/zanbai2/zanbai.com_201407'.$day.'_access_log | grep -v "spider" | grep -v "spider.htm" | grep -v "YisouSpider" | grep -v "bot.html" |grep -v "360Spider" | grep -v "webmeup-crawle" |grep -v  "robot" | grep -v "nutch" | grep -v "Nutch"|grep -v ".jpg" | grep -v ".png" | grep -v ".js" '.$expe.'  | wc -l ';
						//exec($str, $res, $rc);
						$re = shell_exec($str);
						//echo $str. "\r\n";
						$i += intval($re);
						//echo  intval($re)."\r\n";
					}
					echo $i . "\r\n";
				}
			}
		}
	}

}