<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class operation extends ZB_Controller {
	
	#更新首页轮播图片
	public function update_home_pics(){
		try{
			#获取参数
/* 			$img1 = isset($_POST['img1'])?$_POST['img1']:'';
			$link1 = isset($_POST['link1'])?$_POST['link1']:'';
			$img2 = isset($_POST['img2'])?$_POST['img2']:'';
			$link2 = isset($_POST['link2'])?$_POST['link2']:'';
			$img3 = isset($_POST['img3'])?$_POST['img3']:'';
			$link3 = isset($_POST['link3'])?$_POST['link3']:'';
			$img4 = isset($_POST['img4'])?$_POST['img4']:'';
			$link4 = isset($_POST['link4'])?$_POST['link4']:'';
			 */
			$img1 = $this->input->post('img1', true, '');
			$link1 = $this->input->post('link1', true, '');
			$img2 = $this->input->post('img2', true, '');
			$link2 = $this->input->post('link2', true, '');
			$img3 = $this->input->post('img3', true, '');
			$link3 = $this->input->post('link3', true, '');
			$img4 = $this->input->post('img4', true, '');
			$link4 = $this->input->post('link4', true, '');
			
			#拼装
			$value = array(array('img'=>$img1,'link'=>$link1),array('img'=>$img2,'link'=>$link2),array('img'=>$img3,'link'=>$link3),array('img'=>$img4,'link'=>$link4));
			
			#入库
			$this->load->model('mo_operation');
			$this->mo_operation->update_home_pics(1,$value);#1业务号代表首页轮播图片
			
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	#添加品牌
	public function addbrand(){
		try{
			#获取参数
/* 			$name = isset($_POST['name'])?$_POST['name']:'';
			$ename = isset($_POST['ename'])?$_POST['ename']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$img = isset($_POST['img'])?$_POST['img']:'';
			$property = isset($_POST['property'])?$_POST['property']:'';
			$big_pic = isset($_POST['big_pic'])?$_POST['big_pic']:'';
			$rank_score = isset($_POST['rank_score'])?$_POST['rank_score']:''; */
			
			$name = $this->input->post('name', true, '');
			$ename = $this->input->post('ename', true, '');
			$desc = $this->input->post('desc', true, '');
			$img = $this->input->post('img', true, '');
			$property = $this->input->post('property', true, '0');
			$big_pic = $this->input->post('big_pic', true, '');
			$rank_score = $this->input->post('rank_score', true, '');
			$ebusiness_id = $this->input->post('ebusiness_id', true, '');
			
			$eb_name = $this->input->post('eb_name', true, '');
			$eb_url = $this->input->post('eb_url', true, '');
			if($eb_url){
				if(substr($eb_url, 0 , 4)!='http'){
					$eb_url = "http://".$eb_url;
				}
			}

			$first_char = tool::format_first_char($name);

			#拼装
			$branddata = array(
				'name' => $name,
				'english_name' => $ename,
				'pic' => $img,
				'big_pic' => $img,
				'desc' => $desc,
				//'first_char' => substr( $ename, 0, 1 ),
				'first_char' => $first_char,
				'property' => $property,
				'rank_score' => $rank_score,
				'ebusiness_id' => $ebusiness_id,
				'eb_name' => $eb_name,
				'eb_url' => $eb_url,
			);
		
			#入库
			$this->load->model('mo_brand');
			$this->mo_brand->add_brand($branddata);
			
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	#编辑品牌
	public function editbrand(){
		try{
			#获取参数
/* 			$id = isset($_POST['id'])?$_POST['id']:'';
			$name = isset($_POST['name'])?$_POST['name']:'';
			$ename = isset($_POST['ename'])?$_POST['ename']:'';
			$desc = isset($_POST['desc'])?$_POST['desc']:'';
			$small_img = isset($_POST['small_img'])?$_POST['small_img']:'';
			$big_img = isset($_POST['big_img'])?$_POST['big_img']:'';
			$property = isset($_POST['property'])?$_POST['property']:'';
			$rank_score = isset($_POST['rank_score'])?$_POST['rank_score']:''; */
			
			$id = $this->input->post('id', true, '');
			$name = $this->input->post('name', true, '');
			$ename = $this->input->post('ename', true, '');
			$desc = $this->input->post('desc', true, '');
			$small_img = $this->input->post('small_img', true, '');
			$big_img = $this->input->post('big_img', true, '');
			$property = $this->input->post('property', true, '0');
			$rank_score = $this->input->post('rank_score', true, '');
			$ebusiness_id = $this->input->post('ebusiness_id', true, 0);
			$eb_name = $this->input->post('eb_name', true, '');
			$eb_url = $this->input->post('eb_url', true, '');
			$brandtag_ids = $this->input->post("brandtag_ids", true, '');
			
			if($eb_url){
				if(substr($eb_url, 0 , 4)!='http'){
					$eb_url = "http://".$eb_url;
				}
			}
			$first_char = $this->tool->format_first_char($name);
			if($brandtag_ids){
				if(substr($brandtag_ids,-1,1) == ","){
					$brandtag_ids = substr($brandtag_ids, 0, -1);
				}
				$tmp = explode(",", $brandtag_ids);
				$brandtag_ids = $tmp;
			}else{
				$brandtag_ids = array();
			}
			
			#拼装
			$branddata = array(
					'id' => $id,
					'name' => $name,
					'english_name' => $ename,
					'pic' => $small_img,
					'desc' => $desc,
					//'first_char' => substr( $ename, 0, 1 ),
					'first_char' => $first_char,
					'property' => $property,
					'big_pic' => $big_img,
					'rank_score' => $rank_score,
					'ebusiness_id' => $ebusiness_id,
					'eb_name' => $eb_name,
					'eb_url' => $eb_url,
			);
		
			#入库
			$this->load->model('mo_brand');
			$this->load->model('do/do_brandtag');
			$this->mo_brand->update_brand($branddata);
		
			$brandtag = $this->do_brandtag->get_brandtag_by_shop($id);
			$data['brandtag'] = $brandtag;

			$exist = array_keys($brandtag);
			$delete = array_diff($exist, $brandtag_ids);
			$add = array_diff($brandtag_ids, $exist);

			if($delete){
				foreach($delete as $v){
					$re = $this->do_brandtag->delte_index_tag($id, $v);
				}
				
			}
			if($add){
				foreach($add as $v){
					$add_data = array();
					$add_data['brand_id'] = $id;
					$add_data['brandtag_id'] = $v;
					$re = $this->do_brandtag->add_index_tag($add_data);
				}
			}

			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
	
		}catch(Exception $e){
			
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

	public function delete_brand(){
		try{
			$brand_id = $this->input->post('brand_id', true, 0);

			#入库
			$this->load->model('mo_brand');
			$this->mo_brand->delete(array('brand_id'=>$brand_id));
		
			#返回
			echo 1;	
		}catch(Exception $e){
			echo 0;
		}
	}
	
	#根据首字母，获取品牌html
	public function getbrandhtml(){
		try{
			#获取参数
			//$char = isset($_POST['char'])?$_POST['char']:'';
			$char = $this->input->post('char', true, '');
			
			#查询
			$this->load->model('mo_brand');
			$brands = $this->mo_brand->get_brands_by_first_char($char,10000);
			

			#渲染
			$data['brands'] = $brands;
			$html = $this->load->view("template/admin_brand",$data,true);

			/*
			$html = '';
			$basic_html = '<div style="margin-top:10px;padding:5px;border:1px dashed gray;margin-right: 10px;width: 200px;float: left;"><p>id：%s</p><p>默认名称：%s </p><p>备选名称：%s</p><p>描述：%s</p><p>小图片：<img src="%s" width="40" height="40"></p><p>大图片：<img src="%s" width="80" height="80"></p></div>';
			foreach($brands as $brand){
				$segment_data = array();
				$segment_data[] = $brand['id'];
				$segment_data[] = $brand['name'];
				$segment_data[] = $brand['english_name'];
				$segment_data[] = $brand['desc'];
				$segment_data[] = $brand['pic'];
				$segment_data[] = $brand['big_pic'];
				$html .= vsprintf($basic_html, $segment_data);
			}
			*/
			#返回
			echo $html;
		
		}catch(Exception $e){
		}
	}
}