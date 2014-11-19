<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// */2 * * * * /usr/bin/php /var/www/zan/index.php cron_weixin format_user_from_sogou >/dev/null 2>&1 &
// */2 * * * * /usr/bin/php /var/www/zan/index.php cron_weixin format_weixin_from_sogou >/dev/null 2>&1 &

class cron_weixin extends ZB_Controller {

    const PAGE_ID = 'cron_weixin';
    public function __construct(){
        parent::__construct();
        set_time_limit(3000);
        ini_set('memory_limit', '1G');

        $this->load->model('mo_shop');
        $this->load->model('mo_brand');
        $this->load->model('mo_discount');
        $this->load->model('mo_common');
        $this->load->model('mo_geography');
        $this->load->model('mo_coupon');
        $this->load->model('mo_cronweixin');
        require_once (APPPATH."/third_party/simple_html_dom-master/"."simple_html_dom.php");
    }
    //http://www.82ip.com/thread-11822-1-2.html
    // zan.com/cron_weixin/ip82
    public function ip82(){
        require_once( APPPATH.'/libraries/class.textExtract.php' );
        
        $page_urls = array();
        for($i=1;$i<19;$i++){
            $page_urls[] = "http://www.82ip.com/forum-74-{$i}.html";
        }
        $content_urls = array();
        $i = 0;
        foreach($page_urls as $url){
            $i++;
            $this->write_file("82url {$i}/ {$count}");
           $content = file_get_contents($url);
           $preg='/<a .*?href="(.*?)".*?>/is';
           preg_match_all($preg,$content,$matches);
           if($matches[1]){
            foreach($matches[1] as $v){
                if(strstr($v, "thread-") !== false){
                    $v_md5 = md5($v);
                    $content_urls[$v_md5] = $v;
                }
            }
           }
        }

        $count = count($content_urls);

        $path = FCPATH."ck.txt";
        $i = 0;
        foreach($content_urls as $v){
            $i++;

            $this->write_file("82ip {$i}/ {$count}");


            $url = "http://www.82ip.com/".$v;
            $iTextExtractor = new textExtract( $url );
            $text = $iTextExtractor->getPlainText();
            if( $iTextExtractor->isGB ) $text = iconv( 'GBK', 'UTF-8//IGNORE', $text );
            if($text){
                $text = str_replace("<br />", "\r\n", $text);
                file_put_contents($path, $text."\r\n", FILE_APPEND);
            }
        }
        echo 'ok';
        die;
        



    }

