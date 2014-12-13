<div class="container" style="margin-top:50px;margin-bottom:150px;">

<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
		<form class="/admin/content/add" method="post">

           <div class="control-group">
              <div class="controls" style="">
                    <label class="control-label" style="width:60px;">类型:</label>
                    <select id="type" name="type" style="margin-left:15px;width:150px;">
                    <?php foreach($ana_type_list as $k => $item){?>
                    <option <?php if($info && $info['type'] == $k):?><?php endif;?> value="<?php echo $k;?>"><?php echo $item;?></option>
                    <?php }?>
                    </select>
                </div>
            </div>

            <div class="control-group">
              	<div class="controls">
                  <label class="control-label" style="width:60px;">名称:</label>
                 <input  id="name" name="name" style="height:25px;width:200px;" value="<?php if($info) echo $info['name'];?>">
              	</div>
            </div>

            <div class="control-group">
                <div class="controls">
                <label class="control-label" style="width:60px;">内容:</label>
                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" name="desc_content" id="desc_content"><?php if($info) echo $info['desc_content'];?></textarea>
               
                </div>
                coupon对应id，英文逗号分隔。
            </div>




            <input type="hidden" id="id" name="id" value="<?php echo $id;?>"/>
            <button class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;">添加</button>
    </form>
    </div>
</div>
