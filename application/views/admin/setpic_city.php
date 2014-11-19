<div class="container" style="margin-top:50px;">
<?php foreach ($areas as $area) :?>

<div style="color:red;font-size:17px;"><?php echo $area['name'];?></div>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>城市名称</th>
      <th>前台状态</th>
      <th>操作</th>
      <th>首页排名(默认1000，0则排名最靠前)</th>
      <th>选择浮层排名(默认1000，0则排名最靠前)</th>
      <th>编辑</th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach($area_citys[$area['id']] as $city):?>
    <tr>

      <th><?php echo $city['name'];?></th>
      <th><?php echo $status[$city['reserve_1']]?></th>
      <th>
      <?php if($city['reserve_1']):?>
      <a class="btn btn-danger" href="javascript:;" onclick="city_show(<?php echo $city['id'];?>);">显示</a>
      <?php else:?>
      <a class="btn btn-primary" href="javascript:;" onclick="city_hidden(<?php echo $city['id'];?>);">隐藏</a>
      <?php endif;?>
      </th>
      <th><input type="text" class="input-small" id="level_<?php echo $city['id'];?>" name="level" value="<?php echo $city['level'];?>" /><button onclick="set_city_level(<?php echo $city['id'];?>);" type="button" class="btn">修改排序</button></th>
      <th><input type="text" class="input-small" id="level_top_<?php echo $city['id'];?>" name="level_top" value="<?php echo $city['level_top'];?>" /><button onclick="set_city_level_top(<?php echo $city['id'];?>);" type="button" class="btn">修改排序</button></th>
      <th><a class="btn btn-link" href="/admin/setpic/city_modify?id=<?php echo $city['id'];?>">编辑</a></th>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
<?php endforeach?>
</div>