    public function proxy(){
        //http://www.56ads.com/plus/search.php?keyword=%B4%FA%C0%ED++&searchtype=title&channeltype=0&orderby=&kwtype=0&pagesize=1220&typeid=0&TotalResult=1945&PageNo=1
        $url = "http://www.56ads.com/plus/search.php?keyword=%B4%FA%C0%ED++&searchtype=title&channeltype=0&orderby=&kwtype=0&pagesize=3220&typeid=0&TotalResult=1945&PageNo=1";
        $content = 123;

    }
    // zan.com/cron_weixin/create_proxy
    public function create_proxy(){
        $path = FCPATH."ck.txt";
        $file = fopen($path,"r");
        while ( !feof ( $file) ){
            $i++;
            $buffer = fgets($file);
            $buffer = trim($buffer);
            if(!$buffer){
                continue;
            }
            $list = array(';', '@', '#', '|');
            $start = 0;
            foreach($list as $v){
                $s = strpos($buffer, $v);
                if($s !== false){
                    if($s < $start){
                        $start = $s;
                    }elseif(!$start){
                        $start = $s;
                    }
                }
            }
            if($start){
                $str = substr($buffer, 0, $start);
                $str = trim($str);
                $tmp = explode(":", $str);
                $ip = $tmp[0];
                $port = $tmp[1];
            }else{
                $str = $buffer;
                $tmp = explode(":", $str);
                $ip = $tmp[0];
                $port = $tmp[1];
            }

            if($ip && $port){
                $add_data = array();
                $add_data['ip'] = $ip;
                $add_data['port'] = $port;
                $add_data['source'] = $buffer;
                $this->mo_cronweixin->add_proxy($add_data);
            }
            
        }
        fclose($file);
    }
    // update  `my_proxy` set good=1 where status=0 and ischecked=1
    // zan.com/cron_weixin/check_proxy
    public function check_proxy(){
        $now = time();
        $list = $this->mo_cronweixin->get_all_proxy(array('check_time <'=> $now, 'diff'=>0));
        $ids = array();
        foreach($list as $re){
            $stime = time();
            if($stime - $now > 1200){
                var_dump($ids);
                echo "20fenzhong";
                die;
            }
            $proxy_id = $re['id'];
            $ids[$proxy_id] = $proxy_id;
            $proxy = "{$re['ip']}:{$re['port']}";
            $url = "http://weixin.sogou.com/weixin?type=1&ie=utf8&query=%E5%91%A8%E6%9E%97%E4%B9%A6&page=1";
            $re = tool::curl_get($url, 10, $proxy);
            $etime = time();
            $diff = $etime - $stime;
            $add_data = array();
            if($re == false){
                $add_data['check_time'] = $now + 186400;
            }else{
                if(strlen($re)<10000){
                    $diff = 20;
                }
                $add_data['check_time'] = $now + 86400;
            }
            $add_data['diff'] = $diff;
            
            $this->mo_cronweixin->modify_proxy($add_data, $proxy_id);
        }
    }
    // zan.com/cron_weixin/cc
    public function cc(){
        $proxy = "221.180.130.42:80";
        //$proxy = "60.191.178.130:8080";
        $url = "http://weixin.sogou.com/weixin?type=2&query=%E5%91%A8&ie=utf8&_ast=1412222336&_asf=null&w=01019900&p=01030402&dp=1&cid=null&sut=1237&sst0=1412222342764&lkt=0%2C0%2C0";
        $re = tool::curl_get($url, 20, $proxy);
    
        var_dump($re);
    }



    // zan.com/cron_weixin/ciku
    public function ciku(){exit();
        $path = FCPATH."ck.txt";
        $file = fopen($path,"r");
        $i=0;
        $re = array();
        while ( !feof ( $file) ){
            $i++;
            $buffer = fgets($file);
            $buffer = trim($buffer);
            $tmp = explode(",", $buffer);
            $content = $tmp[1];
            $re[$content] = 1;            
        }
        fclose($file);
        foreach($re as $nick=>$v){
            $data = array();
            $data['nick'] = $nick;
            $this->mo_cronweixin->simple_add($data);

        }
    }
    public function get_user_from_chuansongme(){

    }
    public function create_user(){
        
    }
    // zan.com/cron_weixin/create_anyv
    //curl_get
    //async_get_url
    //27 70 80
    // http://www.anyv.net/index.php/category-80
    // http://www.anyv.net/index.php/category-80-page-2
    public function create_anyv($cat_id = 27){
        require_once (APPPATH."/third_party/simple_html_dom-master/"."simple_html_dom.php");
        //获取page
        $cat_url_tem = "http://www.anyv.net/index.php/category-%s";
        $cat_page_url_tem = "http://www.anyv.net/index.php/category-%s-page-%s";
        $cat_url = sprintf($cat_url_tem, $cat_id);
        
        $url_md5 = md5($cat_url);
        $save_path = "/tmp/".$url_md5;
        if(!file_exists($save_path)){
            $content = tool::curl_get($cat_url);
            file_put_contents($save_path, $content);
        }else{
        }
        $format_time = 0;
        $content = file_get_contents($save_path);
        //您的访问出错了
        if(strlen($content)<10000){
            unlink($save_path);
            $this->write_file("抓取他人账号，路由出错");
            echo "路由出错";
            return 0;
        }
        $html = new simple_html_dom();
        $html->load_file($save_path);
        $last_page = 1;
        foreach($html->find('.pages div a') as $k => $element){
            $element = strip_tags($element);
            $element = str_replace("...", "", $element);
            $element = intval($element);
            if($element > $last_page){
                $last_page = $element;
            }
        }
        for($i=1; $i<=$last_page; $i++){
            $page_url = sprintf($cat_page_url_tem, $cat_id, $i);

            $url_md5 = md5($page_url);
            $save_path = "/tmp/".$url_md5;
            if(!file_exists($save_path)){
                $content = tool::curl_get($cat_url);
                $content = iconv("gbk", "utf-8", $content);
                file_put_contents($save_path, $content);
            }else{
            }
            $format_time = 0;
            $content = file_get_contents($save_path);
            //您的访问出错了
            if(strlen($content)<10000){
                unlink($save_path);
                $this->write_file("抓取他人账号，路由出错");
                echo "路由出错";
                return 0;
            }
            $html = new simple_html_dom();
            $html->load_file($save_path);
            $last_page = 1;
            foreach($html->find('.pic_article_home2 li a') as $k => $element){
                //$span = $element->find("span");
                $href = $element->href;
                $title = $element->title;
                var_dump( $href, $title );

            }
            die;
        }

    }

