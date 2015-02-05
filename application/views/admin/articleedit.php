<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript"> var ueContent = UE.getEditor('content');</script>


<div class="container" style="margin-top:50px;width:87%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>编辑页面</legend>                      
                   <div style="display:none" id="article_id"><?php echo $article['article_id'];?></div>  

		           <div class="control-group">
		              	<label class="control-label" style="width:60px;">TITLE:</label>
		              	<div class="controls" style="margin-left:80px;">
		              		<input type="text" id="title" style="height:25px;width:200px;" placeholder=""  value="<?php echo $article['title'];?>">
		              	</div>
		           </div>	

		           <div class="control-group">
		              	<label class="control-label" style="width:60px;">SOURCE:</label>
		              	<div class="controls" style="margin-left:80px;">
		              		<input type="text" id="source"  style="height:25px;width:200px;" placeholder="" value="<?php echo $article['source'];?>">
		              	</div>
		           </div>	

		           <div class="control-group">
		              	<label class="control-label" style="width:60px;">AUTHOR:</label>
		              	<div class="controls" style="margin-left:80px;">
		              		<input type="text" id="authorName" style="height:25px;width:200px;" placeholder=""  value="<?php echo $article['authorname'];?>">
		              	</div>
		           </div>	

		           <div class="control-group">
		              	<label class="control-label" style="width:60px;">PUBLISHTIME:</label>
		              	<div class="controls" style="margin-left:80px;">
		              		<input type="text" id="publishTime" style="height:25px;width:200px;" placeholder=""  value="<?php echo $article['publishtime'];?>">
		              	</div>
		           </div>	
		          
		           <div class="control-group">
		                <label class="control-label" style="width:60px;">DESC:</label>
		                <div class="controls" style="margin-left:80px;">
		                  <textarea rows="2" id="desc" style="width:600px;" value="<?php echo $article['desc'];?>"><?php echo $article['desc'];?></textarea>
		                </div> 
		           </div>

		           <div class="control-group">
		                <label class="control-label" style="width:60px;">IMAGE:</label>
		                <div class="controls" style="margin-left:80px;">
		                  <textarea rows="2" id="image" style="width:600px;" value="<?php if ($article->images && $article->images[0] && $article->images[0]['url']) echo $article['images'][0]['url'];?>"><?php if ($article->images && $article->images[0] && $article->images[0]['url']) echo $article['images'][0]['url'];?></textarea>
		                </div> 
		           </div>

		           <div class="control-group">
		                <label class="control-label" style="width:60px;">CONTENT:</label>
		                <div class="controls" style="margin-left:80px;">
		                  <textarea rows="10" id="content" style="width:600px;"><?php echo $article['content'];?></textarea>
		                </div>
		           </div>
			
			       <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit_article();">编辑</button>

	    </div>

	    
	</div>
</div>