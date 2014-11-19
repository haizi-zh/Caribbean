
<div>如果需要精确到国家或城市中的商家，请谨慎选择:</div>
<?php foreach($list as $area=>$country_list):?>
<table class="table table-bordered">
<tr class="success"><th>
州地区:<?php echo trim($areas[$area]['name']);?><input onclick="select_area(<?php echo $area;?>);" type="checkbox" id="area_<?php echo $area;?>" name="area" value="<?php echo $area;?>" />
</th></tr>

<?php foreach($country_list as $country=>$city_list):?>
<tr class="error"><th>
&nbsp;&nbsp;&nbsp;&nbsp;国家:<?php echo trim($countrys[$country]['name']);?><input onclick="select_country(<?php echo $country;?>);" type="checkbox" act-area-country="<?php echo $area;?>" id="country_<?php echo $country;?>" name="country" value="<?php echo $country;?>" />
</th></tr>


<?php foreach($city_list as $city=>$shop_list):?>
<tr class="error"><th>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;城市:<?php echo trim($citys[$city]['name']);?><input onclick="select_city(<?php echo $city;?>);" type="checkbox" act-country-city="<?php echo $country;?>" act-area-city="<?php echo $area;?>" id="city_<?php echo $city;?>" name="city" value="<?php echo $city;?>" />
</th></tr>
<tr>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<th style="padding-left:40px;">

<table class="table ">

<?php $shop_chunk_list = array_chunk($shop_list, 4);?>
<?php foreach($shop_chunk_list as $key => $shop_item):?>
<tr>
<?php foreach($shop_item as $shop_id => $shop):?>

<td>
<?php echo $shop['name'];?><input type="checkbox" name="shop" act-area="<?php echo $area;?>" act-country="<?php echo $country;?>" act-city="<?php echo $city;?>" value="<?php echo $shop['id'];?>" />
</td>
<?php endforeach;?>
</tr>
<?php endforeach;?>
</table>
</th></tr>
<?php endforeach;?>

<?php endforeach;?>

</table>
<?php endforeach;?>





