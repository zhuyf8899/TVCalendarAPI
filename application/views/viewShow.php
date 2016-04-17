<!--每一部剧的具体信息-->
</div><!-- /container -->
<style type="text/css">
.header-right{
	text-align: right;
}
.header-left{
	text-align: left;
}
</style>
<div class="container">
  <div class="page-header">
    <h1 class="header-left"><?php $transStatus = array('Canceled/Ended' => '已完结/已停播', 'Returning Series' => '回归剧(正在连载)', 'New Series' => '新剧(正在连载)','Final Season' => '完结季(正在连载)' ); if(isset($showInfo['s_name_cn'])){echo $showInfo['s_name_cn'].':';}if(isset($showInfo['s_name'])){echo $showInfo['s_name'];} ?></h1>
    <div class="header-right">
      <button type="button" class="btn btn-lg btn-success" id="sub" onclick="subscribe();" style="<?php if($subOrNot){echo "display:none";} ?>" >订阅本剧</button>
      <button type="button" class="btn btn-lg btn-warning" id="unsub" onclick="unSubscribe();" style="<?php if(!$subOrNot){echo "display:none";} ?>" >不再订阅</button>
    </div>
  </div>
  <div style="text-align:center;">
  	<img class="img-thumbnail"  alt="sibig_box_pic" src="<?php if(isset($showInfo['s_sibig_image'])){echo $CUrl.'/cat/imgs/sibig/'.substr($showInfo['s_sibig_image'], 16);} ?>" data-holder-rendered="true">
  	<br/>
  </div>
  <br/>
  <table class="table table-bordered table-hover">
    <tr>
    	<th class="col-md-2">剧状态</th>
    	<td class="col-md-2"><?php if(isset($showInfo['status'])){echo $transStatus["{$showInfo['status']}"];} ?></td>
    	<th class="col-md-2">更新时间</th>
    	<td class="col-md-2"><?php if(isset($showInfo['update_time'])){echo $showInfo['update_time'];} ?></td>
    	<th class="col-md-2">每集长度</th>
    	<td class="col-md-2"><?php if(isset($showInfo['length'])){echo $showInfo['length'];} ?></td>
    </tr>
    <tr>
    	<th class="col-md-2">地区</th>
    	<td class="col-md-2"><?php if(isset($showInfo['area'])){echo $showInfo['area'];} ?></td>
    	<th class="col-md-2">更新频道</th>
    	<td class="col-md-2"><?php if(isset($showInfo['channel'])){echo $showInfo['channel'];} ?></td>
    	<th class="col-md-2">当前已记录</th>
    	<td class="col-md-2"><?php if(isset($episodeInfo)){echo count($episodeInfo)."集";} ?></td>
    </tr>
  </table>

  <div class="well">
    <p>剧情介绍：
    	<?php
    	if(isset($showInfo['s_description'])){echo $showInfo['s_description'];}
    	?>
    </p>
  </div>

  <div class="page-header">
    <h3>分季列表</h3>
  </div>
  <div class="row">
	  <table class="table table-hover table-striped">
	    <thead>
	      <tr>
	      	<th class="col-md-4">第<?php if(isset($episodeInfo[0]['se_id'])){echo $episodeInfo[0]['se_id'];} ?>季</th>
	      	<th class="col-md-2"></th>
	      	<th class="col-md-3"></th>
	      	<th class="col-md-3"></th>
	      </tr>
	    </thead>
	    <tbody>
	    <?php
	    for ($i=0; $i < count($episodeInfo); $i++) { 
	    	if ($i>0 && $episodeInfo[$i]['se_id'] != $episodeInfo[$i-1]['se_id']) {
	    		?>
	    			</tbody>
				</table>
				<table class="table table-hover table-striped">
	    			<thead>
	      				<tr>
					      	<th class="col-md-4">第<?php if(isset($episodeInfo[$i]['se_id'])){echo $episodeInfo[$i]['se_id'];} ?>季</th>
					      	<th class="col-md-2"></th>
					      	<th class="col-md-3"></th>
					      	<th class="col-md-3"></th>
					    </tr>
					</thead>
					<tbody>
	    		<?php
	    	}
	    	if(isset($episodeInfo[$i]))
	    	{
	    	?>
	    	<tr>
	    		<th class="col-md-4"><?php echo $episodeInfo[$i]['e_name']; ?></th>
		      	<th class="col-md-2">第<?php echo $episodeInfo[$i]['se_id']; ?>季，第<?php echo $episodeInfo[$i]['e_num']; ?>集</th>
		      	<th class="col-md-3"><?php echo $episodeInfo[$i]['e_time']; ?></th>
		      	<th class="col-md-3">
		      	<button type="button" id="s<?php echo $episodeInfo[$i]['e_id']; ?>" class="btn btn-success" onclick="syn(<?php echo $this->session->u_id.','.$episodeInfo[$i]['e_id']; ?>);" <?php if( $episodeInfo[$i]['syn'] == 1){echo "style=\"display:none\"";} ?> >我看完了</button>
		      	<button type="button" id="u<?php echo $episodeInfo[$i]['e_id']; ?>" class="btn btn-warning" onclick="unsyn(<?php echo $this->session->u_id.','.$episodeInfo[$i]['e_id']; ?>);" <?php if( $episodeInfo[$i]['syn'] == 0){echo "style=\"display:none\"";} ?> >取消同步</button>
            <a href="https://btio.pw/search/<?php echo urlencode($showInfo['s_name']); ?>" class="btn btn-info" >前往下载链接&raquo;</a>
		      	</th>
	    	</tr>
	    	<?php
	    	}
	    }
	    ?>
	    </tbody>
	  </table>
  </div>
