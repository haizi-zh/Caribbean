<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">


问题反馈
<table class="table table-bordered">
 <thead>
    <tr>
      <th>id</th>
      <th>类型</th>
      <th>uid</th>
      <th>link</th>
      <th>email</th>
      <th>问题</th>
      <th>创建时间</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $v['id'];?></th>
      <th><?php if(isset($types[$v['type']])) echo $types[$v['type']];?></th>
      <th><?php if($v['uid'] && isset($v['uid'])) echo $v['uid'];?><a target="_blank" href="/myprofile?uid=<?php if($v['uid'] && isset($v['uid'])) echo $v['uid'];?>">查看</a></th>
      <th><?php if($v['link'] && isset($v['link'])) echo $v['link'];?></th>
      <th><?php if($v['email'] && isset($v['email'])) echo $v['email'];?></th>

      <th><?php if($v['content'] && isset($v['content'])) echo $v['content'];?></th>
      <th><?php if($v['ctime'] && isset($v['ctime'])) echo date("Y-m-d H:i:s", $v['ctime']);?></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>

<div class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div>




</div>