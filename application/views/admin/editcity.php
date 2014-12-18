<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑城市</legend>    
			   <div class="row-fluid">
                <div class="span12 well well-large form-horizontal bs-docs-example">
                <form class="/admin/dianping/ping">
                        <div class="input-prepend">
                          <label class="control-label" style="width:120px;">城市名称:</label>
                          <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="name" name="name" value="<?php echo $name?>">
                        </div>
                        <div class="input-prepend">
                          <label class="control-label" style="width:60px;">城市ID:</label>
                          <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="id" name="id" value="<?php echo $id?>">
                        </div>

                <button class="btn btn-large btn-primary"  type="submit" style="float:right;margin-right:100px;">确认</button>  

                </form>               
                
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
          <tbody>
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
</div>







