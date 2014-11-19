
<div class="container" style="margin-top:50px;margin-bottom:150px;">

<?php if(!$id):?>
<div class="hero-unit">
<input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id?>">
<div class="control-group">
  <label class="control-label" style="width:60px;">上传图片:</label>
  <div class="controls" style="margin-left:80px;">
  <img id="city_pic" src=""></img><br>
  <form action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="upload_form" name="upload_form" enctype="multipart/form-data">
  <input type="hidden" name="policy" value="<?php echo $policy?>">
  <input type="hidden" name="signature" value="<?php echo $signature?>">
  <input type="file" id="upload_file" name="file">
  </form>
  </div>
  <iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>
</div>
<div class="control-group">
    <label class="control-label" style="width:60px;">图片描述(100字内):</label>
    <div class="controls" style="margin-left:80px;">
      <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="desc" name="desc"></textarea>
    </div>
    <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_photo();">保存</button>
</div>
</div>

<?php else:?>

<div class="hero-unit">
<input type="hidden" name="id" id="id" value="<?php echo $id?>">

<div class="control-group">
    <label class="control-label" style="width:60px;">图片描述(100字内):</label>
    <div class="controls" style="margin-left:80px;">
      <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="desc" name="desc"><?php if($info['desc']) echo $info['desc'];?></textarea>
    </div>
    <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="modify_photo_desc();">修改</button>
</div>
</div>


<?php endif;?>

<a  href="/admin/shop/photo/?shop_id=<?php echo $shop_id;?>" class="btn btn-link btn-primary">查看商户:<?php echo $shop_info['name'];?>的图片列表</a>

<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>图片</th>
      <th>图片描述</th>
      <th>编辑描述</th>
      <th>删除</th>
      <th>上传时间</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?> 

    <?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><img width="60" height="60" src="<?php echo ($v['photo']);?>!pingpreview"></img></th>
      <th><?php if($v['desc']) echo htmlspecialchars($v['desc']);?></th>
      <th>
        <a href="/admin/shop/photo/?id=<?php echo $v['id'];?>"  class="btn btn-link">编辑描述</a>
      </th>

      <th>
        <a href="javascript:;" onclick="delete_shop_photo(<?php echo $v['id'];?>);" class="btn btn-link">删除</a>
      </th>
      <th><?php echo date("Y-m-d H:i:s", $v['ctime']);?></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>

<?php if(isset($page_html) && $page_html):?>
<div><?php echo $page_html;?></div>
<?php endif;?>

</div>






