
<?php if(isset($fav_shops) && $fav_shops):?>
	<?php if($page==1):?>
		<div class="hidden_margin" id="shop_list">
	<?php endif;?>

	<?php foreach($fav_shops as $shop):?>
		<div class="shop_single fl clearfix">
			<div class="avatar_wrap fl">
				<a href="<?php echo $shop['ext']['shop_url'];?>">
				<img src="<?php echo $shop['pic'];?>" width="172" height="130" class="shop_avatar"/>
				</a>
			</div>
			<div>
				<h3 class="shop_name" ><a href="<?php echo $shop['ext']['shop_url'];?>"><?php echo $shop['name'];?></a></h3>
				<?php if(0&&$shop['discount_info']):?>
				
				<a href="/discount/<?php echo $shop['discount_info']['id'];?>/">
				<span class="card_icon_black">折扣</span>
				</a>
				<?php endif;?>
				<div><a class="disable_btn_small" href="javascript:;" action-type="unfav" action-data="id=<?php echo $shop['id'];?>&type=0">已收藏</a></div>

				<div class="rating_wrap_small">
					<span title="<?php echo $shop['score'] ?>星商户" class="star star<?php echo $shop['score']?>0"></span>
				</div>

				<div class="comment_num"><a href="<?php echo $shop['ext']['shop_url'];?>" class="num linkb"><?php echo $shop['ext']['dianping_cnt'];?>条</a>网友评论</div>
			</div>
		</div>
	<?php endforeach;?>

	<?php if($page==1):?>
		</div>
		<?php if($fav_shops_count > 4):?>
		<p class="clearfix tar"><a href="javascript:;" class="more" id="shop_more" action-type="shop_more" action-data="2">更多<span class="moredown"></span></a></p>
		<?php endif;?>
	<?php endif;?>

<?php endif;?>

