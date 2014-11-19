<div class="container" style="margin-top:50px;margin-bottom:150px;width:87%;">

<table class="table table-bordered">
  商户列表
 <thead>
    <tr>
      <th>ID</th>
      <th>商店名称</th>
      <th>英文名称</th>
      <th>城市</th>
      <th>国家</th>

    </tr>
  </thead>
  <tbody>
    <?php if(isset($shops) && $shops):?>
  	<?php foreach($shops as $k=>$v):?>
    <?php if($v['status'] != 0) continue;?>
    <tr>

      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['name'];?><a target="_blank" href="/shop/?shop_id=<?php echo $v['id'];?>" style="color:blue;">前台</a></th>
      <th><?php echo $v['english_name'];?></th>
      <th><?php echo $citys[$v['city']]['name'];?></th>
      <th><?php echo $countrys[$v['country']]['name'];?></th>

    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>


</div>

