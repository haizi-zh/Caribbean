<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class shop extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_dianping");
		$this->load->model("mo_shop");
		$this->load->model("mo_user");
	}
	# http://10.11.12.13/aj/shop/get_dianping/?id=1976
	public function get_dianping(){
		$dianping_id = $this->input->get("id", true, 0);
		$dianping_id = intval($dianping_id);

		if (!$dianping_id) {
			$code = "201";
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>'33'));
			exit;
		}
		$dianping_infos = $this->mo_dianping->get_dianpinginfo_by_ids(array($dianping_id));

		if (!$dianping_infos || !isset($dianping_infos[$dianping_id])) {
			$code = "201";
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>'33'));
			exit;
		}

		$dianping_info = $dianping_infos[$dianping_id];
		$body = $dianping_info['body'];
		$pics = $dianping_info['pics'];
		$score = $dianping_info['score'];
		$data['body'] = $body;
		$data['pics'] = $pics;
		$data['score'] = $score;
		$code = "201";
		echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>$data));
		exit;

	}

	
	#添加一条点评
	public function add_dianping(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
			$id = $this->input->post("id", true, 0);
			$score = $this->input->post('score', true, 0);
			$body = $this->input->post('body', true, '');
			$has_pic = $this->input->post('pics', true, 0);
			$source = $this->input->post('source', true, 'shop');
			if ($has_pic){
				$has_pic = 1;
			}else{
				$has_pic = 0;
			}
			$pics = $this->input->post('pics', true, '');
			if ($pics){
				$pics = json_encode(explode(",",$_POST['pics']));
			}else{
				$pics = '';
			}
			$shop_id = $this->input->post('shop_id', true, 0);

			$user_info=$this->session->userdata('user_info');
			$this->config->load('env',TRUE);

			if(!$user_info){
				$code = '202';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			#判断body是否重复
			$uid = $user_info['uid'];
			$last_body = $this->mo_dianping->get_last_dianping_by_uid($uid);
			if ($last_body && $last_body['body'] == $body) {
				$code = "210";
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>'33'));
				exit;
			}
			#判断是否自己操作的
			if($id){
				$dianping_infos = $this->mo_dianping->get_dianpinginfo_by_ids(array($id));
				if (!$dianping_infos || !isset($dianping_infos[$id])) {
					$code = '201';
					echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
					exit;
				}

				if ($dianping_infos[$id]['uid'] != $user_info['uid']) {
					$code = '205';
					echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
					exit;
				}
			}
			#拼装
			$dianpingdata = array(
					'score' => $score,
					'body' => $body,
					'pics' => $pics,
					'has_pic' => $has_pic,
					'score' => $score,
					'uid' => $user_info['uid'],
					'shop_id' => $shop_id,
					);

			#入库
			if ($id) {
				$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($id);
				$dianpingdata['shop_id'] = $dianping_info['shop_id'];
				$dianping_id = $this->mo_dianping->modify($dianpingdata, $id);
			}else{
				$dianping_id = $this->mo_dianping->add($dianpingdata);
			}
			if (!$dianping_id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>""));
				exit();
			}
			#获取用户信息
			$uid = $user_info['uid'];
			$userinfo_re = $this->mo_user->get_middle_userinfos(array($uid));
			$userinfo = $userinfo_re[$uid];

			#返回
			$code = '200';
			$this->config->load('errorcode',TRUE);
			$source_shop = 1;
			if($source == 'profile'){
				$source_shop = 0;
			}
			$html_data = array('source_shop'=>$source_shop,'cmt_cnt'=>0,'shop_id'=>$shop_id,'score'=>$score,'body'=>$this->tool->clean_html_and_js($body),'dianping_id'=>$dianping_id,'uid'=>$uid,'uname'=>$userinfo['uname'],'image'=>$userinfo['image']);
			$html_data['login_uid']=$uid;
			
			$html = $this->mo_dianping->get_dianping_html($html_data, $has_pic?explode(",",$_POST['pics']):array());

			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>$html));

		}catch(Exception $e){
			#先做个兼容
			if(isset($dianping_id) && $dianping_id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>""));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}
	}

	#根据shop_id,page返回评论html，shop页分页显示评论用
	public function get_paging_html(){
		try{
			$this->config->load('errorcode',TRUE);
			$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
			#获取参数
/* 			if(!isset($_GET['page']) || empty($_GET['page']) || !isset($_GET['shop_id']) || empty($_GET['shop_id'])){
				$code = '201';
				throw new Exception($this->config->item($code,'errorcode'), $code);
			}
			$page = $_GET['page'];
			$shop_id = $_GET['shop_id']; */
			$page = $this->input->get('page', true);
			$shop_id = $this->input->get('shop_id', true);

			$page = intval($page);
			$shop_id = intval($shop_id);

			if (!$page || !$shop_id){
				$code = '201';
				throw new Exception($this->config->item($code,'errorcode'), $code);
			}

			$login_uid = isset($this->session->userdata['user_info']['uid'])?$this->session->userdata['user_info']['uid']:0;
			#获取商家信息
			$shop_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));

			#获取点评信息
			$dianping_re = $this->mo_dianping->get_dianpinginfo_by_shopid_new($shop_id,$page);
			#获取html
			$data = array('login_uid'=>$login_uid,"dianpings"=>$dianping_re,'shop_info'=>$shop_re[$shop_id]);
			$data['shop_id'] = $shop_id;
			$data['page'] = $page;
			$total = $this->mo_shop->get_dianping_cnt($shop_id);
			$page_cnt = ceil($total/10);
			$data['page_cnt'] = $page_cnt;
			$data['show_shop_title'] = 0;
			$shaidan_list_html = $this->load->view("template/shaidan_card", $data, true);

			#获取html
			#$this->load->model('mo_dianping');
			#$html = $this->mo_dianping->get_dianpings_html_by_shop_page($shop_id,$page);

			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>$shaidan_list_html));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}


	#根据shop ip 获得当前shop 的主图和其点评的图片
	public function get_shop_pic() {
		$shop_id = $this->input->get('shop_id', true, 0);
		$max_dp_id = $this->input->get('last_id', true, 0);

		$shop_id = intval($shop_id);
		$max_dp_id = intval($max_dp_id);

		$max_dp_id = 10000000;
		if(intval($shop_id)==0) {
			echo json_encode(array('code'=>'201','msg'=>$this->config->item('201','errorcode')));
			return;
		}
		
		//根据max_dp_id获得点评的图片，返回时按创建时间倒序
		$dianping_pic = $this->mo_dianping->get_dianpingpic_by_shopid($shop_id,$max_dp_id);
		$pics = array();
		//if($max_dp_id == 0) {
			//第一次请求获取shop pic
			
			$shop_info = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
			if(!$shop_info) {
				echo json_encode(array('code'=>'201','msg'=>'error shop id'));
				return;
			}
			$shop_pic = $shop_info[$shop_id]['pic'];
			$pics[] = $shop_pic;
		//}
		#获取商户上传图片
		$shop_photo = $this->mo_shop->get_shopphoto_by_shopid($shop_id, 1, 1000);
		if($shop_photo){
			foreach($shop_photo as $v){
				$pics[] = $v['photo'];
			}
		}
		
		foreach($dianping_pic as $line) {
			$column = explode(",",$line);
			$pics = array_merge($pics,$column);
		}

		foreach($pics as &$pic) {
			$pic = str_replace('\\','',$pic);
			$pic = preg_replace('/[\"\]\[]+/i','',$pic);
			$pic = upimage::format_brand_up_image($pic);
			//$pic = $this->tool->use_image_version($pic,'shopimagepop');
			$pic = $this->tool->use_image_version($pic,'');
		}
		$keys = array_keys($dianping_pic);
		sort($keys);
		if(count($keys)>0) {
			$min_id = $keys[0];
		}
		else {
			$min_id = 0;
		}
		//往后搜索，看是否已结束
		$next_pic = $this->mo_dianping->get_dianpingpic_by_shopid($shop_id,$min_id,1);
		if(empty($next_pic)) {
			//$is_end = true;
		} else {
			//$is_end = false;
		}
		$is_end = false;
		//$min_id = 1;
		$ret = array('pics'=>$pics,'is_end'=>$is_end,'last_id'=>$min_id);
    	echo json_encode(array('code'=>200,'msg'=>$ret));
	}

	public function add_shop_photo(){
		try{
			$data = array();
			$data['shop_id'] = $this->input->post('shop_id', true, '');
			$photo = $this->input->post('photo', true, '');
			$desc = $this->input->post('desc', true, '');
			if($photo){
				$photo = str_replace("!300", "", $photo);
			}
			$data['photo'] = $photo;
			$data['desc'] = $desc;
			$data['ctime'] = time();
			$re = $this->mo_shop->add_shop_photo($data);

			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	public function modify_photo_desc(){
		try{
			$data = array();
			$id = $this->input->post('id', true, '');
			$desc = $this->input->post('desc', true, '');
			$data['desc'] = $desc;
			$re = $this->mo_shop->modify_photo_desc($data, $id);

			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	public function delete_photo(){
		$id = $this->input->post("id", true, 0);
		if($id){
			$re = $this->mo_shop->delete_shop_photo($id);
		}
		echo json_encode(array('code'=>'200','msg'=>'succ'));
	}
	public function change_rank_score_foradmin(){
		try{
			$data = array();
			$id = $this->input->post('id', true, '');
			$rank_score = $this->input->post('rank_score', true, '');
			$rank_score = intval($rank_score);
			$data['rank_score'] = $rank_score;
			$data['id'] = $id;
			$re = $this->mo_shop->update_info($data);

			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	public function delete_cache_foradmin(){
		try{
			$shop_id = $this->input->post('id', true, '');

			$cache_keys = context::get("cache_keys", false);
			$cache_key_templage = "%s_shop_%s_%s";
			$cache_key = sprintf($cache_key_templage, $cache_keys['shop_pre'], $shop_id, 0);
			
			$re = $this->memcached_library->delete($cache_key);

			$cache_key_templage = "%s_sinfo_%s_%s";

			$key = sprintf($cache_key_templage, $cache_keys['shop_infos_pre'], $shop_id, 0);;
			$re = $this->memcached_library->delete($key);

			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	public function delete_cache_brand_foradmin(){
		try{
			$shop_id = $this->input->post('id', true, '');

			$this->mo_shop->delete_cache_shop_brand($shop_id);

			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}


}