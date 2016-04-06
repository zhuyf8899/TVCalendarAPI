<!--每个用户的订阅剧集操作的快捷入口-->
</div><!-- /container -->
<div class="container">
  <div class="page-header">
	<h1>近期剧集</h1>
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
      	<td class="col-md-2">播放状态</td>
      	<td class="col-md-2">观看状态</td>
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
	      	<td class="col-md-2"><?php echo $oneEp['e_status']; ?></td>
	      	<td class="col-md-2">
	      	  <span class=\"label label-default\" style="<?php if($oneEp['syn'] == 0){echo "display: none;"} ?>">已观看</span>
	      	  <button type="button" id="sep<?php echo $oneEp['e_id']; ?>" class="btn btn-success" onclick="syn(<?php echo $this->session->u_id.','.$episodeInfo[$i]['e_id']; ?>);" <?php if( $oneEp['syn'] == 1){echo "style=\"display:none\"";} ?> >我看完了</button>
	      	</td>
	      	<td class="col-md-1"><a class="btn btn-info" href="/TVCalendarAPI/UI/showSummary/<?php echo $oneEp['s_id'];?>">剧集详情&raquo;</a></td>
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
  <div class="row">
  <?php
  }
  if (isset($mySubscribe)) {
      $rows = intval(ceil((count($mySubscribe))/3));
      for ($i=0; $i < $rows; $i++) 
      { 
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
      }
  }
  ?>
  
  	
  </div><!--row-->
</div><!--container-->