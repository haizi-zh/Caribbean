<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript"> var ueVisitGuide = UE.getEditor('visitGuide'); var ueAntipit = UE.getEditor('antiPit');</script>
<div class="container" style="margin-top:50px;">
	<div class="row-fluid">
		<div class="span12 well well-large form-horizontal bs-docs-example">
			

			<?php if($viewspot){?>
            <legend>编辑景点</legend>
            <div style="display:none" id="viewspot_id"><?php echo $viewspot['viewspot_id'];?></div>


            <!--<div class="control-group">
                <label class="control-label" style="width:60px;">完成状态:</label>
                <div class="controls" style="margin-left:80px;">
                    <select id="isEdited" >
                            <option></option>
                            <option value="0"><?php echo "未审核";?></option>
                            <option value="1"><?php echo "已经审核";?></option>
                    </select>
                </div>
            </div>-->

            <div class="control-group">
              	<label class="control-label" style="width:60px;">景点名称:</label>
              	<div class="controls" style="margin-left:80px;">
                	<input type="text" style="height:25px" placeholder="" id="name" value="<?php echo $viewspot['name'];?>">
              	</div>
            </div>
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">景点简介:</label>
                <div class="controls" style="margin-left:80px;width:400px;">
                  <textarea rows="10" id="description" style="width:600px;" value="<?php echo $viewspot['description'];?>"><?php echo $viewspot['description'];?></textarea>
                </div>
            </div>

            <!-- <div class="control-group">
                <label class="control-label" style="width:60px;">upload_url:</label>
                <div class="controls" style="margin-left:80px;">
                    <textarea rows="2" id="upload_url" style="width:600px;"value="<?php echo $viewspot['upload_url'];?>"><?php echo $viewspot['upload_url'];?></textarea><br><br>
                    <form method="post" action="" enctype="multipart/form-data">
                          <input name="key" type="hidden" value="<resource_key>">
                          <input name="x:<custom_name>" type="hidden" value="<custom_value>">
                          <input name="token" type="hidden" value="<upload_token>">
                          <input name="file" type="file" />
                          <input name="crc32" type="hidden" />
                          <input name="accept" type="hidden" />
                    </form>
                    <iframe src="" name="" id="" style="display:none;"></iframe>
                </div>
            </div> -->

            
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">crawle_url:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="2" id="crawle_url" style="width:600px;" value="<?php echo $viewspot['crawle_url'];?>"><?php echo $viewspot['crawle_url'];?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">详细地址:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="2" id="address" style="width:600px;" value="<?php echo $viewspot['address'];?>"><?php echo $viewspot['address'];?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">营业信息:</label>
                <div class="controls" style="margin-left:80px;">

                    <span style="width:60px;">&nbsp;&nbsp;开放信息:</span>
                    <textarea rows="4" id="openTime" style="width:500px;" value="<?php echo $viewspot['openTime'];?>"><?php echo $viewspot['openTime'];?></textarea><br>

                    <span style="width:60px;">&nbsp;&nbsp;游玩时间:</span>
                    <textarea rows="4" id="openHour" style="width:500px;" value="<?php echo $viewspot['openHour'];?>"><?php echo $viewspot['openHour'];?></textarea>

                </div>
            </div>


            <div class="control-group">
                <label class="control-label" style="width:60px;">景点门票:</label>
                <div class="controls" style="margin-left:80px;">
				  <textarea rows="4" id="priceDesc" style="width:600px;" ><?php echo $viewspot['priceDesc'];?></textarea>
                </div>
            </div>

            
            <div class="control-group">
                <label class="control-label" style="width:60px;">电话:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="phone" value="<?php echo $viewspot['phone'];?>">
                </div>
            </div>        
            
            
            <div class="control-group">
                <label class="control-label" style="width:60px;">排名得分:</label>
                <div class="controls" style="margin-left:80px;">
                  <input type="text" style="height:25px" placeholder="" id="ratingsScore" value="<?php echo $viewspot['ratingsScore'];?>">
                </div>
            </div>


            <div class="control-group">
                <label class="control-label" style="width:60px;">游玩攻略:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="visitGuide" style="width:600px;"><?php echo $viewspot['visitGuide'];?></textarea>
                </div>
            </div>

            <?php if($viewspot['tips']): ?>
            <div class="control-group" >
                <label class="control-label" style="width:60px;">提示:</label>
                <div class="controls" style="margin-left:80px;border:2px double #3299CC;">              
                    <?php foreach( $viewspot['tips'] as $key=>$value){ echo "<br>".($key+1).".".$value['title']; echo "<br>".$value['desc']; } ?>
                </div>
            </div>
            <?php endif; ?>
    

            <div class="control-group">
                <label class="control-label" style="width:60px;">防坑指南:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="antiPit" style="width:600px;"><?php echo $viewspot['antiPit'];?></textarea>
                </div>
            </div>

            

            <div class="control-group">
                <label class="control-label" style="width:60px;">交通指南:</label>
                <div class="controls" style="margin-left:80px;">
                  <textarea rows="10" id="travelGuide" style="width:600px;"><?php echo $viewspot['travelGuide'];?></textarea>
                </div>
            </div>

            <input type="hidden" name="has_map" id="has_map" value="<?php echo $has_map;?>" />
            <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit_viewspot();">编辑景点</button>
           


            <?php }else{?>
            <?php if($viewspot_id):?>
            <h1>景点不存在,或已被删除。请确认</h1>
            <?php endif;?>

            <legend>搜索景点</legend>
            <div style="display:none" id="viewspot_id"><?php echo $viewspot['viewspot_id'];?></div>

            <div class="control-group">
                <label class="control-label" style="width:60px;">输入名称</label>
                <div class="controls" style="margin-left:80px;">
                <input type="text" style="height:28px;margin-left:15px;width:150px;" placeholder="" id="target_viewspot_id" value="<?php if($viewspot_id) echo $viewspot_id;?>">
                </div>
                <button class="btn btn-large btn-primary" type="button" style="float:right;margin-right:100px;" onclick="edit();">确认</button>
            </div>

            

            <table class="table table-bordered">
             <thead>
                <tr>
                  <th>序号</th>
                  <th>景点地址</th>
                  <th>景点名称</th>
                  <th>排名得分</th>
                  <th>编辑操作</th>
                  <th>景点照片</th>
                </tr>
              </thead>
              <tbody id="J_viewspot_table">
                <?php if(isset($list) && $list):?>
                <?php foreach($list as $k=>$v):?>
                <tr>
                      <th><?php echo $k+$offset+1;?></th>
                      <th><?php echo $list[$k]->address;?></th>
                      <th><?php echo $list[$k]->zhname;?></br>
                        
                      </th>
                        <th><?php echo $list[$k]->hotness;?></th> 
                      <th>
                        <a class="btn btn-link btn-danger " href="/admin/editviewspot?viewspot_id=<?php echo $list[$k]->_id;?>&nocache=1" target="_blank"  >编辑景点</a>
                      </th>
                      <th>
                        <a class="btn btn-link btn-primary" href="http://pic.lvxingpai.cn/viewspot/cms?name=<?php echo $list[$k]->zhname;?>" target="_blank" >景点照片</a>
                      </th>

                </tr>
                <?php endforeach;?>
                <?php endif;?>
              </tbody>
            </table>


            <?php }?>
	    </div>
	</div>
</div>