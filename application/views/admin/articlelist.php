<div class="container" style="margin-top:50px;width:87%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>查看全部</legend>                      

			<div id="info_html">
				<?php foreach($infos as $info){?>
					<div style="margin-top:20px;padding:5px;border:2px double #3299CC;margin-right: 20px;width: 200px;float: left;">
						<p style="font-family:Times;font-weight:bold;color:#3299CC">ID:</p>
						<p style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;height: 19px">
							<?php echo $info->_id;?></p>
						<p style="font-family:Times;font-weight:bold;color:#3299CC">TITLE:</p>
						<p style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;height: 19px">
							<?php echo $info->title;?></p>
						<p style="font-family:Times;font-weight:bold;color:#3299CC">AUTHOR:</p>
						<p style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;height: 19px">
							<?php echo $info->authorname;?></p>
						<p style="font-family:Times;font-weight:bold;color:#3299CC">SOURCE:</p>
						<p style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;height: 19px">
							<?php echo $info->source;?></p>
						<p style="font-family:Times;font-weight:bold;color:#3299CC">PUBLISHTIME:</p>
						<p style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;height: 19px">
							<?php date_default_timezone_set("Asia/Shanghai");?>
							<?php echo date("Y-m-d", $info->publishtime/1000);?>
						<p style="font-family:Times;font-weight:bold;color:#3299CC">DESC:</p>
						<p style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;height: 19px">
							<?php echo $info->desc;?></p>
						<p style="font-family:Times;font-weight:bold;color:#3299CC">IMAGE:</p>
						<p style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden">
							<img src="<?php if ($info->images && $info->images[0] && $info->images[0]['url']) echo $info->images[0]['url']; ?>" width="200" height="150"/></p>
						<p><a target="_blank" class="btn-mini btn-primary" href="/admin/articleedit?article_id=<?php echo $info->_id;?>&nocache=1">编辑</a></p>
					</div>
				<?php }?>
			</div>
	    </div>

	    <div class="pagination" style="margin-left: 15px;">
				<?php if($page_html) echo $page_html?>
		</div>
	</div>
</div>