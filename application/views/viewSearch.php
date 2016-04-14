<!--搜索页-->
</div><!-- /container -->
<style type="text/css">
.button-fix{
	margin-left: -15px;
	margin-right: -15px;
	margin-top : -15px;
	margin-bottom: -15px;
}
</style>
<div class="container">
  <div class="page-header">
	<h3>查找剧集</h3>
  <h5>目前仅允许通过剧名称查找（中英文名皆可），如需按照其他方式查找，可以通过<a href="/TVCalendarAPI/index.php/UI/viewMonth">按时间线索查找</a>或者<a href="/TVCalendarAPI/index.php/UI/commend">热度分类推荐</a>进行查看。</h5>
  </div>
  <form id="searchForm" action="/TVCalendarAPI/index.php/UI/search/" method="GET" onsubmit="return check_submit();" >
    <div class="input-group">
        <input type="text" id="searchInput" value="" class="form-control" spellcheck="false" placeholder="如 Game of Thrones" />
        <span class="input-group-addon"><button class="btn btn-primary btn-lg button-fix" type="submit"><span class="glyphicon glyphicon-search"> </span></button></span>
    </div>
  </form>

  <br/>
  <br/>
  <br/>
  <table class="table table-condensed">
  <?php
  $transStatus = array('Canceled/Ended' => '已完结/已停播', 'Returning Series' => '回归剧(正在连载)', 'New Series' => '新剧(正在连载)' );

  if (isset($result)) 
  {
  	foreach ($result as $oneShow) 
  	{
  	?>
	  	<tr>
	  		<td class="col-md-4"><img src="<?php echo $CUrl.$oneShow['s_sibox_image'] ;?>" alt="剧照"></td>
	  		<td class="col-md-6"><h4><?php echo $oneShow['s_name_cn'].'<br/>';?></h4><?php echo $oneShow['s_name']; ?><br/>地区:<?php echo $oneShow['area']; ?>&nbsp;&nbsp;&nbsp;状态:<?php echo $transStatus["$oneShow[status]"];?></td>
	  		<td class="col-md-2"><a class="btn btn-info" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $oneShow['s_id']; ?>">剧集详情&raquo;</a></td>
	  	</tr>
  	<?php
  	}
  }
  ?>
  </table>
  <?php
  if ($fullRequest) 
  {
  	?>
  	<p>您搜索的结果过多，我们只为您显示了部分结果,您可以更加详细搜索内容或者点击<a href="<?php echo $_SERVER['REQUEST_URI'].'/fullresult';?>">这里查看</a>全部搜索结果</p>
  	<?php
  }
  ?>

  <script type="text/javascript">
  	function check_submit() {
  		flag = false;
  		if ($("#searchInput").val() != "") 
  		{
  			flag = true;
  			//$("#searchForm").action = 'http://yifanslab.cn/TVCalendarAPI/index.php/UI/search/'+$("#searchInput").val;
  			$('#searchForm').attr('action', '/TVCalendarAPI/index.php/UI/search/' + $("#searchInput").val());
  		}
  		else
  		{
  			$("#searchInput").focus();
  		}
  		return flag;
  	}
  </script>
</div>