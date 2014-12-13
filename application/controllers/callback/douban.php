<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Douban extends CI_Controller {
	function index() {
		session_start();
		define("RENREN_API_ROOT",APPPATH."/third_party/renren/");
		require_once (RENREN_API_ROOT."RenrenOAuthApiService.class.php");
		require_once APPPATH .'config/env.php';
		
		if(!$_GET) {
        	$url = "https://www.douban.com/service/auth2/auth?client_id={$douban['apikey']}&redirect_uri={$douban['redirect_uri']}&response_type=code&scope=shuo_basic_r,shuo_basic_w,douban_basic_common ";
	        header("Location:{$url}");
	        exit;
		}
 		$code = $_GET['code'];
		if($code)
		{
			//获取accesstoken
			$oauthApi = new RenrenOAuthApiService;
			$this->config->load('env',TRUE);
			$env = $this->config->item('env');
            $renren = $env['douban'];
			$post_params = array('client_id'=>$renren['apikey'],
					'client_secret'=>$renren['secretkey'],
					'redirect_uri'=>$renren['redirect_uri'],
					'grant_type'=>'authorization_code',
					'scope'=>$renren['scope'],
					'code'=>$code);
			$token_url='https://www.douban.com/service/auth2/token';
			$access_info=$oauthApi->rr_post_curl($token_url,$post_params);//使用code换取token
			if(isset($access_info['access_token'])) {
				$uid = $access_info['douban_user_id'];
				$refresh_token = $access_info['refresh_token'];
				$access_token = $access_info['access_token'];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://api.douban.com/v2/user/~me');
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer {$access_token}" ));
				$info = curl_exec($ch);
				if(curl_error($ch)=='') {
					
				}else {
					//返回错误
				}
				$info = json_decode($info);
				if(is_object($info)) {
					$info = get_object_vars($info);
					$image = $info['avatar'];
				}else {
					$image = 'http://img3.douban.com/icon/user_normal.jpg';
				}
				curl_close($ch);
				$this->session->set_userdata('access_token',$access_token);
				#获取用户openid
				$this->session->set_userdata('openid',$uid);
				$info = array();
				$info['openid'] = $uid;
				$info['uname'] = $access_info['douban_user_name'];
				$info['image'] = $image;

				#整理user_info数据
				$formart_userinfo = self::tidy_userinfo($info);
				#将user_info插入数据库
				$this->load->model('mo_user');
				$local_userinfo = $this->mo_user->get_local_userinfo($formart_userinfo);
				
				$this->session->set_userdata('user_info',$local_userinfo);
				$source_url = $this->input->get("source_url", true, "http://". $_SERVER['HTTP_HOST']."/");
				$from = $this->input->get('from', TRUE, '');
				if($from && $from == 'm1'){
					$suffix = '';
					$suffix .= 'sid=' . $this->session->userdata('session_id');
					$suffix .= '&uname=' . $local_userinfo['uname'];
					$suffix .= '&uid=' . $local_userinfo['uid'];
					header("Location:http://". $_SERVER['HTTP_HOST'] . $source_url . "&" . $suffix);
				}else{
					header("Location:http://". $_SERVER['HTTP_HOST'] . $source_url);
				}
			}
		}
	}


	/*
	 * 整理用户信息函数，后续插入
	 */
	function tidy_userinfo($userinfo)
	{
		$data['source'] = 'renren';
		$data['sid'] = $this->session->userdata('openid');
		$data['uname'] = $userinfo['uname'];
		$data['image'] = $userinfo['image'];
		$data['reserve_1'] = $this->session->userdata['access_token'];
		return $data;
	}	
}
?>