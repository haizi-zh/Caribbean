<div class="container" style="margin-top:50px;width:87%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑页面</legend>                      
                   <div style="display:none" id="operation_id"><?php echo $operation['operation_id'];?></div>  

		           <div class="control-group">
		              	<label class="control-label" style="width:60px;">TITLE:</label>
		              	<div class="controls" style="margin-left:80px;">
		              		<input type="text" style="height:25px;width:200px;" placeholder="" id="title" value="<?php echo $operation['title'];?>">
		              	</div>
		           </div>	
		          
		           <div class="control-group">
		                <label class="control-label" style="width:60px;">COVER:</label>
		                <div class="controls" style="margin-left:80px;">
		                  <textarea rows="2" id="cover" style="width:500px;" value="<?php echo $operation['cover'];?>"><?php echo $operation['cover'];?></textarea>
		                </div> 
		           </div>

		           <div class="control-group">
		                <label class="control-label" style="width:60px;">LINK:</label>
		                <div class="controls" style="margin-left:80px;">
		                  <textarea rows="2" id="link" style="width:500px;" value="<?php echo $operation['link'];?>"><?php echo $operation['link'];?></textarea>
		                </div> 
		           </div>
			
			       <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit_operation();">编辑</button>

	    </div>

	    
	</div>
</div>