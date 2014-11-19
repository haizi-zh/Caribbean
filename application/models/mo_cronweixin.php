<?php

class Mo_cronweixin extends CI_Model {

    const DEFAULT_SCAN_SHOP_CNT = 6000;
    const MAX_SEACH_SHOP_CNTY = 100;
    const PAGE_SIZE = 10;
    function __construct(){
        parent::__construct();
        $this->load->model('do/do_cronweixin');

    }
    public function simple_add($data){
        $exist_nick = $this->do_cronweixin->get_info_by_nick($data['nick']);
        if(!$exist_nick){
            return $this->do_cronweixin->add($data);
        }
    }
    public function add($data){
        $wkey = $data['wkey'];
        if(!$wkey){
            return;
        }

        $exist = $this->do_cronweixin->get_info_by_wkey($wkey);
        if($exist){
            if( ($data['spider_time'] - $exist['spider_time'] > 9200) || (!$exist['sogou_url']) ){
                $id = $exist['id'];
                $re = $this->do_cronweixin->update($data, $id);
            }
            return;
        }
        $exist_nick = $this->do_cronweixin->get_info_by_nick($data['nick']);
        if($exist_nick){
            if( ($data['spider_time'] - $exist_nick['spider_time'] > 9200) || (!$exist_nick['sogou_url']) ){
                $id = $exist_nick['id'];
                $re = $this->do_cronweixin->update($data, $id);
            }
            return;
        }

        return $this->do_cronweixin->add($data);
    }
    public function modify($data, $id){
        $re = $this->do_cronweixin->update($data, $id);
        return $re;
    }

    public function get_user($spider_time = 0){
        $re = $this->do_cronweixin->get_user($spider_time);
        return $re;
    }
    public function get_user_infos($uids){
        $re = $this->do_cronweixin->get_user_infos($uids);
        return $re;
    }

    public function get_weixin_user($spider_time=0){
        $re = $this->do_cronweixin->get_weixin_user($spider_time);
        return $re;
    }

    public function add_weixin($data){
        $uid = $data['uid'];
        $title = $data['title'];
        if(!$uid || !$title){
            return;
        }
        $title_md5 = md5($title);
        $exist = $this->do_cronweixin->get_weixin_by_titlemd5_uid($uid, $title_md5);
        if($exist){
            $id = $exist['id'];
            $re = $this->do_cronweixin->update_weixin($data, $id);
            return;
        }
        $data['title_md5'] = $title_md5;
        return $this->do_cronweixin->add_weixin($data);
    }

    public function get_weixin_list($page=1, $pagesize=10){
        $re = $this->do_cronweixin->get_weixin_list($page, $pagesize);
        return $re;
    }
    public function get_weixin_count(){
        $re = $this->do_cronweixin->get_weixin_count();
        return $re;
    }

    public function add_proxy($data){
        $data['ctime'] = time();
        $exist = $this->do_cronweixin->get_proxy_ip_port($data['ip'], $data['port']);
        if(!$exist){
            return $this->do_cronweixin->add_proxy($data);
        }
    }
    public function delete_proxy($id, $diff){
        if($id){
            if(!$diff){
                $diff = 20;
            }
            if($diff > 14){
                $check_time = time() + 6000;
                $this->modify_proxy(array('diff'=>$diff, 'check_time'=>$check_time ), $id);
            }
        }
    }
    public function modify_proxy($data, $id){
        $re = $this->do_cronweixin->modify_proxy($data, $id);
        return $re;
    }
    public function get_all_proxy($where = array()){
        $list = $this->do_cronweixin->get_all_proxy($where);
        return $list;
    }
    public function get_rand_proxy(){
        //$list = $this->do_cronweixin->get_all_proxy(array('diff <'=>15, 'check_time >'=>0));
        $list = $this->do_cronweixin->get_all_proxy(array('diff <'=>15, 'check_time >'=>0));
        if($list){
            shuffle($list);
            $re = $list[0];
            $proxy_id = $re['id'];
            $proxy = "{$re['ip']}:{$re['port']}";
            return array("proxy_id"=>$proxy_id, "proxy"=>$proxy);
        }
        return array("proxy_id"=>0, "proxy"=>'');
    }

}