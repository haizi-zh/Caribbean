<div class="container" style="margin-top:50px;margin-bottom:150px;">
商户:<?php echo $shop_info['name'];?>

<table class="table table-bordered">
 <thead>
    <tr>
      <th>交通方式</th>
      <th>描述</th>
      <!--<th>简介描述</th>
      <th>排序</th>
      <th>line</th>-->
      <th>操作</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($type_lists as $k => $v):?>
    <tr>
      <th><?php echo $v;?></th>
      <th><?php if($list && isset($list[$k])) echo $list[$k]['description'];?></th>
      <!--<th><?php if($list && isset($list[$k])) echo $list[$k]['description_simple'];?></th>
      <th><?php if($list && isset($list[$k])) echo $list[$k]['level'];?></th>-->
      <th><a href="/admin/directions/add_type/?shop_id=<?php echo $shop_id;?>&id=<?php if($list && isset($list[$k]))  echo $list[$k]['id'];?>&type=<?php echo $k;?>" class="btn btn-info">编辑</a></th>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>






</div>