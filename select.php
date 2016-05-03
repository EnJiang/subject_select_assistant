<?php 
if(!isset($_SESSION['number']))
    header("location:".web_location);

$subject_position=array();
for($i=0;$i<6;$i++){
    $subj_no='subj_no'.($i+1);
    $subj_no_list[$i]=$_POST[$subj_no];
    $teac_no='teac_no'.($i+1);
    $teac_no_list[$i]=$_POST[$teac_no];
    if($subj_no_list[$i]&&$teac_no_list[$i]){
        array_push($subject_position,$i);
    }
}
$subj_no_list=implode(',', $subj_no_list);
$teac_no_list=implode(',', $teac_no_list);
$subject_position=implode(',', $subject_position);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>辅助选课系统</title>
<script src="http://apps.bdimg.com/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">

<script>
var loop;
var subject;

function select_loop(subject){
        $.post('/response/select_loop.php',
      		  {
      		    subject:subject
      		  },
      		  function(data,status){
              		var status=eval('(' + data + ')'); 
              		for(key in status){
                  		if(status[key]=="已成功"&&$("#"+key).text()!="已成功")
                      		$("#success").text(
                      				parseInt( $("#success").text() )  +1
                              		);
                  		
                      		$("#time").text(
                      				parseInt( $("#time").text() )  +1
                              		);
                  			$("#"+key).text(status[key]);
                		  }
            		  
            		  if(status[key]=="禁止登陆"){
                		  clearInterval(loop);
                		  for(key in status){
               			      if(status[key]=="已成功")
                   			    continue;
               			      else
                 			    $("#"+key).text("禁止登陆");
                		  }
                		  return;
            		  }
               		   if(status[key]=="全部完成"){
                    		clearInterval(loop);
                    		for(key in status){
                     			  $("#"+key).text("全部完成");
                    		}
                   		 return;
            		  }
      		  });
}

$(document).ready(function(){
    $.post('/response/subject.php',function(data,status){
        $("#ajax-fill-subject").html(data);
  		  });
    $.post('/response/select.php',
    	{
    	subj_no_list:<?php echo '"'.$subj_no_list.'"';?>,
    	teac_no_list:<?php echo '"'.$teac_no_list.'"';?>,
 	    subject_position:<?php echo '"'.$subject_position.'"';?>
		},
    	    function(data,status){
			$("#ajax-fill-select").html(data);
  		  });
    $.post('/response/subject.php',function(data,status){
        subject=data;
  		  });
	loop=self.setInterval('select_loop(subject);',5000);
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

<table class="table table-bordered" style="margin-top:5%">
    <caption style="text-align:center;font-size:3ex;">待选的课程</caption>
    <thead>
        <tr>
            <th>序号</th>
            <th>课程号</th>
            <th>课程名</th>
            <th>教师号</th>
            <th>教师名</th>
            <th>上课时间</th>
            <th>当前情况</th>
        </tr>
    </thead>
    <tbody id="ajax-fill-select">
            <tr>
            <th>A</th>
            <th>00000000</th>
            <th>加载中...</th>
            <th>0000</th>
            <th>加载中...</th>
            <th>加载中...</th>
            <th>加载中...</th>
        </tr>
    </tbody>
</table>

<div style="text-align:center;">
<span style="margin-right:5% ">已成功 <span class="badge" id="success">0</span></span>
<span style="margin-right:5% ">尝试次数 <span class="badge" id="time">0</span></span>
</div>

</div>
</body>
</html>