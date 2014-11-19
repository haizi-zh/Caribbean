<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Links extends ZB_Controller {
		
	const PAGESIZE = 20;
	const PAGE_ID = 'links';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_link");
	}

	public function add_link(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$id = $this->input->get("id", true, 0);
		$cat_id = $this->input->get("cat_id", true, 0);
		$info = array();
		$name = $this->input->post("name", true, 0);
		if($id){
			$info = $this->mo_link->get_link_info($id);
		}
		$data['info'] = $info;
		$data['id'] = $id;
		$data['cat_id'] = $cat_id;

		if($name){
			$now = time();
			$id = $this->input->post("id", true, 0);
			$url = $this->input->post("url", true, '');
			$level = $this->input->post("level", true, 0);
			$cat_id = $this->input->post("cat_id", true, 0);
			if($id){
				$add_data = array();
				$add_data['level'] = $level;
				$add_data['name'] = $name;
				$add_data['url'] = $url;
				$add_data['mtime'] = $now;
				$re = $this->mo_link->update_link($add_data, $id);
			}else{
				$add_data = array();
				$add_data['cat_id'] = $cat_id;
				$add_data['level'] = $level;
				$add_data['name'] = $name;
				$add_data['url'] = $url;
				$add_data['ctime'] = $now;
				$add_data['mtime'] = $now;
				$re = $this->mo_link->add_link($add_data);
			}
			echo "<script language='javascript'>alert('保存信息成功！') ;window.location.href='/admin/links/cat/' ;</script>" ;
			return;
		}
		$this->load->admin_view('admin/links/add_link', $data);
	}

	public function cat(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$this->load->model("do/do_tag");
		$this->load->model("mo_geography");
		$list = $this->mo_link->get_cat_list();
		if($list){
			foreach($list as $k=>$v){
				$cat_id = $v['id'];
				$link_list = $this->mo_link->get_link_list($cat_id);
				$list[$k]['links'] = $link_list;
				$list[$k]['links_count'] = count($link_list);
			}
		}
		$data['offset'] = 0;
		$data['list'] = $list;
		$this->load->admin_view('admin/links/cat', $data);	
	}

	public function add_cat(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$id = $this->input->get("id", true, 0);
		$info = array();
		$name = $this->input->post("name", true, 0);
		if($id){
			$info = $this->mo_link->get_cat_info($id);
		}
		$data['info'] = $info;
		$data['id'] = $id;

		if($name){
			$now = time();
			$id = $this->input->post("id", true, 0);
			$level = $this->input->post("level", true, 0);
			if($id){
				$add_data = array();
				$add_data['level'] = $level;
				$add_data['name'] = $name;
				$add_data['mtime'] = $now;
				$re = $this->mo_link->update_cat($add_data, $id);
			}else{
				$add_data = array();
				$add_data['level'] = $level;
				$add_data['name'] = $name;
				$add_data['ctime'] = $now;
				$add_data['mtime'] = $now;
				$re = $this->mo_link->add_cat($add_data);
			}
			echo "<script language='javascript'>alert('保存信息成功！') ;window.location.href='/admin/links/cat/' ;</script>" ;
			return;
		}
		$this->load->admin_view('admin/links/add_cat', $data);
	}

}