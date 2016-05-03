<?php
$subject=json_decode($_POST['subject']);

/*
 * 选课请求模块 安全起见本模块不上传
 */

$result=array("status0"=>"已成功");
echo json_encode($result);
?>