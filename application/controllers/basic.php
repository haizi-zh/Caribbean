<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Basic extends ZB_Controller {



	function rad($d)
	{
	   	return $d * 3.1415926535898 / 180.0;
	}
	#这个不好用。
	function GetDistance($lat1, $lng1, $lat2, $lng2){
		$EARTH_RADIUS = 6378.137;
		$radLat1 = $this->rad($lat1);
		//echo $radLat1;
	   $radLat2 = $this->rad($lat2);
	   $a = $radLat1 - $radLat2;
	   $b = $this->rad($lng1) - $this->rad($lng2);
	   $s = 2 * asin(sqrt(pow(sin($a/2),2) +
	    cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
	   $s = $s *$EARTH_RADIUS;
	   $s = round($s * 10000) / 10000;
	   return $s;
	}
	#用这个
	public function getDistance_good($lat1, $lng1, $lat2, $lng2){
		$earthRadius = 6367000; //approximate radius of earth in meters

		/*
		Convert these degrees to radians
		to work with the formula
		*/

		$lat1 = ($lat1 * pi() ) / 180;
		$lng1 = ($lng1 * pi() ) / 180;

		$lat2 = ($lat2 * pi() ) / 180;
		$lng2 = ($lng2 * pi() ) / 180;

		/*
		Using the
		Haversine formula

		http://en.wikipedia.org/wiki/Haversine_formula

		calculate the distance
		*/

		$calcLongitude = $lng2 - $lng1;
		$calcLatitude = $lat2 - $lat1;
		$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
		$calculatedDistance = $earthRadius * $stepTwo;

		return round($calculatedDistance);
	}
	// zan.com/basic/distan
 	public function distan(){
 		
		#40.762321,-73.974849
		$lng1 = "-73.974849";
		$lat1 = "40.762321";
		$lng2 = "-73.9951226";
		$lat2 = "40.7366398";

		$this->load->model("mo_shop");
		$five = $this->mo_shop->get_shopinfo_by_id(2040);
		$location =  $five['location'];
		$tmp  = explode(',', $location);
		$lat1 = $tmp[0];
		$lng1 = $tmp[1];


		$shops = $this->mo_shop->get_all_shop(true);


		foreach ($shops as $key => $shop) {
			$shop_id = $shop['id'];
			$location =  $shop['location'];
			if ($shop['status']) {
				continue;
			}
			if (!$location) {
				continue;
			}
			$tmp  = explode(',', $location);
			$lat1 = $tmp[0];
			$lng1 = $tmp[1];
			$list = array();
			foreach ($shops as $kk => $vv) {
				$target_shop_id = $vv['id'];
				if(!$vv['location']){
					continue;
				}
				if ($vv['status']) {
					continue;
				}
				if ($shop_id == $target_shop_id) {
					continue;
				}

				$location =  $vv['location'];
				$tmp  = explode(',', $location);
				$lat2 = $tmp[0];
				$lng2 = $tmp[1];

				$len2 = $this->getDistance_good($lat1, $lng1, $lat2, $lng2);

				$list[$target_shop_id] = $len2;

			}
			asort($list);
			$i = 0;
			foreach ($list as $target_shop_id => $distance) {
				if($i > 20){
					break;
				}
				$i++;
				$nearby_data = array();
				$nearby_data['shop_id'] = $shop_id;
				$nearby_data['target_shop_id'] = $target_shop_id;
				$nearby_data['simple_distance'] = round($distance/1000);
				$nearby_data['distance'] = $distance;
				
				$this->mo_shop->add_shop_nearby($nearby_data);
			}
		}
		$list = array();
		foreach ($shops as $key => $shop) {
			if(!$shop['location']){
				continue;
			}
			$location =  $shop['location'];
			$tmp  = explode(',', $location);
			$lat2 = $tmp[0];
			$lng2 = $tmp[1];

			$len = 	$this->GetDistance($lat1, $lng1, $lat2, $lng2);
			$len2 = $this->getDistance_good($lat1, $lng1, $lat2, $lng2);

			$list[$shop['name'].$shop['id']] = $len2;
			//var_dump($len, $len2, $shop['name'], $shop['english_name'], "\r\n");

		}
		asort($list);
		var_dump($list);die;
		var_dump($five);die;
		//$lng1 = "22.42139";
		//$lat1 = "114.0806";
		//$lng2 = "22.46406";
		//$lat2 = "114.0855";



		#22.42139, 114.0806 22.46406, 114.0855

		#40.7366398,-73.9951226
		$len = 	$this->GetDistance($lat1, $lng1, $lat2, $lng2);
		$len2 = $this->getDistance_good($lat1, $lng1, $lat2, $lng2);
		var_dump($len, $len2);
		die;
 	}

 }




