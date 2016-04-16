<!--查看推荐的页面-->
</div><!-- /container -->
<div class="container">
 	<div class="page-header">
		<h3>当前热播</h3>
	</div>
	<div class="row">
    	<div class="col-md-10">
      		<?php
      		$transStatus = array('Canceled/Ended' => '已完结/已停播', 'Returning Series' => '回归剧(正在连载)','Final Season' => '完结季(正在连载)', 'New Series' => '新剧(正在连载)' );
      		if (isset($iLike)) 
      		{
      		?>
      		<div class="page-header">
				<h4>猜我喜欢</h4>
			</div>
      		<table class="table table-condensed">
	      		<thead>
	      			<tr>
	      				<th class="col-md-3">#</th>
	      				<th class="col-md-2">剧名</th>
	      				<th class="col-md-1">地区/状态</th>
	      				<th class="col-md-2">推荐原因</th>
                <th class="col-md-1">订阅</th>
	      				<th class="col-md-1">剧集详情</th>
	      			</tr>
	      		</thead>
	      		<tbody>
      		<?php
            $amount = count($iLike);
            $counter = 0;
      			foreach ($iLike as $oneShow) 
      			{
              if(isset($oneShow['s_id']))
              {
      				?>
      				<tr>
      					<td class="col-md-3"><img src="<?php echo $CUrl.$oneShow['s_sibox_image'] ;?>" alt="<?php echo $oneShow['s_name'].':'.$oneShow['s_name_cn']; ?>"></td>
      					<td class="col-md-2" ><?php echo $oneShow['s_name'].'<br/>'.$oneShow['s_name_cn']; ?></td>
      					<td class="col-md-1"><?php echo $oneShow['area'].'/'.$transStatus["{$oneShow['status']}"]; ?></td>
      					<!--<td class="col-md-2"><?php //if($counter >= $amount/2){echo "和您关注同一部剧的人还关注了这部剧";}else{ echo "因为您关注了“{$oneShow['t_name_cn']}”标签";}; ?></td>-->
                <td class="col-md-2"><?php if($counter >= $amount/2){echo "和您关注同一部剧的人还关注了这部剧";}else{ echo "因为您关注了“{$oneShow['t_name_cn']}”标签";}; ?></td>
                <td class="col-md-1">占位</td>
      					<td class="col-md-1"><a class="btn btn-info" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $oneShow['s_id']; ?>">剧集详情&raquo;</a></td>
      				</tr>
      				<?php
              }
              $counter++;
      			}
      			if(!isset($hot))
      			{
      				$hot = array();
      			}
      			$counter = 0;
      			foreach ($hot as $oneShow) 
      			{
      				if($counter == 5)
      					break;
      				$counter++;
      				?>
      				<tr>
      					<td class="col-md-3"><img src="<?php echo $CUrl.$oneShow['s_sibox_image'] ;?>" alt="<?php echo $oneShow['s_name'].':'.$oneShow['s_name_cn']; ?>"></td>
      					<td class="col-md-2" ><?php echo $oneShow['s_name'].'<br/>'.$oneShow['s_name_cn']; ?></td>
      					<td class="col-md-1"><?php echo $oneShow['area'].'/'.$transStatus["{$oneShow['status']}"]; ?></td>
      					<td class="col-md-2">因为它很热门</td>
                <td class="col-md-1">占位</td>
      					<td class="col-md-1"><a class="btn btn-info" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $oneShow['s_id']; ?>">剧集详情&raquo;</a></td>
      				</tr>
      				<?php
      			}
      		?>
	      		</tbody>
      		</table>
      		<?php
      		}
      		else
      		{
      		?>
      		<div class="page-header">
				<h4>本站排名</h5>
			</div>
      		<table class="table table-condensed">
	      		<thead>
	      			<tr>
	      				<th class="col-md-3">#</th>
	      				<th class="col-md-2">剧名</th>
	      				<th class="col-md-1">地区/状态</th>
	      				<th class="col-md-2">热度</th>
                <th class="col-md-1">占位</th>
	      				<th class="col-md-1">剧集详情</th>
	      			</tr>
	      		</thead>
	      		<tbody>
      		<?php
      			foreach ($hot as $oneShow) 
      			{
      				?>
      				<tr>
      					<td class="col-md-3"><img src="<?php echo $CUrl.$oneShow['s_sibox_image'] ;?>" alt="<?php echo $oneShow['s_name'].':'.$oneShow['s_name_cn']; ?>"></td>
      					<td class="col-md-2" ><?php echo $oneShow['s_name'].'<br/>'.$oneShow['s_name_cn']; ?></td>
      					<td class="col-md-1"><?php echo $oneShow['area'].'/'.$transStatus["{$oneShow['status']}"]; ?></td>
      					<td class="col-md-2"><?php echo $oneShow['numbers'] ?></td>
                <td class="col-md-1">占位</td>
      					<td class="col-md-1"><a class="btn btn-info" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $oneShow['s_id']; ?>">剧集详情&raquo;</a></td>
      				</tr>
      				<?php
      			}
      		?>
	      		</tbody>
      		</table>
      		<?php
      		}
      		?>
    	</div>
    	<div class="col-md-2">
    		<div class="page-header">
				<h4>选择您喜欢的类型</h5>
			</div>
      		<?php
      		if (isset($tag)) 
      		{
      			foreach ($tag as $oneTag) 
      			{
      				?>
      				<br/>
      				&nbsp;&nbsp;&nbsp;<button type="button" id="<?php echo 'l'.$oneTag['t_id'];?>" onclick="like(<?php echo ($oneTag['t_id'].','.$this->session->u_id);?>);" class="btn btn-success" <?php if($oneTag['lik'] == 0){echo "style=\"display:none\"";} ?> ><?php echo $oneTag['t_name_cn']; ?></button>&nbsp;&nbsp;&nbsp;

      				&nbsp;&nbsp;&nbsp;<button type="button" id="<?php echo 'u'.$oneTag['t_id'];?>" onclick="unlike(<?php echo ($oneTag['t_id'].','.$this->session->u_id);?>);" class="btn btn-warning" <?php if($oneTag['lik'] == 1){echo "style=\"display:none\"";} ?> >不再订阅“<?php echo $oneTag['t_name_cn']; ?>”</button>&nbsp;&nbsp;&nbsp;<br/>
      				<?php
      			}
      		}
      		?>
    	</div>
  	</div>
