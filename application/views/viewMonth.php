</div> <!-- /container -->
<style>
.navbar-left{
	margin-left: -15px;
}
</style>
<div class="container">
<div class="navbar navbar-default" >
	<div class="navbar-collapse collapse" style="text-align: center;">
		<ul class="nav navbar-nav  navbar-left">
		  <li>
		    <a class="btn btn-default" href="/TVCalendarAPI/index.php/UI/viewMonth/<?php if(isset($dateStart)){ echo date('Y-m',strtotime("$dateStart -1 month"));} ?>" role="button">
		    上月</a>
		  </li>
		</ul>
		<span style="line-height: 50px;">
		  <?php if(isset($dateStart)){ echo date('Y年m月',strtotime($dateStart));} ?>
		</span>
		<ul class="nav navbar-nav navbar-right">
		  <li>
		    <a class="btn btn-default" href="/TVCalendarAPI/index.php/UI/viewMonth/<?php if(isset($dateStart)){ echo date('Y-m',strtotime("$dateStart +1 month"));} ?>" role="button">
		    下月</a>
		  </li>
		</ul>
	</div>
	
</div>
<?php
$week = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
if (isset($shows)) {
	$days = count($shows);
	foreach ($shows as $dayDate => $oneday)
	{
		?>
		<table class="table table-hover table-striped">
		  <thead>
		  	<tr>
		  		<th><?php echo substr($dayDate,5,5); ?></th>
		  		<th><?php echo $week[date("w",strtotime($dayDate))];?></th>
		  		<th></th>
		  		<th></th>
		  	</tr>
		  </thead>
		  <tbody>
		  	<?php
		  	foreach ($oneday as $aShow) {
		  		?>
		  		<tr>
		  			<th class="col-md-1"><?php echo substr($aShow['e_time'],-8); ?></th>
		  			<th class="col-md-9"><mark><?php echo $aShow['s_name']; ?></mark>:第<?php echo $aShow['se_id']; ?>季，第<?php echo $aShow['e_num']; ?>集&nbsp;&nbsp;&nbsp;“<?php echo $aShow['e_name']; ?>”</th>
		  			<th class="col-md-1">
		  			<button type="button" name="<?php echo 'u'.$this->session->u_id.$aShow['s_id'];?>" onclick="unsubscribe(<?php echo ($aShow['s_id'].','.$this->session->u_id.','.$this->session->u_id.$aShow['s_id']);?>);" class="btn btn-warning" <?php if($aShow['sub'] != "1"){echo "style=\"display:none\"";} ?> >不再订阅</button>
		  			<button type="button" name="<?php echo 's'.$this->session->u_id.$aShow['s_id'];?>" onclick="subscribe(<?php echo ($aShow['s_id'].','.$this->session->u_id.','.$this->session->u_id.$aShow['s_id']);?>);" class="btn btn-success" <?php if($aShow['sub'] == "1"){echo "style=\"display:none\"";} ?> >订阅</button>
		  			</th>
		  			<th class="col-md-1"><a class="btn btn-info" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $aShow['s_id']; ?>">剧集详情</a></th>
		  		</tr>
		  		<?php
		  	}
		  	?>
		  </tbody>
		</table>
		<?php
	}

}
?>
<!--表格模板
<table class="table table-hover table-striped">
<thead>
		  	<tr>
		  		<th class="col-md-1">1</th>
		  		<th class="col-md-9">2</th>
		  		<th class="col-md-1">3</th>
		  		<th class="col-md-1">4</th>
		  	</tr>
		  </thead>
		  <tbody>
		  	<tr>
		  		<th class="col-md-1">1</th>
		  		<th class="col-md-9">2</th>
		  		<th class="col-md-1">3</th>
		  		<th class="col-md-1">4</th>
		  	</tr>
		  </tbody>
</table>
-->
</div>
<script type="text/javascript">
	function subscribe(s_id,u_id,button_name)
	{
		var flag = false;
        var ids = new RegExp("^\\d*$");
	    if (!ids.test(s_id)||!ids.test(u_id))
	    {
	      toastr.error("参数传递错误", "错误");
	      //toastr.info(phoneNumber, "DEBUG");
	      $("#"+button_name).focus();
	      return false;
	    }
	    data = {'u_id':u_id,'s_id':s_id};
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
              $("button[name=s"+button_name+"]").hide();
              $("button[name=u"+button_name+"]").show();
              flag = true;
            }
            else if(result == "Repeat")
            {
            	toastr.warning("您已订阅过:"+result.substr(3), "警告");
            	$("button[name=s"+button_name+"]").hide();
              	$("button[name=u"+button_name+"]").show();
              	flag = true;
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

	function unsubscribe(s_id,u_id,button_name) {
		var flag = false;
        var ids = new RegExp("^\\d*$");
	    if (!ids.test(s_id)||!ids.test(u_id))
	    {
	      toastr.error("参数传递错误", "错误");
	      //toastr.info(phoneNumber, "DEBUG");
	      $("#"+button_name).focus();
	      return false;
	    }
	    data = {'u_id':u_id,'s_id':s_id};
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
              $("button[name=u"+button_name+"]").hide();
              $("button[name=s"+button_name+"]").show();
              flag = true;
            }
            else if(result == "None")
            {
            	toastr.warning("您还未订阅过:"+result.substr(3), "警告");
            	$("button[name=u"+button_name+"]").hide();
              	$("button[name=s"+button_name+"]").show();
              	flag = true;
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
</script>
