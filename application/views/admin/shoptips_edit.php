<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑购物攻略</legend>

           <div class="control-group">
              	<label class="control-label" style="width:60px;">商家id:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:500px;" placeholder="" id="shop_id" value="<?php echo $shoptips_info['shop_id'];?>">
              	</div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">显示级别:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="level" value="<?php echo $shoptips_info['level'];?>">(数字，显示级别从0开始优先显示，同级别按时间倒序，默认1000)
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">标题:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="title" value="<?php echo $shoptips_info['title'];?>">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">移动端标题:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="title_mobile" value="<?php echo $shoptips_info['title_mobile'];?>">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">分享到第三平台文案（100字以内）:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="share_content"><?php echo $shoptips_info['share_content'];?></textarea>
                </div>
           </div>
           <div class="control-group">
              	<label class="control-label" style="width:60px;">详情:##必须成对出现。:</label>
              	<div class="controls" style="margin-left:80px;width:800px;height:1000px;" id="my_content"></div>
           </div>


           <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" id="add_shoptips">添加并发布</button>
           <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" id="save_shoptips">保存</button>
	    </div>
	</div>
</div>

