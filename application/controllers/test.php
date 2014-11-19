<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

# http://zan.com/test/img
public function img(){
		set_time_limit(3000);
		ini_set('memory_limit', '3G');

		$this->load->model("mo_brand");
		$list = $this->mo_brand->get_all_brand();

		$this->load->library('thinkimage/ThinkImage', 2, 'thinkimage');
		$this->load->library("common/image");

		foreach ($list as $key => $value) {
			if($value['big_pic']){
				continue;
			}
			$pic_url = "http://zanbai.b0.upaiyun.com/brand/brand_{$value['id']}.jpg";
			$exist = @getimagesize($pic_url);
			
			if($exist){
				$brand_data = array();
				$brand_data['id'] = $value['id'];
				$brand_data['big_pic'] = $pic_url;
				$brand_data['pic'] = $pic_url;
				$re = $this->mo_brand->update_info($brand_data);
				continue;
			}

			$img = new ThinkImage(THINKIMAGE_GD, FCPATH.'images/brand_background.jpg' );
			$brand_id = $value['id'];
			$path = "/var/www/htdocs/zanbai.com";
			$path = "/var/www/htdocs/zan";

			$info = imagettfbbox(16, 0, $path . "/system/fonts/msyh.ttf", $value['name']);
   	 		$minx = min($info[0], $info[2], $info[4], $info[6]); 
   	 		$maxx = max($info[0], $info[2], $info[4], $info[6]); 
			$re = $img->text($value['name'], $path . "/system/fonts/msyh.ttf",16, '#333333', array(10,30));
			$len = $maxx-$minx + 20;
			$img->crop($len, 83, 0, 0, $len, 83);
			$img->save(FCPATH.'images/brand/'.$brand_id.'.jpg');

			$re = $this->image->upload_brand( $brand_id );
			
			unset($img);
		}
		echo 123;
	}






	/*
	$height = 600;
	$width = 600;
	//创建背景图
	$im = ImageCreateTrueColor($width, $height);
	//分配颜色
	$white = ImageColorAllocate ($im, 255, 255, 255);
	$blue = ImageColorAllocate ($im, 0, 0, 64);
	//绘制颜色至图像中
	ImageFill($im, 0, 0, $white);
	//绘制字符串：Hello,PHP
	//ImageString($im, 10, 100, 120, 'Hello,PHP', $white);
	//输出图像，定义头
	Header ('Content-type: image/png');
	//将图像发送至浏览器
	ImagePng($im);
	//清除资源
	ImageDestroy($im);

	die;
	*/


	public function index(){
		$bound = "((47.17947473709184, 16.529998779296875), (60.166813385162186, 62.101287841796875))";
 		$this->load->model('mo_map');
 		$re = $this->mo_map->get_shop_range($bound);

		// echo 123;
 		// $this->load->model('mo_brand');
 		// $re = $this->mo_brand->get_hot_brand_by_city_id(1);

// 		$this->load->model('mo_social');
// 		$re = $this->mo_social->get_fans_cnt(1360227445);

// 		$this->load->model('mo_shop');
// 		$re = $this->mo_shop->get_shopcnt_by_brand_property_city(0,0,1);

// 		echo $this->tool->clean_file_version('http://zanbai.b0.upaiyun.com/2013/03/99eae868b66d704d.jpg!300','!popup');
//		$this->load->model('mo_dianping');
//		$re = $this->mo_dianping->get_valid_dianping_cnt(10);

//  		$this->load->view('map');
		#入库
// 		$this->load->model('mo_operation');
// 		$re = $this->mo_operation->get_value(mo_operation::INDEX_PICS);#1业务号代表首页轮播图片
// 		$this->load->model('mo_user');
// 		$re = $this->mo_user->get_middle_userinfos(array(1360227445));
		
// 		$this->load->model('mo_comment');
// 		$re = $this->mo_comment->get_commentinfo_by_dianpingid(87);

// 		$this->load->model('mo_user');
// 		$re = $this->mo_user->get_userinfo_by_source_sid('weibo','1577127583');
// 		$re = $this->mo_user->get_simple_userinfos(array(1360227445));

// 		$data = array(
// 				'email' => '1@2.3',
// 				'uname' => 'demien',
// 				'image' => 'http://tp4.sinaimg.cn/1577127583/180/5621616424/1',
// 				'gender' => 1,
// 				'phone' => '110',
// 				'source' => 'weibo',
// 				'sid' => '1577127583',
// 		);
// 		$this->load->model('do/do_user');
// 		$this->do_user->add_user($data);
// 		$re = $this->do_user->get_userinfo_by_source_sid('weibo','1577127583');

// 		$this->load->model('mo_geography');
// 		$re = $this->mo_geography->get_cities_by_country(1);

// 		$this->mo_geography->add_country(array('name'=>'中国','english_name'=>'China','area_id'=>3));
// 		$this->mo_geography->add_city(array('name'=>'香港','english_name'=>'Hongkong','area_id'=>3,'country_id'=>14));
// 		$this->mo_geography->add_city(array('name'=>'约克','english_name'=>'York','area_id'=>2,'country_id'=>5));
// 		$this->mo_geography->add_city(array('name'=>'苏黎士','english_name'=>'Zurich','area_id'=>2,'country_id'=>9));
// 		$this->mo_geography->add_area(array('name'=>'亚太','english_name'=>'Aisa Pacific'));
// 		$this->load->model('mo_shop');
// 		$re = $this->mo_shop->get_dianping_cnt(7);
// 		$re = $this->mo_shop->get_lastdianping_by_shopids(array(7));
// 		$this->load->model('do/do_index_shop_lastdianping');
// 		$re = $this->do_index_shop_lastdianping->get_lastdianping_by_shopids(array(8));
// 		$re = $this->mo_shop->add_last_dianping(1,345);
// 		$re = $this->mo_shop->get_shops_by_brand_property(1);
// 		$re = $this->mo_shop->add_index_brand_shop(array(7));

// 		$re = $this->mo_shop->add_index_brand_shop(array('shop_id'=>7,'brand_id'=>1));
// 		$this->load->library('session');
// 		$session_id = $this->session->all_userdata();

// 		$re = explode(",","123,234");

// 		$shopdata = array(
// 				'name' => "Macy's Department Store",
// 				'english_name' => "Macy's Department Store",
// 				'desc' => '奥特莱斯（Outlets）最早诞生于美国，迄今已有近一百年的历史。Outlets最早就是“工厂直销店”专门处理工厂尾货。后来逐渐汇集，慢慢形成类似Shopping Mall的大型Outlets购物中心，并逐渐发展成为一个独立的零售业态。虽然Factory Outlet这种业态在美国已有100年的历史，但真正有规模的发展是从1970年左右开始的。',
// 				'pic' => 'http://demien.b0.upaiyun.com/2013/01/a468420ea7a38fdd.jpg',
// 				'address' => '西城区西单北大街131号西单大悦城6楼',
// 				'phone' => '010-235698471',
// 				);
// 		$this->load->model('shop');
// 		$re = $this->shop->add($shopdata);
// 		$pics = array('http://zanbai.b0.upaiyun.com/2013/01/ef106ca4ccff3df7.jpg','http://zanbai.b0.upaiyun.com/2013/01/3ef816869dc66fc7.jpg');
// 		$dianpingdata = array(
// 				'score' => 3,
// 				'body' => "我去啊啊啊",
// 				'pics' => json_encode($pics),
// 				'has_pic' => 1,
// 				'uid' => 123,
// 				'shop_id' => 7,
// 		);
// 		$this->load->model('mo_dianping');
// 		$re = $this->mo_dianping->add($dianpingdata);
// 		$this->load->model('mo_dianping');
// 		$re = $this->mo_dianping->get_dianpinginfo_by_shopid(7);

// 		$this->config->load('errorcode',TRUE);
// 		$msg = $this->config->item('200','errorcode');

		
// 		$this->config->load('env',TRUE);
// 		$msg = $this->config->item('upyun-bucket','env'); /// 空间名
		

// 		$branddata = array(
// 				'name' => "阿玛尼",
// 				'english_name' => "Armani",
// 				'pic' => "http://zanbai.b0.upaiyun.com/2013/02/6b69c52a6fb26ea0.jpg",
// 				'first_char' => 'A',
// 				);
//		$this->load->model('mo_shop');
//		$re = $this->mo_shop->get_all_shop();
// 		$this->mo_shop->add_brand($branddata);
// 		$re = $this->mo_shop->get_brands_by_first_char('P');

// 		#header
// 		$this->load->view('testheader');
	
// 	    #回调	
// 		require_once APPPATH .'third_party/weibo/weibo_authv2.php';
// 		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY);
// 		$url = $o->getAuthorizeURL(WB_CALLBACK_URL);
// 		echo $url;
		
// 		#load page
// 		$this->load->view('test',array('url'=>$url));
		
// 		#footer
// 		$this->load->view('testfooter');
	}
}
