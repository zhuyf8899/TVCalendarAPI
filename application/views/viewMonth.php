</div> <!-- /container -->

</style>
<div class="container">
<div class="navbar navbar-default" >
	<div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
		  <li>
		    <a class="btn btn-default" href="/TVCalendarAPI/index.php/UI/viewMonth/<?php if(isset($dateStart)){ echo date('Y-m',strtotime("$dateStart -1 month"));} ?>" role="button">
		    上月</a>
		  </li>
		</ul>
		<ul class="nav navbar-nav" style="align:center;">
		  <li>
		    <a><?php if(isset($dateStart)){ echo date('Y年m月',strtotime($dateStart));} ?></a>
		  </li>
		</ul>
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
		  			<?php 
		  			if ($aShow['sub'] == "1") {
		  				echo "<button type=\"button\" class=\"btn btn-success\">不再订阅</button>";
		  			}
		  			else{
		  				echo "<button type=\"button\" class=\"btn btn-warning\">订阅</button>";
		  				} ?>
		  			</th>
		  			<th class="col-md-1"><a class="btn btn-info" href="/TVCalendarAPI/index.php/UI/showSummary?s_id=<?php echo $aShow['s_id']; ?>">剧集详情</a></th>
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
