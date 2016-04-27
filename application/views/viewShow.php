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
      <button type="button" class="btn btn-lg btn-success" id="sub" name="s999999" onclick="subscribe(<?php if(isset($s_id)){echo $s_id.','.$this->session->u_id.',999999';} ?>);" style="<?php if($subOrNot){echo "display:none";} ?>" >订阅本剧</button>
      <button type="button" class="btn btn-lg btn-warning" id="unsub" name="u999999" onclick="unsubscribe(<?php if(isset($s_id)){echo $s_id.','.$this->session->u_id.',999999';} ?>);" style="<?php if(!$subOrNot){echo "display:none";} ?>" >不再订阅</button>
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
  <?php 
  if (count($episodeInfo) == 0) 
  {
  	echo "<h5>当前没有集记录</h5>";
  }
  else
  {
  ?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading<?php if(isset($episodeInfo[0]['se_id'])){echo $episodeInfo[0]['se_id'];}?>">
		    <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php if(isset($episodeInfo[0]['se_id'])){echo $episodeInfo[0]['se_id'];}?>" aria-expanded="true" aria-controls="collapse<?php if(isset($episodeInfo[0]['se_id'])){echo $episodeInfo[0]['se_id'];}?>" onclick="changeArrow('<?php if(isset($episodeInfo[0]['se_id'])){echo $episodeInfo[0]['se_id'];}?>');">
			    <h4 class="panel-title">
			      	<?php if(isset($episodeInfo[0]['se_id'])){echo '第'.$episodeInfo[0]['se_id'].'季';} ?>
			        <span class="glyphicon glyphicon-menu-down" aria-hidden="true" id="down<?php echo $episodeInfo[0]['se_id'];?>" style="float: right;display: none"></span>
			        <span class="glyphicon glyphicon-menu-up" aria-hidden="true" id="up<?php echo $episodeInfo[0]['se_id'];?>" style="float: right;" ></span>
			    </h4>
		    </a>
		</div>
		<div id="collapse<?php if(isset($episodeInfo[0]['se_id'])){echo $episodeInfo[0]['se_id'];}?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php if(isset($episodeInfo[0]['se_id'])){echo $episodeInfo[0]['se_id'];}?>">
			<div class="panel-body">
				<table class="table table-hover table-striped">
				    <thead>
				      <tr>
				      	<th class="col-md-4">集名</th>
				      	<th class="col-md-2">集数</th>
				      	<th class="col-md-3">播放日期</th>
				      	<th class="col-md-3">选项</th>
				      </tr>
				    </thead>
				    <tbody>
				    <?php
				    for ($i=0; $i < count($episodeInfo); $i++) { 
				    	if ($i>0 && $episodeInfo[$i]['se_id'] != $episodeInfo[$i-1]['se_id']) {
				    		?>
				    			</tbody>
							</table>
						</div><!--panel-body-->
					</div><!--collapse-->
				</div><!--panel panel-default-->
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="heading<?php if(isset($episodeInfo[$i]['se_id'])){echo $episodeInfo[$i]['se_id'];}?>">
					    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php if(isset($episodeInfo[$i]['se_id'])){echo $episodeInfo[$i]['se_id'];}?>" aria-expanded="false" aria-controls="collapse<?php if(isset($episodeInfo[$i]['se_id'])){echo $episodeInfo[$i]['se_id'];}?>" onclick="changeArrow('<?php if(isset($episodeInfo[$i]['se_id'])){echo $episodeInfo[$i]['se_id'];}?>');">
						    <h4 class="panel-title">
						      	<?php if(isset($episodeInfo[$i]['se_id'])){echo '第'.$episodeInfo[$i]['se_id'].'季';} ?>
						        <span class="glyphicon glyphicon-menu-down" aria-hidden="true" id="down<?php echo $episodeInfo[$i]['se_id'];?>" style="float: right;"></span>
						        <span class="glyphicon glyphicon-menu-up" aria-hidden="true" id="up<?php echo $episodeInfo[$i]['se_id'];?>" style="float: right;display: none" ></span>
						    </h4>
					    </a>
					</div>
					<div id="collapse<?php if(isset($episodeInfo[$i]['se_id'])){echo $episodeInfo[$i]['se_id'];}?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php if(isset($episodeInfo[$i]['se_id'])){echo $episodeInfo[$i]['se_id'];}?>">
						<div class="panel-body">
							<table class="table table-hover table-striped">
				    			<thead>
				      				<tr>
								      	<th class="col-md-4">集名</th>
								      	<th class="col-md-2">集数</th>
								      	<th class="col-md-3">播放日期</th>
								      	<th class="col-md-3">选项</th>
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
					      	<?php
					      	if(strtotime(date('Y-m-d H:i:s')) > strtotime($episodeInfo[$i]['e_time'])){
					      	?>
					      	<button type="button" id="s<?php echo $episodeInfo[$i]['e_id']; ?>" class="btn btn-success" onclick="syn(<?php echo $this->session->u_id.','.$episodeInfo[$i]['e_id']; ?>);" <?php if( $episodeInfo[$i]['syn'] == 1){echo "style=\"display:none\"";} ?> >我看完了</button>
					      	<button type="button" id="u<?php echo $episodeInfo[$i]['e_id']; ?>" class="btn btn-warning" onclick="unsyn(<?php echo $this->session->u_id.','.$episodeInfo[$i]['e_id']; ?>);" <?php if( $episodeInfo[$i]['syn'] == 0){echo "style=\"display:none\"";} ?> >取消同步</button>
			            <a target="_blank" href="/TVCalendarAPI/index.php/UI/download?r_id=<?php echo urlencode($showInfo['r_id']);?>&se_id=<?php echo $episodeInfo[$i]['se_id']; ?>&e_num=<?php echo  $episodeInfo[$i]['e_num'];?>&e_id=<?php echo $episodeInfo[$i]['e_id']; ?>" class="btn btn-info" >前往下载链接&raquo;</a>
			            	<?php
			            	}
			            	else
			            	{
			            		echo "尚未播出";
			            	}
			            	?>
					      	</th>
				    	</tr>
				    	<?php
				    	}
				    }
				}//end of else
				    ?>
				    </tbody>
				</table>
			</div><!--panel-body-->
		</div><!--collapse-->
	</div><!--panel panel-default-->
	  
  </div><!--panel-group-->
</div>