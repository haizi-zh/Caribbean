<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加IOS高清图片</legend>
        
           <?php 
           $pics= array();
           if($coupon_info){
            $pics = $coupon_info['mobile_pics'];
            if($pics){
              $pics = json_decode($pics, true);
              
            }
           
           }
           ?>
          <div class="control-group">
            <label class="control-label" style="width:60px;">上传图片:</label>
            <div class="controls" style="margin-left:80px;">
            <!--
            <img id="city_pic" src="<?php echo $pic;?>"></img><br>
            -->
            <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="upload_form" name="upload_form" enctype="multipart/form-data">
            <input type="hidden" name="policy" value="<?php echo $policy?>">
            <input type="hidden" name="signature" value="<?php echo $signature?>">
            <input type="file" id="upload_file" name="file">
            </form>
            </div>
            <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>
          </div>



           <div class="control-group">
                <label class="control-label" style="width:60px;">图片列表(拖动以排序):</label>
                <ul class="controls" id="my_list" style="margin-left:80px;">
                <?php if($pics):?>
                <?php foreach($pics as $pic):?>
                <li style="padding:5px;"><img  width='80' height='80' name='city_pic' src="<?php echo $pic;?>"></img></li>
                <?php endforeach;?>
                <?php endif;?>
                </ul>
           </div>

          <input type="hidden" id="id" name="id" value="<?php echo $id;?>">

          <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_coupon_mobile_image();" id="add_shoptips">添加</button>
	    </div>
	</div>
</div>

