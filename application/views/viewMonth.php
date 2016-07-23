<!--每个月的剧集列表-->
 </div><!-- /container -->

<style>
.navbar-left{
	margin-left: -15px;
}
.panel-heading a:focus,.panel-heading a:hover{
	text-decoration: none;
}
</style>
<div class="container">
<div class="navbar navbar-default" >
	<div class="navbar-collapse collapse" style="text-align: center;">
		<ul class="nav navbar-nav navbar-left">
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
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php
$week = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
if (isset($shows)) 
{
	$days = count($shows);
	foreach ($shows as $dayDate => $oneday)
	{
		?>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading<?php echo substr($dayDate,5,5);?>">
		    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo substr($dayDate,5,5);?>" aria-expanded="false" aria-controls="collapse<?php echo substr($dayDate,5,5);?>" onclick="changeArrow('<?php echo substr($dayDate,5,5);?>');">
			    <h4 class="panel-title">
			      	<?php echo substr($dayDate,5,5).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$week[date("w",strtotime($dayDate))]; ?>
			        <span class="glyphicon glyphicon-menu-down" aria-hidden="true" id="down<?php echo substr($dayDate,5,5);?>" style="float: right;"></span>
			        <span class="glyphicon glyphicon-menu-up" aria-hidden="true" id="up<?php echo substr($dayDate,5,5);?>" style="float: right;display: none" ></span>
			    </h4>
		    </a>
		</div>
		<div id="collapse<?php echo substr($dayDate,5,5);?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo substr($dayDate,5,5);?>">
			<div class="panel-body">
			  	<table class="table table-hover table-striped">
			  		<tbody>
			  		<?php
				  	foreach ($oneday as $aShow) 
				  	{
				  		?>
				  		<tr>
				  			<th class="col-md-1"><?php echo substr($aShow['e_time'],-8); ?></th>
				  			<th class="col-md-9"><mark><?php echo $aShow['s_name_cn'].'('.$aShow['s_name'].')'; ?></mark>:第<?php echo $aShow['se_id']; ?>季，第<?php echo $aShow['e_num']; ?>集&nbsp;&nbsp;&nbsp;“<?php echo $aShow['e_name']; ?>”</th>
				  			<th class="col-md-1">
				  			<button type="button" name="<?php echo 'u'.$this->session->u_id.$aShow['s_id'];?>" onclick="unsubscribe(<?php echo ($aShow['s_id'].','.$this->session->u_id.','.$this->session->u_id.$aShow['s_id']);?>);" class="btn btn-warning" <?php if($aShow['sub'] != "1"){echo "style=\"display:none\"";} ?> >不再订阅</button>
				  			<button type="button" name="<?php echo 's'.$this->session->u_id.$aShow['s_id'];?>" onclick="subscribe(<?php echo ($aShow['s_id'].','.$this->session->u_id.','.$this->session->u_id.$aShow['s_id']);?>);" class="btn btn-success" <?php if($aShow['sub'] == "1"){echo "style=\"display:none\"";};if(!$login_flag){echo ' disabled="disabled"';} ?>  ><?php if(!$login_flag){echo '未登录';}else{echo '订阅';} ?></button>
				  			</th>
				  			<th class="col-md-1"><a class="btn btn-info" target="_blank" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $aShow['s_id']; ?>">剧集详情&raquo;</a></th>
			  			</tr>
			  		<?php
			  		}
			  		?>
			        </tbody>
				</table>
			</div>
		</div>
	</div>
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