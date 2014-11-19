<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			
			<legend>商家品牌导入</legend>
			<?php if($shop){?>
<!-- 			<form action="/aj/brandimport/import" method="post" enctype="multipart/form-data"> -->
<!-- 			<div class="control-group"> -->
<!--            	<div class="controls" style="margin-left:20px;"> -->
<!--               	<input type="file" style="height:25px;margin-left:25px;width:200px;" placeholder="" id="file" name="file"> -->
<!--               	</div> -->
<!--             </div> -->
<!--           <input class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;" value="提交"/> -->
<!--           </form> -->
			<div class="control-group">
            <label style="margin-left:65px;"><b>商家名称：<?php echo $shop['name'];?></b></label><br><br>
           	<form action="/aj/brandimport/import_brand?shop_id=<?php echo $shop['id'];?>" method="post" enctype="multipart/form-data">
           	<label class="control-label" ><b>导入品牌：</b></label>
			<div class="control-group">
            	<div class="controls" style="margin-left:10px;">
               	<input type="file" style="height:25px;margin-left:15px;width:200px;" placeholder="" id="file" name="file">
              	</div>
            </div>
            注意：请确保导入文件中不含有： “ 或 " （中英文的双引号）
           <input class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;" value="提交"/><br>
           </form>
           <?php }else{?>
           <div class="control-group">
              	<label class="control-label" style="width:60px;">输入商家:</label>
              	<div class="controls" style="margin-left:80px;">
              	    <select id="shop_box" style="margin-left:15px;width:150px;">
	                	<option></option>
	                	<?php foreach($shops as $shop){?>
					  	<option value="<?php echo $shop['id'];?>"><?php echo $shop['name'];?></option>
					  	<?php }?>
					</select>
                	<input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="target_shop_id">
              	</div>
            </div>
            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="confirm();">确认</button>
            <?php }?>
		
	    </div>
	</div>
</div>