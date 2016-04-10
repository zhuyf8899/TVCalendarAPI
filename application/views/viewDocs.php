<!--文档页-->
</div><!-- /container -->
<div class="container">
<?php
if ($kind == 'letter') 
{
?>
	<div class="page-header">
	<h3>致所有用户的一封信</h3>
	</div>
	<p>
		尊敬的各位用户：
	</p>
	<p>
		首先，十分感谢您选择使用我们的美剧日历服务。
	</p>
	<p>
		我们这个项目的目的正如之前所说，是帮助想观看美剧的用户们提供一个关于播放信息的辅助网站，您可以通过它获得相应的美剧更新信息和历史播放数据。这些数据来源于互联网的各个角落，我们通过定期采集后提供给大家。或许大家已经看出来了，我们的这个项目的数据是免费的，项目的本身也是免费且开源的。
	</p>
	<p>
		然而，在这个项目运行的过程中，我们不得不支付供其运行的一些硬件经费，费用往往产生于：
	</p>
	<ul>
		<li>云服务器费用：目前使用的是服务商提供的最小型虚拟服务器，在用户增加后可能也随之增加</li>
		<li>数据存储费用：目前尚未使用额外的数据盘，但随着数据库的日益增加可能在以后的某个时间出现这项支出</li>
		<li>开发者账号费用：iOS客户端的开发者账号目前使用的是项目成员的个人开发账号</li>
	</ul>
	<p>
		我们尽自己最大的力量维持该项目的运营（项目组成员均为免费兼职开发此项目，并均摊了当前的成本），该项目目前全部的收入为:
	</p>
	<ul>
		<li>项目组成员均摊：目前是最主要的经济支持</li>
		<li>广告收入：我们计划在最近开始投放来自百度等平台的广告以获得收入，但此方面的收入微乎其微（因为浏览人数较少且我们不愿牺牲太多的用户体验）</li>
		<li>赞助</li>
	</ul>
	<p>
		我们在这里请愿意帮助我们一起运营的用户资助我们，所有的收入在被确认后和支出将被记录在以下的表格中且仅用于支付上述支出。作为开发者，我们万分感谢您对本项目的帮助！
	</p>
	<p>赞助连接（请在汇款后注明“美剧日历”，以便我们尽快统计并将您的赞助金额上传到下方表格，您的个人信息会被严格保密）<img src="aa" alt="二维码" /></p>
	<h4>近期收支表（项目组成员的均摊费用不在其中，因为费用的产生时项目组成员已经先行垫付）</h4>
	<table class="table table-condensed">
		<thead>
			<tr>
				<th class="col-md-2">时间</th>
				<th class="col-md-1">类别</th>
				<th class="col-md-4">原因</th>
				<th class="col-md-3">金额</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if (isset($budget)) 
		{
			foreach ($budget as $record) 
			{
			
		?>
			<tr class="<?php if($record['b_kind']=='支出'){echo "danger";}else{echo "success";}?>">
				<td class="col-md-2"><?php echo $record['b_time']; ?></td>
				<td class="col-md-1"><?php echo $record['b_kind'];?></td>
				<td class="col-md-4"><?php echo $record['b_reason']; ?></td>
				<td class="col-md-3"><?php echo $record['b_amount']; ?></td>
			</tr>
		<?php
			}
		}
		?>
		</tbody>
	</table>
<?php
}
else if($kind == 'license')
{
?>
	<div class="page-header">
	<h3>法律信息</h3>
	</div>
	<p>本项目采用开源的方式进行发行，其中网站部分使用MIT许可进行授权，以下为许可原文：</p>
	<pre>
		The MIT License (MIT)

		Copyright (c) 2014 - 2015, British Columbia Institute of Technology

		Permission is hereby granted, free of charge, to any person obtaining a copy
		of this software and associated documentation files (the "Software"), to deal
		in the Software without restriction, including without limitation the rights
		to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
		copies of the Software, and to permit persons to whom the Software is
		furnished to do so, subject to the following conditions:

		The above copyright notice and this permission notice shall be included in
		all copies or substantial portions of the Software.

		THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
		IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
		FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
		AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
		LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
		OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
		THE SOFTWARE.
	</pre>
	<p>在您注册并使用本项目的时刻起，我们视为您已阅读并同意上述许可的信息，如您拒绝此协议则请不要使用本项目。</p>
	<hr>
	<p>本项目使用了EllisLab的CodeIgniter代码，点此<a href="https://github.com/bcit-ci/CodeIgniter/blob/develop/license.txt">阅读其协议</a></p>
<?php	
}
else if($kind == 'about')
{
?>
<div class="page-header">
	<h3>关于我们</h3>
	</div>
		<p>美剧日历项目是由北信科的几个闲着无聊想看美剧但是又经常忘了哪天更新的几个学生合作完成的一个通过爬取互联网上西方电视剧数据并提供给用户的一个信息平台。</p>
		<p>项目的开发收到了很多组织和个人的帮助，这些帮助来自包括但不限于<a href="http://iflab.org/">ifLab创联</a>,<a href="http://jsjxy.bistu.edu.cn/">北京信息科技大学计算机学院</a>.</p>
		<p>项目的服务器端的开发者为<a href="http://yifans.org">凡爷</a>,iOS版本的开发者为<a href="http://iMing.org">高铭</a></p>
<?php
}
else{}
?>
</div>