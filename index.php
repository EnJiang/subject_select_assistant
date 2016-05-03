<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>辅助选课系统</title>
<script src="http://apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div style="margin-top:15%;margin-left:30%;width:40%;">
<form class="form-horizontal" role="form" method="post" action="/response/login.php">
   <div class="form-group">
      <label for="number" class="col-sm-2 control-label">学号</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" name="number" 
            placeholder="请输入学号">
      </div>
   </div>
   <div class="form-group">
      <label for="password" class="col-sm-2 control-label">密码</label>
      <div class="col-sm-10">
         <input type="password" class="form-control" name="password" 
            placeholder="请输入密码">
      </div>
   </div>
   <div class="form-group" style="text-align:center">
      <div class="col-sm-offset-2 col-sm-10">
         <button type="submit" class="btn btn-default" >登录</button>
      </div>
   </div>
</form>
</div>
</body>
</html>
