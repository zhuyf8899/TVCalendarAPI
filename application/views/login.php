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
    <button class="btn btn-lg btn-primary btn-block" type="submit" >Login in</button>
  </form>
</div> <!-- /container -->
<script type="text/javascript">
    
    
    function checkform(){
      var flag = false;
      phoneNumber = document.getElementById("inputPhone").value;
      pwd =  document.getElementById("inputPassword").value;
      data = {'u_phone':phoneNumber,'u_passwd':pwd};
      $.ajax({
        type: 'POST',
        url: '/TVCalendarAPI/index.php/Ui/ajaxCheckPw',
        data: data,
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
            flag = true;
            return true;
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
          
          flag = false;
        },
      });
      alert(flag.toString());
      toastr.warning(flag.toString(), "DEBUG");
      return flag;
    }
    /*
  function checkform() {
    xmlhttp = new XMLHttpRequest();
    data = {'u_phone':phoneNumber,'u_passwd':pwd};
    xmlhttp.onreadystatechange=function()
    {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
      {
        result = xmlhttp.responseText;
        if (result == "OK") 
        {
          toastr.error("验证成功", "信息");
          return true;
        }
        else if(result == 'WrongPW')
        {
          toastr.error("用户名或密码错误", "错误");
          return false;
        }
        else
        {
          toastr.error("参数错误", "错误");
          return false;
        }
      }
      else
      {
        //toastr.warning("当前网络连接不正常", "警告");
        return false;
      }
    }
    xmlhttp.open("POST","/TVCalendarAPI/index.php/Ui/ajaxCheckPw",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send(data);
    return false;
  }*/    
      
      
  
</script>

