<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class basic extends ZB_Controller {

	# http://zan.com/mobile/basic/test?gender=man&type=yifu&country=usa
	public function test(){
		#男女，国家。类型
		$data = array();
		$gender = $this->input->get("gender", true, "man");
		$type = $this->input->get("type", true, "yifu");
		$country = $this->input->get("country", true, "usa");
		$re['html'] = "信息没有收录。请反馈给我们做更新。谢谢";

		if(!$gender||!$type||!$country){
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$re));
			exit();
		}
		$data['gender'] = $gender;
		$data['type'] = $type;
		$data['country'] = $country;
		$this->config->load('dimension',TRUE);
		$dimension = $this->config->item($gender, "dimension");
		$dimension_country = $this->config->item("dimension_country", "dimension");
		$list = $dimension[$type];
		$count = 0;
		$re_list = array();
		

		foreach($list as $k => $v){
			if($v[0]==$country){
				$re_list[] = $v;
			}
			if($v[0]=='china'){
				$re_list[] = $v;
			}
			if(!isset($dimension_country[$v[0]])){
				$re_list[] = $v;
			}
		}
		if(!$re_list){
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$re));
			exit();
		}
		$this->config->load('dimension',TRUE);
		$dimension_title = $this->config->item("dimension_title", "dimension");
		foreach ($re_list as $key => $value) {
			if(isset($dimension_title[$value[0]])){
				$re_list[$key][0] = $dimension_title[$value[0]];
			}
			$tmp_count = count($value);
			if($tmp_count > $count){
				$count = $tmp_count;
			}
		}
		
		$tmp = array();
		foreach ($re_list as $key => $value) {
			for($i=0;$i<$count;$i++){
				if(isset($value[$i])){
					$tmp[$i][$key] = $value[$i];
				}
 			}
		}

		$list = $tmp;
		$data['list'] = $list;
		$html = $this->load->view("template/dimension",$data,true);
		$data['html'] = $html;
		$data['pageid'] = 123;
		$this->load->web_view('dimension', $data);
	}

	# http://zan.com/mobile/basic/get_dimension_list
	public function get_dimension_list(){
		$this->config->load('dimension',TRUE);
		$woman = $this->config->item("woman", "dimension");
		$man = $this->config->item("man", "dimension");
		$child = $this->config->item("child", "dimension");
		$dimension_country = $this->config->item("dimension_country", "dimension");

		$data = array();
		$data['gender'] = array('man'=>'男人', 'woman'=>'女人', 'child'=>'儿童');
		$data['type'] = array();
		$data['type']['man'] = array("xie"=>"男鞋",'yifu'=>'男士正装,夹克，外套','kuzi'=>'男裤', 'chenshan'=>'男士衬衣', 'neiku'=>'男士内裤' );
		$data['type']['woman'] = array("xie"=>"女鞋",'yifu'=>'女上装(正装，夹克，大衣)','maoyi'=>'衬衣和毛衣', 'wenxiongxiongwei'=>'文胸胸围', 'wenxiongzhaobei'=>'文胸罩杯','neiku'=>'女士内裤', 'kuzi'=>'女裤');
		$data['type']['child'] = array("xie"=>"童鞋",'yifu'=>'美标童装');

		$country_list = array();
		foreach ($data['type'] as $gender => $v) {
			foreach ($v as $type => $vv) {
				if(isset(${$gender}[$type])){
					$list = ${$gender}[$type];
					foreach ($list as $kkk => $vvv) {
						if(isset($dimension_country[$vvv[0]])){
							$country_list[$gender][$type][$vvv[0]] = $dimension_country[$vvv[0]];
						}
					}
				}
			}			
		}
		$data['country'] = $country_list;

		/*
		$data['country'] = array();
		$data['country']['man']['xie'] = array("us"=>"美国",'uk'=>'英国','europe'=>'欧洲','australia'=>'澳大利亚','china'=>'中国','japan'=>'日本');
		$data['country']['man']['yifu'] =  array("us"=>"美国",'uk'=>'英国','europe'=>'欧洲','korea'=>'韩国','japan'=>'日本','sml'=>'S-M-L');
		$data['country']['man']['kuzi'] =  array("us"=>"美国",'uk'=>'英国','europe'=>'欧洲','korea'=>'韩国','japan'=>'日本','sml'=>'S-M-L');
		$data['country']['man']['chenshan'] =  array("us"=>"美国",'uk'=>'英国','europe'=>'欧洲','korea'=>'韩国','japan'=>'日本','sml'=>'S-M-L');
		$data['country']['man']['neiku'] =  array("us"=>"美国",'uk'=>'英国','europe'=>'欧洲','korea'=>'韩国','japan'=>'日本','sml'=>'S-M-L');
		$data['country']['woman']['xie'] =  array("us3"=>"美国3",'uk3'=>'英国3');
		$data['country']['woman']['yifu'] =  array("us4"=>"美国4",'uk4'=>'英国4');
		$data['country']['child']['xie'] =  array("us5"=>"美国5",'uk5'=>'英国5');
		$data['country']['child']['yifu'] =  array("us6"=>"美国6",'uk6'=>'英国6');
		*/

		$re = $data;
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$re));
	}

	# http://zan.com/mobile/basic/get_dimension?gender=woman&type=yifu&country=uk
	# http://zan.com/mobile/basic/get_dimension?gender=child&type=yifu&country=usa
	public function get_dimension(){
		#男女，国家。类型
		$data = array();

		$gender = $this->input->get("gender", true, "");
		$type = $this->input->get("type", true, "");
		$country = $this->input->get("country", true, "");
		$re['html'] = "信息没有收录。请反馈给我们做更新。谢谢";

		if(!$gender||!$type||!$country){
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$re));
			exit();
		}
		$data['gender'] = $gender;
		$data['type'] = $type;
		$data['country'] = $country;
		$this->config->load('dimension',TRUE);
		$dimension = $this->config->item($gender, "dimension");
		$dimension_country = $this->config->item("dimension_country", "dimension");
		$list = $dimension[$type];
		$count = 0;
		$re_list = array();
		

		foreach($list as $k => $v){
			if($v[0]==$country){
				$re_list[] = $v;
			}
			if($v[0]=='china'){
				$re_list[] = $v;
			}
			if(!isset($dimension_country[$v[0]])){
				$re_list[] = $v;
			}
		}
		if(!$re_list){
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$re));
			exit();
		}
		$this->config->load('dimension',TRUE);
		$dimension_title = $this->config->item("dimension_title", "dimension");
		foreach ($re_list as $key => $value) {
			if(isset($dimension_title[$value[0]])){
				$re_list[$key][0] = $dimension_title[$value[0]];
			}
			$tmp_count = count($value);
			if($tmp_count > $count){
				$count = $tmp_count;
			}
		}
		
		$tmp = array();
		foreach ($re_list as $key => $value) {
			for($i=0;$i<$count;$i++){
				if(isset($value[$i])){
					$tmp[$i][$key] = $value[$i];
				}
 			}
		}

		$list = $tmp;
		$data['list'] = $list;
		$html = $this->load->view("template/dimension",$data,true);

		$re['html'] = $html;
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ','data'=>$re));
	}

	public function create_imgage(){
		
		set_time_limit(3000);
		ini_set('memory_limit', '1G');
		$this->load->model("mo_dianping");
		$id = 1127;
		$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($id);
		$body = $dianping_info['body'];
		$pics = $dianping_info['pics'];
		$this->image2($body, $pics);
	}


	# http://zan.com/mobile/basic/shop_img
	public function shop_img(){
		$shop_id = $this->input->get("shop_id",true,5);
		$shop_id = intval($shop_id);
		$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		if(!$shop_re){
			echo false;
			exit();
		}
		$shop_info = $shop_re[$shop_id];
		$desc = $shop_info['desc'];

		$this->image2($desc, array());

	}

	# http://zan.com/mobile/basic/image2
	public function image2($body, $pics){
		$explode = "8c5f5ccda43f1b2d3c73e785c5055126";
		preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', $body, $out);
		$format_body = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', $explode, $body);
		$re = array();
		$i=0;

		if($out[0]){
			$list = explode($explode, $format_body);
			$out0 = $out[0];
			$out2 = $out[2];
			$image_count = count($out2);
			$count_list = count($list);
			
			foreach ($list as $key => $value) {
				$value = $this->tool->clean_all_2($value, 0);
				$re[] = array('txt'=>$value);

				if(isset($out2[$key]) && $i < 10){
					$img_str = $out2[$key];
					$img_str = str_replace("popup", "pingbody", $img_str);
					$re[] = array('img' => $img_str);
					$i++;
				}
			}
		}else{
			$tmp = explode("<br>", $body);

			//$tmp = $this->tool->clean_all_2($body, 0);
			//$re[] = array('txt'=>$tmp);
			foreach($tmp as $v){
				
				$v = str_replace("  ", "", $v);
				$re[] = array('txt'=>$this->tool->clean_all_2($v, 0));
			}
			
			
		}
		

		//$re[] = array('txt'=>"更多图片信息请查看 www.zanbai.com                 ZANBAI出境购物指南全球百货攻略");
		//$re[] = array('txt'=>"");

		$dele_file_paths = array();
		$img_path = array();
		$imgs = array();
		foreach($re as $k => $v){
			if (isset($v['txt'])) {
				if(!$v['txt']){
					continue;
				}
				$img = new text2img();
				$str = $v['txt'];
				$file_path = md5($k.$str);
				$file_path = FCPATH.'tmp/'.$file_path.'.jpg';
				$img->text2Img($str, $file_path);
				unset($img);
				$re[$k]['img'] = $file_path;
				$imgs[] = $file_path;

				$dele_file_paths[] = $file_path;
			}else{
				$imgs[] = $v['img'];
			}
		}

		$target = FCPATH.'images/ss.jpg';//背景图片
		$dele_file_paths[] = $target;
		$source = array();
		$height = 0;
		if($imgs){
			foreach ($imgs as $k=>$v){
				$source[$k]['source'] = Imagecreatefromjpeg($v);
				$source[$k]['size'] = getimagesize($v);
				$height += $source[$k]['size'][1];
			}
		}

		$height += 30;
		$width = 460;

		$target_img = ImageCreateTrueColor($width, $height);

		$white = ImageColorAllocate ($target_img, 255, 255, 255);
		ImageFill($target_img, 0, 0, $white);
		$re = Imagejpeg($target_img, $target);
		
		$target_img = Imagecreatefromjpeg($target);

		$num1=0;
		$num=1;
		$tmp=2;
		$tmpy=5;//图片之间的间距
		$leng = count($source);
		for ($i=0; $i<$leng; $i++){
			imagecopy($target_img,$source[$i]['source'],$tmp,$tmpy,0,0, $width, $source[$i]['size'][1]);
			$tmp = $tmp + $source[$i]['size'][0];

			$tmp = $tmp + 5;
			//if($i==$num){
				$tmpy = $tmpy + $source[$i]['size'][1];
				$tmpy = $tmpy + 2;
				var_dump($tmpy);
				$tmp=2;
				$num=$num+3;
			//}
		}
		
		$re = Imagejpeg($target_img, FCPATH.'tmp/ss2.jpg');
		var_dump( FCPATH.'tmp/ss2.jpg' );
		if($dele_file_paths){
			foreach ($dele_file_paths as $key => $file) {
				//unlink($file);
			}
		}


		var_dump($re, $target_img);die;
	}

}
