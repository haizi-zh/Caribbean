<div class="container" style="margin-top:50px;margin-bottom:150px;width:87%;">

<table class="table table-bordered">
  微信列表列表
 <thead>
    <tr>
      <th>ID</th>
      <th>uid</th>
      <th>名称</th>
      <th>微信时间</th>
      <th>抓取时间</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['uid'];?>
        -<?php echo $user_infos[$v['uid']]['nick'];?>
        (<?php echo $user_infos[$v['uid']]['wkey'];?>)
      </th>
      <th><?php echo $v['title'];?><a target="_blank" href="<?php echo $v['wurl'];?>" style="color:blue;">查看</a></th>
      
      <th><?php echo time::format_time($v['wtime']);?></th>
      <th><?php echo time::format_day($v['ctime']);?></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>


</div>

