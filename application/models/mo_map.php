<?php
#地图信息
class Mo_map extends CI_Model {

    const DEFAULT_SCAN_SHOP_CNT = 6000;
    const MAX_SEACH_SHOP_CNTY = 100;
    const PAGE_SIZE = 10;
    function __construct(){
        parent::__construct();
    }


    public function get_shop_range($bounds, $page){
        # bounds is two point (west, south) (east, north)
        # eg: ((47.17947473709184, 16.529998779296875), (60.166813385162186, 62.101287841796875))
        $this->load->model('mo_shop');
        $bounds = str_replace(array("(",")"),'',$bounds);
        $bounds_arr = explode(',',$bounds);
        $lat_south = isset($bounds_arr[0])?$bounds_arr[0]:-90;
        $lat_north = isset($bounds_arr[2])?$bounds_arr[2]:90; 
        $lng_west = $bounds_arr[1]?$bounds_arr[1]:-180;
        $lng_east = $bounds_arr[3]?$bounds_arr[3]:180;

        $shops = $this->mo_shop->get_shop_info_by_limit(self::DEFAULT_SCAN_SHOP_CNT);
        
        $result = array();
        foreach($shops as $shop) {
            $location = trim($shop['location']);
            if(empty($location)) continue;
                $latlng = explode(",",$location);
                $lat = $latlng[0];
                $lng = $latlng[1];
        
            if($lat > $lat_south && $lat < $lat_north ){
                if($lng > $lng_west && $lng < $lng_east) {
                    $result[] = $shop;
                } 
            }   
            if(count($result) >= self::MAX_SEACH_SHOP_CNTY) break;
        }

        return array('shops'=>$result, 'cnt'=>count($result));
    }
}