<?php
#点评操作类
class Mo_dianping extends ZB_Model {
	const CACHA_TIME = 86400;
	// get_dianping_pre_next
	const KEY_GET_DIANPING_PRE_NEXT = "%s_1_%s_%s";

	const KEY_GET_DIANPING_INFOS = "%s_2_%s";
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_dianping');
		$this->load->model('do/do_comment');
	}

	#添加一个点评
	public function add($data){
		$this->load->model('mo_shop');
		#插入点评
		$dianping_id = $this->do_dianping->add($data);

#################################主表入库后的关联操作#################################
		#更新商家的最新点评索引
		
		$this->mo_shop->add_last_dianping($data['shop_id'],$dianping_id);

		#如果打分了，则刷新分数
		if($data['score']){
			//$this->update_shop_score($data['shop_id'], $data['score']);
		}
		#为粉丝根系feed
		$this->load->model('mo_social');
		$this->mo_social->update_fans_ping($data['uid'],$dianping_id);

		$this->modify_shop_cache($data['shop_id']);

		return $dianping_id;
	}
	public function modify_top($data, $id){
		$dianping_id = $this->do_dianping->modify($data, $id);

		$this->modify_shop_cache($data['shop_id']);
		return $dianping_id;
	}

	public function modify($data, $id){
		$dianping_id = $this->do_dianping->modify($data, $id);

		$this->modify_shop_cache($data['shop_id']);
		return $dianping_id;
	}

	public function modify_shop_cache($shop_id){
		$re = false;
		if($shop_id){
			$use_memcache = context::get('use_memcache', 0);
			if($use_memcache){
				$this->load->library('memcached_library');
				$cache_keys = context::get("cache_keys", false);
				$cache_key_templage = "%s_shop_%s_%s";
				$cache_key = sprintf($cache_key_templage, $cache_keys['shop_pre'], $shop_id, 0);
				$re = $this->memcached_library->delete($cache_key);
			}
		}
		return $re;
	}

	public function modify_shop_score($data, $id){
		$old_info = $this->get_dianpinginfo_by_id($id);
		
		if($data['score'] && $data['score'] != $old_info['score'] ){
			$diff_score = $data['score'] - $old_info['score'];
			$this->update_shop_score($old_info['shop_id'], $diff_score);
		}
		return true;
	}
	public function update_shop_score($shop_id, $score){
		$this->load->model('mo_shop');
		$shop_info = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		if($shop_info){
			$total_score = $shop_info[$shop_id]['total_score'];
			$valid_cnt = $this->get_valid_dianping_cnt($shop_id);
			
			$new_score = ceil(($total_score+$score)/($valid_cnt));

			#更新得分
			$scoredata['id'] = $shop_id;
			$scoredata['total_score'] = $total_score+$score;
			$scoredata['score'] = $new_score;
			$this->mo_shop->update_score($scoredata);
		}
	}

	public function repair_score($shop_id){
		$this->load->model('mo_shop');
		$shop_info = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		if($shop_info){
			$total_score = $this->get_value_dianping_score($shop_id);
			$valid_cnt = $this->get_valid_dianping_cnt($shop_id);

			if($valid_cnt && $total_score){
				$new_score = ceil(($total_score)/($valid_cnt));
			} else {
				$new_score = 0;
			}
			#更新得分
			$scoredata['id'] = $shop_id;
			$scoredata['total_score'] = $total_score;
			$scoredata['score'] = $new_score;
			$re = $this->mo_shop->update_score($scoredata);
			return $re;
		}
		return false;
	}

	

	/**
	 *删除一个点评
	 *影响的范围有 1，点评表 2，商店的最新点评索引 3，用户的点评数量 4，粉丝系的根feed
	 *  @author daijun
	 *
	 **/
	public function delete($data){
		$dianping_id = isset($data['dianping_id'])?$data['dianping_id']:0;
		$shop_id = isset($data['shop_id'])?$data['shop_id']:0;

		$dianping_infos = $this->get_dianpinginfo_by_ids(array($dianping_id));
		$dianping_info = $dianping_infos[$dianping_id];

		//修复积分
		$res = $this->do_dianping->delete($dianping_id) ;
		if($shop_id){
			$score = $dianping_info['score'];
		}
		#删除回复
		$this->do_comment->delete_by_dianpingid($dianping_id);
		$cache_re = $this->modify_shop_cache($data['shop_id']);

		return $res;
	}

	#恢复一个评论
	public function recover($dianping_id){
		return $this->do_dianping->recover($dianping_id);
	}

	public function get_dianpinginfo_by_id($id){
		$infos = $this->get_dianpinginfo_by_ids(array($id));
		if (isset($infos[$id])) {
			return $infos[$id];
		}
		return array();
	}

	#根据id获取点评信息 KEY_GET_DIANPING_INFOS
	public function get_dianpinginfo_by_ids($ids){
		$this->load->model('mo_user');
		$this->load->model('mo_shop');
		$this->load->model('mo_comment');

		if(!$ids){
			return array();
		}

		$re = $this->get_multi_cache(self::KEY_GET_DIANPING_INFOS, "mo_dianping", $ids, array());
		$data = $re['data'];
		$diff_ids = $re['diff_ids'];
		if($diff_ids){
			#从do层获取结果
			$format_re = $this->do_dianping->get_dianpinginfo_by_ids($diff_ids);

			#变成key value
			$return = array();

			$shop_ids = $uids = array();
			foreach($format_re as $each){
				$shop_ids[$each['shop_id']] = $each['shop_id'];
				$uids[$each['uid']] = $each['uid'];
			}
			$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
			$user_infos = $this->mo_user->get_middle_userinfos($uids);
			foreach($format_re as $each){
				if ( !$each['shop_id'] || !isset($shop_infos[$each['shop_id']]) || ($shop_infos[$each['shop_id']]['status'] != 0 )) {
					continue;
				}
				$each['cmt_cnt'] = $this->mo_comment->get_comment_cnt_by_dianping($each['id'], 0);

				$each['clean_body'] = $this->tool->clean_html_and_js($each['body']);
				$each['clean_short_body'] = $this->tool->substr_cn2($each['clean_body'],40);

				$uid = $each['uid'];
				$user_info = $this->mo_user->get_simple_userinfos(array($uid));
				if (isset($user_info[$uid])) {
					$each['user'] = $user_info[$uid];
				}
				$each['pic'] = "";
				$each['pics_list'] = array();
				if($each['has_pic']) {
					$pics = json_decode($each['pics'], true);
					$each['pic'] = $pics[0];
					$each['pics_list'] = $pics;
				}

				$uid = $each['uid'];
				$user_info = array();
				if(isset($user_infos[$uid])){
					$user_info = $user_infos[$uid];
				}
				$each['user_info'] = $user_info;

				$shop_id = $each['shop_id'];
				$shop_info = array();
				if(isset($shop_infos[$shop_id])){
					$shop_info = $shop_infos[$shop_id];
				}
				$each['shop_info'] = $shop_info;
				
				$return[$each['id']] = $each;
			}
			

			$re = $this->get_multi_cache(self::KEY_GET_DIANPING_INFOS, "mo_dianping", $ids, array(), self::CACHA_TIME, $return);
			$data = $re['data'];
			$diff_ids = $re['diff_ids'];
		}else{
			$return = $data;
		}

		#排序
		$sorted = array();
		foreach($ids as $id){ 
			if(!isset($return[$id])){
				continue;
			}
			$sorted[$id] = $return[$id];
		}

		return $sorted;
	}

	#根据商家id获取点评ids
	public function get_dianping_ids_by_shopid($shopid,$page=1,$pagesize=10){
		#从do层获取结果
		$re = $this->do_dianping->get_dianping_ids_by_shopid($shopid,$page,$pagesize);
		return $re;
	}
	public function get_dianpinginfo_by_shopid_new($shopid,$page=1,$pagesize=10){
		$dianping_re = $this->get_dianping_ids_by_shopid($shopid, $page, $pagesize);
		$dianping_infos = array();
		$dianping_ids = array();

		if($dianping_re){
			foreach($dianping_re as $v){
				$dianping_ids[] = $v['id'];
			}
			$dianping_infos = $this->get_dianpinginfo_by_ids($dianping_ids);
		}
		return $dianping_infos;
	}

	#根据商家id获取点评信息
	public function get_dianpinginfo_by_shopid($shopid,$page=1,$pagesize=10){
		$this->load->model('mo_user');
		$this->load->model('mo_comment');
		#从do层获取结果
		$format_re = $this->do_dianping->get_dianpinginfo_by_shopid($shopid,$page,$pagesize);

		#添加clean body
		$uids = array();
		foreach($format_re as $key=>$value){
			$value['clean_body'] = $this->tool->clean_html_and_js($value['body']);

			$uids[] = $value['uid'];
			$format_re[$key] = $value;
		}
		#获取用户信息
		$userinfos_re = $this->mo_user->get_middle_userinfos($uids);
		#获取回复计数
		#把用户信息加入返回值
		foreach($format_re as $index=>$dianping){
			$dianping['user_info'] = isset($userinfos_re[$dianping['uid']])?$userinfos_re[$dianping['uid']]:array();
			$dianping['cmt_cnt'] = $this->mo_comment->get_comment_cnt_by_dianping($dianping['id'], 0);
			$format_re[$index] = $dianping;
		}

		return $format_re;
	}

	#根据shop_id 获取点评里的图片，按点评 id倒序排列
	public function get_dianpingpic_by_shopid($shop_id,$max_dp_id,$count=10) {
		#从do层获取结果
		$format_re = $this->do_dianping->get_dianpinginfo_by_shopid($shop_id,1,$count,true,$max_dp_id);
		$dp_pic_list = array();
		foreach($format_re as $dianping) {
			$d_id = $dianping['id'];
			$dp_pic_list[$d_id] = $dianping['pics'];
		}
		$pics =  $this->tool->std2array($dp_pic_list);
		return $pics;
	}

	public function format_dianping_info($dianping_ids){
		$dianping_infos = $this->get_dianpinginfo_by_ids($dianping_ids);
		return $dianping_infos;
	}

	#获取点评的html，添加点评假写用
	public function get_dianping_html($data,$pics,$need_comment = true){
		$dianping_id = $data['dianping_id'];
		$source_shop = $data['source_shop'];
		$dianping_infos = $this->format_dianping_info(array($dianping_id));
		if ($source_shop) {
			foreach ($dianping_infos as $key => $value) {
				unset($dianping_infos[$key]['shop_info']);
			}
		}


		$data['dianpings']=$dianping_infos;

		$data['have_no_page'] = 1;
		$basic_html = $this->load->view('template/shaidan_card',$data,true);

		return $basic_html;
	}

	#返回点评中的图片html,添加点评假写用 (准备废弃)
	public function get_dianping_pic_html($pics,$dianping_id){
		#没有图片
		if(empty($pics)) return '';

		#有图片
		$pic_html = '<a href="/ping/'.$dianping_id.'" class="linkb">更多<span class="moredown"></span></a><div class="pic_wrap">';
		foreach($pics as $pic){
			$pic_html .= '<a href="/ping/'.$dianping_id.'" target="_blank"><img src="'.$pic.'!pingpreview" height="80"></a>';
		}
		$pic_html .= '</div>';
		return $pic_html;
	}

	#获取评分星级html,添加点评假写用 (准备废弃)
	public function get_score_html($score){
		#基本html
		$big_score = $score*10;
		if($score) $html = '<div class="rating_wrap"><span class="rating_title">综合评分</span><div class="rating_wrap_small"><span title="'.$score.'星商户" class="star star'.$big_score.'"></span></div>'.$score;
		else $html = '<div class="rating_wrap"><span class="rating_title">综合评分</span><div class="rating_wrap_small"><span title="0星商户" class="star star00"></span></div>'.$score;
		return $html;
	}

	#根据shop_id,page返回评论html，shop页分页显示评论用(逐步废弃)
	private function get_dianpings_html_by_shop_page($shop_id,$page){
		$this->load->model('mo_user');
		$this->load->model('mo_comment');
		#获取点评信息
		$dianpings = self::get_dianpinginfo_by_shopid($shop_id,$page);

		#获取用户信息
		$uids = array();
		foreach($dianpings as $key=>$value){
			$uids[] = $value['uid'];
		}

		$userinfos_re = $this->mo_user->get_simple_userinfos($uids);

		#获取回复计数
		#把用户信息加入返回值
		foreach($dianpings as $index=>$dianping){
			$dianping['user_info'] = isset($userinfos_re[$dianping['uid']])?$userinfos_re[$dianping['uid']]:array();
			$dianping['cmt_cnt'] = $this->mo_comment->get_comment_cnt_by_dianping($dianping['id'], 0);
			$dianpings[$index] = $dianping;
		}
		#渲染html
		$html = '';
		foreach($dianpings as $dianping){
			$uid = $dianping['uid'];
			$userinfo = isset($userinfos_re[$uid])?$userinfos_re[$uid]:array('uname'=>'default','image'=>'');
			$html .= self::get_dianping_html(array('cmt_cnt'=>$dianping['cmt_cnt'],'shop_id'=>$shop_id,'score'=>$dianping['score'],'body'=>$dianping['clean_body'],'dianping_id'=>$dianping['id'],'uid'=>$uid,'uname'=>$userinfo['uname'],'image'=>$userinfo['image']), $dianping['has_pic']?json_decode($dianping['pics'], true):array());
		}

		return $html;
	}

	#获取热门点评
	public function get_hot_dianping($page, $pagesize){
		#从do层获取结果
		$format_re = $this->do_dianping->get_last_dianping($page, $pagesize);

		$dianping_ids = array();
		foreach($format_re as $each){
			$dianping_ids[] = $each['id'];
		}

		return self::get_dianpinginfo_by_ids($dianping_ids);
	}

	#根据点评id批量渲染点评(逐步废弃)
	public function render_normal_dianping($ids,$need_comment = true){
		$this->load->model('mo_user');
		$this->load->model('mo_comment');

		$format_re = self::get_dianpinginfo_by_ids($ids);
		if (!$format_re) {
			return array();
		}
		#获取用户信息
		$uids = array();
		foreach($format_re as $key=>$value){
			$uids[] = $value['uid'];
		}
		$uids = array_unique($uids);
		$userinfos_re = $this->mo_user->get_simple_userinfos($uids);
		#获取回复计数
		#把用户信息加入返回值
		foreach($format_re as $index=>$dianping){
			$dianping['user_info'] = isset($userinfos_re[$dianping['uid']])?$userinfos_re[$dianping['uid']]:array();
			$dianping['cmt_cnt'] = $this->mo_comment->get_comment_cnt_by_dianping($dianping['id'], 0);
			$format_re[$index] = $dianping;
		}

		#渲染html
		$html = '';
		$uid = isset($uids[0])?$uids[0]:0;
		$userinfo = isset($userinfos_re[$uid])?$userinfos_re[$uid]:array('uname'=>'default','image'=>'');
		foreach($format_re as $dianping){
			$html .= self::get_dianping_html(array('cmt_cnt'=>$dianping['cmt_cnt'],'shop_id'=>$dianping['shop_id'],'score'=>$dianping['score'],'body'=>$dianping['clean_body'],'dianping_id'=>$dianping['id'],'uid'=>$dianping['uid'],'uname'=>$dianping['user_info']['uname'],'image'=>$dianping['user_info']['image']), $dianping['has_pic']?json_decode($dianping['pics'], true):array(),$need_comment);
		}

		return $html;
	}

	#获取用户的点评id
	public function get_dianpingids_by_uid($uid,$page=1,$pagesize=10){
		#从do层获取结果
		$format_re = $this->do_dianping->get_dianpingids_by_uid($uid,$page,$pagesize);
		$result = array();
		foreach($format_re as $each){
			$result[] = $each['id'];
		}

		return $result;
	}
	public function get_dianpingids_by_uids($uids){
		#从do层获取结果
		$format_re = $this->do_dianping->get_dianpingids_by_uids($uids);
		$result = array();
		foreach($format_re as $each){
			$result[] = $each['id'];
		}
		return $result;
	}

	#获取点评的评论总数
	public function get_comment_cnt_by_dianping($dianping_ids, $type=0){
		#从do层获取结果
		foreach($dianping_ids as $dianping_id){
			$cnt = $this->do_comment->get_comment_cnt_by_dianping($dianping_id, $type);
			$re[$dianping_id] = $cnt;
		}

		return $re;
	}

	#有效点评数
	public function get_valid_dianping_cnt($shop_id){
		#从do层获取结果
		$re = $this->do_dianping->get_valid_dianping_cnt($shop_id);

		#格式化成数组
		$format_re = $this->tool->std2array($re);

		return isset($format_re[0]['count(*)'])?$format_re[0]['count(*)']:0;
	}

	public function get_value_dianping_score($shop_id){
		#从do层获取结果
		$re = $this->do_dianping->get_value_dianping_score($shop_id);

		#格式化成数组
		$format_re = $this->tool->std2array($re);

		return isset($format_re[0]['sum'])?$format_re[0]['sum']:0;

	}

	public function get_last_dianping_by_uid($uid){

		#从do层获取结果
		$format_re = $this->do_dianping->get_last_dianping_by_uid($uid);
		if($format_re){
			return $format_re;
		}else{
			return array();
		}
	}


	public function get_all_dianpings(){
		$re = $this->do_dianping->get_all_dianpings();
		return $re;
	}
	public function get_all_dianpings_info(){
		$re = $this->do_dianping->get_all_dianpings_info();
		return $re;
	}
	
	// KEY_GET_DIANPING_PRE_NEXT
	public function  get_dianping_pre_next($id, $shop_id){
		$re = $this->get_simple_cache(self::KEY_GET_DIANPING_PRE_NEXT, "mo_dianping", array($id, $shop_id), self::CACHA_TIME);
		if($re != false){
			return $re;
		}

		$dianping_re = $this->get_dianpinginfo_by_shopid_new($shop_id, 1, 1000);
		if(!$dianping_re || count($dianping_re)<2){
			return array();
		}
		$keys = array_keys($dianping_re);
		$next = $pre = array();
		foreach($keys as $k => $v){
			if($v == $id){
				if(isset($keys[$k-1])){
					$pre = $keys[$k-1];
				}else{
					$pre = $keys[count($keys)-1];
				}
				if(isset($keys[$k+1])){
					$next = $keys[$k+1];
				}else{
					$next = $keys[0];
				}
				if($next == $id){
					$next = '';
				}
				if($pre == $id){
					$pre = '';
				}
				break;
			}
		}
		if($pre){
			$pre = $dianping_re[$pre];
		}
		if($next){
			$next = $dianping_re[$next];
		}

		$re = array();
		$re['pre'] = $pre;
		$re['next'] = $next;

		$this->get_simple_cache(self::KEY_GET_DIANPING_PRE_NEXT, "mo_dianping", array($id, $shop_id), self::CACHA_TIME, $re);
		return $re;

	}

}



