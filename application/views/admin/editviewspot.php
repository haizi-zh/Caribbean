<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑景点</legend>
			<div style="display:none" id="viewspot_id"><?php echo $viewspot['id'];?></div>

			<?php if($viewspot){?>

            <div class="control-group">
              	<label class="control-label" style="width:60px;">所在地:</label>
              	<div class="controls" style="margin-left:80px;">
	                <select id="area" onchange="change(this)">
	                	<option></option>
	                	<?php foreach($areas as $area){?>
					  	<option value="<?php echo $area['id'];?>" <?php if($area['id'] == $viewspot['area']){?>selected="selected" <?php }?>><?php echo $area['name'];?></option>
					  	<?php }?>
					</select>&nbsp;
	                <select id="country">
	                	<?php foreach($countries as $id=>$name){?>
					  	<option value="<?php echo $id;?>" <?php if($id == $viewspot['country']){?>selected="selected" <?php }?>><?php echo $name;?></option>
					  	<?php }?>
					</select>&nbsp;
					<select id="city">
						<?php foreach($cities as $city){?>
					  	<option value="<?php echo $city['id'];?>" <?php if($city['id'] == $viewspot['city']){?>selected="selected" <?php }?>><?php echo $city['name'];?></option>
					  	<?php }?>
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
              	<label class="control-label" style="width:60px;">景点门票:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="price" value="<?php  ?>">
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">景点简介:</label>
              	<div class="controls" style="margin-left:80px;width:400px;">
                	<textarea rows="10" id="desc" style="width:600px;"><?php echo $viewspot['desc'];?></textarea>
              	</div>
            </div>
      
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">地址:</label>
              	<div class="controls" style="margin-left:80px;">
              		<textarea rows="5" id="address" style="width:600px;"><?php echo $viewspot['address'];?></textarea>
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">电话:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="phone" value="<?php echo $viewspot['phone'];?>">
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">营业时间:</label>
              	<div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="business_hour" style="width:600px;"><?php echo $viewspot['business_hour'];?></textarea>
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">排名得分:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="score" value="<?php echo $viewspot['score'];?>">
              	</div>
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">游玩攻略</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="visit_guide" style="width:600px;"><?php echo $viewspot['visit_guide'];?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">防坑指南</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="anti_pit" style="width:600px;"><?php echo $viewspot['anti_pit'];?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">交通指南</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="travel_guide" style="width:600px;"><?php echo $viewspot['travel_guide'];?></textarea>
                </div>
            </div>

            <div class="control-group">
              	<label class="control-label" style="width:60px;">位置:</label>
              	<div class="controls" style="margin-left:80px;">
              		<div id="lat" value="<?php echo $lat?>" style="display:none"><?php echo $lat?></div>
              		<div id="lon" value="<?php echo $lon?>" style="display:none"><?php echo $lon?></div>
              		<input type="text" style="height:25px" placeholder="" id="location" value="<?php echo $viewspot['location'];?>"><br><br>
              		<div id="map-canvas" style="height: 500px"></div>
              	</div>
            </div>



            <input type="hidden" name="has_map" id="has_map" value="<?php echo $has_map;?>" />
            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit_viewspot();">编辑景点</button>
            <?php }else{?>
            <?php if($viewspot_id):?>
            <h1>景点不存在,或已被删除。请确认</h1>
            <?php endif;?>
            <div class="control-group">
              	<label class="control-label" style="width:60px;">选择景点:</label>
              	<div class="controls" style="margin-left:80px;">
              		<select id="viewspot_box" style="margin-left:15px;width:150px;">
	                	<option></option>
	                	<?php foreach($shops as $viewspot){?>
					  	<option value="<?php echo $viewspot['id'];?>"><?php echo $viewspot['name'];?></option>
					  	<?php }?>
					</select>
                	<input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="target_viewspot_id" value="<?php if($viewspot_id) echo $viewspot_id;?>">
              	</div>
            </div>
            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit();">确认</button>
            <?php }?>
	    </div>
	</div>
</div>