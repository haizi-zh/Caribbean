<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">

<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
		<form class="/admin/dianping/comment">
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">回复内容:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="content" name="content" value="<?php echo $content?>">
            </div>
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">回复ID:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="dianping_id" name="dianping_id" value="<?php echo $dianping_id?>">
            </div>
            
            <input type="hidden" name="user_eight" id="user_eight" value="<?php echo $user_eight;?>" />
            <button class="btn btn-large btn-primary" type="submit" style="margin-right:100px;">筛选</button>
    </form>
    </div>
    <?php foreach($show_list as $k=>$item):?>
    <a class="btn btn-large btn-primary" href="/admin/dianping/ping/?user_eight=<?php echo $k;?>" style="margin-right:100px;"><?php echo $item;?></a>
    <?php endforeach;?>
</div>



<?php echo $show_list[$user_eight];?>


<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>ID</th>
      <th>评论uid</th>
      <th>评论用户昵称</th>
      <th>商家id</th>
      <th>商家</th>
      <th>对应点评id</th>
	  <th>评论</th>
      <th>创建时间</th>
      <th>状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['uid'];?></th>
      <th><?php echo $user_infos[$v['uid']]['uname'];?><a target="_blank" href="/myprofile?uid=<?php echo $v['uid'];?>" style="color:blue;">主页</a></th>
      <th><?php echo $v['shop_id'];?></th>
      <th><a target="_blank" href="/shop/<?php echo $v['shop_id']?>"><?php if(isset($shop_infos[$v['shop_id']]))echo $shop_infos[$v['shop_id']]['name'];?></a></th>
      <th><a target="_blank" href="/ping/<?php echo $v['dianping_id'];?>"><?php echo $v['dianping_id'];?></a></th>
      <th><?php echo htmlspecialchars($v['content']);?></th>
      <th><?php echo date('Y-m-d H:i:s', $v['ctime']);?></th>
      <th><?php echo $status[$v['status']];?></th>
      <th>
      <?php if($v['status'] == 0):?>
      <a href="javascript:;" onclick="delete_dianping_comment(<?php echo $v['id'];?>);">删除</a>
      <?php else:?>
      <a href="javascript:;" onclick="recover_dianping_comment(<?php echo $v['id'];?>);">恢复</a>
    <?php endif;?>
      </th>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>

<div class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div>


</div>




