<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "");

define("weixin_help_old", '');

define("weixin_help", '');


define("weixin_newuser",'');

define("weixin_notfound",'');

$wechatObj = new wechatCallbackapiTest();

//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
    //用于给微信服务器发送信息，验证网站合法性
	  public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }else{
            return false;
        }
    }

    //校验微信服务器发来的信息
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
	  
    public function responseMsg()
    {
    //get post data, May be due to the different environments
        $tplInfo = self::initInfo();

        $tplInfo["msgType"] = "news";
        
        $kw = trim($tplInfo["keyword"]);
        switch( true ){
          case ( $kw === "1" ):
          //主要是为了将1和支教助学在cache中存的是相同的key
            $tplInfo["keyword"] = "1";
            $tplInfo["type"] = "1";
            $sendStr = self::getNews($tplInfo);
            break;   
          case ( $kw === "7" || $kw == "帮助" || $kw === "help" ):
            $tplInfo["content"] = weixin_help;
            $tplInfo["msgType"] = "text";
            $sendStr = self::getText($tplInfo);
            break;   
          case ( $kw === "Hello2BizUser"):
            $tplInfo["content"] = weixin_newuser;
            $tplInfo["msgType"] = "text";
            $sendStr = self::getText($tplInfo);
            break;
          case ( $kw === "notfound"):
            $tplInfo["content"] = weixin_notfound;
            $tplInfo["msgType"] = "text";
            $sendStr = self::getText($tplInfo);
            break;
          case ( $kw === "info"):
            $tplInfo["content"] = $tplInfo["fromUsername"];
            $tplInfo["msgType"] = "text";
            $sendStr = self::getText($tplInfo);
            break;
          default:
            //$tplInfo["keyword"] = "";
            //$tplInfo["content"] = '请输入正确的关键字，输入"帮助"得到帮助信息';
            //$sendStr = self::getNews($tplInfo, $helplist);
            //$sendStr = self::getText($tplInfo);

            $tplInfo["content"] = $tplInfo["keyword"];
            $sss = $tplInfo["keyword"];
            $tplInfo["content"] = "";
            for($num = 0; $num < strlen($sss); $num++)
                $tplInfo["content"] .= chr(10).ord(substr($sss,$num,1));
            //$tplInfo["content"] = chr(230).chr(10).ord(substr($sss,0,1));
            //$tplInfo["content"] = strlen($sss);
            $tplInfo["msgType"] = "text";
            $sendStr = self::getText($tplInfo);
        }
        echo $sendStr;


    }
    /*
     * @return  array
     *
     * 初始化微信服务器传过来的数据到一个数组中
     */
    public function initInfo(){
      $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
      $tplInfo = array();
      $tplInfo["fromUsername"] = $postObj->FromUserName;
      $tplInfo["toUsername"] = $postObj->ToUserName;
      $tplInfo["keyword"] = ($postObj->Content==="") ? "1" : $postObj->Content;
      $tplInfo["createTime"] = time();
      $tplInfo["articleCount"] = 5;
      return $tplInfo;
    }

    public function getMsg(){

    }

    /*
     * @param  array  包含参数信息的数组
     * @return string 微信服务器接收的格式化字符串
     *
     */
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
     * @param  array  包含参数信息的数组
     * @return string 微信服务器接收的格式化字符串
     *
     */
    public function getText($tplInfo){
      $textTpl =  "<xml>
                   <ToUserName><![CDATA[%s]]></ToUserName>
                   <FromUserName><![CDATA[%s]]></FromUserName>
                   <CreateTime>%s</CreateTime>
                   <MsgType><![CDATA[%s]]></MsgType>
                   <Content><![CDATA[%s]]></Content>
                   <FuncFlag>0</FuncFlag>
                   <Articles>";
      return sprintf($textTpl, $tplInfo["fromUsername"], $tplInfo["toUsername"], $tplInfo["createTime"], $tplInfo["msgType"], $tplInfo["content"]);
    }

    public function getMusic($tplInfo){

    }

    public function getHelpList($tplInfo = array()){
      $mysql = new SaeMysql();
      $sql = "select * from `helplist`";
      $helplist = $mysql->getData( $sql );
      return $helplist;
    }

    /*
     * @param   int     返回数组内元素的个数
     * @param   int     选取数字的上限
     * @return  array   返回数组
     * 
     * 例如：参数为（3,10）时返回array（2,4,7）
     * 返回3个元素，这三个元素的大小从0-10中随机选取
     */
    public function getRandNumArr($retAmount, $sum){
      $retArr = array();
      for($num = 0; $num < $retAmount;){
        $tmp = rand(0, $sum - 1);
        if(!in_array($tmp, $retArr)){
          $retArr[] = $tmp;
          $num++;
        }
        else
          continue;
      }
      sort($retArr);
      return $retArr;
    }

/*
	public function mysql_test($content){
	     $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
        if($link)
        {
           $re = mysql_select_db(SAE_MYSQL_DB,$link);
           $sql = "insert into info set reason = '{$content}'";
           mysql_query($sql, $link);
        }
	}
*/

}
