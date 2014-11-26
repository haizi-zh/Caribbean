<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加景点</legend>
          <div class="control-group">
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
            </div> 
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">景点名称:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="name">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">景点门票:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="price">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">景点简介:</label>
                <div class="controls" style="margin-left:80px;width:400px;">
                  <textarea rows="10" id="desc" style="width:600px;"></textarea>
                </div>
            </div>
      
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">地址:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="5" id="address" style="width:600px;"></textarea>
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
                  <textarea rows="10" id="business_hour" style="width:600px;"></textarea>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">排名得分:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="score">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">游玩攻略</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="visit_guide" style="width:600px;"></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">防坑指南</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="anti_pit" style="width:600px;"></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">交通指南</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="travel_guide" style="width:600px;"></textarea>
                </div>
            </div>



            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_viewspot();">添加景点</button>
	    </div>
	</div>
</div>