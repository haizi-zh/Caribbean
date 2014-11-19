<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">
<a href="/admin/content/add" class="btn btn-link">添加</a>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>类型</th>
      <th>名称</th>
      <th>内容</th>
      <th>编辑</th>
      <th>删除</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?> 
    <?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo $ana_type_list[$v['type']];?></th>
      <th><?php echo htmlspecialchars($v['name']);?>
      <a href="/admin/ana/coupon/?show_coupon_id=<?php echo $v['id'];?>" class="btn btn-large btn-primary" >查看统计</a>
      </th>
      <th><?php echo htmlspecialchars($v['desc_content']);?></th>
      <th><a href="/admin/content/add?id=<?php echo $v['id'];?>" class="btn btn-link">修改</a> </th>
      <th><a href="/admin/content/del?id=<?php echo $v['id'];?>" class="btn btn-link">删除</a> </th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
</div>






