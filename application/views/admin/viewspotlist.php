<div class="container" style="margin-top:50px;margin-bottom:150px;width:95%;">



<div class="row-fluid">
    <div class="span12 well well-large form-horizontal bs-docs-example">

                <div class="input-prepend">
                <label class="control-label" style="width:60px;">所在地:</label>
                    <div class="controls" style="margin-left:80px;">
                          <select id="area" >
                            <option></option>
                            <option value="0"><?php echo "国内";?></option>
                            <option value="1"><?php echo "国外";?></option>
                          </select>&nbsp;
                          <select id="country">
                          </select>&nbsp;
                          <select id="city">
                          </select>&nbsp;&nbsp;&nbsp;&nbsp;

                          <button id="isEdited" class="" value="0" href="javascript:void(0);" action-type="follow"><span>是否审核</span></button>
                    </div>

                </div>

                <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="select_city();">筛选</button>
                                
    </div>

</div>



<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th style="height:28px;margin-left:15px;width:250px;">景点地址</th>
      <th>景点名称</th>
      <th>排名得分</th>
      <th>编辑操作</th>
      <th>景点照片</th>
    </tr>
  </thead>
  <tbody id="J_viewspot_table">
    <?php if(isset($list) && $list):?>
  	<?php foreach($list as $k=>$v):?>
    <tr>
          <th><?php echo $k+$offset+1;?></th>
          <th style="height:28px;margin-left:15px;width:250px;"><?php echo $list[$k]->address;?></th>
          <th><?php echo $list[$k]->zhname;?></br>
            
          </th>
            <th><?php echo $list[$k]->hotness;?></th> 
          <th>
            <a class="btn btn-link btn-danger " href="/admin/editviewspot?viewspot_id=<?php echo $list[$k]->_id;?>&nocache=1" target="_blank"  >编辑景点</a>
          </th>
          <th>
            <a class="btn btn-link btn-primary" href="http://pic.lvxingpai.cn/viewspot/cms?name=<?php echo $list[$k]->zhname;?>" target="_blank" >景点照片</a>
          </th>




    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>

<div id="pages" class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div>


</div>