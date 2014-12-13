<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map1 extends CI_Controller {

    const PAGE_ID = 'map1';

    public function index()
    {
        $jsplugin_list = array();#需要用到的js插件
        $data['pageid'] = self::PAGE_ID;
        $data['jsplugin_list'] = $jsplugin_list;
        $this->load->view('map1', $data,false,true,false);
    }
}