    public function write_file($content=''){
        file_put_contents("/tmp/log", $content."\r\n", FILE_APPEND);

    }
     // zan.com/cron_weixin/create_anyv_new
    // http://www.anyv.net/index.php/viewnews-28366
    public function create_anyv_new(){
        $cat_urls = array();
        for($i=1; $i<=28366; $i++){
            $cat_url = "http://www.anyv.net/index.php/viewnews-".$i;
            $url_md5 = md5($cat_url);
            $save_path = "/home/weixin/".$url_md5;
            if(file_exists($save_path)){
                continue;
            }
            $cat_urls[] = $cat_url;
            if(count($cat_urls) > 50){
                $data = tool::async_get_url($cat_urls, 50);
                foreach($data as $k => $content){
                    $cat_url = $cat_urls[$k];
                    $url_md5 = md5($cat_url);
                    $save_path = "/home/weixin/".$url_md5;
                    if(!file_exists($save_path)){
                        $content = iconv("gbk", "utf-8", $content);
                        file_put_contents($save_path, $content);
                    }else{
                    }
                }
                $cat_urls = array();
            }
        }
        echo 'ok';
        for($i=1; $i<=28366; $i++){
            var_dump($i);

            $cat_url = "http://www.anyv.net/index.php/viewnews-".$i;
            $url_md5 = md5($cat_url);
            $save_path = "/home/weixin/".$url_md5;
            if(!file_exists($save_path)){
                $content = tool::curl_get($cat_url);
                $content = iconv("gbk", "utf-8", $content);
                file_put_contents($save_path, $content);
            }else{
            }
            $format_time = 0;
            $content = file_get_contents($save_path);
            //您的访问出错了

            if(strlen($content)<10000){
                var_dump($save_path);
                //unlink($save_path);
                $this->write_file("抓取anyv账号，路由出错");
                echo "路由出错";
                //return 0;
            }
            $html = new simple_html_dom();
            $html->load_file($save_path);
            $last_page = 1;
            $cat_name = "";
            foreach($html->find('.global_module3_caption a') as $k => $element){
                //$span = $element->find("span");
                $cat_name = strip_tags($element);
                if(strpos($cat_name, "微信公众账号")){
                    $cat_name = str_replace("微信公众账号", "", $cat_name);
                    break;
                }
            }
            
            foreach($html->find('div [id=article_extinfo] h1') as $k => $element){
                $nick = strip_tags($element);
                $nick = trim($nick);
            }
           
            foreach($html->find('div [id=article_extinfo] h5') as $k => $element){
               
                $wkey = $element->innertext;
                $p = strpos($wkey , "<p>");
                if($p){
                    $wkey = substr($wkey, 0 , $p);
                }

                $wkey = strip_tags($wkey);
                $wkey = str_replace("{$nick}微信号:", "", $wkey);
                $wkey = trim($wkey);

            }

            $add_data = array();
            $add_data['nick'] = $nick;
            $add_data['wkey'] = $wkey;
            $add_data['type_name'] = $cat_name;
            
            $id = $this->mo_cronweixin->add($add_data);
            
        }
    }
    public function check_sogou_user_exist(){

    }
    // zan.com/cron_weixin/format_user_from_sogou
    // 构建weixin用户数据
    public function format_user_from_sogou(){
        $stime = $now = time();
        $yes_time = $now - 86400;
        $ten_day_time = $now - 864000;
        $list = $this->mo_cronweixin->get_user($yes_time, 1, 100);
        var_dump(count($list));
        if($list){
            $i=0;
            foreach($list as $v){
                $i++;
                $nick = $v['nick'];
                //$nick = "组织策划";
                $this->write_file("sogou用户nick:{$nick}");

                $proxy_re = $this->mo_cronweixin->get_rand_proxy();
                $proxy_id = $proxy_re['proxy_id'];
                $proxy = $proxy_re['proxy'];
                $mt_rand = mt_rand(1,6);
                $this->write_file($mt_rand);
                if($mt_rand == 3){
                    $proxy = "";
                    $proxy_id = 0;
                }else{
                    $this->write_file($proxy);
                }
        

                $total_page = $this->search_sogou_user_all($nick, 1, true, $proxy, $proxy_id);
                if($total_page > 20){
                    $total_page = 20;
                }
                $re = $this->search_sogou_user_all($nick, $total_page, false, $proxy, $proxy_id);
                if($total_page > 1){
                    
                }
                //usleep(500000);
                //sleep(1);

                $add_data = array('status'=>1);
                if($v['wkey']){
                    $add_data['spider_time'] = $now;
                }else{
                    $add_data['spider_time'] = $ten_day_time;
                }
                
                $this->mo_cronweixin->modify($add_data, $v['id']);
                
                if($i>101){
                    echo "succ";
                    exit();
                }
                $etime = time();
                if($etime - $stime > 60){
                    echo "time";
                    die;
                }
            }
        }
    }

