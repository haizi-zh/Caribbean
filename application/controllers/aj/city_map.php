<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class city_map extends ZB_Controller {
        
    #后台登录   
    public function get_shops(){
        $bounds = $this->input->get('bounds', true, '');
        $page = $this->input->get('page', true, 1);
        if(empty($bounds)) {echo 'err';exit;} 
        $bounds = urldecode($bounds);

        $this->load->model('mo_map');
        $this->load->model('mo_shop');
        $this->load->model('mo_brand');
        $shops = $this->mo_map->get_shop_range($bounds, $page);
        #为shop增加品牌 to do
        echo json_encode($shops);
    }

    function get_shop_brands($shops){
        // $shop_ids = array();
        // foreach ($shops['shops'] as $key => $shop) {
        //     $shop_ids[] = $shop['id'];
        // }
        // $brand_shop = $this->mo_shop->get_brands_by_shops($shop_ids);
        // $re = array();
        // $brands = array();
        // foreach($brand_shop as $shop_id => $brand){
        //     if($brand){
        //         $rand_brand = array_rand($brand, 10);
        //         $re[$shop_id] = $rand_brand;
        //         if (!empty($rand_brand)) {
        //             $brands = array_merge($brands, $rand_brand);
        //         }
        //     }
        // }
        // $brand_info = $this->mo_brand->get_brands_by_ids($brands);

        // foreach ($shops['shops'] as $key => $shop) {
        //     $shop_id = $shop['id'] ;
        //     $brand_list = "";
        //     $i = 0;
        //     if (!isset($re[$shop_id])){
        //         continue;
        //     }
        //     foreach($re[$shop_id] as $k=>$brand){
        //         if(isset($brand_info[$brand])){
        //             $i++;
        //             if($i > 2){
        //                 break;
        //             }
        //             $brand_list .= $brand_info[$brand]['name'].",";
        //         }
        //     }
        //     $shops['shops'][$key]['brand_list'] = $brand_list;
        // }
    }
}