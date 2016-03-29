<style type="text/css">
  body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="text"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
<div class="container">

  <form class="form-signin" onsubmit="return checkform();">
    <h2 class="form-signin-heading">用户登入：</h2>
    <label for="inputEmail" class="sr-only">手机号码</label>
    <input type="text" id="inputPhone" class="form-control" placeholder="手机号码" required autofocus>
    <label for="inputPassword" id="pw" class="sr-only">用户密码</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="密码" required>
    <br/>
    <div>
          <label>
            没有账号？<a href="/TVCalendarAPI/index.php/Ui/webreg">点此注册</a>
          </label>
        </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Login in</button>
  </form>
</div> <!-- /container -->
<script type="text/javascript">
    function checkform(){
      phoneNumber = document.getElementById("inputPhone").value;
      pwd =  document.getElementById("pw").value;
      data = {'u_phone':phoneNumber,'u_passwd':pwd}
      $.ajax({
        url:  '/TVCalendarAPI/index.php/Ui/ajaxCheckPw',
        type: 'post',
        data:  data,
        async: false,
        timeout: 5000,
        //ajax error
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
          alert(XMLHttpRequest.status);
          alert(XMLHttpRequest.readyState);
          alert(textStatus);
        },
        //ajax success
        success: function(result)
        {
          toastr[info](result, "DEBUG")
          if( result == 'OK' )
          {
            toastr[success]("验证成功", "信息")
            return true;
          }
          else if(result == 'WrongPW')
          {
            toastr[error]("用户名或密码错误", "错误");
            return false;
          }
          else
          {
            toastr[error]("未知错误", "错误");
            return false;
          }
        }
    }); 
  }
</script>

