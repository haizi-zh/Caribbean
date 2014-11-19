<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class upimage{
	# http://zanbai.b0.upaiyun.com/2013/08/1ce3dd4cfd915d60.jpg!300
	# http://img5.zanbai.com/2013/08/1ce3dd4cfd915d60.jpg!300
	public static function format_brand_up_image($pic){
		
		$dian_pos = strpos($pic, ".jpg");
		$number = substr($pic, $dian_pos-1, 1);
		if(!is_numeric($number)){
			$number = ord($number);
		}

		$re = intval($number)%5;
		$list = array(1=>1,2=>2,3=>3,4=>4,5=>5);
		if( !$re ){
			$re = 5;
			//return $pic;
		}
		$url = "img{$re}.zanbai.com";
		$re_pic = str_replace("zanbai.b0.upaiyun.com", $url, $pic);
		return $re_pic;
	}

}