    // zan.com/cron_weixin/search_sogou_user_all
    public function search_sogou_user_all($nick = '最佳', $all_page=4, $get_page = false, $proxy = '', $proxy_id=0){
        $stime = time();
        $url_template = "http://weixin.sogou.com/weixin?type=1&ie=utf8&query=%s&page=%s";
        $save_paths = $urls = array();
        for($page=1;$page<=$all_page;$page++){
            $nick_urlencode = urlencode($nick);
            $url = sprintf($url_template, $nick_urlencode, $page);
            
            //$this->write_file($url);

            $url_md5 = md5($url);
            $today = date("Ym", time());
            $save_path = "/home/sogou/".$today.$url_md5;
            $save_paths[$url_md5] = $save_path;
            if(!file_exists($save_path)){
                $urls[$url_md5] = $url;
            }else{
            }
        }

        if($urls){
            $re = tool::async_get_url($urls, 10, $proxy);
            if($re){
                foreach($re as $url_md5=>$content){
                    $save_path = "/home/sogou/".$today.$url_md5;
                    file_put_contents($save_paths[$url_md5], $content);
                }
            }
        }
        $etime = time();
        $diff = $etime - $stime;
        if($proxy_id){
            if(!$diff){
                $diff = 1;
            }
            $this->mo_cronweixin->delete_proxy($proxy_id, $diff);
        }

        if($save_paths){
            foreach($save_paths as $save_path){
                $content = file_get_contents($save_path);
                if(strlen($content)<10000){
                    $this->mo_cronweixin->delete_proxy($proxy_id);
                }
                if($get_page){
                    return $this->format_user_content($content, $save_path, $get_page);
                }else{
                    $this->format_user_content($content, $save_path);
                }
            }
        }
    }

