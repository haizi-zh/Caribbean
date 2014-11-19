<div class="ZB_shop_content clearfix">

	<div class="side_bar fl">
		<!--  这里是关注列表信息-->
		<div class="right_block">
			<div class="profile_info">
				<dl class="avatar_info clearfix">
					<dt class="fl">
						<a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo $user_info['uid'];?>">
							<img rel="nofollow" alt="出境购物" src="<?php echo $user_info['image'];?>" width="80" height="80" alt="<?php echo $user_info['uname'];?>">
						</a>
					</dt>
					<dd class="nameBox">
						<a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo $user_info['uid'];?>" class="name" title="<?php echo $user_info['uname'];?>"><?php echo $user_info['uname'];?></a>
					</dd>
				</dl>
				<ul class="user_atten clearfix user_atten_l">
					<?php if($login_uid == $user_info['uid']):?>
					<li class="S_line2"><a href="<?php echo view_tool::echo_isset($domain);?>/friends?type=attentions&uid=<?php echo $user_info['uid'];?>"><strong><?php echo $user_info['attention_cnt'];?></strong><span>关注</span></a></li>
					<li class="S_line2"><a href="<?php echo view_tool::echo_isset($domain);?>/friends?type=fans&uid=<?php echo $user_info['uid'];?>"><strong><?php echo $user_info['fans_cnt'];?></strong><span>粉丝</span></a></li>
					<?php endif;?>
					<li class="no_border"><a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?shaidan=1&uid=<?php echo $user_info['uid'];?>"><strong><?php echo $user_info['dianping_cnt'];?></strong><span>晒单</span></a></li>
				</ul>
			</div>
		</div>

		<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
		<!--  /这里是个人信息-->
	</div>

	<div class="friends_list fr">
		<div class="friend_list"><b><?php if($type == 'fans') echo '粉丝';elseif($type == 'attentions') echo '关注人';?>列表</b></div>
		<div class="friends_wrap fr">
			<?php if(isset($user_infos) && $user_infos):?>
			<?php foreach($user_infos as $user){?>
			<div class="friend">
				<div class="profile_info">
					<dl class="avatar_info clearfix">
						<dt class="fl">
							<a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?shaidan=1&uid=<?php echo $user['uid'];?>">
								<img rel="nofollow" alt="出境购物" src="<?php echo $user['image'];?>" width="80" height="80" alt="<?php echo $user['uname'];?>">
							</a>
						</dt>
						<dd class="nameBox">
							<a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?shaidan=1&uid=<?php echo $user['uid'];?>" class="name" title="<?php echo $user['uname'];?>"><?php echo $user['uname'];?></a>
						</dd>
						<dd class="sexBox">
							<span><?php if($user['gender']) echo  '男'; else echo '女';?></span>
						</dd>
						
							<!-- 切换class 改变关注状态-->
							<!-- <a action-type="unfollow" action-data="uid=<?php echo $user['uid'];?>" class="W_btn_a" title="已关注" href="javascript:void(0);"><span>已关注</span></a> -->
							<!--<a class="W_btn_a" title="已关注" href="javascript:void(0);"><span>已关注</span></a> -->

							<?php if($user['relation']!=2){?>
							<dd class="btn_bed">
								<!-- 切换class 改变关注状态-->
								<?php if($user['relation']==0){?>
									<a class="W_btn_b" title="加关注" href="javascript:void(0);" action-type="follow" action-data="uid=<?php echo $user['uid'];?>"><span>关注</span></a>
								<?php }elseif($user['relation']==1){?>
									<a class="W_btn_a" title="已关注" href="javascript:void(0);" action-type="unfollow" action-data="uid=<?php echo $user['uid'];?>"><span>已关注</span></a>
								<?php }?>
							</dd>
							<?php }?>

						
					</dl>
					<ul class="user_atten clearfix user_atten_l">
						<!--
						<li class="S_line2"><a href="<?php echo view_tool::echo_isset($domain);?>/friends?type=attentions&uid=<?php echo $user['uid'];?>"><strong><?php echo $user['attention_cnt'];?></strong><span>关注</span></a></li>
						<li class="S_line2"><a href="<?php echo view_tool::echo_isset($domain);?>/friends?type=fans&uid=<?php echo $user['uid'];?>"><strong><?php echo $user['fans_cnt'];?></strong><span>粉丝</span></a></li>
						-->
						<li class="no_border"><a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?shaidan=1&uid=<?php echo $user['uid'];?>"><strong ><?php echo $user['dianping_cnt'];?></strong><span>晒单</span></a></li>
					</ul>
				</div>
			</div>
			<?php }?>
			<?php else:?>
				<div class="info_blank"><p>
				<?php if($type == 'fans'):?>
				还没有人关注呦，叫好朋友一起来吧
				<?php else:?>
				还没有关注人呦
				<?php endif;?>
				</p>
				</div>

			<?php endif;?>
		</div>
	</div>
</div>