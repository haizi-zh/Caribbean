<?php if($list):?>
<style type="text/css">
	table tr{height: 30px}
	table tr:nth-child(even){background: #ccc}
</style>
<table style="width:100%;text-align:center">
<?php foreach($list as $k=>$v):?>
<tr>
<?php foreach($v as $kk => $vv):?>
<td><?php echo $vv;?></td>
<?php endforeach;?>
</tr>
<?php endforeach;?>
</table>
<?php else:?>
你搜索的数据不存在。请反馈给我们做完善。谢谢。
<?php endif;?>