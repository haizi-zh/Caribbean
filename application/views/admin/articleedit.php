<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript"> var ueContent = UE.getEditor('content');</script>


<div class="container" style="margin-top:50px;width:87%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example" style="position:relative">
			<legend>编辑页面</legend>                      
     	<div style="display:none" id="article_id"><?php echo $article['article_id'];?></div>

     	<div class="control-group">
        	<label class="control-label" style="width:60px;">TITLE:</label>
        	<div class="controls" style="margin-left:80px;">
        		<input type="text" id="title" style="height:25px;width:400px;" placeholder=""  value="<?php echo $article['title'];?>">
        	</div>
     	</div>

     	<div class="control-group">
        	<label class="control-label" style="width:60px;">SOURCE:</label>
        	<div class="controls" style="margin-left:80px;">
        		<input type="text" id="source"  style="height:25px;width:400px;" placeholder="" value="<?php echo $article['source'];?>">
        	</div>
     	</div>

     	<div class="control-group">
        	<label class="control-label" style="width:60px;">AUTHOR:</label>
        	<div class="controls" style="margin-left:80px;">
        		<input type="text" id="authorName" style="height:25px;width:400px;" placeholder=""  value="<?php echo $article['authorname'];?>">
        	</div>
     	</div>

     	<div class="control-group">
        	<label class="control-label" style="width:60px;">PUBLISHTIME:</label>
        	<div class="controls" style="margin-left:80px;">
		        <?php date_default_timezone_set("Asia/Shanghai");?>
        		<input type="text" id="publishTime" style="height:25px;width:400px;" placeholder=""  value="<?php echo date("Y-m-d", $article['publishtime']/1000);?>">
        	</div>
     	</div>

     	<div class="control-group">
          <label class="control-label" style="width:60px;">DESC:</label>
          <div class="controls" style="margin-left:80px;">
            	<textarea rows="2" id="desc" style="width:600px;" value="<?php echo $article['desc'];?>"><?php echo $article['desc'];?></textarea>
          </div>
     	</div>

      <form method="post" action="http://upload.qiniu.com/" enctype="multipart/form-data" id="form_image" name="form_image" style="display:inline-block;height:50px;">
        <input name="key" type="hidden" value="cms_test_14">
        <input name="token" type="hidden" value="<?php echo $token;?>">
        <input name="file" type="file"/>
      </form>
      <div id="submit" style="display:inline-block;" class="btn btn-primary">提交</div>

     	<div class="control-group">
          <label class="control-label" style="width:60px;">IMAGE:</label>
          <div class="controls" style="margin-left:80px;">
            	<textarea rows="2" id="image" style="width:600px;" value="<?php if ($article['images'] && $article['images'][0] && $article['images'][0]['url']) echo $article['images'][0]['url'];?>"><?php if ($article['images'] && $article['images'][0] && $article['images'][0]['url']) echo $article['images'][0]['url'];?></textarea>
          </div>
     	</div>

     	<div class="control-group">
          <label class="control-label" style="width:60px;">CONTENT:</label>
          <div class="controls" style="margin-left:80px;">
            	<textarea rows="10" id="content" style="width:600px;"><?php echo $article['content'];?></textarea>
          </div>
     	</div>

      <button class="btn btn-large btn-primary" type="button" style="position:absolute;top:15px;right:20px;" onclick="edit_article();">编辑完成</button>
    </div>
	</div>
</div>