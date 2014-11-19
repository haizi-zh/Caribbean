<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">

<div style="width:15%;float:left;">
大洲列表
<table class="table table-bordered">
 <thead>
    <tr>
      <th>id</th>
      <th>名称</th>
      <th>english_name</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($areas) && $areas):?>
  	<?php foreach($areas as $k=>$v):?>
    <tr>
      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['name'];?></th>
      <th><?php echo $v['english_name'];?></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
</div>

<div style="width:30%;float:left;margin-left:10px;">
国家列表
<table class="table table-bordered">
 <thead>
    <tr>
      <th>id</th>
      <th>名称</th>
      <th>english_name</th>
      <th>area_id</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($countrys) && $countrys):?>
    <?php foreach($countrys as $k=>$v):?>
    <tr>
      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['name'];?></th>
      <th><?php echo $v['english_name'];?></th>
      <th><?php echo $v['area_id'];?>(<?php echo $areas[$v['area_id']]['name'];?>)</th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
</div>


<div style="width:50%;float:left;margin-left:10px;">
城市列表 

<table class="table table-bordered">
 <thead>
    <tr>
      <th>id</th>
      <th>名称</th>
      <th>english_name</th>
      <th>country_id</th>

    </tr>
  </thead>
  <tbody>
    <?php if(isset($citys) && $citys):?>
    <?php foreach($citys as $k=>$v):?>
    <tr>
      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['name'];?></th>
      <th><?php echo $v['english_name'];?></th>
      <th><?php echo $v['country_id'];?>(<?php echo $countrys[$v['country_id']]['name'];?>)</th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
</div>


</div>
