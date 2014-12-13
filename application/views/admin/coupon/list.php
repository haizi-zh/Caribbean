<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">

<div class="row-fluid">
    <div class="span12 well well-large form-horizontal bs-docs-example">
    <form class="form-inline">
              <div class="input-prepend">
                <label class="control-label" style="width:60px;">id:</label>
                <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="id" name="id" value="<?php if(isset($id) && $id) echo $id?>">
              </div>
              <div class="input-prepend">
                <label class="control-label" style="width:60px;">商家ID:</label>
                <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="shop_id" name="shop_id" value="<?php if(isset($shop_id) && $shop_id)  echo $shop_id?>">
              </div>

              <div class="input-prepend">
                <label class="control-label" style="width:60px;">品牌id:</label>
                <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="brand_id" name="brand_id" value="<?php if(isset($brand_id) && $brand_id)  echo $brand_id?>">
              </div>
              

              <div class="input-prepend">
                <label class="control-label" style="width:60px;">状态:</label>
                <select style="height:25px;margin-left:25px;width:100px;" name="status" id="status">
                <?php foreach($status_list as $k=>$v):?>
                <option <?php if($status == $k):?>selected=true<?php endif;?> value="<?php echo $k;?>"><?php echo $v;?></option>
                <?php endforeach;?>
                </select>
              </div>
            <button class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;">筛选</button>
    </form>
    </div>
</div>



<a target="_blank" href="/admin/coupon/add_coupon" class="btn btn-link btn-primary">添加优惠券</a>




<table class="table table-bordered">
 <thead>
    <tr>

      <th>优惠券ID</th>
      <th>类型</th>
      <th>商家ID</th>
      <th>商家</th>
      <th>标题</th>
      <th>正文</th>
      <th>显示国家</th>
      <th>显示级别</th>
      <th>状态</th>
      <th>开放/关闭</th>
      <th>编辑</th>
      <th>图片</th>
      <th>pdf</th>
      <th>IOS图片</th>
      <th>上传pdf</th>
      <th>上传IOS高清图片</th>
      <th>SEO</th>
      <th>创建时间</th>
      <th>编辑时间</th>

    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $v['id'];?></th>
      <th><?php if($v['brand_id']) echo "品牌优惠券"; else echo "商场优惠券";?></th>
      <th title="<?php echo $v['shop_id'];?>"><?php echo tool::substr_cn2($v['shop_id'], 10);?></th>
      
      <th><?php if($v['shop_info'] && isset($v['shop_info']['name'])) echo $v['shop_info']['name'];?></th>
      
      <th><?php echo $v['title'];?></th>

      <th id="body_<?php echo $v['id'];?>" ><?php echo tool::substr_cn2($v['body'],100);?><span action-type="show_more" action-data="<?php echo $v['id'];?>" class="btn btn-link btn-primary">展开更多<span><div id="more_<?php echo $v['id'];?>" style="display:none;"><?php echo $v['body'];?></div></th>
      <th>
      <?php 
      if($v['country_ids']){
        $tmp_country_ids = explode(',', $v['country_ids']);
        foreach($tmp_country_ids as $country_id){
          if(isset($all_countrys[$country_id])){
            echo $all_countrys[$country_id]['name'].",";
          }
        }
      }

      ?>
      </th>
      <th><?php echo $v['level'];?></th>
      <th style="color:red;"><?php echo $status_list[$v['status']];?></th>
      <?php if($v['status']== 0):?>
      <th ><a href="javascript:;" class="btn btn-link btn-primary"  onclick="delete_coupon(<?php echo $v['id']?>)">关闭</a></th>
      <?php else:?>
      <th><a href="javascript:;" class="btn btn-link btn-primary"  onclick="recover_coupon(<?php echo $v['id']?>)">开放</a></th>
      <?php endif;?>


      <th>
        <a target="_blank" class="btn btn-link btn-primary"  href="/admin/coupon/add_coupon/?id=<?php  echo $v['id'];?>">编辑基本信息</a>
        <a target="_blank" class="btn btn-link btn-primary"  href="/admin/coupon/add_coupon_rich/?id=<?php  echo $v['id'];?>">编辑富文本信息</a>
      </th>

      <th>
      <?php if($v['pics']):?>
      <?php $pics = $v['pics'];$pics = json_decode($pics, true);?>
      <?php foreach($pics as $pic):?>
      <img src="<?php echo $pic;?>" width="20" height="20" action-type="show_img" action-data="<?php echo $pic;?>"/>
      <?php endforeach;?>
      <?php endif;?>
      </th>
      <th ><a style="color:red;" href="<?php echo $coupon_pdf_domain;?>/<?php echo $v['pdf_name'];?>" target="_blank"><?php echo $v['pdf_name'];?></a></th>
      <th>
      <?php if($v['mobile_pics']):?>
      <?php $mobile_pics = $v['mobile_pics'];$mobile_pics = json_decode($mobile_pics, true);?>
      <?php foreach($mobile_pics as $pic):?>
      <img src="<?php echo $pic;?>" width="20" height="20" action-type="show_img" action-data="<?php echo $pic;?>"/>
      <?php endforeach;?>
      <?php endif;?>
      </th>

      <th><a target="_blank" class="btn btn-link btn-primary"  href="/admin/coupon/add_pdf/?id=<?php  echo $v['id'];?>">编辑</a></th>
      <th><a target="_blank" class="btn btn-link btn-primary"  href="/admin/coupon/mobileimg/?id=<?php  echo $v['id'];?>">编辑</a></th>
      <th><a target="_blank" class="btn btn-link btn-primary"  href="/admin/coupon/edit_seo/?id=<?php  echo $v['id'];?>">SEO</a></th>
      <th><?php echo date("Y-m-d H:i:s", $v['ctime']);?></th>
      <th><?php if($v['mtime']) echo date("Y-m-d H:i:s", $v['mtime']);?></th>
      
      
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>

<div class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div>




</div>