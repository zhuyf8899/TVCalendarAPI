<div class="container">

  <form class="form-signin" action="/TVCalendarAPI/index.php/UI/index" method="GET" onsubmit="return checkform();">
    <h2 class="form-signin-heading">用户登入：</h2>
    <label for="inputEmail" class="sr-only">手机号码</label>
    <input type="text" id="inputPhone" class="form-control" placeholder="手机号码" required autofocus>
    <label for="inputPassword" id="pw" class="sr-only">用户密码</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="密码" required>
    <br/>
    <div>
          <label>
            没有账号？<a href="/TVCalendarAPI/index.php/UI/webreg">点此注册</a>
          </label>
        </div>
    <button class="btn btn-lg btn-primary btn-block" id="loginButton" type="submit" >Login in</button>
  </form>
</div> <!-- /container -->