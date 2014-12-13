<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑城市</legend>    
			                
           <div style="display:none" id="city_id"><?php echo $city['city_id'];?></div>  
           <div class="control-group">
              	<label class="control-label" style="width:60px;">默认名称:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:200px;" placeholder="" id="name" value="<?php echo $city['name'];?>">
              	</div>
           </div>	
          
           <div class="control-group">
                <label class="control-label" style="width:60px;">城市描述:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="6" id="desc" style="width:500px;" value="<?php echo $city['desc'];?>"><?php echo $city['desc'];?></textarea>
                </div> 
           </div> 

           <div class="control-group">
                <label class="control-label" style="width:60px;">城市图片:</label>
                <div class="controls" style="margin-left:80px;">
                  <img id="city_pic"></img><br>
                    <form action=" " target="ifmUpload" method="post" id="brand_form" name="upload_form" enctype="multipart/form-data">
                      <input type="hidden" name="policy" value="<?php echo $policy?>">
            <input type="hidden" name="signature" value="<?php echo $signature?>">
                <input type="file" id="upload_file" name="file">
            </form>
            <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>           
                </div>                
           </div>


           <div class="control-group">
                <label class="control-label" style="width:60px;">参考游玩时间:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="6" id="timeCostDesc" style="width:500px;" value="<?php echo $city['timeCostDesc'];?>"><?php echo $city['timeCostDesc'];?></textarea>
                </div>           
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">最佳旅游时间:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="6" id="travelMonth" style="width:500px;" value="<?php echo $city['travelMonth'];?>"><?php echo $city['travelMonth'];?></textarea>
                </div>           
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">历史文化:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="6" id="culture" style="width:500px;" value="<?php echo $city['culture'];?>"><?php echo $city['culture'];?></textarea>
                </div> 
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">活动:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="6" id="activityIntro" style="width:500px;" value="<?php echo $city['activityIntro'];?>"><?php echo $city['activityIntro'];?></textarea>
                </div> 
           </div> 

           <div class="control-group">
                <label class="control-label" style="width:60px;">亮点:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="6" id="lightspot" style="width:500px;" value="<?php echo $city['lightspot'];?>"><?php echo $city['lightspot'];?></textarea>
                </div> 
           </div>


           <div class="control-group">
                <label class="control-label" style="width:60px;">贴心提示:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="6" id="tips" style="width:500px;" value="<?php echo $city['tips'];  ?>"><?php echo $city['tips'];  ?></textarea>
                </div> 
           </div>         


           <div class="control-group">
                <label class="control-label" style="width:60px;">交通:</label>
                <div class="controls" style="margin-left:80px;">
                <?php foreach($city['localTraffic'] as $key=>$traffic){ ?>
                  <span style="line-height:30px;border:3px solid #000;height:50px;color:black;font-weight:bold">Title<?php echo $key+1; ?></span>
                  <textarea rows="1" class="localTraffic_title" style="line-height:30px;width:455px" value="<?php echo $traffic['title']; ?>"><?php echo $traffic['title']; ?></textarea><br><br>
                  <textarea rows="10" class="localTraffic_content" style="width:500px;" value="<?php echo $traffic['contents']; ?>"><?php echo $traffic['contents']; ?></textarea><br><br>
                <?php } ?>
                </div> 
           </div>                          


          <div class="control-group">
                <label class="control-label" style="width:60px;">到达:</label>
                <div class="controls" style="margin-left:80px;">
                <?php foreach($city['remoteTraffic'] as $key=>$traffic){ ?>
                   <span style="line-height:30px;border:3px solid #000;height:50px;color:black;font-weight:bold">Title<?php echo $key+1; ?></span>
                   <textarea rows="1" class="remoteTraffic_title" style="line-height:30px;width:455px" value="<?php echo $traffic['title']; ?>"><?php echo $traffic['title']; ?> </textarea><br><br>
                   <textarea rows="10" class="remoteTraffic_content" style="width:500px" value="<?php echo $traffic['title']; ?>"><?php echo $traffic['contents']?> </textarea><br><br>
                <?php } ?>
                </div> 
           </div>  


           
           <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="editcity();">确认</button>
          

	    </div>
	</div>
</div>