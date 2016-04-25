<!--某一集的下载链接-->
</div><!-- /container -->
<div class="container">
	<div class="page-header">
		<h3>下载链接</h3>
		<h5>注意：下载链接是由<a href="https://btio.pw/">BTSOW</a>等网站提供，您点击下载时会跳转到第三方网站的链接，我们不对也无法对链接的内容承担任何责任。</h5>
		<h5>您在点击下载时意味着您已经阅读过我们的法律条款以及知晓上述声明，如果您认为资源侵犯了您的权益，请立刻<a href="mailto:zhuyf8899@gmail.com">联系我们</a>，我们会在48小时内封禁对该链接的引用。</h5>
	</div>
	<?php
	if (isset($link)) 
	{
		?>
		<table class="table table-hover table-striped">
			<thead>
		        <tr>
			      	<td class="col-md-6">文件名</td>
			      	<td class="col-md-2">清晰度</td>
			        <td class="col-md-2">文件大小</td>
			      	<td class="col-md-2">下载链接</td>
		      	</tr>
		    </thead>
    		<tbody>
    		<?php
    		foreach ($link as $oneLink) 
    		{
    			?>
    			<tr>
    				<td class="col-md-6"><?php echo $oneLink['item_file_name']; ?></td>
    				<td class="col-md-2"><?php echo $oneLink['item_format']; ?></td>
    				<td class="col-md-2"><?php echo $oneLink['item_size']; ?></td>
    				<td class="col-md-2"><?php if($oneLink['item_ed2k_link'] != 'NULL'){
    					echo "<a href=\"{$oneLink['item_ed2k_link']}\" target=\"_blank\">点击跳转下载</a>";
    					}elseif($oneLink['item_magnet_link'] != 'NULL'){
    					echo "<a href=\"{$oneLink['item_magnet_link']}\" target=\"_blank\">点击跳转下载</a>";
    					}else{
    						echo "下载链接已失效";
    						} ?>
    				</td>
    			</tr>
    			
    			<?php
    		}
			?>
			</tbody>
		</table>
		<?php
		if (count($link) == 0) 
		{
			echo "<h4>当前还没有可用下载，可能字幕组还没有来得及更新翻译好的熟肉，也有可能是该剧太冷门，您可以稍后再试试看.</h4>";
		}
	}else{
		echo "<h4>当前还没有可用下载，可能字幕组还没有来得及更新翻译好的熟肉，也有可能是该剧太冷门，您可以稍后再试试看.</h4>";
	}
	
	?>