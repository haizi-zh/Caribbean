<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class brandimport extends ZB_Controller {
	
	
	const filename = 'missing_brands.csv';
	
	public function import(){
		
		$file=fopen($_FILES['file']['tmp_name'],"r");
		$this->load->model('mo_brand');
		while(!feof($file))
		{
			$line = fgets($file);
			
			#没有内容
			if(!$line) continue;
			$lien = str_replace('"','',trim($line));
			$pieces = explode(',',$line);
			$brand = $pieces[0];
			$second_name = isset($pieces[1])?$pieces[1]:'';
			
			if($brand == '') continue;
			$first_char = substr($brand,0,1);
			$data = array(
					'name' => $brand,
					'english_name' => $brand,
					'first_char' => strtoupper($first_char),
// 					'property' => 1, #mo_brand::DEPARTMENT,
					);
			$this->mo_brand->add_brand($data);
		}
		fclose($file);
	}
	
	public function import_brand(){		
		$this->config->load('errorcode',TRUE);
		$shop_id = $this->input->get('shop_id', TRUE);
		if(!$shop_id) {
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}
		
		$this->load->model('mo_brand');
		$this->load->model('mo_shop');
		
		$shopinfo_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		$shop = isset($shopinfo_re[$shop_id])?$shopinfo_re[$shop_id]:array();
		
		#获取品牌列表
		$file=fopen($_FILES['file']['tmp_name'],"r");
		$brand_names = array();
		while(!feof($file)){
			$brand_names[] = trim(fgets($file));
		}
		fclose($file);
		#品牌导入
		/*
		$re = $this->mo_brand->get_id_by_name($brand_names);
		foreach($re as $each){
			$data = array();
			$data['shop_id'] = $shop_id;
			$data['shop_property'] = $each['property'];
			$data['city'] = $shop['city'];
			$data['brand_id'] = $each['brand_id'];
			$this->mo_shop->add_index_brand_shop($data);
		}
		
		$find_brand_names = array_keys($re);
		$brand_names = self::convert_to_lower($brand_names);
		$find_brand_names = self::convert_to_lower($find_brand_names);

		$lost_brand = array_diff($brand_names, $find_brand_names);
		*/
		
		$lost_brand = array();
		foreach ($brand_names as $k => $name_more) {
			if (!$name_more) {
				continue;
			}
			$tmp_names = explode(" ", $name_more);

			if (count($tmp_names) == 1) {
				$tmp_names = explode(" ", $name_more);
			}
			$tmp = array();
			if (count($tmp_names) > 1) {
				$count = count($tmp_names);
				$last = $count -1;
				$last_name = $tmp_names[$last];
				$check_han = $this->utf8_str($last_name);

				if ($check_han) {
					$tmp[] = $last_name;
					array_pop($tmp_names);
					$tmp[] = implode(" ", $tmp_names);
				}else{
					$tmp[] = implode(" ", $tmp_names);
				}

				$tmp_names = $tmp;
			}
			//continue;
			$checked = 0;
			foreach ($tmp_names as $k2 => $name) {
				
				$name = trim($name);
				$name=trim(trim($name,"　"));  
				
				$re = $this->mo_brand->get_id_by_name_foradmin($name);
				
				if($re){
					foreach($re as $each){
						$data = array();
						$data['shop_id'] = $shop_id;
						$data['shop_property'] = $each['property'];
						$data['city'] = $shop['city'];
						$data['brand_id'] = $each['brand_id'];
						$r = $this->mo_shop->add_index_brand_shop($data);
					}
					$checked = 1;
				}else{
					$re = $this->mo_brand->get_id_by_englishname_foradmin($name);
					
					if($re){
						foreach($re as $each){
							$data = array();
							$data['shop_id'] = $shop_id;
							$data['shop_property'] = $each['property'];
							$data['city'] = $shop['city'];
							$data['brand_id'] = $each['brand_id'];
							$r = $this->mo_shop->add_index_brand_shop($data);
						}
						$checked = 1;
					}else{
						$name = tool::clean_blank($name);
						$re = $this->mo_brand->get_id_by_reserve1_foradmin($name);
						
						if($re){
							foreach($re as $each){
								$data = array();
								$data['shop_id'] = $shop_id;
								$data['shop_property'] = $each['property'];
								$data['city'] = $shop['city'];
								$data['brand_id'] = $each['brand_id'];
								$r = $this->mo_shop->add_index_brand_shop($data);
							}
							$checked = 1;
						}else{
							$r = 0;
							//$lost_brand[] = $name;
						}
					}
				}
				
			}
			if (!$checked) {
				$lost_brand[] = implode(" ", $tmp_names);
			}
		}
		if($lost_brand){
			$str = "";
			foreach($lost_brand as $brand){
				$str .= "{$brand}\n";
			}
		}
		$this->export_csv("missing_brands.csv", $str);

		exit();
		self::make_file($lost_brand);
		Header('Content-Disposition: attachment; filename="missing_brands.csv"'); 
        readfile(dirname(BASEPATH).DIRECTORY_SEPARATOR.'images/'.self::filename);
	}

	function export_csv($filename,$data) { 
	    header("Content-type:text/csv"); 
	    header("Content-Disposition:attachment;filename=".$filename); 
	    header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
	    header('Expires:0'); 
	    header('Pragma:public'); 
	    echo $data; 
	}

	function utf8_str($str){  
		$mb = mb_strlen($str,'utf-8');  
		$st = strlen($str);  
		if($st==$mb)  
		return 0;  
		if($st%$mb==0 && $st%3==0)  
		return 1;  
		return 1;  
	}  

	public function make_file($lost_brand){
		//$file_path = dirname(BASEPATH).DIRECTORY_SEPARATOR.'images/'.self::filename;
		$file_path = "/tmp/".self::filename;
		$re = @unlink($file_path);

		//chmod(dirname(BASEPATH).DIRECTORY_SEPARATOR.'images/', 777);
		//touch($file_path);
		file_put_contents($file_path, "");
		$re = chmod($file_path, 777);
		foreach($lost_brand as $brand){
			
			$re = file_put_contents($file_path, $brand."\n",FILE_APPEND);
			var_dump($re);
		}
	}

	public function convert_to_lower($names){
		$result = array();
		foreach($names as $name){
			$result[] = strtolower(trim($name));
		}
		return $result;
	}
}
