<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>设置首页轮播图片</legend>

           <?php for($i=1;$i<5;$i++){$each=isset($pics[$i-1])?$pics[$i-1]:array();$img=isset($each['img'])?$each['img']:'';$link=isset($each['link'])?$each['link']:'';?>
           <div class="control-group">
              	<label class="control-label" style="width:60px;">图片<?php echo $i;?>:</label>
              	<div class="controls" style="margin-left:80px;">
              		<img id="topic_pic0<?php echo $i;?>" src=<?php echo $img;?>></img><br><br>
              	    <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="topic_0<?php echo $i;?>" name="upload_form" enctype="multipart/form-data">
              	    	<input type="hidden" name="policy" value="<?php echo $security[$i-1]['policy'];?>">
						<input type="hidden" name="signature" value="<?php echo $security[$i-1]['signature'];?>">
				        <input type="file" id="upload_file<?php echo $i;?>" name="file">
				    </form>
              	</div>
              	<label class="control-label" style="width:60px;">链接<?php echo $i;?>:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:500px;" placeholder="" id="link<?php echo $i;?>" value="<?php echo $link;?>">
              	</div>
              	<br><br><legend></legend>
           </div>
           <?php }?>
           <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>

           <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="setpic();">设置</button>
	    </div>
	</div>
</div>
