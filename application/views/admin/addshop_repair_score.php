<div class="container" style="margin-top:130px;margin-bottom:150px;">

<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
		<form class="/admin/addshop/repair_score/">
			<div style="color:red;"><?php echo $content;?></div>
            <div class="control-group">
              	<div class="controls">
                  <label class="control-label" style="width:60px;">商店ID:</label>
              	  <input type="text" style="height:25px;margin-left:25px;width:100px;" placeholder="" id="shop_id" name="shop_id" value="<?php echo $shop_id;?>">
              	</div>
            </div>
            <button class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;">修复</button>
    </form>

    <a href="/admin/addshop/repair_score/?repair_all=all">我要修复全部</a>(注意:请不要频繁操作!)
    </div>

</div>
</div>