</div>
<script type="text/javascript">
	function like(t_id,u_id) {
        var ids = new RegExp("^\\d*$");
	    if (!ids.test(t_id)||!ids.test(u_id))
	    {
	      toastr.error("参数传递错误", "错误");
	      //toastr.info(phoneNumber, "DEBUG");
	      $("#l"+t_id).focus();
	    }
	    data = {'u_id':u_id,'t_id':t_id};
        $.ajax({
          type: 'POST',
          url: '/TVCalendarAPI/index.php/UI/ajaxLike',
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
              toastr.success("已关注:"+result.substr(3), "操作完成");
              //$("button[id=s"+e_id+"]").hide();
              //$("button[id=u"+e_id+"]").show();
              $("#l"+t_id).hide();
              $("#u"+t_id).show();
            }
            else if(result == "Repeat")
            {
            	toastr.warning("您已关注过:"+result.substr(3), "警告");
            	$("#l"+t_id).hide();
              	$("#u"+t_id).show();
            }
            else
            {
              toastr.error("未知错误", "错误");
            }
          },
        });
        //toastr.warning(flag.toString(), "DEBUG");
	}

	function unlike(t_id,u_id) {
        var ids = new RegExp("^\\d*$");
	    if (!ids.test(t_id)||!ids.test(u_id))
	    {
	      toastr.error("参数传递错误", "错误");
	      //toastr.info(phoneNumber, "DEBUG");
	      $("#u"+t_id).focus();
	    }
	    data = {'u_id':u_id,'t_id':t_id};
        $.ajax({
          type: 'POST',
          url: '/TVCalendarAPI/index.php/UI/ajaxUnlike',
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
              toastr.success("取消关注:"+result.substr(3), "操作完成");
              //window.location.href("/TVCalendarAPI/index.php/UI/index");
              //$("button[id=u"+e_id+"]").hide();
              //$("button[ud=s"+e_id+"]").show();
              $("#u"+t_id).hide();
              $("#l"+t_id).show();
            }
            else if(result == "None")
            {
            	toastr.warning("您未关注:"+result.substr(3), "警告");
            	$("#u"+t_id).hide();
              	$("#s"+t_id).show();
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