    //处理user文本
    public function format_user_content($content, $save_path, $get_page = false){
        if(strlen($content)<10000){
            unlink($save_path);
            //var_dump($url, $content);
            $this->write_file("抓取sogou账号，路由出错");
            echo "路由出错";
            //die;
            return 0;
        }
        if(strstr($content, "暂无与")){
            unset($content);
            $content = null;
            echo "暂无与";
            return;
        }
        $html = new simple_html_dom();
        $html->load_file($save_path);
        if($get_page){
            $number = $html->find('div #scd_num', 0);
            $number = trim(strip_tags($number));
            $number = intval($number);
            $total_page = ceil($number/10);
            if(!$total_page){
                $total_page = 1;
            }
            return $total_page;
        }

        $now = time();
        foreach($html->find('div .results div') as $k => $element){
            $logo = $element->find('.img-box img', 0)->src;
            $card = $element->find('.pos-ico .pos-box img', 1)->src;

            $sogou_url = $element->href;
            $new_nick = $element->find('.txt-box h3', 0);
            $wkey = $element->find('.txt-box h4', 0);
            $sp_tit_gongneng = $element->find('.txt-box .s-p3 .sp-tit', 0);
            $sp_tit_rengzheng = $element->find('.txt-box .s-p3 .sp-tit', 1);
            $sp_tit_gongneng = trim(strip_tags($sp_tit_gongneng));
            $sp_tit_rengzheng = trim(strip_tags($sp_tit_rengzheng));

            $sp_txt_gongneng = $element->find('.txt-box .s-p3 .sp-txt', 0);
            $sp_txt_rengzheng = $element->find('.txt-box .s-p3 .sp-txt', 1);
            $sp_txt_gongneng = trim(strip_tags($sp_txt_gongneng));
            $sp_txt_rengzheng = trim(strip_tags($sp_txt_rengzheng));  

            $new_nick = trim(strip_tags($new_nick));
            $wkey = trim(strip_tags($wkey));
            $wkey = str_replace("微信号：", "", $wkey);

            $add_data = array();
            $add_data['nick'] = $new_nick;
            $add_data['wkey'] = $wkey;
            $add_data['sogou_url'] = $sogou_url;
            $add_data['status'] = 1;
            $add_data['spider_time'] = $now;

            $add_data['gongneng'] = $sp_txt_gongneng;
            $add_data['renzheng'] = $sp_txt_rengzheng;
            if($logo){
                $add_data['logo'] = $logo;
            }

            if($card){
                $add_data['card'] = $card;
            }
            $this->mo_cronweixin->add($add_data);
        }
    }

