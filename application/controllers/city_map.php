<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_Map extends ZB_Controller {

    const PAGE_ID = 'city_map';
    public function __construct(){
        parent::__construct();
        $this->load->model('mo_shop');
        $this->load->model('mo_brand');
        $this->load->model('mo_discount');
        $this->load->model('mo_common');
        $this->load->model('mo_geography');
        $this->load->model('mo_coupon');
    }

    // $city_name ,$page = 1
    public function index(){

        $data = array() ;
        $segment_array = $this->uri->segment_array();
        
        if($segment_array[1]=='city_map'){
            $city_id = $this->input->get("city", true, 0);
            $city_info = $this->mo_geography->get_city_info_by_id($city_id);
            if($city_info){
                $lower_name = $city_info['lower_name'];
            }
            $re_url = base_url("/{$lower_name}-shoppingmap/");
            redirect($re_url, 'location', 301);
        }


        $city = $this->input->get('city',true,1); #城市
        $city = intval($city);

        if(!$city){
            $this->tool->sorry();
        }

        $city_info = $this->mo_geography->get_city_info_by_id($city);
        
        $data['city_info'] = $city_info;

        list($data['lat'] , $data['lng']) = explode(',', $data['city_info']['reserve_2'] ) ;
        $data['area_cities'] = $this->mo_geography->get_all_cities();
        $data['country_code'] = array('1'=>'amc','2'=>'eup','3'=>'asia');

        $city_name = $city_info['name'];
        $lat_lng_str = $city_info['reserve_2'];
        $lat_lng = explode(',',$lat_lng_str);
        $lat = trim($lat_lng[0]);
        $lng = trim($lat_lng[1]);
        $data['city'] = $city;
        $data['city_id'] = $city;
        $data['pageid'] = self::PAGE_ID;
        $data['jsplugin_list'] = array();
        $data['city_name'] = $city_info['name'];
        $data['city_lower_name'] = $city_info['lower_name'];
        $data['city_info'] = $city_info;
        $data['lat'] = $lat;
        $data['lng'] = $lng;
        $data['area_cities'] = $this->mo_geography->get_all_cities();
        $data['country_code'] = array('1'=>'amc','2'=>'eup','3'=>'asia');

//<title>【纽约购物地图】详实纽约购物地图—赞佰网</title>
//<meta name="keywords" content="纽约购物地图" />
//<meta name="description" content="赞佰网为您提供最详实的纽约购物地图，纽约购物地图囊括所有纽约购物中心，纽约奥特莱斯，纽约购物街区，纽约商场百货地图信息" />

        $data['page_title_single'] = "【{$city_name}购物地图】详实{$city_name}购物地图—赞佰网";
        $data['seo_keywords'] = "{$city_name}购物地图";
        $data['seo_description'] = "赞佰网为您提供最详实的{$city_name}购物地图，{$city_name}购物地图囊括所有{$city_name}购物中心，{$city_name}奥特莱斯，{$city_name}购物街区，{$city_name}商场百货地图信息";

        $data['tj_id'] = "city_map";
        $js_version = context::get('js_version', '');
        $js_domain = context::get('js_domain', '');
        $css_domain = context::get('css_domain', '');
        $use_fe = context::get('use_fe', '');

        $data['js_version'] = $js_version;
        $data['js_domain'] = $js_domain;
        $data['css_domain'] = $css_domain;
        $data['use_fe'] = $use_fe;

        $this->load->view('shopping/map' ,$data) ;
    }



    public function index2(){
        $segment_array = $this->uri->segment_array();
        if($segment_array[1]=='city_map'){
            $city_id = $this->input->get("city", true, 0);
            $city_info = $this->mo_geography->get_city_info_by_id($city_id);
            if($city_info){
                $lower_name = $city_info['lower_name'];
            }
            $re_url = base_url("/{$lower_name}-shoppingmap/");
            redirect($re_url, 'location', 301);
        }


        $city = $this->input->get('city',true,1); #城市
        $city = intval($city);

        if(!$city){
            $this->tool->sorry();
        }

        $city_info = $this->mo_geography->get_city_info_by_id($city);
        $city_name = $city_info['name'];
        $lat_lng_str = $city_info['reserve_2'];
        $lat_lng = explode(',',$lat_lng_str);
        $lat = trim($lat_lng[0]);
        $lng = trim($lat_lng[1]);
        $data['city'] = $city;
        $data['city_id'] = $city;
        $data['pageid'] = self::PAGE_ID;
        $data['jsplugin_list'] = array();
        $data['city_name'] = $city_info['name'];
        $data['city_lower_name'] = $city_info['lower_name'];
        $data['city_info'] = $city_info;
        $data['lat'] = $lat;
        $data['lng'] = $lng;
        $data['area_cities'] = $this->mo_geography->get_all_cities();
        $data['country_code'] = array('1'=>'amc','2'=>'eup','3'=>'asia');

//<title>【纽约购物地图】详实纽约购物地图—赞佰网</title>
//<meta name="keywords" content="纽约购物地图" />
//<meta name="description" content="赞佰网为您提供最详实的纽约购物地图，纽约购物地图囊括所有纽约购物中心，纽约奥特莱斯，纽约购物街区，纽约商场百货地图信息" />

        $data['page_title_single'] = "【{$city_name}购物地图】详实{$city_name}购物地图—赞佰网";
        $data['seo_keywords'] = "{$city_name}购物地图";
        $data['seo_description'] = "赞佰网为您提供最详实的{$city_name}购物地图，{$city_name}购物地图囊括所有{$city_name}购物中心，{$city_name}奥特莱斯，{$city_name}购物街区，{$city_name}商场百货地图信息";

        $data['tj_id'] = "city_map";
        $this->load->view('city_map', $data, false, true, false);
    }
}
