<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商店详情页</title>
<link rel="stylesheet" type="text/css" href="../css/common.css"/>
<link rel="stylesheet" type="text/css" href="../css/ZB_setting.css"/>
</head>
<body class="ZB_setting">
		<div class="ZB_shop_content clearfix">
			<div class="side_bar fl">
				<!--  这里是个人信息-->
				<div class="right_block">
					<div class="profile_info">
						<dl class="avatar_info clearfix">
							<dt class="fl">
								<a href="">
									<img rel="nofollow" src="<?php echo $userinfo['image']?>" width="80" height="80" alt="<?php echo $userinfo['uname']?>">
								</a>
							</dt>
							<dd class="nameBox">
								<a href="" class="name" title="<?php echo $userinfo['uname']?>"><?php echo $userinfo['uname']?></a>
							</dd>
						</dl>
						<ul class="user_atten clearfix user_atten_l">
							<li class="S_line2"><a href=""><strong><?php echo $userinfo['dianping_cnt']?></strong><span>点评</span></a></li>
							<li class="S_line2"><a href=""><strong><?php echo $userinfo['comment_cnt']?></strong><span>评论</span></a></li>
						</ul>
					</div>
				</div>
				<!--  /这里是个人信息-->

				<!-- 私信功能不做
				<div class="right_block">
					<div class="title">通用</div>
				</div>
				/私信功能 -->
			</div>
			<div class="setting fr">
				<!-- 个人信息 -->
				<div class="setting_wrap">
					<div class="info_list clearfix">
						<div class="tit fl">昵称：</div>
						<div class="inp">
							<input id="uname" type="text" class="W_input" value="<?php echo $userinfo['uname']?>"><span class="notice">6~16个字符组成，区分大小写</span>
						</div>
						<div class="tips"></div>
					</div>
					
					<div class="info_list clearfix">
						<div class="tit fl"><i>*</i>性别：</div>
						<div class="inp">
							<input name="gender" type="radio" <?php if($userinfo['gender'] == 1):?>checked=checked<?php endif;?> value="1"><span class="sex">男</span>
							<input name="gender" type="radio" <?php if($userinfo['gender'] == 0):?>checked=checked<?php endif;?> value="0"><span class="sex">女</span>
						</div>
						<div class="tips"></div>
					</div>

					<!-- 上传图片 -->
					<div class="upload_img">
						<p class="upload_title">从电脑中选择您喜欢的图片作为新的头像</p>
						<div class="select_btn">
							<a href="javascript:void(0);" class="post_btn"><input type="button" id="fileUploadBtn" class="file_btn">选择文件</a></div>
						<p class="pic_condition">您可以上传JPG、JPEG、BMP文件，文件最大为400KB</p>
						<div class="pic_wrap clearfix">
							<div class="pic_default fl">
							<!-- 替换这里的img src属性 并控制display属性-->
								<img rel="nofollow" src="" id="originImg" width="303" height="303" style="display:none">
								<input id="imgUrl" type="hidden" value=""> <!-- aj用的 -->
							</div>
							<div class="clip_wrap fl">
								<p>系统将自动为您生成三个不同尺寸的头像，请注意较小尺寸下观看头像是否清晰。</p>
								<div class="avatar_wrap">
									<span class="avatar_B" id="preview1"><img rel="nofollow" src="" width="120"  height="120" style="display: none;position: relative;"/></span>120X120
								</div>
								<div class="avatar_wrap">
									<span class="avatar_M" id="preview2"><img rel="nofollow" src="" width="50" height="50" style="display: none;position: relative;"/></span>50X50
									<span class="avatar_S" id="preview3"><img rel="nofollow" src="" width="30" height="30" style="display: none;position: relative;"/></span>30X30
								</div>
							</div>
						</div>
					</div>
					<!-- //上传图片 -->
					<!-- <input type="button" id="saveSetting" class="post_btn btn_wrap" value="保存"></input>-->
					 <div class="btn_wrap"><a href="javascript:void(0);" id="saveSetting" class="post_btn">保存</a></div>
					<!-- 上传头像的裁剪就拜托屌哥了 -->
				</div>
				<!-- /个人信息 -->

				<!-- 图片上传form -->
				<form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post"
					id="uploadForm" name="uploadForm" enctype="multipart/form-data">
                    <input type="hidden" name="policy" id="policy">
                    <input type="hidden" name="signature" id="signature">
                    <input type="file" id="uploadFile" name="file" style="-ms-filter:\'progid:DXImageTransform.Microsoft.Alpha(Opacity=0)\';filter:alpha(opacity=0);opacity:0;position: absolute;top: 261px;left: 503px;width: 80px;height: 40px;*height: 42px;">
                </form>
                <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>
		</div>


	</div>
</body>
</html>

