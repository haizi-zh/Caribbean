<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">
<div class="btn-group">
  <button class="btn btn:focus"><a href="/admin/discount/discount_list">正常的列表</a></button>
  <button class="btn"><a href="/admin/discount/discount_list/?status=1">删除的列表</a></button>
</div>
<div class="row-fluid">
    <div class="span12 well well-large form-horizontal bs-docs-example">
    <form class="/admin/dianping/ping">

            <div class="input-prepend">
              <label class="control-label" style="width:60px;">id:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="id" name="id" value="<?php echo $id?>">
            </div>
            
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">商家id:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="shop_id" name="shop_id" value="<?php echo $shop_id?>">
            </div>
            
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">折扣正文:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="body" name="body" value="<?php echo $body?>">
            </div>

            <input type="hidden" id="status" name="status" value="<?php echo $status;?>" />
            <button class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;">筛选</button>
    </form>

    </div>
</div>
<h3>
<?php if($status==0) echo "正常的列表";else echo "删除的列表";?>
</h3>

<?php $status = array(0=>'正常',1 =>'删除');?>
<?php $outofdate = array(0=>'未',1 =>'过期');?>
<?php $now = time();?>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>ID</th>
      <th>商家</th>
      <th>折扣正文</th>
      
      <th>状态</th>
      <th>恢复/删除</th>
      <th>编辑</th>
      <th>编辑seo</th>
      <th>创建时间</th>
      <th>编辑时间</th>
      <th>是否过期</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo $v['id'];?></th>
      <th><a target="blank" href="/shop/<?php echo $v['shop_info']['id'];?>"><?php if($v['shop_info'] && isset($v['shop_info']['name'])) echo $v['shop_info']['name'];?></a></th>
      <th action onclick="show(<?php echo $v['id'];?>)"  id="clean_body_<?php echo $v['id'];?>" ><?php echo $v['clean_body'];?></th>
      <th onclick="hidden(<?php echo $v['id'];?>)" id="body_<?php echo $v['id'];?>" style="display:none"><?php echo $v['body'];?></th>

      <th style="color:red;"><?php echo $status[$v['status']];?></th>
      <?php if($v['status']== 0):?>
      <th><a href="javascript:;" class="btn btn-link btn-primary"  onclick="delete_discount(<?php echo $v['id']?>)">删除</a></th>
      <?php else:?>
      <th><a href="javascript:;" class="btn btn-link btn-primary"  onclick="recover_discount(<?php echo $v['id']?>)">恢复</a></th>
      <?php endif;?>
      <th><a target="_blank" class="btn btn-link btn-primary"  href="/admin/discount/edit/?id=<?php  echo $v['id'];?>">编辑</a></th>
      <th><a target="_blank" class="btn btn-link btn-primary"  href="/admin/discount/edit_seo/?id=<?php  echo $v['id'];?>">编辑seo</a></th>
      <th><?php echo date("Y-m-d H:i:s", $v['ctime']);?></th>
      <th><?php if($v['mtime']) echo date("Y-m-d H:i:s", $v['mtime']);?></th>
      <th><?php if($v['etime'] && $v['etime'] < $now ) echo "过期"; else echo "未";?></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
<div class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div>

</div>