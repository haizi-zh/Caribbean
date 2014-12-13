<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑<?php echo $city_info['name'];?></legend>
			<div style="display:none" id="id"><?php echo $id;?></div>
            

            <div class="control-group">
              	<label class="control-label" style="width:60px;">显示名称:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px;width:500px;" placeholder="" id="name" value="<?php echo $city_info['name'];?>">
              	</div>
            </div>
            
            <div class="control-group">
              	<label class="control-label" style="width:60px;">别名:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px;width:500px;" placeholder="" id="english_name" value="<?php echo $city_info['english_name'];?>">
              	</div>
            </div>


            <div class="control-group">
              	<label class="control-label" style="width:60px;">手机端图片和web首页图片:</label>
              	<div class="controls" style="margin-left:80px;">
              		<img id="city_pic" src="<?php echo $city_info['reserve_3'];?>"></img><br><br>
              	    <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="upload_form" name="upload_form" enctype="multipart/form-data">
              	    	<input type="hidden" name="policy" value="<?php echo $policy?>">
						<input type="hidden" name="signature" value="<?php echo $signature?>">
				        <input type="file" id="upload_file" name="file">
				    </form>
				    <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>
              	</div>
            </div>

            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="city_modify();">编辑</button>

	    </div>
	</div>
</div>