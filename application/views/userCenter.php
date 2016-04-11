<!--每个用户个人信息修改-->
</div><!-- /container -->
<div class="container">
 	<div class="page-header">
		<h3>我的个人信息</h3>
	</div>
	<div>
		<form onsubmit="return check_form();" class="form-horizontal">
		  <div class="form-group">
		    <label for="inputPhone" class="col-sm-2 control-label">注册手机号</label>
		    <div class="col-sm-4">
		      <input type="input" class="form-control" id="inputPhone" placeholder="请输入新手机号" disabled value="<?php if(isset($userInfo['u_phone'])){echo $userInfo['u_phone'];} ?>">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputName" class="col-sm-2 control-label">昵称</label>
		    <div class="col-sm-4">
		      <input type="input" class="form-control" id="inputName" placeholder="昵称" value="<?php if(isset($userInfo['u_name'])){echo $userInfo['u_name'];} ?>">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPassword" class="col-sm-2 control-label">密码</label>
		    <div class="col-sm-4">
		      <input type="password" class="form-control" id="inputPassword" placeholder="密码">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPasswordNew" class="col-sm-2 control-label">新密码</label>
		    <div class="col-sm-4">
		      <input type="password" class="form-control" id="inputPasswordNew" placeholder="如不更改密码此项不填">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPasswordNewRe" class="col-sm-2 control-label">重复新密码</label>
		    <div class="col-sm-4">
		      <input type="password" class="form-control" id="inputPasswordNewRe" placeholder="如不更改密码此项不填">
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-default">更新我的资料</button>
		    </div>
		  </div>
		</form>	
	</div>
</div>
<script type="text/javascript">
	function check_form() 
	{
		var exName = "<?php if(isset($userInfo['u_name'])){echo $userInfo['u_name'];} ?>";
		var name = $("#inputName").val();
		var pwd = $("#inputPassword").val();
		var pwdNew = $("#inputPasswordNew").val();
		var pwdNewRe = $("#inputPasswordNewRe").val();

		if ((exName == name) && (pwdNew) == "")
		{
			toastr.warning("您并未对个人信息作出修改","警告");
			return false;
		}
		var data = {'name':'','pwd':'','pwdNew':''};
		if (pwdNew != "") 
		{
			if (pwdNew != pwdNewRe) 
			{
				toastr.warning("新密码输入不一致","警告");
				return false;
			}
			if (pwd == pwdNew) 
			{
				toastr.warning("您未更改密码","警告");
				return false;
			}
			var regPwd = new RegExp("^\\w*$");
			if (!regPwd.test(pwd) || !regPwd.test(pwdNew)) 
			{
				toastr.error("密码存在不合法字符", "错误");
				return false;
			}
			var data = {'name':name,'pwd':pwd,'pwdNew':pwdNew}
		}
		else
		{
			var regName = new RegExp("'");
			if (regName.test(name)) 
	        {
	          toastr.warning("新昵称存在敏感字符", "警告");
	          $("#inputName").focus();
	          return false;
	        }
			var data = {'name':name,'pwd':pwd,'pwdNew':pwd}
		}
			
		$.ajax({
	        type: 'POST',
	        url: '/TVCalendarAPI/index.php/UI/ajaxUpdateUser',
	        data: data,
	        async:false,
	        error: function(XMLHttpRequest, textStatus, errorThrown)
	        {
	          toastr.info("Status:"+XMLHttpRequest.status+"\nreadyState:"+XMLHttpRequest.readyState+"\ntext:"+textStatus, "DEBUG");
	          toastr.error("Ajax错误", "错误");
	        },
	        success: function(result)
	        {
	          if (result == "OK") 
	          {
	            toastr.success("更新个人资料成功", "信息");
	            //window.location.href("/TVCalendarAPI/index.php/UI/index");
	            return false;
	          }
	          else if(result == 'WrongPw')
	          {
	            toastr.warning("原密码不正确", "警告");
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
		

		return false;
	}
</script>