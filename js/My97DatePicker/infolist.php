<?php
$this->load->helper('Html');
$Html = new Html();
$Html->showMasterHead();
?>
<script>
function checkmoreoptions(objNam, msg, msg2){    
    if(!chkCheckBoxChs(objNam)){
        alert(msg2);
        return false;
    }else{
        if(confirm(msg)){
            return true;
        }else{
            return false;
        }
    }
}

function moreoptions(){
    var optionname = $("#moreselect").val();
    var msg = "";
    if (optionname == 'recommend1'){
        msg = "你确定要进行批量设置推荐操作吗？";
    }else if(optionname == 'recommend2'){
        msg = "你确定要进行批量取消推荐操作吗？";
    }else if(optionname == 'winning1'){
        msg = "你确定要进行批量设置中奖操作吗？";
    }else if(optionname == 'winning2'){
        msg = "你确定要进行批量取消中奖操作吗？";
    }else if(optionname == 'moredel'){
        //msg = "你确定要进行批量删除操作吗？";
        alert("为数据安全考虑，多选删除操作已被屏蔽，如有此需要，请联程序开发管理员");
        return false;
    }else{
        alert("请您选择要进行的操作");
        return false;
    }
    if(checkmoreoptions('infoIds[]', msg, '请选择要操作的数据')){
        $('#infoForm').submit();
    }
} 
</script>
</head>
<body>
<!--bodytitle start-->
<div class="bodytitle">
  <div class="bodytitleleft"></div>
  <div class="bodytitletxt">作品管理 - 作品列表</div>
  <div class="bodytitletxt2"></div>
</div>
<!--bodytitle end-->
<!--search start-->
<table width="100%" border=0 align=center cellpadding="5" cellspacing=1 class=tbtitle style="background: #cad9ea;">
  <tr bgcolor="#f5fafe">
    <td align="center">
      <form name="searchForm" id="searchform" method="get" action="">
        <div align="left">
                    昵称:<input class="searchTopInput" type="text" name="search[addressee]" value="<?php echo $search['addressee']?>" id="addressee" >
                    内容:<input class="searchTopInput" type="text" name="search[letterinfo]" value="<?php echo $search['letterinfo']?>" id="letterinfo" >
                    网名:<input class="searchTopInput" type="text" name="search[sender]" value="<?php echo $search['sender']?>" id="sender" >
                    手机号:<input class="searchTopInput" type="text" name="search[sendernumber]" value="<?php echo $search['sendernumber']?>" id="sendernumber" >
                    发送给<select name="search[sendtotype]" id="sendtotype">
<option value=''>请选择</option>
                      <option value="1" <?php echo $search['sendtotype']=="1"?"selected":"";?>>亲人</option>
                      <option value="2" <?php echo $search['sendtotype']=="2"?"selected":"";?>>爱人</option>
                      <option value="3" <?php echo $search['sendtotype']=="3"?"selected":"";?>>朋友</option>
                      <option value="4" <?php echo $search['sendtotype']=="4"?"selected":"";?>>其他</option>
</select>
                    是否推荐<select name="search[recommend]" id="recommend">
<option value=''>请选择</option>
                      <option value="1" <?php echo $search['recommend']=="1"?"selected":"";?>>推荐</option>
                      <option value="2" <?php echo $search['recommend']=="2"?"selected":"";?>>正常</option>
</select>
                    是否中奖<select name="search[winning]" id="winning">
<option value=''>请选择</option>
                      <option value="1" <?php echo $search['winning']=="1"?"selected":"";?>>中奖</option>
                      <option value="2" <?php echo $search['winning']=="2"?"selected":"";?>>未中奖</option>
</select>
<!--
                    创建时间:<?php echo $Html->showInputDateTime(array('name'=>'search[createtime]','value'=>empty($search['createtime'])?'':$search['createtime'],'id'=>'createtime','format'=>'yyyy-MM-dd', 'startDate'=>'%y-%M-01'));?>
-->
                    <input type="hidden" name="orderby" value="<?php echo $orderby;?>">
          <input type="hidden" name="dir" value="<?php echo $dir;?>">
          每页显示<input type="text" name="pagesize" id="pagesize" style="width:25px;" value="<?php echo $pagesize;?>" onkeyup="value=value.replace(/[^\d]/g,'') "onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" >
          <input type="submit"  id="button" value="搜索"/>
          <input type="button"  id="button2" onclick="window.location.href='/index.php/master/work_info/infolist'" value="重置" />
        </div>
      </form>
    </td>
  </tr>
