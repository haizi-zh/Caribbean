<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加管理员信息</legend>

           <div class="control-group">
              	<label class="control-label" style="width:60px;">用户名:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:500px;" placeholder="" id="username" value="<?php if($user_info) echo $user_info['username'];?>">
              	</div>
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;">密码:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="password" value="">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">用户昵称:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="nikename" value="<?php if($user_info) echo $user_info['nikename'];?>">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">权限:</label>
                <div class="controls" style="margin-left:80px;">
                <select name="power" id="power">
                  <?php foreach($powers as $k => $v):?>
                  <option <?php if($user_info && $user_info['power'] == $k):?>selected<?php endif;?> value="<?php echo $k;?>"><?php echo $v;?></option>
                  <?php endforeach;?>
                </select>
                </div>
           </div>
           <input type="hidden" id="id" name="id" value="<?php echo $id;?>" />
           <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_user();">添加</button>
	    </div>
	</div>
</div>

