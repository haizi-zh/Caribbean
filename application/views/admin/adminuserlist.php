<div class="container" style="margin-top:50px;margin-bottom:150px;">
后台用户管理 <a class="btn btn-large btn-primary" href="/admin/adminuser/add/">添加新用户</a>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>ID</th>
      <th>用户名称</th>
      <th>昵称</th>
      <th>权限</th>
      <th>编辑</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['username'];?></th>
      <th><?php echo $v['nikename'];?></th>
      <th style="color:red;"><?php if(isset($powers[$v['power']]))echo $powers[$v['power']];?></th>
      <th><a target="_blank" href="/admin/adminuser/add/?id=<?php  echo $v['id'];?>">编辑</a></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
<?php if(isset($page_html) && $page_html):?>
<div><?php echo $page_html;?></div>
<?php endif;?>
</div>