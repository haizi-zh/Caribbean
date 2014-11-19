<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">
<div class="btn-group">
  <button class="btn btn:focus"><a href="/admin/discount/shoptips_list">正常的列表</a></button>
  <button class="btn"><a href="/admin/discount/shoptips_list/?status=1">删除的列表</a></button>
  <button class="btn"><a href="/admin/discount/shoptips_list/?status=3">只面向baidu列表</a></button>
</div>
<div class="row-fluid">
    <div class="span12 well well-large form-horizontal bs-docs-example">
    <legend>购物攻略</legend>
    <form class="/admin/dianping/ping">
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">id:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="id" name="id" value="<?php echo $id;?>">
            </div>
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">国家id:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="country_id" name="country_id" value="<?php echo $country_id;?>">
            </div>
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">城市id:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="city_id" name="city_id" value="<?php echo $city_id;?>">
            </div>
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">商家id:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="shop_id" name="shop_id" value="<?php echo $shop_id;?>">
            </div>
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">正文:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="body" name="body" value="<?php echo $body;?>">
            </div>

            <input type="hidden" id="status" name="status" value="<?php echo $status;?>" />
            <button class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;">筛选</button>
    </form>
    </div>
</div>
<h3>
<?php if($status==0) echo "正常的列表";else echo "删除的列表";?>
</h3>

<?php $status = array(0=>'正常',1 =>'删除',2=>"未发布",3=>"面向百度");?>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>ID</th>
      <th>国家</th>
      <th>城市</th>
      <th>商家</th>
      <th width="100">标题</th>
      <th width="100">正文</th>
      <th>显示级别</th>
      <th>状态</th>
      <th>恢复/删除</th>
      <th>发布</th>
      <th>编辑</th>
      <th>编辑seo</th>
      <th>创建时间</th>
      <th>编辑时间</th>
      <th>查看</th>
      <th>查看</th>
      <th>百度收录</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['country_name'];?></th>
      <th><?php echo $v['city_name'];?></th>
      <th><?php if($v['shop_info'] && isset($v['shop_info']['name'])) echo $v['shop_info']['name'];?></th>
      
      <th width="100"><?php echo $v['title'];?></th>

      <th width="100" action onclick="show(<?php echo $v['id'];?>)"  id="clean_body_<?php echo $v['id'];?>" ><?php echo $v['clean_body'];?></th>
      <th onclick="hidden(<?php echo $v['id'];?>)" id="body_<?php echo $v['id'];?>" style="display:none"><?php echo $v['body'];?></th>
      
      <th><?php echo $v['level'];?></th>
      <th style="color:red;"><?php echo $status[$v['status']];?></th>
      <?php if($v['status']== 0):?>
      <th ><a href="javascript:;" class="btn btn-link btn-primary"  onclick="delete_discount(<?php echo $v['id']?>)">删除</a></th>
      <?php elseif($v['status'] ==3):?>
      <th ><a href="javascript:;" class="btn btn-link btn-primary"  onclick="recover_discount(<?php echo $v['id']?>)">面向用户</a></th>
      <?php else:?>
      <th><a href="javascript:;" class="btn btn-link btn-primary"   onclick="recover_discount(<?php echo $v['id']?>)">恢复</a></th>
      <?php endif;?>
      <th > <?php if($v['status']== 2):?><a href="javascript:;" class="btn btn-link btn-primary"  onclick="publish_discount(<?php echo $v['id']?>)">发布</a><?php endif;?></th>
      <th><a target="_blank" class="btn btn-link btn-primary"   href="/admin/discount/edit/?id=<?php  echo $v['id'];?>">编辑</a></th>
      <th><a target="_blank" class="btn btn-link btn-primary"  href="/admin/discount/edit_seo/?id=<?php  echo $v['id'];?>">编辑seo</a></th>
      <th><?php echo date("Y-m-d H:i:s", $v['ctime']);?></th>
      <th><?php if($v['mtime']) echo date("Y-m-d H:i:s", $v['mtime']);?></th>


      <th>
        <?php if($v['city']):?>
        <?php 
        $city=$v['city'];
        $city_list = explode("," ,$city);
        ?>
        <?php foreach($city_list as $my_city):?>
        <?php if(!$my_city) continue;?>
        <a target="_blank" class="btn btn-link btn-primary"  href="/<?php echo $citys[$my_city]['lower_name'];?>-shoppingtips/?nocache=1"><?php echo $citys[$my_city]['name'];?>攻略列表</a>
        
        <?php endforeach;?>
        <?php endif;?>

        <?php if($v['country']):?>
        <a target="_blank" class="btn btn-link btn-primary"  href="/admin/discount/delete_shoptips_country_list/?country=<?php echo $v['country'];?>">清除国家攻略列表</a>
        <?php endif;?>

      </th>
      <th><a target="_blank" class="btn btn-link btn-primary"  href="/shoptipsinfo/<?php  echo $v['id'];?>/?nocache=1">攻略查看</a></th>
      <th>
        <?php 
        if(isset($baidu_infos[$v['id']]['stime']) && $baidu_infos[$v['id']]['stime']){
          echo "收录时间:".date("Y-m-d", $baidu_infos[$v['id']]['stime'])."<br>";
          if($baidu_infos[$v['id']]['stime'] != $baidu_infos[$v['id']]['nstime']){
            echo "最新收录时间:".date("Y-m-d", $baidu_infos[$v['id']]['nstime'])."<br>";
          }
        }else{
          echo "未收录";
        }

      ?>
      <br>
      <a target="_blank" class="btn btn-link btn-primary"  href="http://www.baidu.com/s?wd=<?php  echo $v['title'];?>">百度标题</a>
      <br>
      <a target="_blank" class="btn btn-link btn-primary"  href="http://www.baidu.com/s?wd=http://www.zanbai.com/shoptipsinfo/<?php  echo $v['id'];?>/">百度url</a>
      </th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>


<div class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div>


</div>