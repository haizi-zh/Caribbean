<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript"> var ueVisitGuide = UE.getEditor('visitGuide'); var ueAntiPit = UE.getEditor('antiPit');</script>
<script id="editor" type="text/plain" style="width:1024px;height:500px;"></script>

<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			<legend>添加景点</legend>


            <div class="control-group">
                <label class="control-label" style="width:60px;">景点名称:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="name">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">景点简介:</label>
                <div class="controls" style="margin-left:80px;width:400px;">
                  <textarea rows="10" id="description" style="width:600px;"></textarea>
                </div>
            </div>
            

            <div class="control-group">
                <label class="control-label" style="width:60px;">详细地址:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="2" id="address" style="width:600px;"></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">营业信息:</label>
                <div class="controls" style="margin-left:80px;">
                    <span style="width:60px;">&nbsp;&nbsp;开放信息:</span>
                    <input type="text" style="height:25px;width:100px" placeholder="" id="openTime"> 

                    <span style="width:60px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;起始时间:</span>
                    <input type="text" style="height:25px;width:100px" placeholder="" id="openHour"> 

                    <span style="width:60px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;关闭时间:</span>
                    <input type="text" style="height:25px;width:100px" placeholder="" id="closeHour"> 
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">景点门票:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="priceDesc">
                </div>
            </div>
                        
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">电话:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="phone">
                </div>
            </div>        
            
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">排名得分:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="ratingsScore">
                </div>
            </div>

            
            <div class="control-group">
                <label class="control-label" style="width:60px;">游玩攻略:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="visitGuide" style="width:600px;"></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">防坑指南:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="antiPit" style="width:600px;"></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">交通指南:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="travelGuide" style="width:600px;"></textarea>
                </div>
            </div>



            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="add_viewspot();">添加景点</button>
	    </div>
	</div>
</div>
