<div class="container" style="margin-top:50px;margin-bottom:150px;">
<a target="_blank" href="/admin/ebusiness/add" class="btn btn-link btn-primary">添加电商</a>

<?php $status = array(0=>'开放中',1 =>'关闭中');?>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>电商id</th>
      <th>电商名称</th>
      <th>电商logo</th>
      <th>状态</th>
      <th>开放/关闭</th>
      <th>编辑</th>
      
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo $v['id'];?></th>

      <th><?php echo $v['name'];?></th>
      <th><img src="<?php echo $v['logo'];?>" width="50" height="50" /></th>

      <th style="color:red;"><?php echo $status[$v['status']];?></th>
      <?php if($v['status']== 0):?>
      <th ><a href="javascript:;" onclick="delete_ebusiness(<?php echo $v['id']?>)">关闭</a></th>
      <?php else:?>
      <th><a href="javascript:;" onclick="recover_ebusiness(<?php echo $v['id']?>)">开放</a></th>
      <?php endif;?>
      <th><a target="_blank" href="/admin/ebusiness/add/?id=<?php  echo $v['id'];?>">编辑</a></th>

    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>

<div class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div>



</div>