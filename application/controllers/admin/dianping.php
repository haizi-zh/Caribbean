<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class dianping extends ZB_Controller {
		
	const PAGE_ID = 'dianping';
	const PAGESIZE = 50;
	public function __construct(){
		parent::__construct();
		// $this->load->model('mo_user');
		// $this->load->model('mo_shop');
		// $this->load->model('do/do_dianping');
		// $this->load->model('mo_dianping');
	}

	public function ping(){
		$id = $this->input->get('id', true, '');
		$content = $this->input->get('content', true, '');
		$shop_id = $this->input->get('shop_id', true, '');
		$shop_name = $this->input->get('shop_name', true, '');
		$uid = $this->input->get('uid', true, '');
		$user_nick = $this->input->get('user_nick', true, '');
		$top = $this->input->get('top', true, 'all');
		$status = $this->input->get('status', true, '0');
		$user_eight = $this->input->get('user_eight', true, 1);

		$page = $this->input->get('page', true);
		if(!$page){
			$page = 1;
		}
		
		$user_ids = $viewspot_ids = array();
		$user_ids_list = $viewspot_ids_list = "";
		//echo $this->pagination->create_links();
		$offset = ($page - 1) * self::PAGESIZE;
		$params = array();
		if($shop_name){
			$shop_infos = $this->mo_shop->search_shop($shop_name);
			if($shop_infos){
				foreach($shop_infos as $v){
					$shop_ids[] = $v['id'];
				}
				$shop_ids_list = implode(",", $shop_ids);
			}else{
				$shop_id = 0;
			}
		}

		if($user_nick){
			$user_infos = $this->mo_user->search_nick($user_nick);
			
			if($user_infos){
				foreach($user_infos as $v){
					$user_ids[] = $v['uid'];
				}
				$user_ids_list = implode(",", $user_ids);
			}else{
				$params[] = " uid=0";
			}
		}
		if($id){
			$params[] = " id={$id}";
		}
		if($shop_id){
			$params[] = " shop_id={$shop_id}";
		}
		if($shop_ids_list){
			$params[] = " shop_id in ({$shop_ids_list}) ";
		}
		if($uid){
			$params[] = " uid={$uid}";
		}
		if($user_ids_list){
			$params[] = " uid in ({$user_ids_list}) ";
		}
		if($content){
			$params[] = " body like '%{$content}%'";
		}
		if($top != 'all'){
			$params[] = " top = {$top} ";
		}
		if($status != 'all'){
			$params[] = " status = {$status} ";
		}
		if($user_eight){
			$eight_time = strtotime("20140805");
			$params[] = " ctime > {$eight_time}";
		}
		if($user_eight ==2){
			$params[] = " uid not in(1395815219,1395725734,1396604026)";
		}

		$list = $this->do_dianping->get_last_dianping_admin(self::PAGESIZE, $offset, $params);
		$uids = $shop_ids = array();
		foreach($list as $v){
			$uids[] = $v['uid'];
			$shop_ids[] = $v['shop_id'];
		}

		$count_info = $this->do_dianping->get_last_dianping_admin_cnt($params);
		$count = $count_info['cnt'];
		if($count > 1000){
			//$count = 1000;
		}

		$pagesize = self::PAGESIZE;
		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );


		$uids = array_unique($uids);
		$shop_ids = array_unique($shop_ids);
		$user_infos = $this->mo_user->get_rich_userinfos($uids);
		$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
		$data['user_infos'] = $user_infos;
		$data['shop_infos'] = $shop_infos;
		
		$data['user_eight'] = $user_eight;
		$data['list'] = $list;
		$data['offset'] = $offset;
		$data['page_html'] = $page_html;
		$data['id'] = $id;
		$data['content'] = $content;
		$data['shop_id'] = $shop_id;
		$data['shop_name'] = $shop_name;
		$data['uid'] = $uid;
		$data['user_nick'] = $user_nick;
		$data['top'] = $top;
		$data['status'] = $status;
		$data['top_list'] = array("all"=>"不限",'1'=>'置顶', '0'=>'普通');

		$data['status_list'] = array("all"=>"不限", '0'=>'正常','1'=>'删除');
		$data['pageid'] = self::PAGE_ID;

		$show_list = array(0=>"所有数据", "1"=>"8月后所有数据", "2"=>"8月后屏蔽官方账号数据");
		$data['show_list'] = $show_list;
		$this->load->admin_view('admin/dianping_ping',$data);
		
		#置顶点评数，置顶点评的商家数量。

	}
	
	public function dianping_ping_modify(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$dianping_id = $this->input->get("dianping_id", true, 0);
		$data['dianping_id'] = $dianping_id;
		$this->load->admin_view('admin/dianping_ping_modify', $data);
	}

	
	public function dianping_ping_ctime(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$dianping_id = $this->input->get("dianping_id", true, 0);
		$data['dianping_id'] = $dianping_id;

		$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($dianping_id);
		$data['dianping_info'] = $dianping_info;
		
		$this->load->admin_view('admin/dianping_ping_ctime', $data);
	}
	
	public function comment(){
		$status = array('0'=>'正常','1'=>'删除');
	
		$this->load->model('mo_user');
		$this->load->model('mo_shop');
		$this->load->model('do/do_comment');
		$count_info = $this->do_comment->get_comment_cnt_all();
		$count = $count_info['cnt'];
		
		$page_cnt = ceil($count/self::PAGESIZE);
		$page = $this->input->get('page', true, "1");
		$content = $this->input->get('content', true, '');
		$dianping_id = $this->input->get('dianping_id', true, '');
		$user_eight = $this->input->get('user_eight', true, 1);

		if(!$page){
			$page = 1;
		}
		
		$pagesize = self::PAGESIZE;
		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );


		$offset = ($page - 1) * self::PAGESIZE;
		$params = array();
		if($dianping_id){
			$params[] = " dianping_id={$dianping_id}";
			$page_html = "";
		}
		if($content){
			$params[] = " content like '%{$content}%'";
			$page_html = "";
		}
		if($user_eight){
			$eight_time = strtotime("20140805");
			$params[] = " ctime > {$eight_time}";
		}
		if($user_eight ==2){
			$params[] = " uid not in(1395815219,1395725734,1396604026)";
		}

		$list = $this->do_comment->get_comment_list_for_admin($page, self::PAGESIZE, $params);
		$uids = $shop_ids = array();
		foreach($list as $v){
			$uids[] = $v['uid'];
			$shop_ids[] = $v['shop_id'];
		}
		$uids = array_unique($uids);
		$shop_ids = array_unique($shop_ids);
		$user_infos = $this->mo_user->get_rich_userinfos($uids);

		$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);

		$data['user_eight'] = $user_eight;
		$data['user_infos'] = $user_infos;
		$data['shop_infos'] = $shop_infos;
		
		$data['content'] = $content;
		$data['dianping_id'] = $dianping_id;

		$data['status'] = $status;
		$data['list'] = $list;
		$data['offset'] = $offset;
		$data['page_html'] = $page_html;
		$data['pageid'] = self::PAGE_ID;
		
		$show_list = array(0=>"所有数据", "1"=>"8月后所有数据", "2"=>"8月后屏蔽官方账号数据");
		$data['show_list'] = $show_list;
		
		$this->load->admin_view('admin/dianping_comment',$data);

	}
}



