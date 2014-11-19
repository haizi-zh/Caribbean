<div class="container" style="margin-top:50px;margin-bottom:150px;">

<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
		<form class="/admin/links/add_cat" method="post">
            <div class="control-group">
              	<div class="controls">
                  <label class="control-label" style="width:60px;">名称:</label>
                 <input  id="name" name="name" style="height:25px;width:200px;" value="<?php if($info) echo $info['name'];?>">
              	</div>
            </div>
            <div class="control-group">
                <div class="controls">
                  <label class="control-label" style="width:60px;">显示顺序:</label>
                 <input  id="level" name="level" style="height:25px;width:200px;" value="<?php if($info) echo $info['level'];?>">
                </div>
            </div>

            <input type="hidden" id="id" name="id" value="<?php echo $id;?>"/>
            <button class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;">添加</button>
    </form>
    </div>
</div>
