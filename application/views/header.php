<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="zhuyifan">
    <link rel="icon" href="/TVCalendarAPI/build/image/favicon.ico">
    <title><?php if(isset($title))
                    echo $title;
                 else 
                    echo"TVCalender中文站"?>
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
            <a class="navbar-brand" href="/TVCalendarAPI/index.php/UI/">TvCalendar中文站</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="/TVCalendarAPI/index.php/UI/viewMonth/">本月</a></li>
              <li><a href="#">查找剧集</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">剧集浏览 <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header">按地区</li>
                  <li><a href="#">美国</a></li>
                  <li><a href="#">英国</a></li>
                  <li><a href="#">其他地区</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">按状态</li>
                  <li><a href="#">新番</a></li>
                  <li><a href="#">回归</a></li>
                  <li><a href="#">完结</a></li>
                </ul>
              </li>
            </ul>
            <?php
            if ($this->session->u_id) {
            ?>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $this->session->u_name; ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="/TVCalendarAPI/index.php/UI/myCenter/<?php echo $this->session->u_id;?>">个人中心</a></li>
                  <li><a href="/TVCalendarAPI/index.php/UI/myShows/<?php echo $this->session->u_id;?>">我的剧集</a></li>
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
              <form class="navbar-form navbar-right" action="/TVCalendarAPI/index.php/UI" method="GET" onsubmit="return checkform();">
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
      <script type="text/javascript">
        function checkform(){
          var flag = false;
          phoneNumber = $("#phoneNumber").val();
          pwd = $("#pwd").val();
          var regPwd = new RegExp("^\\w*$");
          var regPh = new RegExp("^\\d*$");

          if (!regPh.test(phoneNumber)) 
          {
            toastr.warning("手机号不符合规范", "警告");
            //toastr.info(phoneNumber, "DEBUG");
            $("#phoneNumber").focus();
            return false;
          }
          if (!regPwd.test(pwd)) 
          {
            toastr.warning("密码含有非法字符", "警告");
            $("#pwd").focus();
            return false;
          }

          data = {'u_phone':phoneNumber,'u_passwd':pwd};
          $.ajax({
            type: 'POST',
            url: '/TVCalendarAPI/index.php/UI/ajaxCheckPw',
            data: data,
            async:false,
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
              alert(XMLHttpRequest.status);
              alert(XMLHttpRequest.readyState);
              alert(textStatus);
            },
            success: function(result)
            {
              if (result == "OK") 
              {
                toastr.success("验证成功", "信息");
                //window.location.href("/TVCalendarAPI/index.php/UI/index");
                flag = true;
              }
              else if(result == 'WrongPW')
              {
                toastr.error("用户名或密码错误", "错误");
                flag = false;
              }
              else
              {
                toastr.error("参数错误", "错误");
                flag = false;
              }
            },
          });
          //toastr.warning(flag.toString(), "DEBUG");
          return flag;
        }
      </script>

    