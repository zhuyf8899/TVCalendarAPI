<div class="container">

  <form class="form-signin" action="/TVCalendarAPI/index.php/UI/index" method="GET" onsubmit="return checkform_reg();">
    <h2 class="form-signin-heading">注册：</h2>
    <label for="inputPhone" class="sr-only">手机号码</label>
    <input type="text" id="inputPhone" class="form-control" placeholder="手机号码" required autofocus>
    <label for="usrName" class="sr-only">用户昵称</label>
    <input type="text" id="usrName" class="form-control" placeholder="昵称（可选）">
    <label for="inputPassword" class="sr-only">用户密码</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="8-32位密码，不接受符号" required>
    <label for="passwdRepeat" class="sr-only">重复密码</label>
    <input type="password" id="passwdRepeat" class="form-control" placeholder="重复密码" required>
    <label for="captcha" class="sr-only">验证码</label>
    <input type="text" id="captcha" class="form-control" placeholder="验证码,点击图片可换一张" required>
    <img id="captcha_img" src="/TVCalendarAPI/index.php/UI/get_code" alt="加载失败,点击重新加载" onclick="change_captcha();">
    <br/>
    <div>
          <label>
            <input type="checkbox" value="agree" id="checkAgree" checked="checked"> 我已知晓并同意 <a href="/TVCalendarAPI/index.php/UI/docs/license">用户协定</a>.
          </label>
        </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit" >注 册</button>
  </form>
</div> <!-- /container -->