    // zan.com/cron_weixin/search_sogou_user_one
    // http://weixin.sogou.com/weixin?type=1&ie=utf8&query=%E8%9B%AE%E5%AD%90%E6%96%87%E6%91%98
    // http://weixin.sogou.com/weixin?query=%E5%A4%A7%E5%AE%B6&sut=923&lkt=0%2C0%2C0&type=1&sst0=1412136961523&cid=null&page=2&ie=utf8&w=01019900&dr=1
    public function search_sogou_user_one($nick = '香港代购', $page = 1, $get_page = false){
        $url_template = "http://weixin.sogou.com/weixin?type=1&ie=utf8&query=%s&page=%s";
        //$nick = "广播电视台";
        if(!$nick){
            echo "no nick";
            return;
        }
        $today = date("Ym", time());
        $nick_urlencode = urlencode($nick);
        $url = sprintf($url_template, $nick_urlencode, $page);
        
        $url_md5 = md5($url);
        $save_path = "/home/sogou/".$today.$url_md5;
        if(!file_exists($save_path)){
            $content = tool::curl_get($url);
            file_put_contents($save_path, $content);
        }else{
        }

        $format_time = 0;
        $content = file_get_contents($save_path);

        if(strlen($content)<10000){
            unlink($save_path);
            //var_dump($url, $content);
            $this->write_file("抓取sogou账号，路由出错");
            echo "路由出错";
            //die;
            return 0;
        }
        if(strstr($content, "暂无与")){
            unset($content);
            $content = null;
            echo "暂无与";
            return;
        }
        $html = new simple_html_dom();
        $html->load_file($save_path);
        var_dump($html);die;
        if($get_page){
            $number = $html->find('div #scd_num', 0);
            $number = trim(strip_tags($number));
            $number = intval($number);
            $total_page = ceil($number/10);var_dump($number);
            return $total_page;
        }

        $now = time();
        foreach($html->find('div .results div') as $k => $element){
            $logo = $element->find('.img-box img', 0)->src;
            $card = $element->find('.pos-ico .pos-box img', 1)->src;

            $sogou_url = $element->href;
            $new_nick = $element->find('.txt-box h3', 0);
            $wkey = $element->find('.txt-box h4', 0);
            $sp_tit_gongneng = $element->find('.txt-box .s-p3 .sp-tit', 0);
            $sp_tit_rengzheng = $element->find('.txt-box .s-p3 .sp-tit', 1);
            $sp_tit_gongneng = trim(strip_tags($sp_tit_gongneng));
            $sp_tit_rengzheng = trim(strip_tags($sp_tit_rengzheng));

            $sp_txt_gongneng = $element->find('.txt-box .s-p3 .sp-txt', 0);
            $sp_txt_rengzheng = $element->find('.txt-box .s-p3 .sp-txt', 1);
            $sp_txt_gongneng = trim(strip_tags($sp_txt_gongneng));
            $sp_txt_rengzheng = trim(strip_tags($sp_txt_rengzheng));  

            $new_nick = trim(strip_tags($new_nick));
            $wkey = trim(strip_tags($wkey));
            $wkey = str_replace("微信号：", "", $wkey);

            $add_data = array();
            $add_data['nick'] = $new_nick;
            $add_data['wkey'] = $wkey;
            $add_data['sogou_url'] = $sogou_url;
            $add_data['status'] = 1;
            $add_data['spider_time'] = $now;

            $add_data['gongneng'] = $sp_txt_gongneng;
            $add_data['renzheng'] = $sp_txt_rengzheng;
            if($logo){
                $add_data['logo'] = $logo;
            }

            if($card){
                $add_data['card'] = $card;
            }
            
            $this->mo_cronweixin->add($add_data);
        }
    }

    //根据人抓去内容
    // zan.com/cron_weixin/format_weixin_from_sogou
    public function format_weixin_from_sogou(){
        $now = time()-186400;
        $stime = time();
        $list = $this->mo_cronweixin->get_weixin_user($now);

        if($list){
            $j = 1;
            var_dump(count($list));
            foreach($list as $v){
                $j++;
                
                if(!$v['sogou_url']){
                    var_dump(123123);
                    continue;
                }else{
                    var_dump(123);
                }

                $uid = $v['id'];
                $sogou_url = $v['sogou_url'];
                // /gzh?openid=
                $sogou_url = str_replace("/gzh?openid=", "", $sogou_url);
                
                $re_page = $this->search_sogou_list($uid, $sogou_url, 1, true);
                $total_pages = $re_page['total_pages'];
                $total_items = $re_page['total_items'];
                if($total_items && $total_pages){
                    if($total_pages > 1){
                        for($i=1; $i<=$total_pages; $i++){
                            $re = $this->search_sogou_list($uid, $sogou_url, $i);
                            sleep(1);
                        }
                    }else{
                        $re = $this->search_sogou_list($uid, $sogou_url, 1);
                         sleep(1);
                    }
                }else{
                    //没有数据
                }

                $add_data = array();
                $add_data['total_pages'] = $total_pages;
                $add_data['total_items'] = $total_items;
                $add_data['spider_time'] = time();
                //var_dump($add_data);
                $modi = $this->mo_cronweixin->modify($add_data, $v['id']);
                //var_dump($modi);
                if($j > 30){
                    echo 32;
                    die;;
                }
                $etime = time();
                if($etime - $stime > 60){
                    echo "time";
                    die;
                }

                var_dump($uid, $total_pages, "</br>");
                //die;
            }
            echo "ok";
        }
    }

    //抓去单个人
    // zan.com/cron_weixin/search_sogou_list

