<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加城市</legend>                      
           
           <div class="control-group">
              	<label class="control-label" style="width:60px;">城市名称:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:200px;" placeholder="" id="name" value=''>
              	</div>
           </div>	
          
           <div class="control-group">
              	<label class="control-label" style="width:60px;">城市描述:</label>
              	<div class="controls" style="margin-left:80px;">
              		<textarea rows="6" id="desc" style="width:500px;"></textarea>
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
                  <textarea rows="6" id="timeCostDesc" style="width:500px;" value=''></textarea>
                </div>           
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">最佳旅游时间:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="6" id="travelMonth" style="width:500px;" value=''></textarea>
                </div>           
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">历史文化:</label>
                <button class="btn btn-primary" type="button" style="float:right;margin-right:230px;" onclick="addgeoHistory()">添加Title</button>
                <div id="geoHistory" class="controls" style="margin-left:80px;">
                  <span style="line-height:30px;border:3px solid #3299CC;height:50px;color:#3299CC;font-weight:bold">New Title</span>
                  <textarea rows="1" class="geoHistory_title" style="line-height:30px;width:425px" value=''></textarea><br><br>
                  <textarea rows="10" class="geoHistory_desc" style="width:500px;" value=''></textarea><br><br>
                </div> 
           </div> 


           <div class="control-group">
                <label class="control-label" style="width:60px;">活动:</label>
                <button class="btn btn-primary" type="button" style="float:right;margin-right:230px;" onclick="addactivities()">添加Title</button>
                <div id="activities" class="controls" style="margin-left:80px;">
                  <span style="line-height:30px;border:3px solid #3299CC;height:50px;color:#3299CC;font-weight:bold">New Title</span>
                  <textarea rows="1" class="activities_title" style="line-height:30px;width:425px" value=''></textarea><br><br>
                  <textarea rows="10" class="activities_desc" style="width:500px;" value=''></textarea><br><br>
                </div> 
           </div> 


           <div class="control-group">
                <label class="control-label" style="width:60px;">游玩体验:</label>
                <button class="btn btn-primary" type="button" style="float:right;margin-right:230px;" onclick="addspecials()">添加Title</button>
                <div id="specials" class="controls" style="margin-left:80px;">
                  <span style="line-height:30px;border:3px solid #3299CC;height:50px;color:#3299CC;font-weight:bold">New Title</span>
                  <textarea rows="1" class="specials_title" style="line-height:30px;width:425px" value=''></textarea><br><br>
                  <textarea rows="10" class="specials_desc" style="width:500px;" value=''></textarea><br><br>
                </div>  
           </div>


           <div class="control-group">
                <label class="control-label" style="width:60px;">贴心提示:</label>
                <button class="btn btn-primary" type="button" style="float:right;margin-right:230px;" onclick="addtips()">添加Title</button>
                <div id="tips" class="controls" style="margin-left:80px;">
                  <span style="line-height:30px;border:3px solid #3299CC;height:50px;color:#3299CC;font-weight:bold">New Title</span>
                  <textarea rows="1" class="tips_title" style="line-height:30px;width:425px" value=''></textarea><br><br>
                  <textarea rows="10" class="tips_desc" style="width:500px;" value=''></textarea><br><br>
                </div> 
           </div>         


           <div class="control-group">
                <label class="control-label" style="width:60px;">交通:</label>
                <button class="btn btn-primary" type="button" style="float:right;margin-right:230px;" onclick="addlocal()">添加Title</button>
                <div id="localTraffic" class="controls" style="margin-left:80px;">
                  <span style="line-height:30px;border:3px solid #3299CC;height:50px;color:#3299CC;font-weight:bold">New Title</span>
                  <textarea rows="1" class="localTraffic_title" style="line-height:30px;width:425px" value=''></textarea><br><br>
                  <textarea rows="10" class="localTraffic_desc" style="width:500px;" value=''></textarea><br><br>
                </div> 
           </div>                          


           <div class="control-group">
                <label class="control-label" style="width:60px;">到达:</label>
                <button class="btn btn-primary" type="button" style="float:right;margin-right:230px;" onclick="addremote()">添加Title</button>
                <div id="remoteTraffic" class="controls" style="margin-left:80px;">
                  <span style="line-height:30px;border:3px solid #3299CC;height:50px;color:#3299CC;font-weight:bold">New Title</span>
                  <textarea rows="1" class="remoteTraffic_title" style="line-height:30px;width:425px" value=''></textarea><br><br>
                  <textarea rows="10" class="remoteTraffic_desc" style="width:500px;" value=''></textarea><br><br>
                </div> 
           </div> 



           <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="addcity();">添加城市</button>
	    </div>
	</div>
</div>