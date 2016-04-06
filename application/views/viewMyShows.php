<!--每个用户的订阅剧集操作的快捷入口-->
</div><!-- /container -->
<div class="container">
  <div class="page-header">
	<h3>我关注的近期剧集</h3>
  <h5>显示过去7天到未来7天的剧集播放情况，获取其他信息请通过<a href="/TVCalendarAPI/index.php/UI/viewMonth">按月份查找</a>或者其他方式了解</h5>
  </div>
  <?php 
  if(isset($rescentEps))
  {
  ?>
  <table class="table table-hover table-striped">
    <thead>
      <tr>
      	<td class="col-md-3">日期</td>
      	<td class="col-md-3">剧名</td>
        <td class="col-md-2">集数</td>
      	<td class="col-md-1">播放状态</td>
      	<td class="col-md-1">观看状态</td>
      	<td class="col-md-1">剧集详情</td>
      	<td class="col-md-1">下载链接</td>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($rescentEps as $oneEp) 
      {

      ?>
        <tr>
          <td class="col-md-3"><?php echo $oneEp['e_time']; ?></td>
	      	<td class="col-md-3"><?php echo $oneEp['s_name']; ?></td>
          <td class="col-md-2"><?php echo '第'.$oneEp['se_id'].'季:第'.$oneEp['e_num'].'集'; ?></td>
	      	<td class="col-md-1"><?php echo $oneEp['e_status']; ?></td>
	      	<td class="col-md-1">
            <button type="button" id="syned<?php echo $oneEp['e_id']; ?>" class="btn btn-default" <?php if( $oneEp['syn'] == 0){echo "style=\"display:none\"";} ?> disabled >已观看</button>
	      	  <button type="button" id="sep<?php echo $oneEp['e_id']; ?>" class="btn btn-success" onclick="syn(<?php echo $this->session->u_id.','.$oneEp['e_id']; ?>);" <?php if( $oneEp['syn'] == 1){echo "style=\"display:none\"";} ?> >我看完了</button>
	      	</td>
	      	<td class="col-md-1"><a class="btn btn-info" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $oneEp['s_id'];?>">剧集详情&raquo;</a></td>
	      	<td class="col-md-1"><a class="btn btn-default" href="#">下载链接&raquo;</a></td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
  <div class="page-header">
	<h3>我订阅的剧集</h3>
  </div><!--page-header-->
  <?php
  }
  if (isset($mySubscribe)) {
      $rows = intval(ceil((count($mySubscribe))/3));
      for ($i=0; $i < $rows; $i++) 
      { 
        ?>
        <div class="row">
        <?php
      	for ($j=0; $j < 3; $j++) 
        {
          if ($i*3+$j>=count($mySubscribe)) 
          {
            break;
          }
          ?>
            <div class="col-md-4">
              <h3><?php echo $mySubscribe[$i*3+$j]['s_name']; ?></h3>
              <img src="<?php echo $CUrl.$mySubscribe[$i*3+$j]['s_sibox_image']; ?>" alt="<?php echo $mySubscribe[$i*3+$j]['s_name']; ?>">
              <p>地区：<?php echo $mySubscribe[$i*3+$j]['area']; ?> 电视台：<?php echo $mySubscribe[$i*3+$j]['channel']; ?></p>
              <p>每周<?php echo $mySubscribe[$i*3+$j]['update_time']; ?>（格林尼治时间）</p>
              <p><a class="btn btn-default" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $mySubscribe[$i*3+$j]['s_id']; ?>" role="button">点击前往 &raquo;</a></p>
            </div>
        <?php
      	}
        ?>
        </div><!--row-->
        <?php
      }
  }
  ?>
</div><!--container-->
<script type="text/javascript">
  function syn(u_id,e_id) {
        var ids = new RegExp("^\\d*$");
      if (!ids.test(e_id)||!ids.test(u_id))
      {
        toastr.error("参数传递错误", "错误");
        //toastr.info(phoneNumber, "DEBUG");
        $("#sep"+e_id).focus();
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
              $("#sep"+e_id).hide();
              $("#syned"+e_id).show();
            }
            else if(result == "Repeat")
            {
              toastr.warning("您曾观看过:"+result.substr(3), "警告");
              $("#sep"+e_id).hide();
              $("#syned"+e_id).show();
            }
            else
            {
              toastr.error("未知错误", "错误");
            }
          },
        });
        //toastr.warning(flag.toString(), "DEBUG");
  }
</script>