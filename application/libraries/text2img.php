<?php

class text2img{
	//$fontFile = 'msyh.ttc'; #字体文件名，请先拷贝一个字体到font目录下，然后修改此配置
	private $LibiFontStyle = "/var/www/htdocs/zan/system/fonts/msyh.ttf";
	private $LibiFontColor = "666";
	private $LibiBackColor = "FFFFFF";
	private $haveBrLinker = "";
	private $LibiWidth;
	private $Message;
	function __construct($options=array()){
		foreach($options as $key=>$val){
			if(!in_array($key,get_class_vars(get_class($this)))){
			continue;
			}else{
			$this->$key=$val;
			}
		}
	}

	private function str_div($str, $width = 10){
		$strArr = array();
		$len = strlen($str);
		$count = 0;
		$flag = 0;
		while($flag < $len){
		//echo $str[$flag].'<br>';
		if(ord($str[$flag]) > 128){
		$count += 1;
		$flag += 3;
		}
		else{
		$count += 0.5;
		$flag += 1 ;
		}
		if($count >= $width){
		$strArr[] = substr($str, 0, $flag);
		$str = substr($str, $flag);
		$len -= $flag;
		$count = 0;
		$flag = 0;
		}
		}
		$strArr[] = $str;
		return $strArr;
	}
	private function str2rgb($str)
	{
		$color = array('red'=>0, 'green'=>0, 'blue'=>0);
		$str = str_replace('#', '', $str);
		$len = strlen($str);
		if($len==6){
		$arr=str_split($str,2);
		$color['red'] = (int)base_convert($arr[0], 16, 10);
		$color['green'] = (int)base_convert($arr[1], 16, 10);
		$color['blue'] = (int)base_convert($arr[2], 16, 10);
		return $color;
		}
		if($len==3){
		$arr=str_split($str,1);
		$color['red'] = (int)base_convert($arr[0].$arr[0], 16, 10);
		$color['green'] = (int)base_convert($arr[1].$arr[1], 16, 10);
		$color['blue'] = (int)base_convert($arr[2].$arr[2], 16, 10);
		return $color;
		}
		return $color;
	}
	 
	public function text2img($text, $file_path){
		if($text==''){
			$this->Message = "没有文字";
			return false;
		}
		$text = substr($text, 0, 30000); #截取前一万个字符
		$paddingTop = 3;
		$paddingLeft = 15;
		$paddingBottom = 3;
		$copyrightHeight = 36;
		 
		$canvasWidth = 500;
		$canvasHeight = $paddingTop + $paddingBottom + $copyrightHeight;
		 
		$fontSize = 12;
		$lineHeight = intval($fontSize * 1.6);
		 
		$textArr = array();
		$tempArr = explode("\n", trim($text));
		$j = 0;
		foreach($tempArr as $v){
			$arr = $this->str_div($v, 25);
			$textArr[] = array_shift($arr);
			foreach($arr as $v){
				$textArr[] = $this->haveBrLinker . $v;
				$j ++;
				if($j > 100){ break; }
			}
			$j ++;
			if($j > 100){ break; }
		}
		 
		$textLen = count($textArr);
		 
		$canvasHeight = $lineHeight * $textLen + $canvasHeight;
		$im = imagecreatetruecolor($canvasWidth, $canvasHeight); #定义画布
		$colorArray = $this->str2rgb($this->LibiBackColor);
		imagefill($im, 0, 0, imagecolorallocate($im, $colorArray['red'], $colorArray['green'], $colorArray['blue']));
		 
		 /*
		$colorArray = $this->str2rgb('000000');
		$colorLine = imagecolorallocate($im, $colorArray['red'], $colorArray['green'], $colorArray['blue']);
		$padding = 3;
		$x1 = $y1 = $x4 = $y2 = $padding;
		$x2 = $x3 = $canvasWidth - $padding - 1;
		$y3 = $y4 = $canvasHeight - $padding - 1;
		imageline($im, $x1, $y1, $x2, $y2, $colorLine);
		imageline($im, $x2, $y2, $x3, $y3, $colorLine);
		imageline($im, $x3, $y3, $x4, $y4, $colorLine);
		imageline($im, $x4, $y4, $x1, $y1, $colorLine);
		*/
		 
		//字体路径
		if(!is_file($this->LibiFontStyle)){
			$this->Message = "字体文件不存在！";
			return false;
		}
		//写入四个随即数字
		$colorArray = $this->str2rgb($this->LibiFontColor);
		$fontColor = imagecolorallocate($im, $colorArray['red'], $colorArray['green'], $colorArray['blue']);
		 
		foreach($textArr as $k=>$text){
			$offset = $paddingTop + $lineHeight * ($k + 1) - intval(($lineHeight-$fontSize) / 2);
			imagettftext($im, $fontSize, 0, $paddingLeft, $offset, $fontColor, $this->LibiFontStyle, $text);
		}
		
		//header('Content-Type: image/png');
		imagejpeg($im, $file_path);
		//imagedestroy($im);

	}
}