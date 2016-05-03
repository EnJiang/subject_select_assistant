<?php
        header("content-type:text/html;charset=utf-8");        

        include_once 'config.php' ;
        include_once document_root.'/response/vcode.php';
        include_once document_root.'/class/student.php';
        include_once document_root.'/response/vcode.php';
        
        $cookie_file=document_root."/tmp/cookie_".session_id();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, SS_VCODE_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file);
        $img=curl_exec($ch);
        
        $imgdir=document_root."/tmp/vcode_".session_id().".jpeg";
        $file=fopen($imgdir,"w");
        fwrite($file, $img);
        fclose($file);
        curl_close($ch);


        $captcha_json=CJY_RecognizeBytes('qq315067671',md5('123000000z' ),'891623','1104',$imgdir);
        $captcha_obj=json_decode($captcha_json);
        
        $number=$_POST['number'];
        $password=$_POST['password'];
        $vcode=$captcha_obj->pic_str;
        
        $student=new student();
        $islogin=$student->login($number, $password,$vcode);

        if($islogin)
        {
            $student->refresh($number, $password);
            $_SESSION['number']=$number;
            $_SESSION['password']=$password;
            echo
            "
             <!DOCTYPE html>
             <script>
                alert('登录成功!');
                location.href='".web_location."/subject.php';
             </script>";
        }
        else {
            echo 
            "
             <!DOCTYPE html>
             <script>
                alert('登录失败!');
                location.href='".web_location."';   
             </script>";
        }
?>

