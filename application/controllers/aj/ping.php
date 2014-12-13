<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Ping extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model('mo_dianping');
		$this->load->model('mo_module');
	}
	public function addcomment(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
			$user_info=$this->session->userdata('user_info');
			$uid = $user_info['uid'];
			$vuid = $uid;

			$shop_id = $this->input->post('shop_id', true, 0);
			$dianping_id = $this->input->post('dianping_id', true, 0);
			$content = $this->input->post('comment', true, '');
			$ocid = $this->input->post('ocid', true, 0);
			$type = $this->input->post('type', true, 0);
			
			$this->config->load('env',TRUE);
			
			if(!$user_info){
				$code = '202';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			
			#拼装
			$comment_data = array(
					'uid' => $uid,
					'shop_id' => $shop_id,
					'dianping_id' => $dianping_id,
					'content' => $content,
					'reserve_1' => $ocid,
					'type' => $type,
			);
			
			#入库
			$this->load->model('mo_comment');
			$comment_id = $this->mo_comment->add($comment_data);
			
			$re = $this->mo_module->format_single_comment($vuid, array($comment_id), 1, $dianping_id, $type);
			$html = $re['comment_list_html'];
			$code = '200';
			/*
			#用户信息
			$this->load->model('mo_user');
			$users = $this->mo_user->get_middle_userinfos(array($uid));
			$user = isset($users[$uid])?$users[$uid]:array('uname'=>'default','image'=>'');
			
			#返回
			
			
			$this->config->load('errorcode',TRUE);
			$ouser_html = '';
			if($ocid){
				#加入原点评作者信息
				if(isset($ori_comment[$ocid])){
					$ouid = $ori_comment[$ocid]['uid'];
					$this->load->model('mo_user');
					$ouser = $this->mo_user->get_simple_userinfos(array($ouid));
					$ouser = $ouser[$ouid];
				}
			}
			var_dump($ouser);

			$comments = array(0=>array('uid'=>$uid,'content'=>$content,'id'=>$comment_id));
			$userinfos_re = array($uid=>$user);

			$comment_data = array("comments"=>$comments,'users'=>$userinfos_re,'dianping_id'=>$dianping_id,'shop_id'=>$shop_id,'login_uid'=>$uid);
			$comment_data['type'] = $type;
			$html = $this->load->view("template/comment_card",$comment_data,true);
			*/

			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>$html));
		
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	public function getcommenthtml(){
		$this->config->load('errorcode',TRUE);
		$vuid = context::get('vuid', 0);
		try{
			#获取参数

			$dianping_id = $this->input->get('dianping_id', true, 0);
			$page = $this->input->get('page', true, 1);
			$pagesize = $this->input->get('pagesize', true, 10);
			$type = $this->input->get('type', true, 0);

			$dianping_id = intval($dianping_id);
			$page = intval($page);
			$pagesize = intval($pagesize);
			if(!$dianping_id){
				$code = '201';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			$comment_re = $this->mo_module->get_comment_html($vuid, $dianping_id, $type, $page, $pagesize);
			$comment_list_html = $comment_re['comment_list_html'];
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>$comment_list_html));
			
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	public function delete_dianping_comment_foradmin(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('mo_comment');
		$re = $this->mo_comment->delete($id);
		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}
	public function recover_dianping_comment_foradmin(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('mo_comment');
		$re = $this->mo_comment->recover($id);
		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		
	}
	
	public function delete_dianping_foradmin(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($id);
		if(!$dianping_info){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return;
		}
		
		$re = $this->mo_dianping->delete(array('dianping_id' => $id, 'shop_id'=>$dianping_info['shop_id']));

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}
	public function recover_dianping_foradmin(){
		#禁止浏览器缓存
		$ping_id = $this->input->post('ping_id', true, 0);
		if(!$ping_id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		
		$this->load->model('mo_dianping');
		$re = $this->mo_dianping->recover($ping_id);

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		
	}
	public function top_dianping(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('mo_dianping');
		$data['top'] = 1;
		$re = $this->mo_dianping->modify_top($data, $id);

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}
	public function untop_dianping(){
		#禁止浏览器缓存
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		
		$this->load->model('mo_dianping');
		$data['top'] = 0;
		$re = $this->mo_dianping->modify_top($data, $id);

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		
	}

	public function dianping_ping_modify_uid(){
		$id = $this->input->post('id', true, 0);
		$uid = $this->input->post('uid', true, 0);
		$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($id);
		$user_info = $this->mo_user->get_simple_userinfo($uid);
		if(!$dianping_info ){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>"点评不存在"));
			return ;
		}
		if(!$user_info){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>"用户不存在"));
			return ;
		}
		$re = $this->mo_dianping->modify(array('uid'=>$uid,'shop_id'=>$dianping_info['shop_id']), $id);
		$old_uid = $dianping_info['uid'];
		$fans = $this->mo_social->get_fans($old_uid);
		$new_fans = $this->mo_social->get_fans($uid);
		if($re){
			//构建这些粉丝的feed
			if($fans){
				foreach($fans as $mo_uid){
					$this->mo_social->update_user_feed($mo_uid, $mo_uid);
				}
			}
			if($new_fans){
				foreach($new_fans as $mo_uid){
					$this->mo_social->update_user_feed($mo_uid, $mo_uid);
				}
			}
		}
		echo json_encode(array('code'=>"200",'msg'=>"成功"));


	}

	public function dianping_ping_ctime(){
		$id = $this->input->post('id', true, 0);
		$ctime = $this->input->post('ctime', true, '');
		$dianping_info = $this->mo_dianping->get_dianpinginfo_by_id($id);
		if($ctime){
			$ctime = strtotime($ctime);
		}else{
			$ctime = time();
		}

		if(!$dianping_info ){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>"点评不存在"));
			return ;
		}

		$re = $this->mo_dianping->modify(array('ctime'=>$ctime, 'shop_id'=>$dianping_info['shop_id']), $id);
		echo json_encode(array('code'=>"200",'msg'=>"成功"));


	}



}