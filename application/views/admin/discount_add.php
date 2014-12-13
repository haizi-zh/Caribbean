<div class="container" style="width:80%; margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well form-horizontal bs-docs-example">
			<legend>添加折扣信息 <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" id="add_discount">添加</button></legend>

           <div class="control-group">
              	<label class="control-label" style="width:60px;">商家id:</label>
              	<div class="controls" style="margin-left:80px;">
              		<input type="text" style="height:25px;width:500px;" placeholder="" id="shop_id" value="">
              	</div>
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;">品牌id:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="brand_id" value="">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">标题:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px;width:500px;" placeholder="" id="title" value="">
                </div>
           </div>


           <div class="control-group">
                <label class="control-label" style="width:60px;">开始时间:</label>
                <div class="controls" style="margin-left:80px;width:260px;">
                  <input type="text" onfocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" value="<?php if(isset($stime) && $stime) echo $stime; else echo date('Y-m-d');?>" name="stime" id="stime" readonly="readonly" style="width:45%;" class="bjyh_text Wdate">
                </div>
           </div>

           <div class="control-group">
                <label class="control-label" style="width:60px;">结束时间:</label>
                <div class="controls" style="margin-left:80px;width:260px;">
                  <input type="text" onfocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true})" value="<?php if(isset($etime) && $etime) echo $etime; else echo date('Y-m-d');?>" name="etime" id="etime" readonly="readonly" style="width:45%;" class="bjyh_text Wdate">
                </div>
           </div>
           <div class="control-group">
                <label class="control-label" style="width:60px;">分享到第三平台文案（100字以内）:</label>
                <div class="controls" style="margin-left:80px;">
                <textarea rows="3" class="valtype" style="margin: 0px; width: 617px; height: 108px;" cols="20" id="share_content"></textarea>
                </div>
           </div>

           <div class="control-group" style="display:none;">
                <label class="control-label" style="width:60px;">是否百货商店不显示:</label>
                <div class="controls" style="margin-left:80px;">
                  <select id="shop_type">
                  <option value=0>否</option>
                  <option value=1>是</option>
                </select>
              </div>
            </div>

           <div class="control-group">
              	<label class="control-label" style="width:60px;">详情(##必须成对出现。):</label>
              	<div class="controls" style="margin-left:80px;width:90%;height:680px;" id="my_content"></div>
           </div>


           
	    </div>
	</div>
</div>