    // oIWsFt9jPnmgqmuOp7XWuGKCRVOo
    //http://weixin.sogou.com/gzhjs?cb=sogou.weixin.gzhcb&openid=oIWsFt9ZcSceQOGINBOCMJ8h0E4o&page=1
    public function search_sogou_list($uid = 1 , $sogou_url = '', $page = 1, $get_page = false){
        $url_template = "http://weixin.sogou.com/gzhjs?cb=sogou.weixin.gzhcb&openid=%s&page=%s";
        //$sogou_url = "oIWsFtza0y7TQKkIZ8SUj_3T69ME";
        //$sogou_url = "/gzh?openid=oIWsFt1_HTTsecjfGnB13pjn00bI";
        //$sogou_url = "/gzhjs?cb=sogou.weixin.gzhcb&openid=oIWsFt9ZcSceQOGINBOCMJ8h0E4o";
        
        if(!$sogou_url){
            return ;
        }
        $today = date("Ymd", time());

        $url = sprintf($url_template, $sogou_url, $page);
        //var_dump($url);
        $url_md5 = md5($url);
        $save_path = "/home/sogoulist/".$today.$url_md5;
        if(!file_exists($save_path)){
            $content = tool::curl_get($url);
            file_put_contents($save_path, $content);
        }else{
        }
        $format_time = 0;
        $content = file_get_contents($save_path);

        if(strstr($content, "302 Found")){
            unset($content);
            unlink($save_path);
            $content = null;
            $this->write_file("抓取sogou内容，路由出错");
            echo "被封闭";
            exit();
        }
        $content = trim($content);
        $content = str_replace("sogou.weixin.gzhcb(", "", $content);
        $end = strrpos($content, ")");
        $content = substr($content, 0, $end);
        $content = json_decode($content, true);
        $totalPages = $content['totalPages'];
        $totalItems = $content['totalItems'];
        if($get_page){
            return array('total_pages'=>$totalPages, 'total_items'=>$totalItems);
        }

        $items = $content['items'];//var_dump($items);
        if(!$items){
            return;
        }
        $now = time();
        foreach($items as $v){
            $search = "/<title>(.*?)<\/title>/si";
            preg_match($search, $v, $rr);
            $title = $rr[1];
            $title = substr($title, 9, -3);
            //echo $rr[1];//var_dump($title);
            $search = "/<url>(.*?)<\/url>/si";
            preg_match($search, $v, $rr);
            $wurl = $rr[1];
            $wurl = substr($wurl, 9, -3);
            //content168
            $search = "/<content168>(.*?)<\/content168>/si";
            preg_match($search, $v, $rr);
            $content168 = $rr[1];
            $content168 = substr($content168, 9, -3);
            //lastModified
            $search = "/<lastModified>(.*?)<\/lastModified>/si";
            preg_match($search, $v, $rr);
            $lastModified = $rr[1];
            //imglink
            $search = "/<imglink>(.*?)<\/imglink>/si";
            preg_match($search, $v, $rr);
            $imglink = $rr[1];
            $imglink = substr($imglink, 9, -3);

            $add_data = array();
            $add_data['uid'] = $uid;
            $add_data['title'] = $title;
            $add_data['imglink'] = $imglink;
            $add_data['wurl'] = $wurl;
            $add_data['content168'] = $content168;
            $add_data['wtime'] = $lastModified;
            $add_data['ctime'] = $now;
            $this->mo_cronweixin->add_weixin($add_data);
        }
    }

    

    function format_str($str){
        $len = strlen($str);//长度
        $new_str = "";

        for($i=0; $i <= $len-1 ;$i++) { $s_hex = ord($str[$i]); if( $s_hex <= 0x7f && $s_hex >=0x00 )
        {
        //ACSII
        $new_str .= $str[$i];
        }
        else if( $s_hex >= 0x81 && $s_hex <=0xfe )
        {
        //双字节
        if( $i == $len-1 ) break;
        $i++;
        $s_hex = ord($str[$i]);
        if( $s_hex >= 0x40 && $s_hex <= 0xfe && $s_hex != 0x7f)
        {
        $new_str .= $str[$i-1];
        $new_str .= $str[$i];
        }
        }
        }
        var_dump($str, $new_str);die;

    }


}