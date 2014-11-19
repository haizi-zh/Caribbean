<div class="container" style="margin-top:50px;width:87%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>查看所有品牌</legend>                      
           	<div>
				<?php foreach($first_chars as $char){?>
					<!-- 
					<a href="javascript: void(0);" style="margin-right:10px;font-size:20px;" onclick="getbrandhtml('<?php echo $char;?>');"><b><?php echo $char;?></b></a>
					-->
					<a href="/admin/allbrand/?s_char=<?php echo $char;?>&nocache=1" style="margin-right:10px;font-size:20px;"><b><?php echo $char;?></b></a>

				<?php }?>
			</div>
			<br><label id="char_label">当前首字母：<?php echo $s_char;?></label>
			<div id="brands_html">
				<?php foreach($brands as $brand){?>
					<div style="margin-top:10px;padding:5px;border:1px dashed gray;margin-right: 10px;width: 200px;float: left;">
						<?php if($s_char != 'All'):?>
							
						    <!--
							<a data-toggle="modal" href="#confirm">
	                            <img onclick="set_brand(<?php echo $brand['id'];?>, '<?php echo urlencode($brand['name']);?>')" src="/images/admin/cross.png" style="float:right">
	                        </a>-->

							<p>id：<?php echo $brand['id'];?></p>
							<p>默认名称：<?php echo $brand['name'];?></p>
							<p>备选名称：<?php echo $brand['english_name'];?></p>
							<p>描述：<?php echo $brand['desc'];?></p>
							
							<p>图片：<img src="<?php echo $brand['big_pic'];?>" width="80" height="80"></p>
							<p>电商：<?php echo $brand['eb_name'];?></p>
							<p>电商url：<?php echo $brand['eb_url'];?></p>
							<p>电商标签:
								<?php if($brand['brandtags']):?>
								<?php foreach($brand['brandtags'] as $brandtag_id => $v):?>
								<?php echo $brandtag_list[$brandtag_id]['name']." ";?>
								<?php endforeach;?>
								<?php endif;?>
							</p>
							<p><a target="_blank" class="btn-mini btn-primary" href="/admin/editbrand?brand_id=<?php echo $brand['id'];?>">编辑</a></p>
						<?php else:?>

							<!--<a data-toggle="modal" href="#confirm">
	                            <img onclick="set_brand(<?php echo $brand['id'];?>, '<?php echo urlencode($brand['name']);?>')" src="/images/admin/cross.png" style="float:right">
	                        </a>-->
							<p>id：<?php echo $brand['id'];?></p>
							<p><?php echo $brand['name'];?></p>
							<p>备:<?php echo $brand['english_name'];?></p>
							<p><a target="_blank" class="btn-mini btn-primary" href="/admin/editbrand?brand_id=<?php echo $brand['id'];?>">编辑</a></p>
						<?php endif;?>
					</div>
				<?php }?>
			</div>
			<div id="brand_id" style="display:none"></div>

			<!-- Modal -->
			<div class="modal fade" id="confirm">
				<div class="modal-dialog">
				  <div class="modal-content">
				    <div class="modal-header">
				      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				      <h4 class="modal-title">删除品牌</h4>
				    </div>
				    <div class="modal-body">
				    	确定要删除品牌 <b id="brand_name"></b> 吗？
				    </div>
				    <div class="modal-footer">
				      <a href="#" onclick="delete_brand();" class="btn btn-primary">确认</a>
				      <a href="#" class="btn" data-dismiss="modal">取消</a>
				    </div>
				  </div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

	    </div>
	</div>
</div>