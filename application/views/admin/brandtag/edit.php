<div class="container" style="margin-top:50px;margin-bottom:150px;">

<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
		<form class="/admin/brandtag/edit" method="post">
            <div class="control-group">
              	<div class="controls">
                  <label class="control-label" style="width:60px;">品牌电商标签名称:</label>
                 <textarea rows="6" id="name" name="name" style="width:400px;"><?php if($info) echo $info['name'];?></textarea>
              	</div>
            </div>
            <input type="hidden" id="id" name="id" value="<?php echo $id;?>"/>
            <button class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;">添加</button>
    </form>
    </div>
</div>
