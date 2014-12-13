<div class="container" style="margin-top:50px;width:95%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>商家品牌管理</legend>
			<?php if($shop){?>
				<div id="shop_id" style="display:none;"><?php echo $shop['id'];?></div>
				<div id="city_id" style="display:none;"><?php echo $shop['city'];?></div>
				<div class="control-group">
					<label class="control-label" style="width:300px;font-weight:700;font-size:20px;"><?php echo $shop['name'];?></label><br>
				</div>
				<!-- <div class="control-group">
	              	<label class="control-label" ><b>添加品牌：</b></label>
	              	<div class="controls" style="margin-left:80px;">
	              		<select id="brand_box" style="margin-left:15px;">
		                	<option></option>
		                	<?php foreach($all_brand as $brand){?>
						  	<option value="<?php echo $brand['id'];?>"><?php echo $brand['name'];?></option>
						  	<?php }?>
						</select>
	                	<input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="品牌 id" id="target_brand_id">
	                	<button class="btn btn-primary" type="button" style="float:right;margin-right:150px;" onclick="add_shop_brand();">添加品牌</button>
	              	</div>
	              	
	              	<label class="control-label" style="font-size:xx-small;width:600px;">( 注：可以通过 1.下拉菜单选择品牌 2.直接填写品牌id。品牌id可以在“品牌管理->查看品牌”找到。)</label>
            	</div> -->
                <div class="control-group">
                    <label class="control-label" ><b>添加品牌：</b></label>
                    <div class="controls" style="margin-left:80px;">
                        <input type="text" style="height:25px;margin-left:25px;width:100px;" id="suggestion_brand" onkeyup="suggestion(this.value)" autocomplete="off">
                        <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="品牌 id" id="target_brand_id">
                        <button class="btn btn-primary" type="button" style="float:right;margin-right:150px;" onclick="add_shop_brand();">添加品牌</button>
                        <div id="suggestion_result" style="width: 385px; position:relative; margin-left:75; padding-left:5px; border:2px solid #ddd; display:none; font: 16px/22px arial; background-color: #ededed;"></div>
                    </div>
                </div>

				<div class="control-group">
	              	<label class="control-label" ><b>品牌选择：</b></label>
	              	<div class="controls" style="margin-left:80px;">
	                	<input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="品牌名" id="brand_name" onkeyup="demo_suggest();">
	              		<div id="name_list" style="position: absolute; width: 193px;display: block;background-color:red;"></div>
	              	</div>
	              	
	              	<label class="control-label" style="font-size:xx-small;width:600px;">( 注：临时功能，limeng的联想功能上线后，此功能会废弃，)</label>
            	</div>

            	<legend><?php echo $shop['name'];?>的所有品牌</legend>
            	<?php foreach($shop_brands_info as $brand){?>
					<div style="margin-top:10px;padding:5px;border:1px dashed gray;margin-right: 10px;width: 100px;float: left;height:35px;font-weight:700;">
                        <a href='javascript:;'>
                            <img onclick="delete_shop_brand(<?php echo $shop['id'];?>,<?php echo $brand['id'];?>);" src="/images/admin/cross.png" style="float:right">
                        </a>
						<p><?php echo $brand['name'];?></p>
					</div>
				<?php }?>
			<?php }else{?>
			<div class="control-group">
              	<label class="control-label" style="width:60px;">选择商家:</label>
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