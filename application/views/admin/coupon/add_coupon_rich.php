<div class="container" style="width:80%; margin-top:50px; ">
	<div class="row-fluid">
		<div class="span12 well form-horizontal bs-docs-example">
			<?php if(!$id):?>
				参数错误
			<?php else:?>
				<legend>编辑<?php echo $coupon_info['title'];?>-富文本信息 <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" id="add_coupon">修改</button></legend>


				<input type="hidden" id="id" name="id" value="<?php echo $coupon_info['id']?>" />
				<div style='visibility: hidden;'><textarea id="content_html" type="display:hidden;"><?php echo $coupon_info['body'];?></textarea></div>
				
				
				<div class="control-group">
					<label class="control-label" style="width:60px;">正文:</label>
					<div class="controls" style="margin-left:80px;width:90%;height:680px;" id="my_content"></div>
				</div>

			<?php endif;?>
		</div>
	</div>
</div>

