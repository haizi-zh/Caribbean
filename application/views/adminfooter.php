<!--
<script src="<?php echo $js_domain;?>/js/jquery/1.7.2/jquery.min.js?v=<?php echo $js_version;?>" type="text/javascript" type="text/javascript"></script>
-->
<script src="<?php echo $js_domain;?>/js/bootstrap/2.0.3/js/bootstrap.min.js?v=<?php echo $js_version;?>" type="text/javascript"></script>

<?php if($pageid == 'editshop' && $has_map && 0 ){?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJDyqjMCFstSfEonVKFTohMw9zL5fuVVU&sensor=true"></script>
<?php }?>

<!--
<?php if(  $pageid == 'dataanalytics' || $pageid == 'ana'){?>
<script type="text/javascript" src="<?php echo $js_domain;?>/js/admin/highstock.src.js?v=<?php echo $js_version;?>"></script>
<?php }?>
-->

<?php if($pageid == 'discount_add' || $pageid == 'discount_edit' || $pageid == 'discount_add_brand' || $pageid == 'shoptips_add' || $pageid == 'shoptips_edit' || $pageid == '1coupon'|| $pageid == 'directions1'
|| $pageid == 'coupon_add'
){?>
<script src="<?php echo $js_domain;?>/js/Lilac.js?v=<?php echo $js_version;?>" type="text/javascript"></script>
<!-- <script src="/js/common.js" type="text/javascript"></script> -->
<script src="<?php echo $js_domain;?>/js/plugins/Lilac.richEditor.js?v=<?php echo $js_version;?>" type="text/javascript"></script>
<script src="<?php echo $js_domain;?>/js/plugins/Lilac.popup.js?v=<?php echo $js_version;?>" type="text/javascript"></script>
<script src="<?php echo $js_domain;?>/js/admin/common.js?v=<?php echo $js_version;?>" type="text/javascript"></script>
<script src="<?php echo $js_domain;?>/js/jquery/jquery.colorbox.js?v=<?php echo $js_version;?>" type="text/javascript" type="text/javascript"></script>

<?php }?>


<!-- 配置文件 -->
<script src="<?php echo $js_domain;?>/js/admin/layer/layer.min.js" type="text/javascript" type="text/javascript"></script>
<?php if(isset($pageid) && $pageid):?>
<script src="<?php echo $js_domain;?>/js/admin/<?php echo $pageid?>.js" type="text/javascript"></script>
<?php endif;?>

<script src="<?php echo $js_domain;?>/js/My97DatePicker/WdatePicker.js" type="text/javascript" type="text/javascript"></script>
<script src="<?php echo $js_domain;?>/js/admin/jquery-ui-1.10.4.js>" type="text/javascript" type="text/javascript"></script>


<!--
<script type="text/javascript" src="<?php echo $js_domain;?>/js/daterangepicker/daterangepicker.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $js_domain;?>/js/daterangepicker/daterangepicker-bs3.css" />
-->

</body>
</html>
