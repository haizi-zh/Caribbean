<!doctype html>
<html>
<?php
$js_version = context::get('js_version', '');
$js_domain = context::get('js_domain', '');
$css_domain = context::get('css_domain', '');
$use_fe = context::get('use_fe', '');
?>
<head>
<meta charset="utf-8">
<title>城市列表页</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php if(isset($page_css) && $page_css):?>
<?php foreach($page_css as $item_css):?>
<link rel="stylesheet" type="text/css" charset="utf-8" href="<?php echo $css_domain;?><?php echo $item_css;?>?v=<?php echo $js_version;?>">
<?php endforeach;?>
<?php endif;?>
<script type="text/javascript" name="baidu-tc-cerfication" src="http://apps.bdimg.com/cloudaapi/lightapp.js#1c382e87125da1b22383bb804a05fd77"></script><script type="text/javascript">window.bd && bd._qdc && bd._qdc.init({app_id: '4ccd56c9ce2095cbfee843cc'});</script>
</head>
<body class="<?php if(isset($body_class) && $body_class) echo $body_class;?>">

<!--
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>商店列表页</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="stylesheet" type="text/css" charset="utf-8" href="../../../css/h5/page/city_list.css">
</head>
<body class="shop_list">-->