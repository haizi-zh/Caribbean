<?php if(isset($shop_infos) && $shop_infos):?>
	<div class="right_block">
		<div class="title">推荐商家</div>
		<ul class="discont_list">
			<?php $i=0;?>
			<?php foreach($shop_infos as $key=>$shop):?>
			<?php $i++;?>
			<li <?php if($i > 3):?>style="display:none;" name="hidden_shops" <?php endif;?>>
				<a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_infos[$shop['city']]['lower_name'];?>/<?php echo $shop['id'];?>/" title="<?php echo $shop['name'];?>" class="textb">
				<img rel="nofollow" src="<?php echo $shop['pic'];?>" alt="<?php echo $shop['name'];?>" width="120" height="80" class="shop_avatar"/>
				<span class="shop_name"><?php echo $shop['name'];?></span>
				</a>
			</li>
			<?php endforeach;?>
		</ul>
		<?php if($show_more == 1):?>
		<p class="clearfix"><a href="javascript:;" id="show_more_nearby_shops" action-type="show_more" class="more">更多商家<span class="moredown"></span></a></p>
		<?php endif;?>
	</div>
<?php endif;?>

