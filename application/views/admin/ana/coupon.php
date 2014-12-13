<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">

<div style="width:100%;float:left;">
coupon (只统计前一天以前的数据，页面无反应请隔2分钟再刷新) <a href="/admin/ana/coupon/?show_type=0&show_coupon_id=<?php echo $show_coupon_id;?>" class="btn btn-large btn-primary">查看/下载分开</a> <a href="/admin/ana/coupon/?show_type=1&show_coupon_id=<?php echo $show_coupon_id;?>" class="btn btn-large btn-primary">查看/下载一起</a> 

<?php if($show_type == 0):?>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>时间</th>
      <?php if($show_coupon_id):?>
      <th><?php echo $ana_content[$show_coupon_id]['name']."查看";?></th>
      <?php else:?>
      <?php foreach($ana_content as $v):?>
      <th><?php echo $v['name']."查看";?></th>
      <?php endforeach;?>
      <?php endif;?>

      <th >ALL查看</th>
      <?php if($show_coupon_id):?>
      <th><?php echo $ana_content[$show_coupon_id]['name']."下载";?></th>
      <?php else:?>
      <?php foreach($ana_content as $v):?>
      <th><?php echo $v['name']."下载";?></th>
      <?php endforeach;?>
      <?php endif;?>

      <th>ALL下载</th>
      <th>下载/查看比率</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($days) && $days):?>
    <?php $i=0;?>
  	<?php foreach($days as $k=>$day):?>
    <?php $i++;?>
    <?php $day_time = date("Y-m-d", $day);?>
    <tr <?php if($i%2==1):?>style="background-color:#f0f8ff;"<?php endif;?> >
      <th><?php echo $day_time;?></th>

      <?php if($show_coupon_id):?>
       <th><?php if(isset($ana_content[$show_coupon_id]['coupon_list'][$day])) echo $ana_content[$show_coupon_id]['coupon_list'][$day]; else echo 0;?></th>
      <?php else:?>
      <?php foreach($ana_content as $v):?>
      <th><?php if(isset($v['coupon_list'][$day])) echo $v['coupon_list'][$day]; else echo 0;?></th>
      <?php endforeach;?>
      <?php endif;?>

      <th style="background-color:red;"><?php if(isset($all_coupon[$day])) echo $all_coupon[$day]; else echo 0;?></th>

      <?php if($show_coupon_id):?>
      <th><?php if(isset($ana_content[$show_coupon_id]['download_list'][$day])) echo $ana_content[$show_coupon_id]['download_list'][$day]; else echo 0;?></th>
      <?php else:?>
      <?php foreach($ana_content as $v):?>
      <th><?php if(isset($v['download_list'][$day])) echo $v['download_list'][$day]; else echo 0;?></th>
      <?php endforeach;?>
      <?php endif;?>

      <th style="background-color:red;">
        <?php if(isset($all_download[$day])) echo $all_download[$day]; else echo 0;?>
      </th>
      <th style="background-color:red;">
        <?php if(isset($all_coupon[$day])) echo "".ceil(($all_download[$day]*100)/$all_coupon[$day]); else echo 0;?>％
      </th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
<?php endif;?>

<?php if($show_type == 1):?>
<table class="table table-bordered">
 <thead>
    <tr>
      <th>时间</th>
      <?php if($show_coupon_id):?>
      <th><?php echo $ana_content[$show_coupon_id]['name']."查看";?></th>
      <th><?php echo $ana_content[$show_coupon_id]['name']."下载";?></th>
      <?php else:?>
      <?php foreach($ana_content as $v):?>
      <th><?php echo $v['name']."查看";?></th>
      <th><?php echo $v['name']."下载";?></th>
      <?php endforeach;?>
      <?php endif;?>
      
      <th>ALL查看</th>
      <th>ALL下载</th>
      <th>下载/查看比率</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($days) && $days):?>
    <?php $i=0;?>
    <?php foreach($days as $k=>$day):?>
    <?php $i++;?>
    <?php $day_time = date("Y-m-d", $day);?>
    <tr <?php if($i%2==1):?>style="background-color:#f0f8ff;"<?php endif;?> >
      <th><?php echo $day_time;?></th>
      <?php if($show_coupon_id):?>
      <th><?php if(isset($ana_content[$show_coupon_id]['coupon_list'][$day])) echo $ana_content[$show_coupon_id]['coupon_list'][$day]; else echo 0;?></th>
      <th><?php if(isset($ana_content[$show_coupon_id]['download_list'][$day])) echo $ana_content[$show_coupon_id]['download_list'][$day]; else echo 0;?></th>
      <?php else:?>
      <?php foreach($ana_content as $v):?>
      <th><?php if(isset($v['coupon_list'][$day])) echo $v['coupon_list'][$day]; else echo 0;?></th>
      <th><?php if(isset($v['download_list'][$day])) echo $v['download_list'][$day]; else echo 0;?></th>
      <?php endforeach;?>
      <?php endif;?>

      <th style="background-color:red;"><?php if(isset($all_coupon[$day])) echo $all_coupon[$day]; else echo 0;?></th>
      <th style="background-color:red;">
        <?php if(isset($all_download[$day])) echo $all_download[$day]; else echo 0;?>
      </th>
      <th style="background-color:red;">
        <?php if(isset($all_coupon[$day])) echo "".ceil(($all_download[$day]*100)/$all_coupon[$day]); else echo 0;?>％
      </th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
<?php endif;?>


</div>
</div>