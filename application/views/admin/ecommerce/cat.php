<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">



<a href="/admin/ecommerce/add_cat" class="btn btn-link">添加电商分类名称</a>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>分类名称</th>
      <th>显示顺序</th>
      <th>编辑</th>
      <th>网址</th>
      <th>添加网址</th>
      
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?> 
    <?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo htmlspecialchars($v['name']);?></th>
      <th><?php echo htmlspecialchars($v['level']);?></th>
      <th><a href="/admin/ecommerce/add_cat?id=<?php echo $v['id'];?>" class="btn btn-link">修改分类名称</a> <a href="javascript:;" action-type="del_cat" action-data="<?php echo $v['id'];?>" class="btn btn-link">删除</a> </th>

      <th>
        <?php if($v['links']):?>
        <table  class="table table-bordered">
<thead>
<tr>
<th>网址名称</th>
<th>网址</th>
<th>显示顺序</th>
<th>编辑</th>
</tr>
</thead>
<tbody>
<?php foreach($v['links'] as $link):?>
<tr>
<th><?php echo $link['name'];?></th>
<th><?php echo $link['url'];?></th>
<th><?php echo $link['level'];?></th>
<th><a target="_blank" href="/admin/ecommerce/add_link?id=<?php echo $link['id'];?>" class="btn btn-link">修改</a> <a href="javascript:;" action-type="del_link" action-data="<?php echo $link['id'];?>" class="btn btn-link">删除</a></th>
</tr>
<?php endforeach;?>
</tbody>
        </table>
<?php endif;?>
      </th>
<th><a target="_blank" href="/admin/ecommerce/add_link?cat_id=<?php echo $v['id'];?>" class="btn btn-link">添加网址</a></th>


    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
</div>






