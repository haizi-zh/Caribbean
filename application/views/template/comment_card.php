
<?php foreach($comments as $comment){?>
	<div class="list clearfix" action-type="replyComment">
		<div style="display:none" id="comment_id"><?php echo $comment['id'];?></div>
		<a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo $comment['uid'];?>" target="_blank" class="avatar" ><img rel="nofollow" src="<?php echo $users[$comment['uid']]['image'];?>" width="30" height="30"/></a>
		<div class="right_comment">
			<a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo $comment['uid'];?>" target="_blank"  class="linkb"><?php echo $users[$comment['uid']]['uname'];?>：</a>
			<?php if(isset($comment['ouser'])){?>
				回复 <a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo $comment['ouser']['uid'];?>" target="_blank"  class="linkb"><?php echo $comment['ouser']['uname'];?>：</a>
			<?php }?>
			<span><?php echo $comment['content'];?></span>
		</div>
		<div class="reply_comment" action-type="toggleReplyDiv">
			<a href="javascript:void(0);">回复</a>
		</div>
		<div class="reply_comment_container clearfix">
			<textarea id="commentContent"></textarea>
			<div class="btn_wrap fr">
				<a href="javascript:void(0);" action-type="sendComment" action-data="dianping_id=<?php echo $dianping_id;?>&ocid=<?php echo $comment['id'];?>&type=<?php echo $type;?>" class="post_btn">
					发送
				</a>
			</div>
		</div>
	</div>
<?php }?>
<?php if(isset($page_html) && $page_html):?>
<div class="quotes fr" id="page_container">
<?php echo $page_html;?>
</div>
<?php endif;?>