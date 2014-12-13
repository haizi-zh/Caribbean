<div class="container" style="width:80%; margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well form-horizontal bs-docs-example">
			<legend>添加购物攻略 
        <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" id="add_shoptips">添加并发布</button>
        <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" id="save_shoptips">只保存</button>
        <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" id="spider_shoptips">只面向百度</button>
      </legend>
           <div class="control-group">
                <label class="control-label" style="width:60px;">国家id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="country" value=""><span style="color:red;">(可不填写，如填写，则本国家所有城市,商店可见,英文逗号分隔多个国家id。)</span>
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">城市id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="city" value=""><span style="color:red;">(可不填写，如填写，则本市所有商店可见,英文逗号分隔多个城市id。)</span>
                </div>
           </div>

           <div class="control-group">
              	<label class="control-label" style="width:60px;">商家id:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:500px;" placeholder="" id="shop_id" value="">
              	</div>
           </div>
           
           <div class="control-group">
                <label class="control-label" style="width:60px;">显示级别:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:200px;" placeholder="" id="level" value="">(数字，显示级别从0开始优先显示，同级别按时间倒序，默认1000)
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">标题:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="title" value="">
                </div>
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;">移动端标题:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="title_mobile" value="">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">分享到第三平台文案（100字以内）:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="share_content"></textarea>
                </div>
           </div>
           <div class="control-group">
              	<label class="control-label" style="width:60px;">详情,##必须成对出现。:</label>
                
              	<div class="controls" style="margin-left:80px;width:90%;height:680px;" id="my_content"></div>
               
                <!--
                <div class="controls" style="margin-left:80px;">
                <script id="container" name="content" type="text/plain"  style="width:800px;">这里写你的初始化内容</script>
                
                </div>
              -->
           </div>
	    </div>
	</div>
</div>


