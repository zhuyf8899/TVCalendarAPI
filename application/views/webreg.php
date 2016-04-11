<div class="container">

  <form class="form-signin" action="/TVCalendarAPI/index.php/UI/index" method="GET" onsubmit="return checkform();">
    <h2 class="form-signin-heading">注册：</h2>
    <label for="inputPhone" class="sr-only">手机号码</label>
    <input type="text" id="inputPhone" class="form-control" placeholder="手机号码" required autofocus>
    <label for="usrName" class="sr-only">用户昵称</label>
    <input type="text" id="usrName" class="form-control" placeholder="昵称（可选）">
    <label for="inputPassword" class="sr-only">用户密码</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="8-32位密码，不接受符号" required>
    <label for="passwdRepeat" class="sr-only">重复密码</label>
    <input type="password" id="passwdRepeat" class="form-control" placeholder="重复密码" required>
    <br/>
    <div>
          <label>
            <input type="checkbox" value="agree" id="checkAgree" checked="checked"> 我已知晓并同意 <a href="/TVCalendarAPI/index.php/UI/docs/license">用户协定</a>.
          </label>
        </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit" >注 册</button>
  </form>
</div> <!-- /container -->
<script type="text/javascript">
    function checkform(){
      var flag = false;
      var phoneNumber = document.getElementById("inputPhone").value;
      var usrName = document.getElementById("usrName").value;
      var pwd =  document.getElementById("inputPassword").value;
      var pwdc = document.getElementById("passwdRepeat").value;
      var regPwd = new RegExp("^\\w*$");
      var regPh = new RegExp("^\\d{11,}$");
      var regName = new RegExp("'");
      if (!$("#checkAgree").is(":checked")) 
      {
        toastr.warning("您未接受协议", "警告");
        $("#checkAgree").focus();
        return false;
      }
      if (!regPh.test(phoneNumber)) 
      {
        toastr.warning("手机号不符合规范", "警告");
        document.getElementById("inputPhone").focus();
        return false;
      }
      if (!regPwd.test(pwd)) 
      {
        toastr.warning("密码含有非法字符", "警告");
        document.getElementById("inputPassword").focus();
        return false;
      }
      if (pwd != pwdc) 
      {
        toastr.warning("两次密码输入不一致", "警告");
        document.getElementById("passwdRepeat").focus();
        return false;
      }
      if (regName.test(usrName)) 
      {
        toastr.warning("昵称存在敏感字符", "警告");
        $("#usrName").focus();
        return false;
      }
      if (usrName == "") 
      {
        toastr.info("未输入昵称，默认使用手机号代替", "信息");
        usrName = phoneNumber;
      }
      data = {'u_phone':phoneNumber,'u_name':usrName,'u_passwd':pwd};
      $.ajax({
        type: 'POST',
        url: '/TVCalendarAPI/index.php/UI/ajaxReg',
        data: data,
        async:false,
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
          alert(XMLHttpRequest.status);
          alert(XMLHttpRequest.readyState);
          alert(textStatus);
          toastr.error("网络错误", "错误");
        },
        success: function(result)
        {
          if (result == "OK") 
          {
            toastr.success("注册成功", "信息");
            //window.location.href("/TVCalendarAPI/index.php/UI/index");
            flag = true;
          }
          else if(result == 'WrongPh')
          {
            toastr.error("该手机号已被使用", "错误");
            flag = false;
          }
          else
          {
            toastr.info(result, "DEBUG ");
            toastr.error("参数错误", "错误");
            flag = false;
          }
        },
      });
      //toastr.warning(flag.toString(), "DEBUG");
      return flag;
    }
</script>