<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>为<?php echo $coupon_info['title'];?>添加pdf文件</legend>


<?php echo form_open_multipart('/admin/coupon/do_upload');?>

<input type="file" name="userfile" size="20" />

<br/><br/>
<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
<input type="submit" value="添加" class="btn btn-large btn-primary"  />

</form>


          
	    </div>
	</div>
</div>

