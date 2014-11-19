<?php
class tag{
  const SHOP_URL = "/%s/%s/";// 微博客搜索的地址s	
  //const TIPS_URL = "/shoptipsinfo/%s/%s";
  const TIPS_URL = "/shoptipsinfo/%s/";
	public static function render_tag($content, $is_target=false) {
		$is_target = $is_target ? 1 : 0;
		$content = str_replace("＃", "#", $content);
		$content = str_replace ( '&#039;', '\'', $content );
		$content = str_replace ( '&#39;', '\'', $content );
		$str = preg_replace("/#([^#]+?)#/ise", "self::strip_tag('\\1','\\0', {$is_target})", $content);
		return $str;
	}
	
    public static function tag_to_link($content, $urls) {
        $out = array();
        preg_match_all("/#(.*?)#/is", $content, $out);
        if (empty($out[0]) || !is_array($out[0]) || $out[1][0] == "")
            return $content;
        foreach ($out[1] as $kk => $tag) {
            $source_str = $out[0][$kk];
            //$url = sprintf($search_domain, urlencode(urlencode(htmlspecialchars_decode($tag))));
            $replace_str = '<a style="color:blue;" target="_blank" href="' . $urls[$kk] . '">' . $tag . '</a>、';
            $replace_str = mb_substr($replace_str, 0, -1, 'UTF-8');
            $content = str_replace($source_str, $replace_str, $content);
        }
        return $content;
    }


	public static function strip_tag($str, $link_word, $is_target=false ) {
		$str = trim($str);
		if($str == ""){
			return "##";
		}
		$shops = context::get('shop_list', array());
		$tips = context::get('tips_list', array());
		$shop_city_lowernames = context::get('shop_city_lowernames', array());

		$target = $is_target ? ' target="_blank"' : '';
		$str = strip_tags($str);
		$link_word = strip_tags($link_word);
	    //增大字符的长度 
		if(mb_strwidth($str) > 80) {
	        $str = mb_strimwidth($str, 0, 80,'','UTF-8');
	    }
	    $shop_id = 0;
	    $tips_info = array();
	    $word = substr($link_word, 1, -1);
	    $word_nospace = str_replace(array(" "," ", "    ","（","）","(",")","&nbsp;", "\r\n","\r", "\n"), "", $word);
	    
	    if (isset( $shops[$word])) {
	    	 $shop_id = $shops[$word];
	   	}elseif(isset( $shops[$word_nospace])){
	   		 $shop_id = $shops[$word_nospace];
	   	}elseif(isset( $tips[$word])){
	   		$tips_info = $tips[$word];
	    }else{
	    	foreach ($shops as $key => $value) {
	    		if (strpos($key, $word)) {
	    			$shop_id = $value;
	    			break;
	    		}
	    	}
	    }
	   	if(!$shop_id && !$tips_info){
	   		return $str;
	   	}
	   	
	    if($shop_id){
	    	if(!isset($shop_city_lowernames[$shop_id])){
	    		return $str;
	    	}
	    	$city_lower_name =  $shop_city_lowernames[$shop_id];
			$url = sprintf(self::SHOP_URL, $city_lower_name, $shop_id);

			$str = '<a class="pink_link" action-url-shop-id="'.$shop_id.'" href="'.$url.'"'.$target.'>'.$word.'</a>';
	    }else{
	    	//$url = sprintf(self::TIPS_URL, $tips_info['city'], $tips_info['id']);
	    	$url = sprintf(self::TIPS_URL, $tips_info['id']);

	    	$str = '<a class="pink_link" href="'.$url.'"'.$target.'>'.$word.'</a>';
	    }
	    //$str = '<a href="'.$url.'"'.$target.'>'.$link_word.'</a>';

	    
		return $str;
	}

}

