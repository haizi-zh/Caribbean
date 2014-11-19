<div class="container" style="margin-top:50px;margin-bottom:150px;width:87%;">

<table class="table table-bordered">
  用户列表
 <thead>
    <tr>
      <th>ID</th>
      <th>名称</th>

    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $v['id'];?></th>
      <th>
        <?php echo $v['nick'];?>
        (<?php echo $v['wkey'];?>)
      </th>


    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>


</div>

