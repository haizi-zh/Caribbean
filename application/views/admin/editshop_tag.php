<div class="container" style="margin-top:50px;margin-bottom:150px;">

<?php echo $shop_info['name'];?>的标签列表


<form class="/admin/taglist/editshop_tag" method="post">
<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>分类名称</th>
      <th>标签列表</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?> 
    <?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo htmlspecialchars($v['name']);?></th>
      <th>
        <?php if(isset($v['list'])):?>
        <?php foreach($v['list'] as $item):?>
        <input type="checkbox" name="tag_id[]" id="tag_id[]" <?php if($shop_tags && isset($shop_tags[$item['id']])):?>checked<?php endif;?> value="<?php echo $item['id'];?>" /> <?php echo $item['name'];?></br>
        <?php endforeach;?>
        <?php endif;?>
      </th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
<button class="btn btn-large btn-primary" type="submit" style="float:right;">保存</button>
</div>


</form>





