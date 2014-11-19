<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加电商信息</legend>
      <!-- name logo description web_site country tags pay_type type-->
           <div class="control-group">
              	<label class="control-label" style="width:60px;">名称:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:500px;"  id="name" value="<?php if($info) echo $info['name'];?>">
              	</div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">描述:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="6" id="description" style="width:500px;"><?php if($info) echo $info['description'];?></textarea>
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">链接:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" id="web_site" value="<?php if($info) echo $info['web_site'];?>">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">国家:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" id="country" value="<?php if($info) echo $info['country'];?>">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">标签:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" id="tags" value="<?php if($info) echo $info['tags'];?>">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">支付类型:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" id="pay_type" value="<?php if($info) echo $info['pay_type'];?>">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">电商类型:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" id="type" value="<?php if($info) echo $info['type'];?>">
                </div>
           </div>




           <?php 
           $pic= "";
           if($info){
            $pics = $info['logo'];
            if($pics){
              $pics = json_decode($pics, true);
              $pic = $pics[0];
            }
           
           }
           ?>
          <div class="control-group">
            <label class="control-label" style="width:60px;">上传图片:</label>
            <div class="controls" style="margin-left:80px;">
            <img id="ebusiness_pic" src="<?php echo $pic;?>"></img><br>
            <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="ebusiness_form" name="ebusiness_form" enctype="multipart/form-data">
            <input type="hidden" name="policy" value="<?php echo $policy?>">
            <input type="hidden" name="signature" value="<?php echo $signature?>">
            <input type="file" id="upload_file" name="file">
            </form>
            </div>
            <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>
          </div>
          <input type="hidden" id="id" name="id" value="<?php echo $id;?>">

          <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_ebusiness();"id="add_shoptips">添加</button>
	    </div>
	</div>
</div>

