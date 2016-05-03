<?php
header("content-type:text/html;charset=utf-8");

include_once 'config.php';
include_once document_root.'/class/student.php';

if(!isset($_SESSION['number']))
    header("location:".web_location);

$number=$_SESSION['number'];
$password=$_SESSION['password'];

$student=new student();
$student->get_student($number, $password);
$student_info=$student->output_info();
$subject=$student_info['subject'];
$subject_html='';
$sub_info_position=array(0,1,2,3,4,6,7,8);

for($i=0;$i<count($subject);$i++){
    $subject_html.='<tr>';
    for($j=0;$j<8;$j++){
        $subject_html.='<td>'.$subject[$i][$sub_info_position[$j]].'</td>';
    }
    $subject_html.='</tr>';
}

echo $subject_html;
?>
