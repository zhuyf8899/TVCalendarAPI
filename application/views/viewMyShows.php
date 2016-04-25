<!--每个用户的订阅剧集操作的快捷入口-->
</div><!-- /container -->
<div class="container">
  <div class="page-header">
	<h3>我关注的近期剧集</h3>
  <h5>显示过去7天到未来7天的剧集播放情况，获取其他剧集信息请通过<a href="/TVCalendarAPI/index.php/UI/viewMonth">按月份查找</a>了解完整的播放表或者通过<a href="/TVCalendarAPI/index.php/UI/search">搜索剧集</a>查找</h5>
  <h5>蓝色背景表格为今日播出剧</h5>
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
        <tr class="<?php if(substr($oneEp['e_time'], 0,10) == date('Y-m-d')){echo 'info';}?>">
          <td class="col-md-3"><?php echo $oneEp['e_time']; ?></td>
	      	<td class="col-md-3"><?php echo $oneEp['s_name_cn'].'<br/>'.$oneEp['s_name']; ?></td>
          <td class="col-md-2"><?php echo '第'.$oneEp['se_id'].'季:第'.$oneEp['e_num'].'集'; ?></td>
	      	<td class="col-md-1"><?php echo $oneEp['e_status']; ?></td>
	      	<td class="col-md-1">
          <?php
            if(strtotime(date('Y-m-d H:i:s')) > strtotime($oneEp['e_time'])){
          ?>
            <button type="button" id="syned<?php echo $oneEp['e_id']; ?>" class="btn btn-default" <?php if( $oneEp['syn'] == 0){echo "style=\"display:none\"";} ?> disabled >已观看</button>
	      	  <button type="button" id="sep<?php echo $oneEp['e_id']; ?>" class="btn btn-success" onclick="syn(<?php echo $this->session->u_id.','.$oneEp['e_id']; ?>);" <?php if( $oneEp['syn'] == 1){echo "style=\"display:none\"";} ?> >我看完了</button>
            <?php
            }
            else
            {
              echo "尚未播放";
            }
            ?>
	      	</td>
	      	<td class="col-md-1"><a class="btn btn-info" target="_blank" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $oneEp['s_id'];?>">剧集详情&raquo;</a></td>
	      	<td class="col-md-1"><a target="_blank" href="/TVCalendarAPI/index.php/UI/download?s_name=<?php echo urlencode($oneEp['s_name']);?>&se_id=<?php echo $oneEp['se_id']; ?>&e_num=<?php echo  $oneEp['e_num'];?>" class="btn btn-info" >前往下载链接&raquo;</a></td>
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
              <h3><?php echo $mySubscribe[$i*3+$j]['s_name_cn']; ?></h3>
              <h5><?php echo $mySubscribe[$i*3+$j]['s_name']; ?></h5>
              <img src="<?php echo $CUrl.$mySubscribe[$i*3+$j]['s_sibox_image']; ?>" alt="<?php echo $mySubscribe[$i*3+$j]['s_name']; ?>">
              <p>地区：<?php echo $mySubscribe[$i*3+$j]['area']; ?> 电视台：<?php echo $mySubscribe[$i*3+$j]['channel']; ?></p>
              <p>每周<?php echo $mySubscribe[$i*3+$j]['update_time']; ?>（格林尼治时间）</p>
              <p><a class="btn btn-default" target="_blank" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $mySubscribe[$i*3+$j]['s_id']; ?>" role="button">点击前往 &raquo;</a></p>
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