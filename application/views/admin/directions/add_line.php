<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加line</legend>
           <div class="control-group">
                <label class="control-label" style="width:60px;">标题:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="title"><?php if($info) echo $info['title'];?></textarea>
                </div>
                如果有文字带链接,请用英文##把文字包起来。如:#something# #something_two#
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;">标题url:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="title_url"><?php if($info) echo $info['title_url'];?></textarea>
                </div>
                存储上文中链接对应的url,多个请用英文竖线分割。如 http://baidu.com/|http://163.com
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;">描述:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="description"><?php if($info) echo $info['description'];?></textarea>
                </div>
                如果有文字带链接,请用英文##把文字包起来。如:#something# #something_two#
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;">描述url:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="description_url"><?php if($info) echo $info['description_url'];?></textarea>
                </div>
                存储上文中链接对应的url,多个请用英文竖线分割。如 http://baidu.com/|http://163.com
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;">显示级别:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:200px;" placeholder="" id="level" value="<?php if($info) echo $info['level'];?>">(数字，显示级别从0开始优先显示，同级别按时间倒序，默认1000)
                </div>
           </div>
           <input type="hidden" id="directions_id" name="directions_id" value="<?php echo $directions_id;?>">
           <input type="hidden" id="shop_id" name="shop_id" value="<?php echo $shop_id;?>">
          <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
          <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_line();" id="add_shoptips">添加</button>
	    </div>
	</div>
</div>

