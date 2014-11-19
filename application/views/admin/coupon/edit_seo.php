<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<?php if(!$id):?>
				参数错误
			<?php else:?>
				<legend>编辑<?php echo $title;?>信息</legend>

				<div class="control-group">
					<label class="control-label" style="width:60px;">seo标题:</label>
					<div class="controls" style="margin-left:80px;">
						<input type="text" style="height:25px;width:500px;" placeholder="" id="seo_title" value="<?php echo $seo_title;?>">
					</div>
				</div>

	           <div class="control-group">
	                <label class="control-label" style="width:60px;">seo的keywords:</label>
	                <div class="controls" style="margin-left:80px;">
	                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="seo_keywords"><?php echo $seo_keywords;?></textarea>
	                </div>
	           </div>

	           <div class="control-group">
	                <label class="control-label" style="width:60px;">seo的description:</label>
	                <div class="controls" style="margin-left:80px;">
	                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="seo_description"><?php echo $seo_description;?></textarea>
	                </div>
	           </div>

				<input type="hidden" id="id" name="id" value="<?php echo $id?>" />
				<button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_seo()" id="edit_discount">修改</button>
			<?php endif;?>
		</div>
	</div>
</div>

