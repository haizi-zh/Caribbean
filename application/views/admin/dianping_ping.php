<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">

<div class="row-fluid">
    <div class="span12 well well-large form-horizontal bs-docs-example">
    <form class="form-inline">
              <div class="input-prepend">
                <label class="control-label" style="width:60px;">晒单id:</label>
                <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="id" name="id" value="<?php echo $id?>">
              </div>
              <div class="input-prepend">
                <label class="control-label" style="width:60px;">晒单内容:</label>
                <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="content" name="content" value="<?php echo $content?>">
              </div>
              <div class="input-prepend">
                <label class="control-label" style="width:60px;">商家ID:</label>
                <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="shop_id" name="shop_id" value="<?php echo $shop_id?>">
              </div>
              <div class="input-prepend">
                <label class="control-label" style="width:60px;">商家名称:</label>
                <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="shop_name" name="shop_name" value="<?php echo $shop_name?>">
              </div>
              <div class="input-prepend">
                <label class="control-label" style="width:60px;">创建人uid:</label>
                <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="uid" name="uid" value="<?php echo $uid?>">
              </div>
              <div class="input-prepend">
                <label class="control-label" style="width:60px;">创建人昵称:</label>
                <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="user_nick" name="user_nick" value="<?php echo $user_nick?>">
              </div>
              <div class="input-prepend">
                <label class="control-label" style="width:60px;">置顶:</label>
                <select style="height:25px;margin-left:25px;width:100px;" name="top" id="top">
                <?php foreach($top_list as $k=>$v):?>
                <option <?php if($top == $k):?>selected=true<?php endif;?> value="<?php echo $k;?>"><?php echo $v;?></option>
                <?php endforeach;?>
                </select>
              </div>
              <div class="input-prepend">
                <label class="control-label" style="width:60px;">状态:</label>
                <select style="height:25px;margin-left:25px;width:100px;" name="status" id="status">
                <?php foreach($status_list as $k=>$v):?>
                <option <?php if($status == $k):?>selected=true<?php endif;?> value="<?php echo $k;?>"><?php echo $v;?></option>
                <?php endforeach;?>
                </select>
              </div>

            <input type="hidden" name="user_eight" id="user_eight" value="<?php echo $user_eight;?>" />

            <button class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;">筛选</button>
    </form>
    <?php foreach($show_list as $k=>$item):?>
    <a class="btn btn-large btn-primary" href="/admin/dianping/ping/?user_eight=<?php echo $k;?>" style="margin-right:100px;"><?php echo $item;?></a>
    <?php endforeach;?>

    </div>

</div>
<?php echo $show_list[$user_eight];?>
<table class="table table-bordered">
 <thead>
    <tr>
       <th>序号</th>
      <th>ID</th>
      <th>评分</th>
      <th>正文(点击看详情)</th>
      <th>uid</th>
      <th>用户</th>
      <th>商家id</th>
      <th>商家</th>
      <th>创建时间</th>
      <th>修改时间</th>
      <th>状态</th>
      <th>操作</th>
      <th>置顶</th>
      <th>预览</th>
      <th>创建人账号</th>
      <th>归属编辑</th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach($list as $k=>$v):?>
    <?php 

      $student = false;
      if($v['uid'] && isset($user_infos[$v['uid']])){
        $user_info = $user_infos[$v['uid']];
        if($user_info['pwd'] == "e10adc3949ba59abbe56e057f20f883e"){
          $student = true;
        }
      }
    ?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['score'];?></th>

      <th onclick="show(<?php echo $v['id'];?>)"  id="clean_body_<?php echo $v['id'];?>" ><?php echo $v['clean_body'];?></th>
      <th onclick="hidden(<?php echo $v['id'];?>)" id="body_<?php echo $v['id'];?>" style="display:none"><?php echo $v['body'];?></th>

      <th><?php echo $v['uid'];?><a target="_blank" href="/myprofile?uid=<?php echo $v['uid'];?>" style="color:blue;">主页</a></th>
      <th><?php if(isset($user_infos[$v['uid']]) && $user_infos[$v['uid']]['uname'] ) echo $user_infos[$v['uid']]['uname'];?></th>
      <th><?php echo $v['shop_id'];?></th>
      <th><?php if($v['shop_id'] && isset($shop_infos[$v['shop_id']])) echo $shop_infos[$v['shop_id']]['name']; else echo "商店不存在";?>－－－<a style="color:green;" target="_blank" href="/shop/<?php echo $v['shop_id']?>">查看</a></th>
      <th><?php echo date('Y-m-d H:i:s', $v['ctime']);?></th>

      <th>
      <a href="/admin/dianping/dianping_ping_ctime/?dianping_id=<?php echo $v['id'];?>" target="_blank" class="btn btn-info">修改时间</a>
      </th>

      <th <?php if($v['status'] != 0):?>style="color:red;"<?php endif;?>><?php echo $status_list[$v['status']];?></th>
      <th>
      <?php if($v['status'] == 0):?>
      <a href="javascript:;" onclick="delete_dianping(<?php echo $v['id'];?>);" class="btn btn-danger">删除</a>
      <?php else:?>
      <a href="javascript:;" onclick="recover_dianping(<?php echo $v['id'];?>);" class="btn btn-primary">恢复</a>
      <?php endif;?>
      </th>

      <th>
      <?php if($v['top'] == 0):?>
      <a href="javascript:;" onclick="top_dianping(<?php echo $v['id'];?>,<?php echo $v['status'];?>);" class="btn btn-danger">置顶</a>
      <?php else:?>
      <a href="javascript:;" onclick="untop_dianping(<?php echo $v['id'];?>);" class="btn btn-primary">取消置顶</a>
      <?php endif;?>
      </th>

      <th>
      <a href="/ping/<?php echo $v['id'];?>" target="_blank" class="btn btn-info">预览</a>
      </th>
      <th>
      <?php if($student) echo $user_infos[$v['uid']]['email'];else echo "外部用户";?><a href="/ping/<?php echo $v['id'];?>" target="_blank" class="btn btn-info">预览</a>
      </th>
      <th>
      <?php if($student):?>
      <a href="/admin/dianping/dianping_ping_modify/?dianping_id=<?php echo $v['id'];?>" target="_blank" class="btn btn-info">归属编辑</a>
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




