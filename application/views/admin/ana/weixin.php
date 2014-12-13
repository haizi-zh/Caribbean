<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">

<div style="width:30%;float:left;">
微信统计
<table class="table table-bordered">
 <thead>
    <tr>
      <th>时间</th>
      <th>点击类型</th>
      <th>关键字</th>
    </tr>
  </thead>

  <tbody>
    <?php if(isset($list) && $list):?>
    <?php $i=0;?>
  	<?php foreach($list as $k=>$item):?>
    <?php $i++;?>
    <tr <?php if($i%2==1):?>style="background-color:#f0f8ff;"<?php endif;?> >
      <th><?php echo date("Y-m-d H:i:s", $item['ctime']);?></th>
      <th><?php echo $types[$item['type']];?></th>
      <th><?php if($item['keyword']) echo $item['keyword'];?></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>

</div>


<div style="width:30%;float:left;">
点击排名
<table class="table table-bordered">
 <thead>
    <tr>
      <th>点击类型</th>
      <th>点击数量</th>
    </tr>
  </thead>

  <tbody>
    <?php if(isset($click) && $click):?>
    <?php $i=0;?>
    <?php foreach($click as $type=>$count):?>
    <?php $i++;?>
    <tr <?php if($i%2==1):?>style="background-color:#f0f8ff;"<?php endif;?> >

      <th><?php echo $types[$type];?></th>
      <th><?php echo $count;?></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>

</div>


<div style="width:30%;float:left;">
用户输入排序
<table class="table table-bordered">
 <thead>
    <tr>
      <th>关键字</th>
      <th>数量</th>
    </tr>
  </thead>

  <tbody>
    <?php if(isset($words) && $words):?>
    <?php $i=0;?>
    <?php foreach($words as $keyword=>$count):?>
    <?php $i++;?>
    <tr <?php if($i%2==1):?>style="background-color:#f0f8ff;"<?php endif;?> >
      <th><?php echo $keyword;?></th>
      <th><?php echo $count;?></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>

</div>

</div>