<!--每个用户个人信息修改-->
</div><!-- /container -->
<script type="text/javascript">
	var str = location.href;
	var strArray = str.spilt('?');
	if (strArray[1] != null) 
	{
		var result = strArray[1].split('=');
		if (result[0] == 'success' && result[1] == 'true') 
		{
			toastr.success("修改个人信息成功","操作成功");
		}
	}
</script>
<div class="container">
 	<div class="page-header">
		<h3>我的个人信息</h3>
	</div>
	<div>
		<form onsubmit="return check_form_usercenter();" class="form-horizontal" action="/TVCalendarAPI/index.php/UI/myCenter/?success=true">
		  <input type="input" class="form-control" id="exName" placeholder="原昵称" style="display:none;" disabled value="<?php if(isset($userInfo['u_name'])){echo $userInfo['u_name'];} ?>">
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