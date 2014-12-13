<div class="container" style="margin-top:50px;margin-bottom:150px;">



<a href="/admin/brandtag/edit" class="btn btn-link">添加品牌电商标签</a>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>名称</th>
      <th>编辑</th>
      <th>删除</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?> 
    <?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo htmlspecialchars($v['name']);?></th>
      <th><a href="/admin/brandtag/edit?id=<?php echo $v['id'];?>" class="btn btn-link">修改</a></th>
      <th><a href="javascript:;" class="btn btn-link" action-type="delete_tag" action-data="<?php echo $v['id'];?>">删除</a></th> 
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
</div>






