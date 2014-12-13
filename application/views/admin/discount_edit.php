<div class="container" style="width:80%; margin-top:50px; ">
	<div class="row-fluid">
		<div class="span12 well form-horizontal bs-docs-example">
			<?php if(!$id):?>
				参数错误
			<?php else:?>
				<legend>编辑<?php echo $type_name;?>信息 <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" id="edit_discount">修改</button></legend>
				<?php if(isset($shop_name) && $shop_name):?>
				<div class="control-group">
					<label class="control-label" style="width:60px;">商家id:</label>
					<div class="controls" style="margin-left:80px;">
						<?php echo $shop_name;?>
					</div>
				</div>
				<?php endif;?>

				<?php if(isset($brand_name) && $brand_name):?>
				<div class="control-group">
					<label class="control-label" style="width:60px;">品牌:</label>
					<div class="controls" style="margin-left:80px;">
						<?php echo $brand_name;?>
					</div>
				</div>
				<?php endif;?>

				<?php if(isset($country_name) && $country_name):?>
				<div class="control-group">
					<label class="control-label" style="width:60px;">国家:</label>
					<div class="controls" style="margin-left:80px;">
						<input disabled type="text" style="height:25px;width:500px;" placeholder="" id="country_name" value="<?php echo $country_name;?>">
					</div>
				</div>
				<?php endif;?>


				<?php if(isset($city_name) && $city_name):?>
				<div class="control-group">
					<label class="control-label" style="width:60px;">城市:</label>
					<div class="controls" style="margin-left:80px;">
						<input disabled type="text" style="height:25px;width:500px;" placeholder="" id="city_name" value="<?php echo $city_name;?>">
					</div>
				</div>
				<?php endif;?>

	           <div class="control-group" <?php if($discount_info['type'] != 2):?>style="display:none;"<?php endif;?> >
	                <label class="control-label" style="width:60px;">显示级别:</label>
	                <div class="controls" style="margin-left:80px;">
	                  <input type="text" style="height:25px;width:200px;" placeholder="" id="level" value="<?php echo $discount_info['level'];?>">(数字，显示级别从0开始优先显示，同级别按时间倒序，默认1000)
	                </div>
	           </div>

				<div class="control-group">
					<label class="control-label" style="width:60px;">标题:</label>
					<div class="controls" style="margin-left:80px;">
						<input type="text" style="height:25px;width:500px;" placeholder="" id="title" value="<?php echo $discount_info['title'];?>">
					</div>
				</div>
				

				<div class="control-group">
					<label class="control-label" style="width:60px;">移动端标题:</label>
					<div class="controls" style="margin-left:80px;">
						<input type="text" style="height:25px;width:500px;" placeholder="" id="title_mobile" value="<?php echo $discount_info['title_mobile'];?>">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" style="width:60px;">开始时间:</label>
					<div class="controls" style="margin-left:80px;width:260px;">
						<input type="text" onfocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" value="<?php if(isset($stime) && $stime) echo $stime; else echo date('Y-m-d');?>" name="stime" id="stime" readonly="readonly" style="width:45%;" class="bjyh_text Wdate">
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
	                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="share_content"><?php echo $discount_info['share_content'];?></textarea>
	                </div>
	           </div>

	           <div class="control-group">
	                <label class="control-label" style="width:60px;">是否百货商店不显示:</label>
	                <div class="controls" style="margin-left:80px;">
	                  <select id="shop_type">
	                  <option value=0>否</option>
	                  <option value=1 <?php if( $discount_info['shop_type']==1):?>selected="selected"<?php endif;?>>是</option>
	                </select>
	              </div>
	            </div>

				<input type="hidden" id="id" name="id" value="<?php echo $discount_info['id']?>" />
				<div style='visibility: hidden;'><textarea id="content_html" type="display:hidden;"><?php echo $discount_info['body'];?></textarea></div>
				
				
				<div class="control-group">
					<label class="control-label" style="width:60px;">详情,##用于商店和攻略名称自动加链接，必须成对出现，否则会出错。。:</label>
					<div class="controls" style="margin-left:80px;width:90%;height:680px;" id="my_content"></div>
				</div>

			<?php endif;?>
		</div>
	</div>
</div>

