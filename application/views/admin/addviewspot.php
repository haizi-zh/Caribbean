<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加景点</legend>
            <!-- <div class="control-group">
              	<label class="control-label" style="width:60px;">所在地:</label>
              	<div class="controls" style="margin-left:80px;">
	                <select id="area" onchange="change(this)">
	                	<option></option>
	                 	<?php foreach($areas as $area){?>
					  	<option value="<?php echo $area['id'];?>"><?php echo $area['name'];?></option>
					  	<?php }?> 
					</select>&nbsp;
	                <select id="country">
					</select>&nbsp;
					<select id="city">
					</select>
              	</div>
            </div>  -->
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">景点名称:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="name">
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">英文名称:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="english_name">
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">景点简介:</label>
              	<div class="controls" style="margin-left:80px;width:200px;">
                	<textarea rows="6" id="desc" style="width:400px;"></textarea>
              	</div>
            </div>
            
            <!-- <div class="control-group">
              	<label class="control-label" style="width:60px;">图片:</label>
              	<div class="controls" style="margin-left:80px;">
              		<img id="shop_pic"></img><br><br>
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
              		<textarea rows="3" id="address" style="width:400px;"></textarea>
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">电话:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="phone">
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">营业时间:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="business_hour">
              	</div>
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">排名得分:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="rank_score" value="">
                </div>
            </div>

			     <div class="control-group">
              	<label class="control-label" style="width:60px;">类型:</label>
              	<div class="controls" style="margin-left:80px;">
                	<select id="property">
					    <option value=0>未选择</option>
					    <option value=1>购物街区</option>
					    <option value=2>购物中心</option>
					    <option value=3>奥特莱斯</option>
					</select>
              	</div>
            </div>
            <div class="control-group">
              	<label class="control-label" style="width:60px;">商家链接:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="link">
              	</div>
            </div>
            <div class="control-group">
                <label class="control-label" style="width:60px;">商家数:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="shop_cnt">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">怎样到达:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="3" id="how_come" style="width:400px;"></textarea>
                </div>
            </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">是否品牌折扣不显示的商店:</label>
                <div class="controls" style="margin-left:80px;">
                  <select id="discount_type">
              <option value=0>未选择</option>
              <option value=1>百货商店</option>

          </select>
                </div>
            </div> -->

            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_shop();">添加景点</button>
	    </div>
	</div>
</div>