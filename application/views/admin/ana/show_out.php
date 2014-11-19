<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">
页面内部点击统计
<div class="row-fluid">
    <div class="span12 well well-large form-horizontal bs-docs-example">
    <form class="/admin/ana/show_out">
            <div class="input-prepend">
              <label class="control-label" style="width:120px;">时间:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="day" name="day" value="<?php if(isset($day) && $day) echo $day;?>">
            </div>
            <button class="btn btn-large btn-primary" type="submit" style="margin-left:25px;">筛选</button>
    </form>
    </div>
</div>


<div style="width:100%;float:left;">


<table class="table table-bordered">
 <thead>
    <tr>
      <th>来自</th>
      <th colspan="2">访问</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($simple) && $simple):?>
    <?php $i=0;?>
  	<?php foreach($simple as $k=>$item):?>
  	<?php arsort($item);?>
  	<tr colspan="3">
  		<td rowspan="<?php echo count($item)+1;?>" colspan=""><?php echo $k;?><?php echo $ana_urls[$k]['name'];?>(<?php echo $to_type_list[$k];?>)</td>
  		<td>
  		</td>
  		<td>
  		</td>
  	</tr>
  	<?php foreach($item as $kk=>$vv):?>
  	<tr colspan="2">
  	<td><?php echo $ana_urls[$kk]['name'];?>--<?php echo $kk;?></td>
  	<td><?php echo $vv;?></td>
	</tr>
	<?php endforeach;?>

    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>

</div>
</div>