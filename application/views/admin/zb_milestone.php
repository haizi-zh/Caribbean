<div class="container" style="margin-top:50px;margin-bottom:150px;">

<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
		<form class="/admin/home/zb_milestone">
            <div class="control-group">
              	<div class="controls">
                  <label class="control-label" style="width:60px;">上线内容:</label>
                 <textarea rows="6" id="content" name="content" style="width:400px;"></textarea>
              	</div>
            </div>
            <button class="btn btn-large btn-primary" type="submit" style="float:right;margin-right:100px;">添加</button>
    </form>
    </div>
</div>



<table class="table table-bordered">
 <thead>
    <tr>
      <th>序号</th>
      <th>上线内容</th>
      <th>上线时间</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($list) && $list):?> 
  	<?php foreach($list as $k=>$v):?>
    <tr>
      <th><?php echo $k+$offset+1;?></th>
      <th><?php echo htmlspecialchars($v['content']);?></th>
      <th><?php echo date('Y-m-d H:i:s', $v['ctime']);?></th>
    </tr>
    <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
<?php if(isset($page_html) && $page_html):?> 
<div><?php echo $page_html;?></div>
<?php endif;?>
</div>




