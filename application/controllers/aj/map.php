<?php 
class map extends ZB_Controller {
	//根据商家中文名,英文名进行模糊摸索
	public function searchshop() {
		$q = $this->input->get('q', true, "");
		$q = mysql_escape_string($q);
		$sql = 'select name,english_name,location from zb_shop where name like "%'.$q.'%" or english_name like "%'.$q.'%" limit 10;';	
        $re = $this->connect_shop($sql);
        echo json_encode($re);
		exit;
	}

	//根据关键搜索相关地点(使用google的place接口)
	public function place_search() {
		$q = $this->input->get('q', true, '');
		$url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query={$q}&sensor=true&key=AIzaSyCP0RiOPh_BaBKkmg7rrzFjCmr6aDWJmdI";
		$re = $this->curl_get($url);
		$re = json_decode($re,true);
		$ret = array();
		if(isset($re['status']) && $re['status'] == "OK") {
		foreach($re['results'] as $one) {
		  $loca = array();
		  $loca['name'] = $one['formatted_address'];
		  $loca['pos'] = $one['geometry']['location'];
		  $viewport_str='';
		  if(isset($one['geometry']['viewport']))
		  {
		    $viewport_str = "northeast_lat:{$one['geometry']['viewport']['northeast']['lat']};";         
		    $viewport_str .= "northeast_lng:{$one['geometry']['viewport']['northeast']['lng']};";         
		    $viewport_str .= "southwest_lat:{$one['geometry']['viewport']['southwest']['lat']};";         
		    $viewport_str .= "southwest_lng:{$one['geometry']['viewport']['southwest']['lng']};";         
		  }
		  $loca['viewport'] = $viewport_str;
		  $loca['location'] = "{$one['geometry']['location']['lat']},{$one['geometry']['location']['lng']}";
		  $ret[] = $loca;
		}
		}
		$ret = array_slice($ret,0,10);
		echo json_encode($ret);
		exit;
	}

	//获得一个range (经纬度范围),返回一个range内的所有商家信息
	public function shopbyrange() {
		$bounds = $q = $this->input->get('range', true, '');
		if(empty($bounds)) {echo 'err';exit;} 
		$bounds = urldecode($bounds);
		#$bounds = "((47.17947473709184, 16.529998779296875), (60.166813385162186, 62.101287841796875)) ";
		$bounds = str_replace(array("(",")"),'',$bounds);
		$bounds_arr = explode(',',$bounds);
		$height_max = isset($bounds_arr[2])?$bounds_arr[2]:90;   
		$height_min = isset($bounds_arr[0])?$bounds_arr[0]:90;   
		$width1 = $bounds_arr[1];
		$width2 = $bounds_arr[3];
		$all =  $this->getalllocation();      
		$result = array();
		$max = 20;
		foreach($all as $place) {
		$location = trim($place['location']);
		if(empty($location)) continue;
		$latlng = explode(",",$location);
		$lat = $latlng[0];
		$lng = $latlng[1];
	
		if($lat > $height_min && $lat < $height_max ) {
			//经度,如果同号,则在范围内,如果异号,
			if(($width1*$width2)>0) {
				if($lng>$width1 && $lng < $width2) {
		        	$result[] = $place;
			    } 
			}else if(($width1*$width2)<0) {
				if($width1>0 ) {
					if($lng>-180 && $lng<$width2) {
						$result[] = $place;
					}else if($lng>$width1 && $lng<180) {
						$result[] = $place;
					}
				}else if ($width1<0) {
					if($lng>$width1 && $lng<0) {
						$result[] = $place;
					}else if($lng>0 && $width2) {
						$result[] = $place;
					}
				}
			}
		}  

		if(count($result)>$max) break;
		}
        echo json_encode($result);
        exit;
	}

	private function curl_get($url) {
		$ch = curl_init();
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// grab URL and pass it to the browser
		$re = curl_exec($ch);
		// close cURL resource, and free up system resources
		curl_close($ch);
		return $re;
	}

	//数据库连接,,暂时用的,不用可以删除
	private function connect_shop($sql) {
		// 连接，选择数据库
		$link = mysql_connect('localhost', 'root', 'Zanbai7486data') or die('Could not connect: ' . mysql_error() );
		mysql_select_db('zanbai') or die('Could not select database');
		mysql_query("set character set 'utf8'");
		$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
		$re = array();
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$re[] = $line;
		}
		// 释放结果集
		mysql_free_result($result);
		// 关闭连接
		mysql_close($link);
		return $re;
	}

	//返回所有的商家信息
	private function getalllocation() {
		//name,englistname,
		$sql = "select name,english_name,location,left(`desc`, 100) as `desc`,address from zb_shop limit 6000";
		$re = $this->connect_shop($sql);
        return $re;
	}
}