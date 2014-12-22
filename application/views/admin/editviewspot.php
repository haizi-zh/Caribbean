<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript"> var ueVisitGuide = UE.getEditor('visitGuide'); var ueAntipit = UE.getEditor('antiPit');</script>
<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑景点</legend>
			<div style="display:none" id="viewspot_id"><?php echo $viewspot['viewspot_id'];?></div>

			<?php if($viewspot){?>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">完成状态:</label>
                <div class="controls" style="margin-left:80px;">
                    <select id="isEdited" >
                            <option></option>
                            <option value="0"><?php echo "未审核";?></option>
                            <option value="1"><?php echo "已经审核";?></option>
                    </select>
                </div>
            </div>

            <div class="control-group">
              	<label class="control-label" style="width:60px;">景点名称:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="name" value="<?php echo $viewspot['name'];?>">
              	</div>
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">景点简介:</label>
                <div class="controls" style="margin-left:80px;width:400px;">
                  <textarea rows="10" id="description" style="width:600px;" value="<?php echo $viewspot['description'];?>"><?php echo $viewspot['description'];?></textarea>
                </div>
            </div>
            

            <div class="control-group">
                <label class="control-label" style="width:60px;">详细地址:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="2" id="address" style="width:600px;" value="<?php echo $viewspot['address'];?>"><?php echo $viewspot['address'];?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">营业信息:</label>
                <div class="controls" style="margin-left:80px;">
                    <span style="width:60px;">&nbsp;&nbsp;开放信息:</span>
                    <input type="text" style="height:25px;width:100px" placeholder="" id="openTime" value="<?php echo $viewspot['openTime'];?>">

                    <span style="width:60px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;起始时间:</span>
                    <input type="text" style="height:25px;width:100px" placeholder="" id="openHour" value="<?php echo $viewspot['openHour'];?>"> 

                    <span style="width:60px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;关闭时间:</span>
                    <input type="text" style="height:25px;width:100px" placeholder="" id="closeHour" value="<?php echo $viewspot['closeHour'];?>"> 
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" style="width:60px;">景点门票:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="priceDesc" value="<?php echo $viewspot['priceDesc'];?>">
                </div>
            </div>

            
            <div class="control-group">
                <label class="control-label" style="width:60px;">电话:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="phone" value="<?php echo $viewspot['phone'];?>">
                </div>
            </div>        
            
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">排名得分:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="ratingsScore" value="<?php echo $viewspot['ratingsScore'];?>">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" style="width:60px;">游玩攻略:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="visitGuide" style="width:600px;"><?php echo $viewspot['visitGuide'];?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">防坑指南:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="antiPit" style="width:600px;"><?php echo $viewspot['antiPit'];?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">交通指南:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="travelGuide" style="width:600px;"><?php echo $viewspot['travelGuide'];?></textarea>
                </div>
            </div>



            <input type="hidden" name="has_map" id="has_map" value="<?php echo $has_map;?>" />
            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit_viewspot();">编辑景点</button>
           


            <?php }else{?>
            <?php if($viewspot_id):?>
            <h1>景点不存在,或已被删除。请确认</h1>
            <?php endif;?>

            <div class="control-group">
                <label class="control-label" style="width:60px;">请输入ID:</label>
                <div class="controls" style="margin-left:80px;">
                <input type="text" style="height:28px;margin-left:15px;width:150px;" placeholder="" id="target_viewspot_id" value="<?php if($viewspot_id) echo $viewspot_id;?>">
                </div>
            </div>

            <!-- <div class="control-group">
                	<label class="control-label" style="width:60px;">选择景点:</label>
                	<div class="controls" style="margin-left:80px;">
                		<select id="viewspot_box" style="margin-left:15px;width:150px;">
  	                	<option></option>
  	                	<?php foreach($shops as $viewspot){?>
  					  	      <option value="<?php echo $viewspot['id'];?>"><?php echo $viewspot['name'];?></option>
  					  	      <?php }?>
  					        </select>
                  </div>                  
            </div> -->


            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit();">确认</button>
            <?php }?>
	    </div>
	</div>
</div>