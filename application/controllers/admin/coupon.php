<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Coupon extends ZB_Controller {
		
	const PAGE_ID = 'coupon';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_coupon");
		$this->load->model("mo_brand");
		$this->load->model("mo_geography");
		  $this->load->helper(array('form', 'url'));
	}
	public function lists(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$pagesize = 20;
		$where = array();
		$status = $this->input->get("status", true, 0);
		$id = $this->input->get("id", true, 0);
		$shop_id = $this->input->get("shop_id", true, 0);
		$brand_id = $this->input->get("brand_id", true, 0);
		$id = intval($id);
		$shop_id = intval($shop_id);
		$brand_id = intval($brand_id);
		if($id){
			$where['id'] = $id;
		}
		if($shop_id){
			$where['shop_id'] = $shop_id;
		}
		if($brand_id){
			$where['brand_id'] = $brand_id;
		}

		$page = $this->input->get("page", true, 1);
		$where['status'] = $status;

		$list = $this->mo_coupon->get_list($where, $page, $pagesize);
		$count = $this->mo_coupon->get_list_count($where);
		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );

		$offset = ($page - 1) * $pagesize;
		$data['offset'] = $offset;

		$data['list'] = $list;
		$data['page_html'] = $page_html;
		$status_list = array(0=>'开放中',1 =>'关闭中');
		$data['status_list'] = $status_list;

		$data['id'] = $id;
		$data['status'] = $status;
		$data['shop_id'] = $shop_id;
		$data['brand_id'] = $brand_id;
		$filedomain = context::get('filedomain');
		$coupon_pdf_domain = $filedomain."/coupon/";

		$data['coupon_pdf_domain'] = $coupon_pdf_domain;
		
		//获取所有国家
		$all_countrys = $this->mo_geography->get_all_countrys();
		$data['all_countrys'] = $all_countrys;
		$this->load->admin_view('admin/coupon/list', $data);
	}

	public function add_coupon(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据
		$data['policy'] = $security['policy'];
		$data['signature'] = $security['signature'];
		$id = $this->input->get('id', false, 0);
		$coupon_info = $this->mo_coupon->get_info_formadmin($id);
		$data['coupon_info'] = $coupon_info;
		$data['id'] = $id;
		$shop_ids = array();

		$template_order_list = array("图在下面", "图在上面");
		$data['template_order_list'] = $template_order_list;
		$country_ids = $brand_countrys = array();
		$brand_infos = array();
		if($id){
			$shop_ids = $coupon_info['shop_id'];
			if($shop_ids){
				$tmp = explode(",", $shop_ids);
				foreach($tmp as $k=> $v){
					if(!$v){
						unset($tmp[$k]);
					}
				}
				$shop_ids = $tmp;
			}
			
			$brand_id = $coupon_info['brand_id'];
			$country_ids = $coupon_info['country_ids'];
			$brand_infos = array();
			if($brand_id){
				$brand_id = substr($brand_id, 1, -1);
				$brand_id = explode(",", $brand_id);
				$country_ids_tmp = explode("|", $country_ids);
				foreach($brand_id as $k=>$v){
					$brand_countrys = $this->mo_brand->get_brand_countrys($v);
					$country_ids = $country_ids_tmp[$k];
					if($country_ids){
						$country_ids = explode(",", $country_ids);
					}
					$brand_infos[$v]['brand_id'] = $v;
					$brand_infos[$v]['brand_countrys'] = $brand_countrys;
					$brand_infos[$v]['country_ids'] = $country_ids;
				}

			}

		}

		$data['shop_ids'] = $shop_ids;

		$data['brand_infos'] = $brand_infos;


		$this->load->admin_view('admin/coupon/add', $data);
	}

	public function add_coupon_rich(){
		$data = array();
		$data['pageid'] = "coupon_add";
		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据
		$data['policy'] = $security['policy'];
		$data['signature'] = $security['signature'];
		$id = $this->input->get('id', false, '');
		$coupon_info = $this->mo_coupon->get_info_formadmin($id);
		$data['coupon_info'] = $coupon_info;
		$data['id'] = $id;
		$shop_ids = array();
		$this->load->admin_view('admin/coupon/add_coupon_rich', $data);
	}

	public function edit_seo(){
		
		$id = $this->input->get("id", true, '');

		$this->load->model("mo_coupon");
		$coupon_info = $this->mo_coupon->get_info_formadmin($id);
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['id'] = $id;
		$data['title'] = $coupon_info['title'];
		$data['seo_title'] = $coupon_info['seo_title'];
		$data['seo_keywords'] = $coupon_info['seo_keywords'];
		$data['seo_description'] = $coupon_info['seo_description'];
		$this->load->admin_view('admin/coupon/edit_seo', $data);
		#footer

	}

	public function add_pdf(){
		$id = $this->input->get('id', false, '');
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['id'] = $id;
		$coupon_info = $this->mo_coupon->get_info($id);
		$data['coupon_info'] = $coupon_info;

		$this->load->admin_view('admin/coupon/add_pdf', $data);

	}
	public function mobileimg(){
		$id = $this->input->get('id', false, '');
		$data = array();
		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据
		$data['policy'] = $security['policy'];
		$data['signature'] = $security['signature'];
		
		$data['pageid'] = "coupon_mobileimg";
		$data['id'] = $id;
		$coupon_info = $this->mo_coupon->get_info($id);
		$data['coupon_info'] = $coupon_info;

		$this->load->admin_view('admin/coupon/mobileimg', $data);
	}
	
	public function do_upload(){
		ini_set('upload_max_filesize','38M');
		$coupon_id = $this->input->post('id', false, '');
		$file_name = 'coupon_'.$coupon_id.".pdf";
		//$config['upload_path'] = FCPATH.'/public/coupon/';
		$config['upload_path'] = "/tmp/";
		$config['allowed_types'] = 'gif|jpg|png|pdf';
		$config['max_size'] = '2000000';

		$config['file_name']  = $file_name;
		$config['overwrite'] = true;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload()){
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('admin/coupon/upload_form', $error);
		} else {
			$add_data['pdf_name'] = $coupon_id.".pdf";
			$this->mo_coupon->update($add_data, $coupon_id);
			//上传到upyun
			$this->load->library("common/image");
			$save_path = "/coupon/{$coupon_id}.pdf";
			try{
				$re = $this->image->upload_file_by_file( "/tmp/".$file_name, $save_path );
			}catch(Exception $e){
				$re = $this->image->upload_file_by_file( "/tmp/".$file_name, $save_path );
			}
			if($re){
				@unlink("/tmp/{$file_name}");
			}

			$data = array('upload_data' => $this->upload->data());
			$this->load->view('admin/coupon/upload_form', $data);
		}
	}
}