</div>
<script type="text/javascript">
	function syn(u_id,e_id) {
        var ids = new RegExp("^\\d*$");
	    if (!ids.test(e_id)||!ids.test(u_id))
	    {
	      toastr.error("参数传递错误", "错误");
	      //toastr.info(phoneNumber, "DEBUG");
	      $("#s"+e_id).focus();
	    }
	    data = {'u_id':u_id,'e_id':e_id};
        $.ajax({
          type: 'POST',
          url: '/TVCalendarAPI/index.php/UI/ajaxSynchron',
          data: data,
          async:true,
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          	toastr.error("Ajax故障", "错误");
          	toastr.info("Status:"+XMLHttpRequest.status+"\nreadyState:"+XMLHttpRequest.readyState+"\ntext:"+textStatus, "DEBUG");
          },
          success: function(result)
          {
          	//toastr.info(result, "DEBUG");
            if (result.substr(0,3) == "OK:") 
            {
              toastr.success("您已观看:"+result.substr(3), "同步完成");
              //$("button[id=s"+e_id+"]").hide();
              //$("button[id=u"+e_id+"]").show();
              $("#s"+e_id).hide();
              $("#u"+e_id).show();
            }
            else if(result == "Repeat")
            {
            	toastr.warning("您曾观看过:"+result.substr(3), "警告");
            	$("#s"+e_id).hide();
              	$("#u"+e_id).show();
            }
            else
            {
              toastr.error("未知错误", "错误");
            }
          },
        });
        //toastr.warning(flag.toString(), "DEBUG");
	}

	function unsyn(u_id,e_id) {
        var ids = new RegExp("^\\d*$");
	    if (!ids.test(e_id)||!ids.test(u_id))
	    {
	      toastr.error("参数传递错误", "错误");
	      //toastr.info(phoneNumber, "DEBUG");
	      $("#u"+e_id).focus();
	    }
	    data = {'u_id':u_id,'e_id':e_id};
        $.ajax({
          type: 'POST',
          url: '/TVCalendarAPI/index.php/UI/ajaxUnsynchron',
          data: data,
          async:true,
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          	toastr.error("Ajax故障", "错误");
          	toastr.info("Status:"+XMLHttpRequest.status+"\nreadyState:"+XMLHttpRequest.readyState+"\ntext:"+textStatus, "DEBUG");
          },
          success: function(result)
          {
            if (result.substr(0,3) == "OK:") 
            {
              toastr.success("取消观看:"+result.substr(3), "操作完成");
              //window.location.href("/TVCalendarAPI/index.php/UI/index");
              //$("button[id=u"+e_id+"]").hide();
              //$("button[ud=s"+e_id+"]").show();
              $("#u"+e_id).hide();
              $("#s"+e_id).show();
            }
            else if(result == "None")
            {
            	toastr.warning("您还未观看过:"+result.substr(3), "警告");
            	$("#u"+e_id).hide();
              	$("#s"+e_id).show();
            }
            else
            {
              toastr.error("未知错误", "错误");
            }
          },
        });
        //toastr.warning(flag.toString(), "DEBUG");
	}

	function subscribe() {
	    data = {'u_id':<?php echo $this->session->u_id; ?>,'s_id':<?php echo $s_id ?>};
        $.ajax({
          type: 'POST',
          url: '/TVCalendarAPI/index.php/UI/ajaxSubscribe',
          data: data,
          async:true,
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          	toastr.error("Ajax故障", "错误");
          	toastr.info("Status:"+XMLHttpRequest.status+"\nreadyState:"+XMLHttpRequest.readyState+"\ntext:"+textStatus, "DEBUG");
          },
          success: function(result)
          {
            if (result.substr(0,3) == "OK:") 
            {
              toastr.success("订阅:"+result.substr(3), "操作成功");
              //window.location.href("/TVCalendarAPI/index.php/UI/index");
              $("#sub").hide();
              $("#unsub").show();
            }
            else if(result == "Repeat")
            {
            	toastr.warning("您已订阅过:"+result.substr(3), "警告");
            	$("#sub").hide();
                $("#unsub").show();
            }
            else
            {
              toastr.error("未知错误", "错误");
              flag = false;
            }
          },
        });
        //toastr.warning(flag.toString(), "DEBUG");
        return flag;
	}

	function unSubscribe() {
	    data = {'u_id':<?php echo $this->session->u_id; ?>,'s_id':<?php echo $s_id ?>};
        $.ajax({
          type: 'POST',
          url: '/TVCalendarAPI/index.php/UI/ajaxUnsubscribe',
          data: data,
          async:true,
          error: function(XMLHttpRequest, textStatus, errorThrown)
          {
          	toastr.error("Ajax故障", "错误");
          	toastr.info("Status:"+XMLHttpRequest.status+"\nreadyState:"+XMLHttpRequest.readyState+"\ntext:"+textStatus, "DEBUG");
          },
          success: function(result)
          {
            if (result.substr(0,3) == "OK:") 
            {
              toastr.success("取消订阅:"+result.substr(3), "操作成功");
              //window.location.href("/TVCalendarAPI/index.php/UI/index");
              $("#sub").show();
              $("#unsub").hide();
            }
            else if(result == "None")
            {
            	toastr.warning("您还未订阅过:"+result.substr(3), "警告");
            	$("#sub").show();
                $("#unsub").hide();
            }
            else
            {
              toastr.error("未知错误", "错误");
            }
          },
        });
        //toastr.warning(flag.toString(), "DEBUG");
        return flag;
	}
</script>