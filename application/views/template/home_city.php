<?php $i=0;?>
<?php foreach($city_list as $item):?>
<?php $i++;if($i>18)break;?>
<li <?php if(isset($city_ids[$item['id']])):?>class="hot"<?php endif;?>>
<a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $item['lower_name'];?>/">
<span class="city_name">
<?php 
	$name_length = mb_strlen($item['name']);
	$fs_l = 30;
	if($name_length==5){
		$fs_l = 18;
	}elseif($name_length == 4){
		$fs_l = 24;
	}
?>
<em class="fs<?php echo $fs_l;?>"><?php echo $item['name'];?></em>
<em class="fs12"><?php echo $item['english_name'];?></em>
</span>
<span class="bg"></span>
</a>
</li>
<?php endforeach;?>