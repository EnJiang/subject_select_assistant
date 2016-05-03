<?php
if(!isset($_SESSION['number']))
    header("location:".web_location);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>辅助选课系统</title>
<script src="http://apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript">
	$(document).ready(function(){
        $.post('/response/subject.php',
      		  function(data,status){
          		  $("#ajax-fill-subject").html(data);
      		  }
      		  );
		}); 
</script>
</head>
<body>
<div style="margin-top:5%;margin-left:10%;width:80%;">

<table class="table table-bordered">
    <caption style="text-align:center;font-size:3ex;">已选的课程</caption>
    <thead>
        <tr>
            <th>序号</th>
            <th>课程号</th>
            <th>课程名</th>
            <th>教师号</th>
            <th>教师名</th>
            <th>上课时间</th>
            <th>上课地点</th>
            <th>校区</th>
        </tr>
    </thead>
    <tbody id="ajax-fill-subject"></tbody>
</table>

<div style=margin-top:5%;text-align:center;><label style="font-size:3ex;">提交选课任务</label></div>
<form method="post"  action="/select.php"  role="form" style=margin-left:10%;width:80%>
    <div class="form-group">
        <input type="text" class="form-control" name="subj_no1"  style=width:18%;display:inline-block;margin-left:7%;
           placeholder="科目一课程代码">
        <input type="text" class="form-control" name="teac_no1"  style=width:18%;display:inline-block;margin-left:2%;
           placeholder="科目一教师代码">
        <input type="text" class="form-control" name="subj_no2"  style=width:15%;display:inline-block;margin-left:9%
           placeholder="科目二课程代码">
        <input type="text" class="form-control" name="teac_no2"  style=width:15%;display:inline-block;margin-left:5%;
           placeholder="科目二教师代码">
     </div>
    <div class="form-group">
        <input type="text" class="form-control" name="subj_no3"  style=width:18%;display:inline-block;margin-left:7%
           placeholder="科目三课程代码">
        <input type="text" class="form-control" name="teac_no3"  style=width:18%;display:inline-block;margin-left:2%;
           placeholder="科目三教师代码">
        <input type="text" class="form-control" name="subj_no4"  style=width:15%;display:inline-block;margin-left:9%
           placeholder="科目四课程代码">
        <input type="text" class="form-control" name="teac_no4"  style=width:15%;display:inline-block;margin-left:5%;
           placeholder="科目四教师代码">
     </div>
     <div class="form-group">
        <input type="text" class="form-control" name="subj_no5"  style=width:18%;display:inline-block;margin-left:7%
           placeholder="科目五课程代码">
        <input type="text" class="form-control" name="teac_no5"  style=width:18%;display:inline-block;margin-left:2%;
           placeholder="科目五教师代码">
        <input type="text" class="form-control" name="subj_no6"  style=width:15%;display:inline-block;margin-left:9%
           placeholder="科目六课程代码">
        <input type="text" class="form-control" name="teac_no6"  style=width:15%;display:inline-block;margin-left:5%;
           placeholder="科目六教师代码">
     </div>
     <div style="text-align:center"><button type="submit" class="btn btn-default">提交</button></div>
</form>
</div>
</body>
</html>