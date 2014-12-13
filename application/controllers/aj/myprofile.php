<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Myprofile extends ZB_Controller {

	public function getPingHtml(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
/* 			$uid = isset($_GET['uid'])?$_GET['uid']:0;
			$page = isset($_GET['page'])?$_GET['page']:1;
			$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10; */
			$uid = $this->input->get('uid', true, 0);
			$page = $this->input->get('page', true, 1);
			$pagesize = $this->input->get('pagesize', true, 10);
			$type = $this->input->get("type",true,"myprofile");
			
			$uid = intval($uid);
			$page = intval($page);
			$pagesize = intval($pagesize);

			if(!$uid){
				$code = '201';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			
			#获取点评ids
			$this->load->model('mo_dianping');
			$this->load->model('mo_social');
			$this->load->model('mo_user');
			//$dianping_ids = $this->mo_dianping->get_dianpingids_by_uid($uid,$page,$pagesize);
			if($type == 'myfeed'){
				#用户的feed
				$dianping_ids = $this->mo_social->get_user_feed($uid, $page, $pagesize);
				$total = $this->mo_social->get_user_feed_cnt($uid);
				$page_cnt = ceil($total/10);

			}elseif($type == 'myprofile'){
				#用户的点评
				$dianping_ids = $this->mo_dianping->get_dianpingids_by_uid($uid, $page, $pagesize);
				#用户点评数
				$total = $this->mo_user->get_dianping_cnt_by_uid($uid);
				$page_cnt = ceil($total/10);
			}
			#渲染html
			//$html = $this->mo_dianping->render_normal_dianping($dianping_ids,false);
			$userinfo_re = $this->mo_user->get_middle_userinfos(array($uid));
			$user_info = isset($userinfo_re[$uid])?$userinfo_re[$uid]:array();

			$dianping_infos = $this->mo_dianping->get_dianpinginfo_by_ids($dianping_ids);
			if($dianping_infos){
				foreach ($dianping_infos as $key => $value) {
					if($value['status'] != 0){
						unset($dianping_infos[$key]);
					}
				}
			}
			$data = array();
			$data['dianpings'] = $dianping_infos;
			$data['page'] = $page;
			$data['page_cnt'] = $page_cnt;
			$data['type'] = $type;
			$data['user_info'] = $user_info;
			$data['show_shop_title'] = 1;
			$data['login_uid'] = $uid;
			//$dianping_html = $this->load->view('template/shaidan_card', array('dianpings'=>$dianping_infos, 'simple'=>1), true);
			$dianping_html = $this->load->view('template/shaidan_card', $data, true);
			$html = $dianping_html;
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>$html));
		
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	// aj/myprofile/delete
	public function delete() {
		#当前登录用户是否是该页面的拥有者
		if(!isset($this->session->userdata['user_info']['uid']) ) {
			echo json_encode(array('code'=>'201','msg'=>"请登录"));
			return ;
		}
		$dianping_id = $this->input->get('id', true);
		
		if($dianping_id == FALSE) {
			echo json_encode(array('code'=>'200','msg'=>''));
			return ;
		}
		$login_uid = $this->session->userdata['user_info']['uid'];
		//$dianping_id = $_GET['id'];
		$this->load->model("mo_dianping");
		$dianping_info = $this->mo_dianping->get_dianpinginfo_by_ids(array($dianping_id));

		if(!$dianping_info) {
			echo json_encode(array('code'=>'200','msg'=>'无此点评信息'));
			return;
		}
		
		$dianping_uid = $dianping_info[$dianping_id]['uid'];
		if($dianping_uid == $login_uid) {
			//删除晒单，减去晒单数量
			$data = array();
			$data['dianping_id'] = $dianping_info[$dianping_id]['id'];
			$data['uid'] = $dianping_info[$dianping_id]['uid'];
			$data['shop_id'] = $dianping_info[$dianping_id]['shop_id'];
			$res = $this->mo_dianping->delete($data);
			if($res) {
				echo json_encode(array('code'=>'200','msg'=>'删除成功'));
				return;
			}
		}
		echo json_encode(array('code'=>'201','msg'=>'无删除权限'));
		return;
	}
}