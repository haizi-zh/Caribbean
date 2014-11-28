<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class home extends ZB_Controller {

	const PAGE_ID = 'home';
	
	public function index()
	{
		$data=array();
		$data['pageid'] = self::PAGE_ID; 


		#load page
		$this->load->admin_view('admin/home', $data);		
	}


	public function zb_milestone(){
		#header

		$this->load->model("do/do_milestone");
		$content = $this->input->get("content", true, '');
		$page = $this->input->get("page", true, 1);
		$page_size = 20;
		if ($content) {
			$data = array();
			$data['content'] = $content;
			$data['ctime'] = time();
			$re = $this->do_milestone->add($data);
			 header("Location:http://". $_SERVER['HTTP_HOST']."/admin/home/zb_milestone");
			 return;
			# code...
		}
		$cnt = $this->do_milestone->get_milestone_cnt_for_admin();
		$list = $this->do_milestone->get_milestone_list_for_admin($page, $page_size);
		$data = array();
		$data['list'] = $list;
		$data['cnt'] = $cnt;
		$offset = ($page - 1) * $page_size;
		$this->load->library('pagination');
		$config['use_page_numbers'] = TRUE;
		
		$config['base_url'] = '/admin/home/zb_milestone/?';

		$config['total_rows'] = $cnt;
		$config['per_page'] = $page_size;
		$config['query_string_segment'] = 'page';
		//$config['use_page_numbers'] = TRUE;
		//$config['page_query_string'] = TRUE;
		$config['page_query_string']  = TRUE;

		$this->pagination->initialize($config);
		$page_html = $this->pagination->create_links();

		$data['page_html'] = $page_html;
		$data['offset'] = $offset;
		$data['pageid'] = self::PAGE_ID;
		#load page
		$this->load->admin_view('admin/zb_milestone', $data);		
			


	}


}