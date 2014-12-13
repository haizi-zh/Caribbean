<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加品牌</legend>                      
           
           <div class="control-group">
              	<label class="control-label" style="width:60px;">默认名称:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:200px;" placeholder="" id="name" value="">
              	</div>
           </div>	
           
           <div class="control-group">
              	<label class="control-label" style="width:60px;">备选名称:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:200px;" placeholder="" id="englist_name" value="">
              	</div>           
           </div>
           	  	
           <div class="control-group">
              	<label class="control-label" style="width:60px;">描述:</label>
              	<div class="controls" style="margin-left:80px;">
              		<textarea rows="6" id="desc" style="width:500px;"></textarea>
              	</div> 
           </div>	
           <div class="control-group">
                <label class="control-label" style="width:60px;">类型:</label>
                <div class="controls" style="margin-left:80px;">
                  <select id="property">
                    <option value="0">品牌</option>
                    <option value="1">商场</option>
                  </select>
                </div> 
           </div> 
           <div class="control-group">
              	<label class="control-label" style="width:60px;">品牌图片:</label>
              	<div class="controls" style="margin-left:80px;">
              		<img id="brand_pic"></img><br>
              	    <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="brand_form" name="upload_form" enctype="multipart/form-data">
              	    	<input type="hidden" name="policy" value="<?php echo $policy?>">
						<input type="hidden" name="signature" value="<?php echo $signature?>">
				        <input type="file" id="upload_file" name="file">
				    </form>
				    <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>				    
              	</div>              	
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">电商名称:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:200px;" placeholder="" id="eb_name" value="<?php echo $brand['eb_name'];?>">
                </div>           
           </div>
                
           <div class="control-group">
                <label class="control-label" style="width:60px;">电商url:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="6" id="eb_url" style="width:500px;" value=""><?php echo $brand['eb_url'];?></textarea>
                </div> 
           </div> 

           <!--
           <div class="control-group">
                <label class="control-label" style="width:60px;">电商:</label>
                <div class="controls" style="margin-left:80px;">
                  <select id="ebusiness_id">
                    <option value="0">不选择</option>
                    <?php if($ebusiness_list):?>
                    <?php foreach($ebusiness_list as $v):?>
                    <option value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>
                    <?php endforeach;?>
                    <?php endif;?>
                  </select>
                </div> 
           </div> 
          -->

           <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="setbrand();">添加</button>
	    </div>
	</div>
</div>