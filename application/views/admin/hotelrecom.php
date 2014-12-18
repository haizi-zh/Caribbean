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
                <button class="btn btn-large btn-primary"  type="submit" style="float:right;margin-right:500px;">搜索酒店</button>  
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
                    <tr>    
                      <th class="btn_bed">
                            <?php if( ($list[$k]->recommend) !=2){?>               
                                    <?php if( ($list[$k]->recommend) ==0){?>
                                        <a class="W_btn_b" title="点击推荐" href="javascript:void(0);" action-type="follow" action-data="uid=<?php echo $list[$k]->_id;?>"><span>点击推荐</span></a>
                                    <?php }elseif( ($list[$k]->recommend) ==1){?>
                                        <a class="W_btn_a" title="已推荐" href="javascript:void(0);" action-type="unfollow" action-data="uid=<?php echo $list[$k]->_id;?>"><span>已推荐</span></a>
                                    <?php }?>
                            <?php }?>
                      </th>
                      <th><input style="width:100px;height:30px" value="<?php echo $list[$k]->ratings[score];?>" old-value="<?php echo $list[$k]->ratings[score];?>" name="ratings_score" id="<?php echo $list[$k]->_id;?>"  /></th>
                      <th><?php echo $k+$offset+1;?></th>
                      <th><?php echo $list[$k]->zhname;?></th>
                      <th><?php echo $list[$k]->_id;?></th>

                    </tr>                    
                  </tbody>
            </table>
             


            
            
            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="">确定</button>
			
	    </div>

	    
	</div>
</div>