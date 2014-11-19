<?php
//define your token
require_once  './application/third_party/weixin/wechat.class.php';
function logdebug($text){
    file_put_contents('/tmp/log.txt',$text."\n",FILE_APPEND);        
};
$options = array(
    'token'=>'hongjun', //填写你设定的key
    'debug'=>true,
    'logcallback'=>'logdebug'
);

$weObj = new Wechat($options);
$weObj->valid();

//getRevID
$getRevEvent = $weObj->getRevEvent();
file_put_contents('/tmp/log.txt',print_r($getRevEvent, true)."\n",FILE_APPEND);

//MENU_KEY_MENU_CITY
//MENU_KEY_MENU_REC

if($getRevEvent){
    if($getRevEvent['key'] == "MENU_KEY_MENU_CITY"){
        $weObj->text("请输入城市，查看城市攻略")->reply();
        exit;
    }
    if($getRevEvent['key'] == "MENU_KEY_MENU_REC"){
        $weObj->text("推荐新戏")->reply();
        exit;
    }
}

$type = $weObj->getRev()->getRevType();

file_put_contents('/tmp/log.txt',$type."\n",FILE_APPEND);   
$getRevFrom = $weObj->getRevFrom();
file_put_contents('/tmp/log.txt',$getRevFrom."\n",FILE_APPEND);

switch($type) {
    case Wechat::MSGTYPE_TEXT:
            $weObj->text("hello, I'm wechat")->reply();
            exit;
            break;
    case Wechat::MSGTYPE_IMAGE:
            break;
    default:
            $weObj->text("help info2")->reply();
}


public function getNews($tplInfo){
  $helplist = self::getHelpList($tplInfo);
  if(empty($helplist)){         //取出的数据为空的时候
      $tplInfo["content"] = '未找到相关结果哦，你可以尝试更换关键词再次搜索，或回复“帮助”查看搜索方法:)';
      return getText($tplInfo);
  }
  $tplInfo["articleCount"] = count($tplInfo) > 5 ? 5: count($tplInfo);
  $textTpl =  "<xml>
               <ToUserName><![CDATA[%s]]></ToUserName>
               <FromUserName><![CDATA[%s]]></FromUserName>
               <CreateTime>%s</CreateTime>
               <MsgType><![CDATA[%s]]></MsgType>
               <ArticleCount>%d</ArticleCount>
               <Articles>";
  $sendStr = sprintf($textTpl, $tplInfo["fromUsername"], $tplInfo["toUsername"], $tplInfo["createTime"], $tplInfo["msgType"], $tplInfo["articleCount"]);
  $itemTpl = "<item>
             <Title><![CDATA[%s]]></Title> 
             <Description><![CDATA[%s]]></Description>
             <PicUrl><![CDATA[%s]]></PicUrl>
             <Url><![CDATA[%s]]></Url>
             </item>";
  
  $index = 0;
  $numArr = self::getRandNumArr($tplInfo["articleCount"], 10);//= array(0, 1);//

  foreach ($helplist as $key => $item) {
    # code...
    //var_dump($numArr);
    if($index == $numArr[0]){
      $sendStr .= sprintf($itemTpl, $item["title"], $item["desc"], $item["picurl"], $item["url"]);
      $index++;
      array_shift($numArr);
    }
    else{
      $index++;
      continue;
    }
  }
  $sendStr .= "</Articles>
               <FuncFlag>1</FuncFlag>
               </xml>"; 
  return $sendStr;
}

/*

define("TOKEN", "hongjun");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();

$wechatObj->responseMsg();



class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to wechat world!";
                    $content = $this->get_by_url("http://zanbai.com/weixinapi/search/get_by_word?keyword={$keyword}");
                    $contentStr = $content;
                    $content_jsondecode = json_decode($content, true);
                    if($content_jsondecode['code'] == 200){
                        $msgType = "news";
                        $infos = $content_jsondecode['data'];
                        $resultStr = $this->format_img_content($fromUsername, $toUsername, $time, $msgType, $infos);
                    }else{
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    }
                	

                    file_put_contents("/tmp/weixin", $resultStr."\r\n", FILE_APPEND);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "123";
        	exit;
        }
    }
    public function format_img_content($fromUsername, $toUsername, $time, $msgType, $infos){
$textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<ArticleCount>1</ArticleCount>
<Articles>
<item>
<Title><![CDATA[%s]]></Title> 
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>
</Articles>
</xml>";
        foreach($infos as $v){
            $Title = $v['name'];
            $Description = $v['desc'];
            $PicUrl = $v['pic'];
            break;
        }
        $content = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $Title, $Description, $PicUrl, '');
        return $content;
    
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

    function get_by_url($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3600); 

        $contents = curl_exec($ch);
        curl_close($ch);

        return $contents;
    }

}*/