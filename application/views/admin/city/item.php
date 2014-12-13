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
            <input type="hidden" name="type" value="<?php echo $type;?>" />
            <input type="hidden" name="sid" value="<?php echo $sid;?>" />

    </form>

    </div>

</div>



<div style="width:100%;float:left;margin-left:10px;">
<?php echo htmlspecialchars($title);?>每日访问列表
</div>


<div id="container" style="min-width:700px;height:400px;width:<?php echo $width;?>%;"></div>
<script type="text/javascript">
$(document).ready(function(){

        $('#container').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -90,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                title: {
                    text: ''
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Tokyo',
                data: <?php echo $a_json;?>
            }]
        });

});
</script>
