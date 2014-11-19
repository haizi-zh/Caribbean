<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加pdf优惠券</legend>
           <div class="control-group">
              	<label class="control-label" style="width:60px;">商家id:</label>
              	<div class="controls" style="margin-left:80px;" id="shop_ids">
                  <?php if($shop_ids):?>
                  <?php foreach($shop_ids as $v):?>
                  <input type="text" style="height:25px;width:200px;" placeholder="" id="shop_id" name="shop_id" value="<?php if($v) echo $v;?>">
                  <?php endforeach;?>
                  <?php else:?>
              		<input type="text" style="height:25px;width:200px;" placeholder="" id="shop_id" name="shop_id" value="<?php if($coupon_info) echo $coupon_info['shop_id'];?>">
                  <?php endif;?>
              	</div>
                
                若填写,是只给这个商家添加优惠券
           </div>
            <div class="control-group">
                <label class="control-label" style="width:60px;"></label>
                <div class="controls" style="margin-left:80px;"><a class="btn btn-link btn-primary" action-type="add_shop">添加一个商店</a></div>
            </div>

           <div id="brand_ids">
           <?php if($brand_infos):?>
           <?php foreach($brand_infos as $item):?>
           <div name="brand_item">
           <div class="control-group">
                <label class="control-label" style="width:60px;">品牌id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:200px;" placeholder="" action-type="brand_id" id="brand_id"  value="<?php if($item['brand_id']) echo $item['brand_id'];?>">
                  若填写,是只给这个拥有这个品牌的所有商家添加优惠券
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;"></label>
                <div class="controls" style="margin-left:80px;" id="country_list">
                  <?php if($item['country_ids']):?>
                  品牌分布的国家:
                  <?php foreach($item['brand_countrys'] as $country_id=>$country_name):?>
                  <input type='checkbox' name='country_ids' id='country_ids_<?php echo $country_id;?>' <?php if(in_array($country_id, $item['country_ids'])):?>checked=checked<?php endif;?> value='<?php echo $country_id;?>'/><?php echo $country_name;?>
                  <?php endforeach;?>
                  <?php endif;?>
                  （若不选择国家，则默认此品牌所有的商家都添加优惠券。若选择则只有选中国家的商家才显示。）
                </div>
           </div>
           </div>
         <?php endforeach;?>
         <?php else:?>
           <div name="brand_item">
           <div class="control-group">
                <label class="control-label" style="width:60px;">品牌id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:200px;" placeholder="" action-type="brand_id" id="brand_id"  value="">
                  若填写,是只给这个拥有这个品牌的所有商家添加优惠券
                </div>
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;"></label>
                <div class="controls" style="margin-left:80px;" id="country_list">
                </div>
           </div>
           </div>
           <?php endif;?>

           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;"></label>
                <div class="controls" style="margin-left:80px;"><a class="btn btn-link btn-primary" action-type="add_brand">添加一个品牌</a></div>
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;">显示级别:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:200px;" placeholder="" id="level" value="<?php if($coupon_info) echo $coupon_info['level'];?>">(数字，显示级别从0开始优先显示，同级别按时间倒序，默认1000)
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">标题:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="title" value="<?php if($coupon_info) echo $coupon_info['title'];?>">
                </div>
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;">折扣券描述:</label>

                <div class="controls" style="margin-left:80px;">
                <?php if($coupon_info && $coupon_info['is_rich'] ==0 ):?>
                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="body"><?php if($coupon_info) echo $coupon_info['body'];?></textarea>
                <?php else:?>
                <a target="_blank" class="btn btn-link btn-primary"  href="/admin/coupon/add_coupon_rich/?id=<?php  if($coupon_info) echo $coupon_info['id'];?>">去编辑富文本信息</a>
                <?php endif;?>
                </div>
                如要编辑富文本形式，请保存后，点击列表重的富文本编辑按钮来添加。
           </div>
           <br/>

           <div class="control-group">
                <label class="control-label" style="width:60px;">分享到第三平台文案（100字以内）:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="share_content"><?php if($coupon_info) echo $coupon_info['share_content'];?></textarea>
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">图片显示位置:</label>
                <div class="controls" style="margin-left:80px;">
                <select name="template_order" id="template_order">

                  <option value="0" <?php if($coupon_info && $coupon_info['template_order']==0 ):?>selected=selected<?php endif;?>><?php echo $template_order_list[0];?></option>
                  <option value="1" <?php if($coupon_info && $coupon_info['template_order']==1 ):?>selected=selected<?php endif;?>><?php echo $template_order_list[1];?></option>
                </select>
                </div>
           </div>
           <br/>

           <div class="control-group">
                <label class="control-label" style="width:60px;">图片显示尺寸:</label>
                <div class="controls" style="margin-left:80px;">
                <select name="img_size" id="img_size">
                  <option value="0" <?php if($coupon_info && $coupon_info['img_size']==0 ):?>selected=selected<?php endif;?>>小图</option>
                  <option value="1" <?php if($coupon_info && $coupon_info['img_size']==1 ):?>selected=selected<?php endif;?>>大图</option>
                </select>
                </div>
           </div>
           <br/>
           



           <?php 
           $pics= array();
           if($coupon_info){
            $pics = $coupon_info['pics'];
            if($pics){
              $pics = json_decode($pics, true);
              
            }
           
           }
           ?>
          <div class="control-group">
            <label class="control-label" style="width:60px;">上传图片:</label>
            <div class="controls" style="margin-left:80px;">
            <!--
            <img id="city_pic" src="<?php echo $pic;?>"></img><br>
            -->
            <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="upload_form" name="upload_form" enctype="multipart/form-data">
            <input type="hidden" name="policy" value="<?php echo $policy?>">
            <input type="hidden" name="signature" value="<?php echo $signature?>">
            <input type="file" id="upload_file" name="file">
            </form>
            </div>
            <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>
          </div>



           <div class="control-group">
                <label class="control-label" style="width:60px;">图片列表(拖动以排序):</label>
                <ul class="controls" id="my_list" style="margin-left:80px;">
                <?php if($pics):?>
                <?php foreach($pics as $pic):?>
                <li style="padding:5px;"><img  width='80' height='80' name='city_pic' src="<?php echo $pic;?>"></img></li>
                <?php endforeach;?>
                <?php endif;?>
                </ul>
           </div>

          <input type="hidden" id="id" name="id" value="<?php echo $id;?>">

          <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_coupon();" id="add_shoptips">添加</button>
	    </div>
	</div>
</div>

