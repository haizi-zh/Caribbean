<div class="container" style="margin-top:50px;margin-bottom:150px;">



<a href="/admin/taglist/edit" class="btn btn-link">添加分类名称</a>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>分类名称</th>
      <th>编辑</th>
      <th>标签列表</th>
      <th>添加标签</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?> 
    <?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo htmlspecialchars($v['name']);?></th>
      <th><a href="/admin/taglist/edit?id=<?php echo $v['id'];?>" class="btn btn-link">修改分类名称</a></th>
      <th>
        <?php if(isset($v['list'])):?>
        <?php foreach($v['list'] as $item):?>
        <a style="align:right" href="/admin/taglist/tags_edit?type=<?php echo $v['id'];?>&id=<?php echo $item['id'];?>" class="btn btn-link">编辑</a><?php echo $item['name'];?> <?php if($item['city_id']) echo " - ". $citys[$item['city_id']]['name'];?></br>
        <?php endforeach;?>
        <?php endif;?>
      </th>
      <th>
        <a href="/admin/taglist/tags_edit?type=<?php echo $v['id'];?>" class="btn btn-link">添加标签</a>
      </th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
</div>






