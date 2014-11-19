<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class content extends ZB_Controller {
		
	const PAGESIZE = 20;
	const PAGE_ID = 'content';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_content");
	}
	// zan.com/admin/content/lists
	public function lists(){
		$data = array();
		$this->config->load('ana');
		$ana_type_list = $this->config->item("ana_type_list");
		$data['ana_type_list'] = $ana_type_list;

		$list = $this->mo_content->get_list();
		$data['offset'] = 0;
		$data['list'] = $list;
		$data['pageid'] = self::PAGE_ID;
		$this->load->admin_view('admin/content/lists', $data);	
	}


	public function add(){
		$data = array();
		$this->config->load('ana');
		$ana_type_list = $this->config->item("ana_type_list");
		$data['ana_type_list'] = $ana_type_list;

		$data['pageid'] = self::PAGE_ID;
		$id = $this->input->get("id", true, 0);
		$info = array();
		$desc_content = $this->input->post("desc_content", true, 0);
		if($id){
			$info = $this->mo_content->get_info($id);
		}
		$data['info'] = $info;
		$data['id'] = $id;

		if($desc_content){
			$now = time();
			$id = $this->input->post("id", true, 0);
			$name = $this->input->post("name", true, '');
			$type = $this->input->post("type", true, 0);
			if($id){
				$add_data = array();
				$add_data['type'] = $type;
				$add_data['name'] = $name;
				$add_data['desc_content'] = $desc_content;
				$add_data['mtime'] = $now;
				$re = $this->mo_content->update($add_data, $id);
			}else{
				$add_data = array();
				$add_data['type'] = $type;
				$add_data['name'] = $name;
				$add_data['desc_content'] = $desc_content;
				$add_data['ctime'] = $now;
				$add_data['mtime'] = $now;
				$re = $this->mo_content->add($add_data);
			}
			echo "<script language='javascript'>alert('保存信息成功！') ;window.location.href='/admin/content/lists/' ;</script>" ;
			return;
		}
		$this->load->admin_view('admin/content/add', $data);
	}

	public function del(){
		$data = array();
		$id = $this->input->get("id", true, 0);
		if($id){
			$re = $this->mo_content->del($id);
			echo "<script language='javascript'>alert('删除成功') ;window.location.href='/admin/content/lists/' ;</script>" ;
			return;
		}
	}

}