<!--这个是UI使用的界面信息-->
<div class="container">
  <div class="page-header">
    <h1><?php if(isset($showInfo['s_name'])){echo $showInfo['s_name'];} ?></h1>
  </div>
  <img class="img-thumbnail" alt="200x200" src="<?php if(isset($showInfo['s_sibox_image'])){echo $CUrl.$showInfo['s_sibox_image'];} ?>" data-holder-rendered="true">
  <table class="table table-bordered table-hover">
    <tr>
    	<th class="col-md-2">剧状态</th>
    	<td class="col-md-2"><?php if(isset($showInfo['status'])){echo $showInfo['status'];} ?></td>
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
	    	?>
	    	<tr>
	    		<th class="col-md-4"><?php if(isset($episodeInfo[$i]['e_name'])){echo $episodeInfo[$i]['e_name'];} ?></th>
		      	<th class="col-md-2">第<?php if(isset($episodeInfo[$i]['se_id'])){echo $episodeInfo[$i]['se_id'];} ?>季，第<?php if(isset($episodeInfo[$i]['e_num'])){echo $episodeInfo[$i]['e_num'];} ?>集</th>
		      	<th class="col-md-3"><?php if(isset($episodeInfo[$i]['e_time'])){echo $episodeInfo[$i]['e_time'];} ?></th>
		      	<th class="col-md-3"><button type="button" class="btn btn-success">我看完了</button><button type="button" class="btn btn-warning">取消同步</button><button type="button" class="btn btn-info">前往下载链接</button></th>
	    	</tr>
	    	<?php
	    }
	    ?>
	    	<tr>
	    		
	    	</tr>
	    </tbody>
	  </table>
  </div>
</div>