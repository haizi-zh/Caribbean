<html>
<head>
<title><?php if($this->config->item($pageid,'page_title_admin') !== FALSE) echo $this->config->item($pageid,'page_title_admin'); else echo $this->config->item('default','page_title_admin');?></title>


<meta http-equiv="content-type" content="text/html;charset=utf-8">
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/js/bootstrap/2.0.3/css/bootstrap.min.css?v=<?php echo $js_version;?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/common.css?v=<?php echo $js_version;?>"/>
<script src="<?php echo $js_domain;?>/js/jquery/1.7.2/jquery.min.js?v=<?php echo $js_version;?>" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $js_domain;?>/js/admin/highstock.src.js?v=<?php echo $js_version;?>"></script>

</head>

<script type="text/javascript">
    var $CONFIG =  {
       <?php if(isset($js_domain)):?>
       js_domain:'<?php echo $js_domain;?>',
       <?php endif;?>
       <?php if(isset($css_domain)):?>
       css_domain:'<?php echo $css_domain;?>',
       <?php endif;?>
       <?php if(isset($data_domain)):?>
       data_domain:'<?php echo $data_domain;?>',
       <?php endif;?>

    }
</script>

<body>
<?php if($pageid != 'login') {if(!$this->session->userdata('admin_login')) header("Location: /admin/login");}?>
<?php $power = $this->session->userdata('power');


