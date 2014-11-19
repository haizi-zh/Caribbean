<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class taglist extends ZB_Controller {

	const PAGE_ID = 'tag';
	
	public function index(){

		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$this->load->model("do/do_tag");
		$this->load->model("mo_geography");
		$list = $this->do_tag->get_cat_list();
		$citys = $this->mo_geography->get_all_cityinfos();
		foreach($list as $k => $v){
			$type = $v['id'];
			$tag_list = $this->do_tag->get_tag_list_by_type($type);
			$tmp_list = "";
			$tmp = array();
			if($tag_list){
				foreach($tag_list as $vv){
					$tmp[] = $vv['name'];
				}
				$tmp_list = implode(',', $tmp);
			}
			

			$list[$k]['list'] = $tag_list;
		}
		$data['citys'] = $citys;
		$data['offset'] = 0;
		$data['list'] = $list;
		$this->load->admin_view('admin/tag_list', $data);	
	}

	public function edit(){

		$this->load->model("do/do_tag");

		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$id = $this->input->get("id", true, 0);
		$info = array();
		$name = $this->input->post("name", true, 0);
		if($id){
			$info = $this->do_tag->get_cat_info($id);
		}
		$data['info'] = $info;
		$data['id'] = $id;

		if($name){
			$id = $this->input->post("id", true, 0);
			if($id){
				$add_data = array();
				$add_data['name'] = $name;
				$re = $this->do_tag->update_cat($add_data, $id);
			}else{
				$add_data = array();
				$add_data['name'] = $name;
				$add_data['ctime'] = time();
				$re = $this->do_tag->add_cat($add_data);
			}
			echo "<script language='javascript'>alert('保存信息成功！') ;window.location.href='/admin/taglist/' ;</script>" ;
			return;
		}


		$this->load->admin_view('admin/tag_cat_edit', $data);	
	}
	public function tags_edit(){
		$this->load->model("do/do_tag");
		$this->load->model("mo_geography");
		$citys = $this->mo_geography->get_all_cityinfos();
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$type = $this->input->get("type", true, 0);
		$id = $this->input->get("id", true, 0);
		$info = array();
		$name = $this->input->post("name", true, 0);
		if($id){
			$info = $this->do_tag->get_tag_info($id);
		}
		$data['info'] = $info;
		$data['type'] = $type;
		$data['id'] = $id;
		$data['citys'] = $citys;
		if($name){
			$id = $this->input->post("id", true, 0);
			$type = $this->input->post("type", true, 0);
			$city_id = $this->input->post("city_id", true, 0);
			if($id){
				$add_data = array();
				$add_data['name'] = $name;
				$add_data['city_id'] = $city_id;
				$re = $this->do_tag->update_tag($add_data, $id);
			}else{
				$add_data = array();
				$add_data['type'] = $type;
				$add_data['name'] = $name;
				$add_data['city_id'] = $city_id;
				$add_data['ctime'] = time();
				$re = $this->do_tag->add_tag($add_data);
			}
			echo "<script language='javascript'>alert('保存信息成功！') ;window.location.href='/admin/taglist/' ;</script>" ;
			return;
		}
		$this->load->admin_view('admin/tags_edit', $data);	

	}

	public function editshop_tag(){
		$this->load->model("do/do_tag");
		$this->load->model("do/mo_shop");
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$shop_id = $this->input->get("shop_id", true, 0);
		$data['offset'] = 0;
		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
		$city_id = $shop_info['city'];
		$data['shop_info'] = $shop_info;
		$data['shop_id'] = $shop_id;

		$list = $this->do_tag->get_cat_list();

		foreach($list as $k => $v){
			$type = $v['id'];
			$tmp_city_id = $city_id;
			if($type!=3){
				$tmp_city_id = 0;
			}
			$tag_list = $this->do_tag->get_tag_list_by_type($type, $tmp_city_id);
			
			$list[$k]['list'] = $tag_list;
		}

		$data['list'] = $list;
		$shop_tags = $this->do_tag->get_tag_by_shop($shop_id);
		$data['shop_tags'] = $shop_tags;

		$tag_id = $this->input->post("tag_id", true, array());
		if($tag_id){
			$exist = array_keys($shop_tags);
			$delete = array_diff($exist, $tag_id);
			$add = array_diff($tag_id, $exist);

			if($delete){
				foreach($delete as $v){
					$re = $this->do_tag->delte_shop_tag($shop_id, $v);
				}
				
			}
			if($add){
				foreach($add as $v){
					$add_data = array();
					$add_data['shop_id'] = $shop_id;
					$add_data['tag_id'] = $v;
					$re = $this->do_tag->add_shop_tag($add_data);
				}
			}
			echo "<script language='javascript'>alert('保存信息成功！') ;window.location.href='/admin/addshop/shoplist/' ;</script>" ;
			return;
		}


		$this->load->admin_view('admin/editshop_tag', $data);	
	}


}



