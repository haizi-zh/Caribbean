<?php
$no_cache = 0;
if($_GET && isset($_GET['no_cache']) && $_GET['no_cache']==1){
	$no_cache = 1;
}
if($_SERVER && isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']=="nocache=1"){
	$no_cache = 1;
}
?>
<div style="display:none">
<?php if($_SERVER['SERVER_NAME']!='zan.com' && $no_cache==0):?>
<script type="text/javascript">

var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");

document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fff68fee1a56f64563d79ce07806ff504' type='text/javascript'%3E%3C/script%3E"));

</script>
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000199935'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1000199935%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>

<?php endif;?>
</div>
</body>
</html>