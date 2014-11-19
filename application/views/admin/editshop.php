<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑商家</legend>
			<div style="display:none" id="shop_id"><?php echo $shop['id'];?></div>

			<?php if($shop){?>

            <div class="control-group">
              	<label class="control-label" style="width:60px;">所在地:</label>
              	<div class="controls" style="margin-left:80px;">
	                <select id="area" onchange="change(this)">
	                	<option></option>
	                	<?php foreach($areas as $area){?>
					  	<option value="<?php echo $area['id'];?>" <?php if($area['id'] == $shop['area']){?>selected="selected" <?php }?>><?php echo $area['name'];?></option>
					  	<?php }?>
					</select>&nbsp;
	                <select id="country">
	                	<?php foreach($countries as $id=>$name){?>
					  	<option value="<?php echo $id;?>" <?php if($id == $shop['country']){?>selected="selected" <?php }?>><?php echo $name;?></option>
					  	<?php }?>
					</select>&nbsp;
					<select id="city">
						<?php foreach($cities as $city){?>
					  	<option value="<?php echo $city['id'];?>" <?php if($city['id'] == $shop['city']){?>selected="selected" <?php }?>><?php echo $city['name'];?></option>
					  	<?php }?>
					</select>
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">显示名称:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="name" value="<?php echo $shop['name'];?>">
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">英文名称:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="english_name" value="<?php echo $shop['english_name'];?>">
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">商家简介:</label>
              	<div class="controls" style="margin-left:80px;width:400px;">
                	<textarea rows="20" id="desc" style="width:600px;"><?php echo $shop['desc'];?></textarea>
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">图片:</label>
              	<div class="controls" style="margin-left:80px;">
              		<img id="shop_pic" src="<?php echo $shop['pic'];?>"></img><br><br>
              	    <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="upload_form" name="upload_form" enctype="multipart/form-data">
              	    	<input type="hidden" name="policy" value="<?php echo $policy?>">
						<input type="hidden" name="signature" value="<?php echo $signature?>">
				        <input type="file" id="upload_file" name="file">
				    </form>
				    <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">地址:</label>
              	<div class="controls" style="margin-left:80px;">
              		<textarea rows="5" id="address" style="width:600px;"><?php echo $shop['address'];?></textarea>
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">电话:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="phone" value="<?php echo $shop['phone'];?>">
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">营业时间:</label>
              	<div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="business_hour" style="width:600px;"><?php echo $shop['business_hour'];?></textarea>
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">排名得分:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="rank_score" value="<?php echo $shop['rank_score'];?>">
              	</div>
            </div>
            
			   <div class="control-group">
              	<label class="control-label" style="width:60px;">类型:</label>
              	<div class="controls" style="margin-left:80px;">
                	<select id="property">
					    <option value=0>未选择</option>
					    <option value=1 <?php if($shop['property'] ==1){?>selected="selected" <?php }?>>购物街区</option>
					    <option value=2 <?php if($shop['property'] ==2){?>selected="selected" <?php }?>>购物中心</option>
					    <option value=3 <?php if($shop['property'] ==3){?>selected="selected" <?php }?>>奥特莱斯</option>
					</select>
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">商家链接:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px;width:600px;" placeholder="" id="link" value="<?php echo $shop['reserve_2'];?>">
              	</div>
            </div>    
            <div class="control-group">
                <label class="control-label" style="width:60px;">商家数:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="shop_cnt" value="<?php echo $shop['reserve_1'];?>">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">怎样到达:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="20" id="how_come" style="width:600px;"><?php echo $shop['reserve_3'];?></textarea>
                </div>
            </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">是否品牌折扣不显示的商店:</label>
                <div class="controls" style="margin-left:80px;">
                  <select id="discount_type">
              <option value=0>未选择</option>
              <option value=1 <?php if($shop['discount_type'] ==1){?>selected="selected" <?php }?>>百货商店</option>

          </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">seo的补充keywords:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="3" id="seo_keywords" style="width:400px;"><?php echo $shop['seo_keywords'];?></textarea>
                </div>
            </div>

            <div class="control-group">
              	<label class="control-label" style="width:60px;">位置:</label>
              	<div class="controls" style="margin-left:80px;">
              		<div id="lat" value="<?php echo $lat?>" style="display:none"><?php echo $lat?></div>
              		<div id="lon" value="<?php echo $lon?>" style="display:none"><?php echo $lon?></div>
              		<input type="text" style="height:25px" placeholder="" id="location" value="<?php echo $shop['location'];?>"><br><br>
              		<div id="map-canvas" style="height: 500px"></div>
              	</div>
            </div>



            <input type="hidden" name="has_map" id="has_map" value="<?php echo $has_map;?>" />
            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit_shop();">编辑商家</button>
            <?php }else{?>
            <?php if($shop_id):?>
            <h1>商家不存在,或已被删除。请确认</h1>
            <?php endif;?>
            <div class="control-group">
              	<label class="control-label" style="width:60px;">选择商家:</label>
              	<div class="controls" style="margin-left:80px;">
              		<select id="shop_box" style="margin-left:15px;width:150px;">
	                	<option></option>
	                	<?php foreach($shops as $shop){?>
					  	<option value="<?php echo $shop['id'];?>"><?php echo $shop['name'];?></option>
					  	<?php }?>
					</select>
                	<input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="target_shop_id" value="<?php if($shop_id) echo $shop_id;?>">
              	</div>
            </div>
            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit();">确认</button>
            <?php }?>
	    </div>
	</div>
</div>