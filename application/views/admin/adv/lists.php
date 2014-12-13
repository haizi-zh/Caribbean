<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">
<a href="/admin/adv/add" class="btn btn-link">添加</a> <a href="/admin/adv/index/?status=0" class="btn btn-link">正常的列表</a>  <a href="/admin/adv/index/?status=1" class="btn btn-link">被删除的列表</a> 
<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>id</th>
      <th>名称</th>
      <th>位置</th>
      <th>url</th>
      <th>国家</th>
      <th>城市</th>
      <th>商店</th>
      <th>排除城市</th>
      <th>排除商店</th>
      <th>排除coupoon_id</th>
      <th>level</th>
      <th>图片</th>
      <th>创建/修改</th>
      <th>编辑</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['name'];?></th>
      <th><?php echo $adv_types[$v['type']];?></th>
      <th><?php echo $v['url'];?></th>
      <th><?php echo $v['country_name'];?></th>
      <th><?php echo $v['city_name'];?></th>
      <th><?php echo $v['shop_name'];?></th>
      <th><?php echo $v['n_city_name'];?></th>
      <th><?php echo $v['n_shop_name'];?></th>
      <th><?php echo $v['n_coupon_id'];?></th>
      
      <th><?php echo $v['level'];?></th>
      <th><img src="<?php echo $imgdomain;?><?php echo $v['pic'];?>" width="50" height="50"/></th>
      <th title="创建<?php echo date('Y-m-d H:i:s', $v['ctime']);?>修改<?php echo date('Y-m-d H:i:s', $v['mtime']);?>"><?php echo date('Y-m-d', $v['ctime']);?></br><?php echo date('Y-m-d', $v['mtime']);?></th>
      <th>
      <a href="/admin/adv/add/?id=<?php echo $v['id'];?>" >编辑</a>
      </th>

      <th>
      <?php if($v['status'] == 0):?>
      <a href="javascript:;" action-type="delete_adv" id="<?php echo $v['id'];?>">删除</a>
      <?php else:?>
      <a href="javascript:;" action-type="recover_adv" id="<?php echo $v['id'];?>">恢复</a>
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




