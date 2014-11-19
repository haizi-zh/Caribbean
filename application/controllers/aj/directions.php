<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class directions extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_directions');
	}
	// ALTER TABLE  `zb_coupon` ADD  `country_ids` VARCHAR( 100 ) NOT NULL default '' AFTER  `brand_id` 
	public function add_type(){

		$this->config->load('errorcode',TRUE);
		try{
			$id = $this->input->post('id', true, 0);
			$shop_id = $this->input->post('shop_id', true, '');
			$description = $this->input->post('description', true, 0);
			$description_simple = $this->input->post('description_simple', true, '');
			$description_url = $this->input->post('description_url', true, '');
			$description_url_simple = $this->input->post('description_url_simple', true, '');
			$type = $this->input->post('type', true, 0);
			$level = $this->input->post('level', true, 1000);
			$line_children = $this->input->post('line_children', false, '');

			$this->config->load('env',TRUE);
			$ctime = time();
			$status = 0;
			$add_data = array(
					'shop_id' => $shop_id,
					'description' => $description,
					'description_simple' => $description_simple,
					'description_url' => $description_url,
					'description_url_simple' => $description_url_simple,
					'type'=>$type,
					'level'=>$level,
					'ctime'=>$ctime,
					'status' => $status,
					);
			
			#入库
			$exist = $this->mo_directions->get_exist_type($shop_id, $type);
			if($id){
				if($exist && $exist['id'] != $id){
					$code = '204';
					echo json_encode(array('code'=>$code,'msg'=>'此交通方式已存在'));
					exit();
				}
				$this->mo_directions->update($add_data, $id);
			}else{
				//检查type是否存在
				if($exist){
					$code = '204';
					echo json_encode(array('code'=>$code,'msg'=>'此交通方式已存在'));
					exit();
				}
				$id = $this->mo_directions->add($add_data);
			}

			if (!$id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			$now = time();
			$directions_id = $id;
			if($line_children){
				foreach($line_children as $v){
					$level = $v['level'];
					$children = $v['children'];
					$tmp = array();
					foreach($children as $vv){
						$type = $vv['type'];
						$name = $vv['name'];
						$line_id = $vv['data'];
						$value = $vv['value'];
						$tmp[$type]['type'] = $type;
						$tmp[$type][$name] = $value;
						$tmp[$type]['id'] = $line_id;
						$tmp[$type]['level'] = $level;
						$tmp[$type]['directions_id'] = $directions_id;
					}
					foreach($tmp as $vvv){
						if($vvv['id']){
							$add_data = array();
							$add_data['item_type'] = $vvv['type'];
							$add_data['description'] = $vvv['description'];
							$add_data['description_url'] = $vvv['description_url'];
							$add_data['level'] = $vvv['level'];
							$add_data['mtime'] = $now;
							$this->mo_directions->update_line($add_data, $vvv['id']);
						}else{
							$add_data = array();
							$add_data['directions_id'] = $vvv['directions_id'];
							$add_data['item_type'] = $vvv['type'];
							$add_data['description'] = $vvv['description'];
							$add_data['description_url'] = $vvv['description_url'];
							$add_data['level'] = $vvv['level'];
							$add_data['mtime'] = $now;
							$add_data['ctime'] = $now;
							$this->mo_directions->add_line($add_data);
						}
					}
				}
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($id) && $id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}
	}
	public function delete_type(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$re = $this->mo_directions->delete_type(array('id' => $id));
		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

	public function recover_type(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$re = $this->mo_directions->recover_type(array('id' => $id));
		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}


	public function add_line(){
		$this->config->load('errorcode',TRUE);
		try{
			$id = $this->input->post('id', false, '');
			$directions_id = $this->input->post('directions_id', false, '');
			$description = $this->input->post('description', true, 0);
			$description_url = $this->input->post('description_url', true, '');
			$title = $this->input->post('title', true, '');
			$title_url = $this->input->post('title_url', true, '');
			$level = $this->input->post('level', true, 1000);
			$this->config->load('env',TRUE);
			$ctime = time();
			$status = 0;
			$add_data = array(
					'directions_id' => $directions_id,
					'description' => $description,
					'description_url' => $description_url,
					'title' => $title,
					'title_url' => $title_url,
					'level'=>$level,
					'ctime'=>$ctime,
					'status' => $status,
					);
			#入库
			if($id){
				$id = $this->mo_directions->update_line($add_data, $id);
			}else{
				$id = $this->mo_directions->add_line($add_data);
			}
			if (!$id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($id) && $id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}
	}

	public function delete_line(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$re = $this->mo_directions->delete_line(array('id' => $id));
		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

	public function recover_line(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$re = $this->mo_directions->recover_line(array('id' => $id));
		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

}