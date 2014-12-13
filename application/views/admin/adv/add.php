<div class="container" style="margin-top:50px;width:95%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加广告</legend>

           <div class="control-group">
                <label class="control-label" style="width:60px;">广告类型:</label>
                <div class="controls" style="margin-left:80px;">
                  <select id="type">
                  <?php if(isset($adv_types) && $adv_types):?>
                  <?php foreach($adv_types as $type_id=>$type_name):?>
                  <option <?php if($info && $info['type'] == $type_id):?>selected="selected"<?php endif;?> value="<?php echo $type_id;?>"><?php echo $type_name;?></option>
                  <?php endforeach;?>
                  <?php endif;?>
                  </select>
                </div>
            </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">国家id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="country" value="<?php if($info && $info['country']) echo substr($info['country'],1,-1);?>"><span style="color:red;">(可不填写，如填写，则本国家所有城市,商店可见,英文逗号分隔多个国家id。)</span>
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">城市id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="city" value="<?php if($info && $info['city']) echo substr($info['city'],1,-1);?>"><span style="color:red;">(可不填写，如填写，则本市所有商店可见,英文逗号分隔多个城市id。)</span>
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">商家id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="shop_id" value="<?php if($info && $info['shop_id']) echo substr($info['shop_id'],1,-1);?>">
                </div>
           </div>


           <div class="control-group">
                <label class="control-label" style="width:60px;">排除的城市id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="n_city" value="<?php if($info && $info['n_city']) echo substr($info['n_city'],1,-1);?>"><span style="color:red;">(可不填写，如填写，则非本市所有商店可见,英文逗号分隔多个城市id。)</span>
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">排除的商家id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="n_shop_id" value="<?php if($info && $info['n_shop_id']) echo substr($info['n_shop_id'],1,-1);?>">
                </div>
           </div>
           
           <div class="control-group">
                <label class="control-label" style="width:60px;">排除的coupon_id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="n_coupon_id" value="<?php if($info && $info['n_coupon_id']) echo substr($info['n_coupon_id'],1,-1);?>">
                </div>
           </div>
           

          <div class="control-group">
            <label class="control-label" style="width:60px;">上传图片:</label>
            <div class="controls" style="margin-left:80px;">
            <img id="pic_src" src="<?php echo $imgdomain;?><?php if($info && $info['pic']) echo $info['pic'];?>" width="50" height="50"></img><br>
            <input type="hidden" name="pic" id="pic" value="<?php if($info && $info['pic']) echo $info['pic'];?>">
            <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="upload_form" name="upload_form" enctype="multipart/form-data">
            <input type="hidden" name="policy" value="<?php echo $policy?>" >
            <input type="hidden" name="signature" value="<?php echo $signature?>">
            <input type="file" id="upload_file" name="file">
            </form>
            </div>
            <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>
          </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">名称:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="name" value="<?php if($info && $info['name']) echo $info['name'];?>">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">url:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="url" value="<?php if($info && $info['url']) echo $info['url'];?>">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">显示级别:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:200px;" placeholder="" id="level" value="<?php if($info && $info['level']) echo $info['level'];?>">(数字，显示级别从0开始优先显示，同级别按时间倒序，默认1000)
                </div>
           </div>
          <input type="hidden" id="id" name="id" value="<?php if($id) echo $id;?>">
          
          <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;"  id="adv_add">添加</button>
	    </div>
	</div>
</div>