?>
<div class="navbar navbar-fixed-top" style="filter:alpha(opacity=100);-moz-opacity:1;-khtml-opacity: 1;opacity: 1;">
	<div class="navbar-inner">
		<div class="container" style="width: auto;">
			<a class="brand" href="/admin" style="margin-left:0px;margin-right:10px;">Zanbai 管理后台</a>
			
			<?php if($pageid != 'login'){?>
			<ul class="nav" role="navigation">
				
<!-- 				<li class="dropdown"> -->
<!-- 					<a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">地域管理<b class="caret"></b></a> -->
<!-- 					<ul class="dropdown-menu" role="menu" aria-labelledby="drop1"> -->
<!-- 						<li><a tabindex="-1" href="/home">添加地域</a></li> -->
<!-- 						<li><a tabindex="-1" href="/home">添加国家</a></li> -->
<!-- 						<li><a tabindex="-1" href="/home">添加城市</a></li> -->
<!-- 					</ul> -->
<!-- 				</li> -->
				
<!-- 				<li class="divider-vertical"></li> -->
				<?php if(!$power):?>
				<li class="dropdown">
					<a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">景点管理 <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
						<li><a tabindex="-1" href="/admin/addshop">添加商家</a></li>
<!-- 						<li><a tabindex="-1" href="/admin/editshop">编辑商家</a></li>
						<li><a tabindex="-1" href="/admin/addshop/shoplist/">商家列表</a></li>
						<li><a tabindex="-1" href="/admin/addshop/repair_score">商家积分修复</a></li>
						<li><a tabindex="-1" href="/admin/taglist/">标签管理</a></li> -->
					</ul>
				</li>
				
                <!-- <li class="divider-vertical"></li>
				<li class="dropdown">
					<a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">品牌管理 <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
					  	<li><a tabindex="-1" href="/admin/setbrand">添加品牌</a></li>
					  	<li><a tabindex="-1" href="/admin/allbrand/?nocache=1">查看品牌</a></li>
					  	<li><a tabindex="-1" href="/admin/editbrand">编辑品牌</a></li>
					  	<li><a tabindex="-1" href="/admin/shopbrand">商家品牌管理</a></li>
					  	<li><a tabindex="-1" href="/admin/brandimport">商家品牌导入</a></li>
					  	<li><a tabindex="-1" href="/admin/brandtag/">品牌电商标签管理</a></li>
					</ul>
				</li>
				
				<li class="divider-vertical"></li>
				<li class="dropdown">
					<a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">运营设置 <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
					   <li><a tabindex="-1" href="/admin/setpic">设置首页轮播图片</a></li>
					  <li><a tabindex="-1" href="/admin/adminuser">为实习生添加账号</a></li>
					  	<li><a tabindex="-1" href="/admin/setpic/city">城市开放</a></li>

					  	<li><a tabindex="-1" href="/admin/discount/add">添加折扣</a></li>
					  	<li><a tabindex="-1" href="/admin/discount/brand_add">品牌折扣</a></li>

					  	<li><a tabindex="-1" href="/admin/discount/discount_list">折扣列表</a></li>

					  	<li><a tabindex="-1" href="/admin/discount/shoptips_add">添加购物攻略</a></li>
					  	<li><a tabindex="-1" href="/admin/discount/shoptips_list">购物攻略</a></li>

					  	<li><a tabindex="-1" href="/admin/coupon/lists">优惠券管理</a></li>

					  	<li><a tabindex="-1" href="/admin/ebusiness/elist">电商管理(考虑废弃)</a></li>

					  	<li><a tabindex="-1" href="/admin/links/cat">友情链接管理</a></li>

					  	<li><a tabindex="-1" href="/admin/ecommerce/cat">新增电商管理</a></li>

					  	<li><a tabindex="-1" href="/admin/content/lists">coupon统计维护</a></li>

					  	<li><a tabindex="-1" href="/admin/adv/">广告</a></li>
					</ul>
				</li>  -->
				
				<!--
				<li class="divider-vertical"></li>
				<li class="dropdown">
					<a href="#" id="drop4" role="button" class="dropdown-toggle" data-toggle="dropdown">晒单/评论删除 <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="drop4">
					  	<li><a tabindex="-1" href="/admin/delete">删除晒单</a></li>
					  	<li><a tabindex="-1" href="/admin/delete_comment">删除评论</a></li>
					</ul>
				</li>
				-->
				
				<!-- <li class=""><a tabindex="-1" href="/admin/dianping/ping/?user_eight=2">晒单</a></li>
				<li class=""><a tabindex="-1" href="/admin/dianping/comment/?user_eight=2">回复</a></li>
				<li class=""><a tabindex="-1" href="/admin/feedback/lists">问题反馈</a></li> -->
				
				<!--
				<li class="divider-vertical"></li>
				<li class="dropdown">
					<a href="#" id="drop5" role="button" class="dropdown-toggle" data-toggle="dropdown">数据统计<b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="drop5">
					  	<li><a tabindex="-1" href="/admin/dataanalytics">数据统计</a></li>
					  	<li><a tabindex="-1" href="/admin/ana/">数据统计</a></li>
					</ul>
				</li>
				-->
				<!--
				<li class=""><a tabindex="-1" href="/admin/home/zb_milestone">上线列表</a></li>-->
				<!-- <li class=""><a tabindex="-1" href="/dataformat/discount">折扣统计</a></li>

				<li class=""><a tabindex="-1" href="/admin/minitool">小工具</a></li> -->
			<?php else:?>

				<?php if($power == 3):?>
					  	<li><a tabindex="-1" href="/admin/setbrand">添加品牌</a></li>
					  	<li><a tabindex="-1" href="/admin/allbrand">查看品牌</a></li>
					  	<li><a tabindex="-1" href="/admin/editbrand">编辑品牌</a></li>
					  	<li><a tabindex="-1" href="/admin/shopbrand">商家品牌管理</a></li>
					  	<li><a tabindex="-1" href="/admin/brandimport">商家品牌导入</a></li>
				<?php endif;?>


			  <!-- <li><a tabindex="-1" href="/admin/setpic">设置首页轮播图片</a></li>-->
			  	<?php if($power == 1):?>
			  	<li><a tabindex="-1" href="/admin/discount/add">添加折扣</a></li>
			  	<li><a tabindex="-1" href="/admin/discount/brand_add">品牌折扣</a></li>
			  	<li><a tabindex="-1" href="/admin/discount/discount_list">折扣列表</a></li>
			  	<?php endif;?>
			  	<?php if($power == 2):?>
			  	<li><a tabindex="-1" href="/admin/discount/shoptips_add">添加购物攻略</a></li>
			  	<li><a tabindex="-1" href="/admin/discount/shoptips_list" target="_blank">购物攻略</a></li>
			  	<?php endif;?>

			<?php endif;?>
				<!-- <li class=""><a tabindex="-1" href="/admin/city">国家/城市id</a></li>
			</ul> -->
				
			<ul class="nav pull-right" style="margin-right:10px;">
				<li id="fat-menu">
                      <a href="javascript:;" id="drop6" role="button">欢迎您，管理员</a>
				</li>
				<li class="divider-vertical"></li>			
				<li id="fat-menu">
                      <a href="/admin/logout" id="drop6" role="button">退出</a>
				</li>
			</ul>
			<?php }?>
			
		</div>
	</div>
</div>