</table>
<!--search end-->
<!--list start-->
<?php if($dir == "ASC" || empty($dir)){$dir = "DESC";}else{$dir = "ASC";};?>
<form name="infoForm" id="infoForm" action="/index.php/master/work_info/setstate" method="post">
<table width="100%" border=0 align=center cellpadding="5" cellspacing=1 class="tbtitle tbhover">
  <tr class="title">  
  <th nowrap="nowrap" align="center"><div align="center" class="STYLE2">选择</div></th>      
    <th align="center" nowrap="nowrap"><a href="#this" onclick="Sort('searchform', 'addressee', '<?php echo $dir;?>')">收件人昵称</a><?php if($orderby == 'addressee') echo "<img src='/public/style/admin/images/$dir.GIF'>"; ?></th>
    <th align="center" nowrap="nowrap"><a href="#this" onclick="Sort('searchform', 'sender', '<?php echo $dir;?>')">发件人网名</a><?php if($orderby == 'sender') echo "<img src='/public/style/admin/images/$dir.GIF'>"; ?></th>
    <th align="center" nowrap="nowrap"><a href="#this" onclick="Sort('searchform', 'sendernumber', '<?php echo $dir;?>')">发件人手机号</a><?php if($orderby == 'sendernumber') echo "<img src='/public/style/admin/images/$dir.GIF'>"; ?></th>
    <th align="center" nowrap="nowrap"><a href="#this" onclick="Sort('searchform', 'sendtotype', '<?php echo $dir;?>')">发送给</a><?php if($orderby == 'sendtotype') echo "<img src='/public/style/admin/images/$dir.GIF'>"; ?></th>
    <th align="center" nowrap="nowrap"><a href="#this" onclick="Sort('searchform', 'paper_info_id', '<?php echo $dir;?>')">选择的信纸</a><?php if($orderby == 'paper_info_id') echo "<img src='/public/style/admin/images/$dir.GIF'>"; ?></th>
    <th align="center" nowrap="nowrap"><a href="#this" onclick="Sort('searchform', 'workimage', '<?php echo $dir;?>')">生成的图片作品</a><?php if($orderby == 'workimage') echo "<img src='/public/style/admin/images/$dir.GIF'>"; ?></th>
    <th align="center" nowrap="nowrap"><a href="#this" onclick="Sort('searchform', 'recommend', '<?php echo $dir;?>')">是否推荐</a><?php if($orderby == 'recommend') echo "<img src='/public/style/admin/images/$dir.GIF'>"; ?></th>
    <th align="center" nowrap="nowrap"><a href="#this" onclick="Sort('searchform', 'winning', '<?php echo $dir;?>')">是否中奖</a><?php if($orderby == 'winning') echo "<img src='/public/style/admin/images/$dir.GIF'>"; ?></th>
    <th align="center" nowrap="nowrap"><a href="#this" onclick="Sort('searchform', 'createtime', '<?php echo $dir;?>')">创建时间</a><?php if($orderby == 'createtime') echo "<img src='/public/style/admin/images/$dir.GIF'>"; ?></th>
    <th align="center">操作</th>
  </tr>
  <?php
   $i = 0;
   foreach($infos as $key => $value){ 
   $i++;
  ?>
  <tr  class="<?php echo $i % 2 == 0?'tbbg':''; ?>">
  <td><input type="checkbox" class="check" name="infoIds[]" value="<?php echo $value['id'];?>" /></td>
    <td  style="text-align:left;"><?php echo $value['addressee'];?></td>
    <td  style="text-align:left;"><?php echo $value['sender'];?></td>
    <td ><?php echo $value['sendernumber'];?></td>
    <td ><?php echo $value['sendtotype']==1?'亲人':'';?>
<?php echo $value['sendtotype']==2?'爱人':'';?>
<?php echo $value['sendtotype']==3?'朋友':'';?>
<?php echo $value['sendtotype']==4?'其他':'';?>
</td>
    <td ><?php echo $value['pname']?></td>
    <td ><img src="<?php echo $value['workimage'];?>" width="100px" height="50px" ></td>
    <td ><?php echo $value['recommend']==1?'推荐':'';?>
<?php echo $value['recommend']==2?'正常':'';?>
</td>
    <td ><?php echo $value['winning']==1?'中奖':'';?>
<?php echo $value['winning']==2?'未中奖':'';?>
</td>
    <td ><?php echo $value['createtime'];?></td>
    <td nowrap="nowrap">
      <img src='/public/style/admin/images/icon_folder.gif'><a href="/index.php/master/work_info/deloneinfo?id=<?php echo $value['id'];?>" onclick="javascript:return confirm('您确定要删除吗?');">删除</a>
      <img src='/public/style/admin/images/table_multiple.png'><a href="/index.php/master/work_info/detailinfo?id=<?php echo $value['id'];?>">查看详细</a>
    </td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="11" style="text-align: left">
      <input type="checkbox" id="checkall" name="checkall" onclick="javascript:checkAll('checkall');" />全选
      <select name="moreselect" id="moreselect">
        <option>请选择</option>
        <option value="recommend1">设置推荐</option>
        <option value="recommend2">取消推荐</option>
        <option value="winning1">设置中奖</option>
        <option value="winning2">取消中奖</option>
        <option value="moredel">删除</option>
      </select>
						<input type="button" value='确定' id="sub" onclick="return moreoptions();" title="确定">
    </td>
  </tr>
  <tr>
    <td colspan="11">
      <center><?php echo $pagenav;?></center>
    </td>
  </tr>
</table>
</form>
<!--list end-->
</body> 
</html>