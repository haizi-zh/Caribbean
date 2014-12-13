<div class="container" style="margin-top:50px;width:100%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example" >
			<legend>添加交通类型</legend>
           <div class="control-group">
              	<label class="control-label" style="width:60px;">商家名称:</label>
              	<div class="controls" style="margin-left:80px;">
              		<?php echo $shop_info['name'];?>
                  <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_type();" id="add_shoptips">保存</button>
              	</div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">交通类型:</label>
                <div class="controls" style="margin-left:80px;">
                  <?php echo $type_lists[$type];?>
                </div>
           </div>
           <!--
           <div class="control-group">
                <label class="control-label" style="width:60px;">显示级别:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:200px;" placeholder="" id="level" value="<?php if($directions_info) echo $directions_info['level'];?>">(数字，显示级别从0开始优先显示，同级别按时间倒序，默认1000)
                </div>
          </div>
          -->

          <input type="hidden" id="shop_id" name="shop_id" value="<?php echo $shop_id;?>">
          <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
          <input type="hidden" id="type" name="type" value="<?php echo $type;?>">


           <div class="control-group">
                <label class="control-label" style="width:60px;">描述:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" class="" style="margin: 0px; width: 90%; height: 48px;"  id="description"><?php if($directions_info) echo $directions_info['description'];?></textarea>
                </div>
    
                如果有文字带链接,请用英文##把文字包起来。如:#something# #something_two#
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">描述url:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3"  style="margin: 0px; width: 90%; height: 48px;" id="description_url"><?php if($directions_info) echo $directions_info['description_url'];?></textarea>
                </div>
                存储上文中链接对应的url,多个请用英文竖线分割。如 http://baidu.com/|http://163.com
           </div>


           <!-- 介绍，时刻表，票价，乘车贴士，预定。咨询电话 -->
           <div id="content">;
           <?php $i=0;?>
           <?php if($line_items):?>
           <?php foreach($line_items as $level => $line_item):?>
           <?php $i++;?>
           <div name="line" level="<?php echo $level;?>"><span id="line_name">线路<?php echo $i;?></span>
           <?php foreach($item_type as $k=>$v):?>
           <div class="control-group">
                <label class="control-label" style="width:60px;"><?php echo $v;?>:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" name="description" style="margin: 0px; width: 90%; height: 48px;" item-type="<?php echo $k;?>" item-data="<?php if($line_item&&$line_item[$k]) echo $line_item[$k]['id'];?>" id="description"><?php if($line_item&&$line_item[$k]) echo $line_item[$k]['description'];?></textarea>
                </div>
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;"><?php echo $v;?>url:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" name="description_url" style="margin: 0px; width: 90%; height: 48px;" item-type="<?php echo $k;?>" item-data="<?php if($line_item&&$line_item[$k]) echo $line_item[$k]['id'];?>" id="description_url"><?php if($line_item&&$line_item[$k]) echo $line_item&&$line_item[$k]['description_url'];?></textarea>
                </div>
           </div>
           <?php endforeach;?>
           <div class="control-group">
                <label class="control-label" style="width:60px;">本线路排序(确保level不同):</label>
                <div class="controls" style="margin-left:80px;">
                <input name="level" value="<?php echo $level;?>" />
                </div>
           </div>

           </div>
          <?php endforeach;?>
          <?php endif;?>
          </div>
          <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_line();" id="add_shoptips">增加线路</button>
          <input type="hidden" id="max-level" value="<?php echo $level;?>"/>
	    </div>
	</div>
</div>

