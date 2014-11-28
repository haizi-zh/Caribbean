<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">



<div class="row-fluid">
    <div class="span12 well well-large form-horizontal bs-docs-example">
    <form class="/admin/dianping/ping">
            <div class="input-prepend">
              <label class="control-label" style="width:120px;">景点名称:</label>
              <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="name" name="name" value="<?php echo $name?>">
            </div>
            <div class="input-prepend">
              <label class="control-label" style="width:60px;">景点ID:</label>
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
      <th>景点名称</th>
      <th>排名得分(可修改)</th>
      <th>操作</th>
      <th>编辑标签</th>
      <th>景点照片</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo $list[$k]->_id;?></th>
      <th>名称：<?php echo $list[$k]->name;?></br>
        <a target="_blank" href="/viewspot/?viewspot_id=<?php echo $list[$k]->_id;?>" style="color:blue;">前台</a>
      </th>
      <th><input style="width:50px;" value="<?php echo $list[$k]->ratings[score];?>" old-value="<?php echo $list[$k]->ratings[score];?>" name="rank_score" id="<?php echo $list[$k]->_id;?>"  /></th>
      <th>
        <a class="btn btn-link btn-danger " href="/admin/editviewspot?viewspot_id=<?php echo $list[$k]->_id;?>&nocache=1" target="_blank"  >编辑</a>
      </th>
      <th>
        <a class="btn btn-link btn-danger" href="/admin/taglist/editshop_tag?shop_id=<?php echo $list[$k]->_id;?>" target="_blank"  >编辑标签</a>
      </th>
      <th>
        <a class="btn btn-link btn-primary" href="/admin/viewspot/photo?viewspot_id=<?php echo $list[$k]->_id;?>" >景点照片</a>
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