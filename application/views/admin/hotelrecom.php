<div class="container" style="margin-top:50px;width:87%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>酒店推荐</legend>                      
            
            <div class="row-fluid">
                <div class="span12 well well-large form-horizontal bs-docs-example">
                <form class="/admin/dianping/ping">
                        <div class="input-prepend">
                          <label class="control-label" style="width:120px;">请输入城市名称:</label>
                          <input type="text" style="height:25px;margin-left:25px;width:250px;" placeholder="" id="name" name="name" value="<?php echo $name?>">
                        </div>                  
                <button class="btn btn-large btn-primary"  type="submit" style="float:right;margin-right:500px;">搜索</button>  
                </form>                          
                </div>
            </div>

           
            <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>推荐</th>
                      <th>排名得分</th>
                      <th>序号</th>                 
                      <th>酒店名称</th>
                      <th>酒店ID</th>               
                    </tr>
                  </thead>

                  <tbody>  
                  <?php if(isset($list) && $list):?>
                  <?php foreach($list as $k=>$v):?>             
                    <tr>  

                      <th class="btn_bed">
                          <input type="checkbox" value="<?php echo $list[$k]->_id;?>" name="editpick[]" <?php if($list[$k]->editpick){  echo "checked"; }?> />                        
                      </th>
                      <th><?php echo $list[$k]->rating;?></th>
                      <th><?php echo $k+$offset+1;?></th>
                      <th><?php echo $list[$k]->zhname;?></th>
                      <th><?php echo $list[$k]->_id;?></th>

                    </tr> 
                  <?php endforeach;?>
                  <?php endif;?>                
                  </tbody>
            </table>
            

            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="recom()">确定</button>
			
	    </div>

	    
	</div>

<div class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div> 


 
</div>