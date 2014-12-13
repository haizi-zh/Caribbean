<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑归属</legend>

           <div class="control-group">
                <label class="control-label" style="width:100px;">发布时间:</label>
                <div class="controls" style="margin-left:80px;">
                  <input style="width:120px;" value="<?=( !empty($dianping_info) && $dianping_info['ctime'] )?date('Y-m-d H:i:s',$dianping_info['ctime']):date('Y-m-d H:i',time());?>" validate="{required:true}"  class="text5" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" id="ctime" name="ctime" />
                </div>
           </div>

           <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="dianping_ping_ctime(<?php echo $dianping_id;?>);"id="add_discount">修改</button>
	    </div>
	</div>
</div>

