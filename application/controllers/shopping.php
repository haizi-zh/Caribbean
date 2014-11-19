<?php
class Shopping extends Zb_controller {
    public function __construct(){
        parent::__construct() ;
    }
    // http://localhost/shopping/map/$city
    // http://zan.com/shopping/map/newyork
    public function map($city_name ,$page = 1){
        $this->load->model(array('mo_city' ,'mo_geography' )) ;
        $data       = array() ;
        $data['city_info']  = $this->mo_city->get_city_by_lowername($city_name) ;
        list($data['lat'] , $data['lng']) = explode(',', $data['city_info']->reserve_2) ;
        $data['area_cities'] = $this->mo_geography->get_all_cities();
        $data['country_code'] = array('1'=>'amc','2'=>'eup','3'=>'asia');
        $this->load->view('shopping/map' ,$data) ;
    }



    // http://zan.com/shopping/migrate/1/3000
    // http://zanbai.com/shopping/migrate/1/3000
    public function migrate($page , $size){
        empty($page) && $page = 1 ;
        empty($size) && $size = 300 ;
        $this->load->model('mo_shop') ;
        $city_list = $this->mo_shop->get_shops($page , $size) ;
        $page_recs = array() ;
        foreach ($city_list as $shop_info) {
            # code...
            if(!empty($shop_info['location'])){
                $assoc = array() ;
                $assoc['id'] = $shop_info['id'] ;
                list($assoc['lat'] , $assoc['lng']) = explode(',', $shop_info['location']) ;
                $page_recs[] = $assoc ;
            }
        }

        if(!empty($page_recs)){
            $this->mo_shop->batch_update($page_recs , 'id') ;
        }
    }

    public function shops(){
      

        $city_id    = $this->input->get('city_id' , true) ;
        $minlat = $this->input->get('minlat' , true) ;
        $maxlat = $this->input->get('maxlat' , true) ;
        $minlng = $this->input->get('minlng' , true) ;
        $maxlng = $this->input->get('maxlng' , true) ;

        if(empty($minlat) || empty($maxlat) || empty($minlng) || empty($maxlng) || empty($city_id)){

            return json_encode(array('cnt' => 0 ,'html' => '' , 'marker' => array() )) ;//param error
        }

        $page   = $this->input->get('page' ,true) ;
        empty($page) && $page = 1;

        $size   = $this->input->get('size' ,true) ;
        empty($size) && $size = 20 ;
        $this->load->model('mo_shop') ;
        $shop_list = $this->mo_shop->get_bounds_shops($city_id , $minlat , $maxlat , $minlng , $maxlng , $page , $size) ;
        $list_data = array() ;
        $list_data['shops'] = $shop_list['rows'] ;
        $list_data['pages'] = ceil($shop_list['count']/$size) ;
        $list_data['cpage'] = $page ;
        $html   = $this->load->view('shopping/shop_list' , $list_data , true) ;

        $ret    = array('cnt' => $shop_list['count'] , 'html' => $html ,'marker' => $shop_list['rows'] ) ;
        echo json_encode($ret) ;
    }
}