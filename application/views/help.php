<div class="ZB_shop_content clearfix">

			<div class="side_bar fl">
				<ul class="help_nav_wrap clearfix" id="help_nav">
					<li><a id="info" href="<?php echo view_tool::echo_isset($domain);?>/help/1" <?php if($tab == 1) {?> class="cur" <?php }?> action-type="changeTab" action-data="target=info">关于赞佰</a></li>
					<li><a id="contact" href="<?php echo view_tool::echo_isset($domain);?>/help/2" <?php if($tab == 2) {?> class="cur" <?php }?> action-type="changeTab" action-data="target=contact">联系我们</a></li>
					<li><a id="duty" href="<?php echo view_tool::echo_isset($domain);?>/help/3" <?php if($tab == 3) {?> class="cur" <?php }?> action-type="changeTab" action-data="target=duty">服务条款</a></li>
				</ul>
			</div>
			<div class="help_wrap fr" id="help_content">
				<?php if($tab==1) { ?>
				<!-- 帮助 -->
				<div class="help_info" node-type="info">
					<h2><span class="title_dot"></span>关于赞佰</h2>
					<div class="info_content">
						<p>想去别的城市购物，都应该去哪里逛呢？</p>
						<p>最近有没有入手几件心仪已久的东东呢？</p>
						<p>有没有遇上什么让人不敢相信的折扣呢？</p>
						<p>想送给特别的她一份礼物，该买什么呢？</p>
						<br/>
						<p>赞佰网收录全球主要购物城市的百货商家名录，致力于成为全球华人的购物指南。成为大家发现商家，记录和分享购物体验的网上社区。</p>
						<p>以下是我们秉承的生活理念：<br/>
						购，助美好生活！<br/>
						带上心爱的人去Shopping吧！<br/>
						分享购物的喜悦！</p>
						<p>对于我们来说，购物的喜悦并不在于不看价签肆意挥洒的酣畅淋漓，而是从眼花缭乱的万千货品中，发现一件恰和心意物品所带来的惊喜。也不在于对大牌奢侈品的狂热追捧，而是对高性价比的永远追求。对于超乎想象的大幅折扣的偶遇，捡到真正便宜货的同时，不在品质和品味上作出丝毫的让步。在于以远低于预期价格购入心仪物品的极大满足感。在于朋友们惊讶和羡慕的表情。在于做出明智的购物选择。在于给生活品质带来的实实在在的提升...</p>
						<p>本站使用第三方账号认证，您的登陆密码并不经过我们的服务器。通过第三方账号登陆后，您可以更改显示的名称和头像。</p>
						<p>赞佰网是北京赞佰千华网络科技有限公司旗下的全球百货攻略网站。</p>
					</div>
				</div>
				<?php } 
					else if($tab == 2) {
				?>
				<!-- 欢迎联系我们 -->
				<div class="help_info" node-type="contact">
					<h2><span class="title_dot"></span>联系我们</h2>
					<div class="info_content">
						<p>我们的产品一直在不断的完善和改进过程中。如果您在使用中发现了什么问题？发现了网页中有错误？ 有什么批评意见和改进的建议？我们非常愿意听到您的反馈。
一切关于购物的话题，有什么不错的想法？我们都想和您交流。</p>
						<p>请致信：<a href=mailto:feedback@zanbai.com><span class="spetex">feedback@zanbai.com</span></a></p>

						<p>希望探讨任何商业合作的潜在机会。</p>
						<p>请致信：<a href=mailto:bd@zanbai.com><span class="spetex">bd@zanbai.com</span></a></p>
						<p>联系电话：<span class="spetex">010-82168082</span></p>
					</div>
				</div>
				<?php }
					else if($tab ==3) {
				?>
				<!-- 友情链接 -->
				<div class="help_info"  node-type="duty">
					<h2><span class="title_dot"></span>服务条款</h2>
					<div class="info_content">
						<p>在使用赞佰网之前，请您务必仔细阅读本网站条款。您的使用行为将被视为对本声明的认可。</p>
						<p><b>所有权和版权</b></p>
						<p>北京赞佰千华网络科技有限公司（赞佰网）拥有本站内容版权和其它相关知识产权。</p>
						<p>未经本公司书面许可，任何人不得复制或以其他任何方式使用本站内容。对不遵守本声明或其他违法、恶意使用本网站内容者，本公司保留追究其法律责任的权利。</p>
						<p><b>免责声明</b></p>
						<p>如果您向赞佰网发布内容，您需要保证，</p>
						<p>1. 拥有您上传到本网站的所有内容的版权或拥有内容所有者的上传许可。<br/>
							2. 能够授予赞佰网相关的权利。<br/>
							3. 不得利用本站制作、复制、查阅和传播下列信息：<br/>
							&nbsp;&nbsp;a.煽动抗拒、破坏宪法和法律、行政法规实施的；<br/>
   &nbsp;&nbsp;b.煽动颠覆国家政权，推翻社会主义制度的；<br/>
   &nbsp;&nbsp;c.煽动分裂国家、破坏国家统一的；<br/>
   &nbsp;&nbsp;d.煽动民族仇恨、民族歧视，破坏民族团结的；<br/>
   &nbsp;&nbsp;e.捏造或者歪曲事实，散布谣言，扰乱社会秩序的；<br/>
   &nbsp;&nbsp;f.宣扬封建迷信、淫秽、色情、赌博、暴力、凶杀、恐怖，教唆犯罪的；<br/>
   &nbsp;&nbsp;g.公然侮辱他人或者捏造事实诽谤他人的；<br/>
   &nbsp;&nbsp;h.损害国家机关信誉的；<br/>
   &nbsp;&nbsp;i.其他违反宪法和法律、行政法规的。<br/>
						</p>
						<p>对于因不满足上述要求所引起的法律传唤、指控、诉讼等，以及因此导致的一切损失、赔偿和费用，赞佰网将不负担任何法律责任。</p>
						<p>赞佰网的部分信息取自互联网，或由第三方和网友提供。赞佰网不保证其准确性。<br/>
赞佰网对使用本站信息造成的一切后果不做任何形式的保证，亦不承担任何法律责任。<br/>
赞佰网可以随时修改或中断服务而不通知用户，亦不承担任何法律责任。<br/>
赞佰网保留删除站内内容而不通知用户的权利。
						</p>
						<p><b>版权投诉</b></p>
						<p>任何单位或个人认为，赞佰网提供的内容侵犯了您的版权，需要赞佰网采取删除、屏蔽等必要措施的。请提供如下所要求的通知书。<br/>
						版权投诉通知书应包含下列内容：<br/>
a.权利人的姓名及联系方式和地址。<br/>
b.明确指出声称被侵权的内容。<br/>
c.构成侵权的证明材料。<br/>
d.纳入如下声明：“本人本着诚信原则，认为被侵犯版权的材料未获得版权所有人、其代理或法律的授权。本人承诺投诉全部信息真实、准确，否则自愿承担一切后果。”
						</p>
						<p>邮寄地址：北京市海淀区北四环西路9号2104-145      邮 编：100080</p>
						<p>客服信箱：<a href=mailto:support@zanbai.com><span class="spetex">support@zanbai.com</span></a></p>
						<p>任何法律问题，将依照中华人民共和国的法律予以处理。</p>
					</div>
				</div>
				<?php  }?>
			</div>
		</div>