<div class="container" style="margin-top:50px;margin-bottom:150px;">

<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
		<form class="/admin/taglist/tags_edit" method="post">
            <div class="control-group">
              <?php if($type == 3):?>
                <div class="controls">
                  <label class="control-label" style="width:60px;">城市:</label>
                  <select name="city_id" id="city_id">
                  <?php foreach($citys as $v):?>

                  <option <?php if($info && $info['city_id'] == $v['id']):?>selected<?php endif;?> value="<?php echo $v['id'];?>"><?php echo $v['name'];?></option>

                  <?php endforeach;?>
                  </select>
                  </div>
               <?php endif;?>
               
              	<div class="controls">
                  <label class="control-label" style="width:60px;">名称:</label>
                 <textarea rows="6" id="name" name="name" style="width:400px;"><?php if($info) echo $info['name'];?></textarea>
              	</div>
            </div>
            <input type="hidden" id="id" name="id" value="<?php echo $id;?>"/>
            <input type="hidden" id="type" name="type" value="<?php echo $type;?>"/>
            <button class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;">添加</button>
    </form>
    </div>
</div>
