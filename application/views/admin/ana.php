<div class="container" style="margin-top:50px;width:95%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>数据统计</legend>
			<ul class="nav nav-tabs" id="nav_uls">
				<li class="active"><a href="javascript: void(0);" data-toggle="tab" node-data="<?php echo $all_slugs;?>">综合</a></li>
				<?php foreach($ana_urls as $slug => $item){?>
					<li><a href="javascript: void(0);" data-toggle="tab" node-data="<?php echo $slug;?>"><?php echo $item['name'];?></a></li>
				<?php }?>
			</ul>
            <div id="container" style="height: 500px; min-width: 500px"></div>
	    </div>
	</div>
</div>