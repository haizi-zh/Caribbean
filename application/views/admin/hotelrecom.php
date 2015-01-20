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
                                </div>
                            </div>
                            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="select_city();">筛选</button>                                           
                </div>
            </div>

           
            <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="background-color:#FF0000"><font color=white>点击推荐</font></th>
                      <th>排名得分</th>
                      <th>序号</th>                 
                      <th>酒店名称</th>
                      <th>酒店简介</th>               
                    </tr>
                  </thead>

                  <tbody id="J_hotel_table">  
                  <?php if(isset($list) && $list):?>
                  <?php foreach($list as $k=>$v):?>             
                    <tr>  

                      <th class="btn_bed">
                          <input type="checkbox" value="<?php echo $list[$k]->_id;?>" name="editpick[]" <?php if($list[$k]->editpick){  echo "checked"; }?> />                        
                      </th>
                      <th><?php echo $list[$k]->rating;?></th>
                      <th><?php echo $k+$offset+1;?></th>
                      <th><?php echo $list[$k]->zhname;?></th>
                      <th><?php echo $list[$k]->desc;?></th>

                    </tr> 
                  <?php endforeach;?>
                  <?php endif;?>                
                  </tbody>
            </table>
            

            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="recom()">确定</button>
			
	    </div>

	    
	</div>

<div id="hotel_pagination" class="pagination" style="margin-left: 15px;">
<?php if($page_html) echo $page_html?>
</div> 


 
</div>