<?php
    include_once 'config.php';
    include_once document_root.'/response/vcode.php';
    include_once document_root.'/class/phpQuery/phpQuery.php';

        $count=0;
    
        $db=new mysqli(mysql_server,mysql_user,mysql_pwd,mysql_default_db);
        if ($db->connect_error) {
            die("连接服务器数据库失败!");
        }
        $db->query("SET NAMES utf8;");
        $all_student=$db->query("SELECT * FROM student WHERE name=''" );
        
        $ch = curl_init();
        
        while($a_student = $all_student->fetch_assoc()) {
            if($a_student['name']!='' )
                continue;

            $cookie_file=document_root."/tmp/cookie_".session_id();

            curl_setopt($ch, CURLOPT_URL, SS_VCODE_URL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_COOKIEJAR,  $cookie_file);
            $img=curl_exec($ch);
            $imgdir=document_root."/tmp/vcode_".session_id().".jpeg";
            $file=fopen($imgdir,"w");
            fwrite($file, $img);
            fclose($file);
            
            $captcha_json=CJY_RecognizeBytes('qq315067671',md5('123000000z' ),'891623','1104',$imgdir);
            $captcha_obj=json_decode($captcha_json);
            
            $data=array('txtUserName'=>$a_student['number'],
                                'txtPassword'=>$a_student['password'],
                                'txtValiCode'=>$captcha_obj->pic_str);
            curl_setopt($ch, CURLOPT_URL, SS_URL);
            $this_header =array('Referer'=>SS_URL);
            curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, document_root."/tmp/cookie_".session_id());
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
            curl_exec($ch);
      
            curl_setopt($ch, CURLOPT_URL,SS_TABLE_URL);
            $this_header =array(
                'Referer'=>SS_TABLE_REFERER_URL);
            curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
            curl_setopt($ch, CURLOPT_POSTFIELDS,array('studentNo'=>$a_student['number']));
            $content=curl_exec($ch);
            
            phpQuery::newDocument($content);
            
            if(count( pq('.tbllist') )-1) {
                $search=array('','姓名：','学院：','校区：');
                $column=array('','name','academy','location');
                for($i=1;$i<4;$i++){
                    $temp=pq("#showStudent")->find("div")->eq($i)->text();
                    $temp=str_replace($search[$i],'', $temp);
                    $temp=substr(trim($temp),6);
                    $info[$column[$i]]=$temp;
                }
                $sql="UPDATE student SET name=?,academy=?,location=? WHERE number=?";
                $stmt=$db->prepare($sql);
                $stmt->bind_param("ssss",$info['name'],$info['academy'],$info['location'],$a_student['number']);
                $stmt->execute();
                $stmt->close();
                $count++;
            }
        }
            $db->close();
            curl_close($ch);
            echo "共有".count($all_student)."条不完整数据，已完成".$count."条数据更新。";
?>