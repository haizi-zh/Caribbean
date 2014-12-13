<div class="right_block">
	<div class="profile_info">
		<dl class="avatar_info clearfix">
			<dt class="fl">
				<a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo $ouid;?>">
					<img alt="出国购物" src="<?php echo isset($user_info['image'])?$user_info['image']:'';?>" width="80" height="80" title="<?php echo isset($user_info['uname'])?$user_info['uname']:'';?>">
				</a>
			</dt>
			<dd class="nameBox">
				<a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo $ouid;?>" class="name" title="<?php echo isset($user_info['uname'])?$user_info['uname']:'';?>"><?php echo isset($user_info['uname'])?$user_info['uname']:'';?></a>
			</dd>
			
			<?php if($suid == $ouid):?>
			<br><p><a href="<?php echo view_tool::echo_isset($domain);?>/setting">编辑信息</a></p>
			<?php endif;?>

			<?php if($relation!=2){?>
			<dd class="btn_bed">
				<!-- 切换class 改变关注状态-->
				<?php if($relation==0){?>
					<a class="W_btn_b" title="加关注" href="javascript:void(0);" action-type="follow" action-data="uid=<?php echo $user_info['uid'];?>"><span>关注</span></a>
				<?php }elseif($relation==1){?>
					<a class="W_btn_a" title="已关注" href="javascript:void(0);" action-type="unfollow" action-data="uid=<?php echo $user_info['uid'];?>"><span>已关注</span></a>
				<?php }?>
			</dd>
			<?php }?>
		</dl>
		<ul class="user_atten clearfix user_atten_l">
			<?php if($ouid == $suid):?>
			<li class="S_line2"><a href="<?php echo view_tool::echo_isset($domain);?>/friends?type=attentions&uid=<?php echo $user_info['uid'];?>"><strong><?php echo isset($user_info['attention_cnt'])?$user_info['attention_cnt']:0;?></strong><span>关注</span></a></li>
			<li class="S_line2"><a href="<?php echo view_tool::echo_isset($domain);?>/friends?type=fans&uid=<?php echo $user_info['uid'];?>"><strong ><?php echo isset($user_info['fans_cnt'])?$user_info['fans_cnt']:0;?></strong><span>粉丝</span></a></li>
			<?php endif;?>
			<li class="no_border"><a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?shaidan=1&uid=<?php echo $user_info['uid'];?>"><strong><?php echo isset($user_info['dianping_cnt'])?$user_info['dianping_cnt']:0;?></strong><span>晒单</span></a></li>
		</ul>
	</div>
</div>