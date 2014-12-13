<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">



<div class="row-fluid">
    <div class="span12 well well-large form-horizontal bs-docs-example">
    <form class="/admin/dianping/ping">
            <div class="input-prepend">
              <label class="control-label" style="width:120px;">商家名称/英文名称:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="name" name="name" value="<?php echo $name?>">
            </div>
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">商家ID:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="id" name="id" value="<?php echo $id?>">
            </div>
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">城市:</label>
              <select style="height:25px;margin-left:25px;width:100px;" name="city" id="city">
              <option value="0">全部</option>
              <?php foreach($citys as $k=>$v):?>
              <option <?php if($city == $k):?>selected=true<?php endif;?> value="<?php echo $k;?>"><?php echo $v['name'];?></option>
              <?php endforeach;?>
              </select>
            </div>
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">怎样到达:</label>
              <input style="height:25px;margin-left:25px;" type="checkbox" name="is_direction" value="1" <?php if($is_direction):?>checked='checked'<?php endif;?> />
            </div>

            

            <button class="btn btn-large btn-primary" type="submit" style="margin-left:25px;">筛选</button>
    </form>
    </div>
<a target="_blank" href="/admin/taglist/" class="btn btn-link btn-primary">去修改标签</a>
</div>



<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>ID</th>
      <th>名称</th>
      <th>排名得分</br>(可以直接修改)</th>
      <th>操作</th>
      <th>编辑标签</th>
      <th>商家照片</th>
      <th>怎样到达</th>
      <th>清显示缓存</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo $v['id'];?></th>
      <th>名称：<?php echo $v['name'];?></br>
        备用：<?php echo $v['english_name'];?></br>
        <a target="_blank" href="/shop/?shop_id=<?php echo $v['id'];?>" style="color:blue;">前台</a>
      </th>
      <th><input style="width:50px;" value="<?php echo $v['rank_score'];?>" old-value="<?php echo $v['rank_score'];?>" name="rank_score" id="<?php echo $v['id'];?>"  /></th>
      <th>
        <a class="btn btn-link btn-danger " href="/admin/editshop?shop_id=<?php echo $v['id'];?>&nocache=1" target="_blank"  >编辑</a>
      </th>
      <th>
        <a class="btn btn-link btn-danger" href="/admin/taglist/editshop_tag?shop_id=<?php echo $v['id'];?>" target="_blank"  >编辑标签</a>
      </th>

      <th>
        <a class="btn btn-link btn-primary" href="/admin/shop/photo?shop_id=<?php echo $v['id'];?>" >商家照片</a>
      </th>
      <th>
        <a class="btn btn-link btn-danger" href="/admin/directions/d_list/?shop_id=<?php echo $v['id'];?>" target="_blank"  >编辑</a></br></br>
        <a class="btn btn-link btn-primary" target="_blank" href="/<?php echo $v['lower_name'];?>/directions/">预览</a>
        <!--
        <iframe src="/<?php echo $v['lower_name'];?>/directions/"></iframe>-->
      </th>

      <th>
        <a class="btn btn-link btn-warning" href="/<?php echo $citys[$v['city']]['lower_name'];?>/<?php echo $v['id'];?>/?nocache=1" target="_blank"  >清显示缓存</a></br></br>
        <a class="btn btn-link btn-warning" href="/brandstreet/<?php echo $v['id'];?>/?nocache=1" target="_blank" >清品牌墙缓存</a>
      </th>

    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>

<div class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div>


</div>