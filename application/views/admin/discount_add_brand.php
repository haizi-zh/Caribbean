<div class="container" style="width:100%; margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well form-horizontal bs-docs-example">
		<legend>为品牌添加折扣信息 <?php if($brand_id):?><button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" id="add_discount">添加</button><?php endif;?></legend>
			<?php if($brand_id){?>
				<div class="control-group">
					<label class="control-label" style="width:60px;">品牌名称:</label>
					<div class="controls" style="margin-left:80px;"  >
						<?php if($brand_info && isset($brand_info['name'])) echo $brand_info['name'];?>
					</div>
				</div>
				<?php if($shop_names && $shop_names):?>
				<div class="control-group">
					<label class="control-label" style="width:60px;">商店名称:</label>
					<div class="controls" style="margin-left:80px;"  >
						<?php if($shop_names) echo $shop_names;?>
					</div>
				</div>
				<?php endif;?>

				<div class="control-group">
					<label class="control-label" style="width:60px;">标题:</label>
					<div class="controls" style="margin-left:80px;">
						<input type="text" style="height:25px;width:500px;" placeholder="" id="title" value="">
					</div>
				</div>


				<div class="control-group">
					<label class="control-label" style="width:60px;">开始时间:</label>
					<div class="controls" style="margin-left:80px;width:260px;">
						<input type="text" onfocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" value="<?php if(isset($etime) && $etime) echo $etime; else echo date('Y-m-d');?>" name="stime" id="stime" readonly="readonly" style="width:45%;" class="bjyh_text Wdate">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" style="width:60px;">结束时间:</label>
					<div class="controls" style="margin-left:80px;width:260px;">
						<input type="text" onfocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" value="<?php if(isset($etime) && $etime) echo $etime; else echo date('Y-m-d');?>" name="etime" id="etime" readonly="readonly" style="width:45%;" class="bjyh_text Wdate">
					</div>
				</div>

	           <div class="control-group">
	                <label class="control-label" style="width:60px;">分享到第三平台文案（100字以内）:</label>
	                <div class="controls" style="margin-left:80px;">
	                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="share_content"></textarea>
	                </div>
	           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">是否百货商店不显示:</label>
                <div class="controls" style="margin-left:80px;">
                  <select id="shop_type">
                  <option value=0>否</option>
                  <option value=1>是</option>
                </select>
              </div>
            </div>
            
				<input type="hidden" name="brand_id" id="brand_id" value="<?php echo $brand_id;?>" />
				<input type="hidden" name="shop_ids" id="shop_ids" value="<?php echo $shop_ids;?>" />
				
				<div class="control-group">
					<label class="control-label" style="width:60px;">详情:</label>
					<div class="controls" style="margin-left:80px;width:90%;height:680px;" id="my_content"></div>
				</div>

			<?php }else{?>

				<div class="control-group">
					<div class="controls" style="margin-left:80px;">
						<label class="control-label" style="width:60px;">选择品牌:</label>
						<div class="controls" style="margin-left:80px;">
							<input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="品牌名" id="brand_name" onkeyup="demo_suggest();">
							<div id="name_list" style="position: absolute; width: 193px;display: block;background-color:red;" ></div>
							<input type="text" style="height:25px;margin-left:25px;width:100px;" onkeyup="change_id();" placeholder="" id="target_brand_id">
						</div>

					</div>
				</div>
				<div id="shop_list"></div>

				<button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="confirm();">确认添加</button>

			<?php }?>

		</div>
	</div>
</div>