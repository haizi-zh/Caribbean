<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript"> var ueContent = UE.getEditor('content');</script>
<script id="editor" type="text/plain" style="width:1024px;height:500px;"></script>

<div class="container" style="margin-top:50px;width:87%;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加内容</legend>                      
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">TITLE:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="title">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">COVER:</label>
                <div class="controls" style="margin-left:80px;">
                    <textarea rows="2" id="cover" style="width:600px;"></textarea>
                </div> 
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">LINK:</label>
                <div class="controls" style="margin-left:80px;">
                    <textarea rows="2" id="link" style="width:600px;"></textarea>
                </div> 
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">CONTENT:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="content" style="width:600px;"></textarea>
                </div>
            </div>


            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_operation();">添加</button>
			
	    </div>

	    
	</div>
</div>