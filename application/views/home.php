 <!-- Main component for a primary marketing message or call to action -->

      <div class="jumbotron">
        <h2>最新最全的欧美剧集播放信息</h2>
        <p>每日更新各类欧美剧集播放信息，注册用户均可关注剧集和同步观看记录。目前收录剧集<?php if (isset($showsNumber)) {
          echo $showsNumber['num'];}else{echo "2300余";}?>部。注册会员享受更多功能。</p>
        <p>本平台基于开源协议发布，同时提供基于iOS系统和Android系统的移动客户端，<a href="">点击下载</a></p>
        <p>
          <a class="btn btn-lg btn-primary" href="/TVCalendarAPI/index.php/UI/webreg" role="button">点击这里注册 &raquo;</a>
        </p>
      </div>

    </div> <!-- /container -->
    <div class="container">
      <h4>本日剧集</h4>
      <hr>
      <!-- Example row of columns -->
      <?php
      if (isset($today)) 
      {
        $rows = intval(ceil((count($today))/3));
        for ($i=0; $i < $rows; $i++) 
        { 
          ?>
          <div class="row">
          <?php
          for ($j=0; $j < 3; $j++) 
          {
            if ($i*3+$j>=count($today)) {
               break;
             } 
            ?>
            <div class="col-md-4">
              <h3><?php echo $today[$i*3+$j]['s_name']; ?></h3>
              <em><?php echo $today[$i*3+$j]['e_name']."\n"; ?></em><br/>
              <img src="<?php echo $CUrl.$mySubscribe[$i*3+$j]['s_sibox_image']; ?>" alt="<?php echo $today[$i*3+$j]['s_name']; ?>">
              <p>第<?php echo $today[$i*3+$j]['se_id']; ?>季，第<?php echo $today[$i*3+$j]['e_num']; ?>集</p>
              <p>地区：<?php echo $today[$i*3+$j]['area']; ?> 电视台：<?php echo $today[$i*3+$j]['channel']; ?></p>
              <p>今日<?php echo $today[$i*3+$j]['e_time']; ?>（格林尼治时间）</p>
              <p><a class="btn btn-default" href="/TVCalendarAPI/index.php/UI/showSummary/<?php echo $today[$i*3+$j]['s_id']; ?>" role="button">点击前往 &raquo;</a></p>
            </div>
            <?php
          }
          ?>
          </div>
      <?php
        }
      }
      ?>
      <!--
        <div class="col-md-4">
          <h3>破产姐妹</h3>
          <em>And The Partnership Hits The Fan</em>
          <img src="http://www.pogdesign.co.uk/cat/imgs/sibox/2-Broke-Girls.jpg" alt="破产姐妹">
          <p>第5季，第21集</p>
          <p>地区：USA 电视台：HBO</p>
          <p>今日02:30（格林尼治时间）</p>
          <p><a class="btn btn-default" href="http://www.pogdesign.co.uk/cat/2-Broke-Girls-summary" role="button">点击前往 &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        -->
    </div> <!-- /container -->