<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑品牌</legend>    
			                
           <?php if($brand){?>
           <div style="display:none" id="brand_id"><?php echo $brand['id'];?></div>  
           <div class="control-group">
              	<label class="control-label" style="width:60px;">默认名称:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:200px;" placeholder="" id="name" value="<?php echo $brand['name'];?>">
              	</div>
           </div>	
           
           <div class="control-group">
              	<label class="control-label" style="width:60px;">备选名称:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:200px;" placeholder="" id="englist_name" value="<?php echo $brand['english_name'];?>">
              	</div>           
           </div>
           	  	
           <div class="control-group">
              	<label class="control-label" style="width:60px;">描述:</label>
              	<div class="controls" style="margin-left:80px;">
              		<textarea rows="6" id="desc" style="width:500px;" value="<?php echo $brand['desc'];?>"><?php echo $brand['desc'];?></textarea>
              	</div> 
           </div>	

           <div class="control-group">
                <label class="control-label" style="width:60px;">类型:</label>
                <div class="controls" style="margin-left:80px;">
                  <select id="property">
                    <option value="0" <?php if($brand['property'] == 0){?>selected="selected"<?php }?> >品牌</option>
                    <option value="1" <?php if($brand['property'] == 1){?>selected="selected"<?php }?> >商场</option>
                  </select>
                </div> 
           </div> 
          <!--
           <div class="control-group">
              	<label class="control-label" style="width:80px;">品牌小图片:</label>
              	<div class="controls" style="margin-left:80px;">
              		<img id="small_pic" src="<?php echo $brand['pic'];?>"></img><br>
              	    <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="small_pic_form" name="upload_form" enctype="multipart/form-data">
              	    	<input type="hidden" name="policy" value="<?php echo $small_policy?>">
						<input type="hidden" name="signature" value="<?php echo $small_signature?>">
				        <input type="file" id="upload_small_file" name="file">
				    </form>
				    <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>				    
              	</div>              	
           </div>
           -->
           
           <div class="control-group">
              	<label class="control-label" style="width:80px;">品牌大图片:</label>
              	<div class="controls" style="margin-left:80px;">
              		<img id="big_pic" src="<?php echo $brand['big_pic'];?>"></img><br>
              	    <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="big_pic_form" name="upload_form" enctype="multipart/form-data">
              	    	<input type="hidden" name="policy" value="<?php echo $big_policy?>">
						<input type="hidden" name="signature" value="<?php echo $big_signature?>">
				        <input type="file" id="upload_big_file" name="file">
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

           <div class="control-group">
                <label class="control-label" style="width:60px;">电商标签(勾选):</label>
                <div class="controls" style="margin-left:80px;">
           <?php if($brandtag_list):?>
           <?php foreach($brandtag_list as $v):?>

            <?php echo $v['name'];?><input type="checkbox" name="brandtag_id" <?php if($brandtag && isset($brandtag[$v['id']])):?>checked=checked<?php endif;?>  value="<?php echo $v['id'];?>" />

            <?php endforeach;?>
            <?php endif;?>
                </div> 
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;"></label>
                <div class="controls" style="margin-left:80px;">
                标签太少？:<a href="/admin/brandtag/" target="_blank">去添加更多的标签</a>
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
                    <option value="<?php echo $v['id'];?>" <?php if($brand['property']==$v['id']):?>selected="selected"<?php endif;?> ><?php echo $v['name'];?></option>
                    <?php endforeach;?>
                    <?php endif;?>
                  </select>
                </div> 
           </div> 
         -->

           
           <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="editbrand();">确认</button>
           <?php }else{?>
           <div class="control-group">
              	<label class="control-label" style="width:80px;">输入品牌id:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="target_brand_id">
              	</div>
            </div>
            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit();">确认</button>
            <?php }?>
	    </div>
	</div>
</div>