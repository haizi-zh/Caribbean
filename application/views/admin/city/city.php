<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">

<div class="row-fluid">
    <div class="span12 well well-large form-horizontal bs-docs-example">
    <form class="">
            <div class="input-prepend">
              <label class="control-label" style="width:120px;">开始时间:</label>
              <input type="text" onfocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" value="<?php if(isset($stime) && $stime) echo $stime; else echo date('Y-m-d');?>" name="stime" id="stime" readonly="readonly" style="width:45%;" class="bjyh_text Wdate">
            </div>
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">结束时间:</label>
              <input type="text" onfocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" value="<?php if(isset($etime) && $etime) echo $etime; else echo date('Y-m-d');?>" name="etime" id="etime" readonly="readonly" style="width:45%;" class="bjyh_text Wdate">
            </div>
            <div class="input-prepend">
            <button class="btn btn-large btn-primary" type="submit" style="margin-left:25px;">筛选</button>
            </div>
            <input type="hidden" name="order" value="<?php echo $order;?>" />


    </form>
<div class="input-prepend">
<a href="/admin/city/city_list/?order=1&stime=<?php echo $stime;?>&etime=<?php echo $etime;?>" class="btn btn-large btn-primary" >按id排序</a>
<a href="/admin/city/city_list/?order=2&stime=<?php echo $stime;?>&etime=<?php echo $etime;?>" class="btn btn-large btn-primary" >按点击从大到小</a> 
<a href="/admin/city/city_list/?order=3&stime=<?php echo $stime;?>&etime=<?php echo $etime;?>" class="btn btn-large btn-primary" >按点击从小到大</a>
</div>
    </div>

</div>



<div style="width:100%;float:left;margin-left:10px;">
城市列表 
<table class="table table-bordered">
 <thead>
    <tr>
      <th>id</th>
      <th>名称</th>
      <th>english_name</th>
      <th>country_id</th>
      <th>总访问量</th>
      <th>每日访问</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($citys) && $citys):?>
    <?php foreach($citys as $k=>$v):?>
    <tr>
      <th><?php echo $v['id'];?></th>
      <th><?php echo $v['name'];?></th>
      <th><?php echo $v['english_name'];?></th>
      <th><?php echo $v['country_id'];?>(<?php echo $countrys[$v['country_id']]['name'];?>)</th>
      <th><?php echo $city_count[$v['id']];?></th>
      <th><a target="_blank" class="btn btn-info" href="/admin/city/item/?type=<?php echo $type;?>&sid=<?php echo $v['id'];?>&stime=<?php echo $stime;?>&etime=<?php echo $etime;?>&title=<?php echo $v['name'];?>">查看</a></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
</div>


</div>

<!--
<div id="container" style="min-width:700px;height:400px;width:300%;"></div>
<script type="text/javascript">
$(document).ready(function(){
    console.log( $('#container'));
    
    $('#container').highcharts({
        chart: {
            type: 'column',
            margin: [ 50, 50, 100, 80]
        },
        title: {
            text: '访问量'
        },
        xAxis: {
            categories:<?php echo $n_json;?>,
            labels: {
                rotation: -45,
                align: 'right',
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '数值'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: '<b>{point.y:.1f} </b>',
        },
        series: [{
            name: 'Population',
            data: <?php echo $c_json;?>,
            dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#ff0000',
                align: 'right',
                x: 4,
                y: 10,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif',
                    textShadow: '0 0 3px black'
                }
            }
        }]
    });
});
</script>
-->