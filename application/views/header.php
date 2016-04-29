<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="KEYWords" lang="zh-CN" contect="美剧日历,TvCalendar,美剧资源,英剧,资源,日历">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="一个美剧更新日历，提供剧集跟踪提醒服务和下载">
    <meta name="Robots" contect= "all">
    <meta name="author" content="zhuyifan">
    <link rel="icon" href="/TVCalendarAPI/build/image/favicon.ico">
    <title><?php if(isset($title))
                    echo $title;
                 else 
                    echo "美剧日历";?>
    </title>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/TVCalendarAPI/build/css/toastr.css" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="/TVCalendarAPI/build/js/toastr.min.js"></script>
    <script src="/TVCalendarAPI/build/js/function.js"></script>
    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 20px;
        font-family: "Droid Sans",微软雅黑,"Lucida Grande","Lucida Sans",icomoon,Helvetica,Arial,Sans;
      }

      .navbar {
        margin-bottom: 20px;
      }
    </style>
    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/TVCalendarAPI/index.php/UI/">美剧日历</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="/TVCalendarAPI/index.php/UI/viewMonth/">本月</a></li>
              <li><a href="/TVCalendarAPI/index.php/UI/search">查找剧集</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">当前热播<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header">本站排行</li>
                  <li><a href="/TVCalendarAPI/index.php/UI/recommend?area=USA">美剧热播</a></li>
                  <li><a href="/TVCalendarAPI/index.php/UI/recommend?area=United+Kingdom">英国热播</a></li>
                  <li role="separator" class="divider"></li>
                  <!--<li class="dropdown-header">猜我喜欢</li>-->
                  <li><a href="/TVCalendarAPI/index.php/UI/recommend/2">下载排行榜</a></li>
                  <li><a href="/TVCalendarAPI/index.php/UI/recommend/1">猜我喜欢</a></li>
                  <!--<li><a href="/TVCalendarAPI/index.php/UI/commend?status=Returning+Series">回归</a></li>
                  <li><a href="/TVCalendarAPI/index.php/UI/commend?status=Canceled%2FEnded">完结</a></li>-->
                </ul>
              </li>
            </ul>
            <?php
            if ($this->session->u_id) {
            ?>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown"><a href="#" id="username_h" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->u_name; ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="/TVCalendarAPI/index.php/UI/myCenter/">个人中心</a></li>
                  <li><a href="/TVCalendarAPI/index.php/UI/myShows/">我的剧集</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="/TVCalendarAPI/index.php/UI/webLogout">登出</a></li>
                </ul>
              </li>
            </ul>
            <?php
            }
            else
            {
            ?>
            <div id="navbar" class="navbar-collapse collapse"><!--nav navbar-nav navbar-right-->
              <form class="navbar-form navbar-right" action="/TVCalendarAPI/index.php/UI" method="GET" onsubmit="return checkform_nav();">
                <div class="form-group">
                  <input type="text" placeholder="手机号码" id="phoneNumber" class="form-control" required >
                </div>
                <div class="form-group">
                  <input type="password" placeholder="密码" id="pwd" class="form-control" required >
                </div>
                <button type="submit" class="btn btn-success">登陆</button>
              </form>
            </div><!--/.navbar-collapse -->
            <?php
            }
            ?>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

    