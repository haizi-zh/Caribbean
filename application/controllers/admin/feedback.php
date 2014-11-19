<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Feedback extends ZB_Controller {
		
	const PAGE_ID = 'feedback';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_feedback");
	}
	// admin/feedback/lists
	public function lists(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$pagesize = 20;
		$page = $this->input->get("page", true, 1);

		$list = $this->mo_feedback->get_feedback_list($page, $pagesize);
		$count = $this->mo_feedback->get_feedback_count();
		
		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );

		$offset = ($page - 1) * $pagesize;
		$data['offset'] = $offset;
		$data['types'] = array("改进建议","内容纠错","bug提交");

		$data['list'] = $list;
		$data['page_html'] = $page_html;

		$this->load->admin_view('admin/feedback', $data);
	}
}