<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑城市</legend>    
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
                              
                        </div>
                    </div>
                    <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="select_city();">筛选地区</button>                               
                </div>
         </div>

         <div class="row-fluid">
         <div class="span12 well well-large form-horizontal bs-docs-example">
                    <div class="input-prepend">
                      <form class="/admin/dianping/ping">
                              <div class="input-prepend">
                                <label class="control-label" style="width:120px;">请输入城市名称:</label>
                                <input type="text" style="height:25px;margin-left:25px;width:150px;" placeholder="" id="name" name="name" value="<?php echo $name?>">
                              </div>
                              <div class="input-prepend">
                                <label class="control-label" style="width:60px;">城市ID:</label>
                                <input type="text" style="height:25px;margin-left:25px;width:150px;" placeholder="" id="id" name="id" value="<?php echo $id?>">
                              </div>
                              <div class="input-prepend"></div>

                      <button class="btn btn-large btn-primary"  type="submit" style="float:right;margin-right:10px;">搜索城市</button> 
                      </form>  
                    </div>
                </div> 
         </div>

         <table class="table table-bordered">
         <thead>
            <tr>
              <th>序号</th>
              <th>城市ID</th>
              <th>城市名称</th>
              <th>编辑操作</th>
            </tr>
            
          </thead>
          <tbody id="J_city_table">
            <?php if(isset($list) && $list):?>
            <?php foreach($list as $k=>$v):?>
            <tr>
              <th><?php echo $k+$offset+1;?></th>
              <th><?php echo $list[$k]->_id;?></th>
              <th><?php echo $list[$k]->zhname;?></th>
              <th>
                <a class="btn btn-link btn-danger " href="/admin/editcitylist?city_id=<?php echo $list[$k]->_id;?>&nocache=1" target="_blank"  >编辑</a>
              </th>


            </tr>
            <?php endforeach;?>
            <?php endif;?>
          </tbody>
        </table>
           
	    </div>
	</div>

<!-- <div class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div> -->


</div>







