<?php
include_once 'config.php' ; 
include_once document_root.'/class/phpQuery/phpQuery.php';

class student
{
    private $number;
    private $name;
    private $academy;
    private $password;
    private $info;
    
    public function login($number,$password,$vcode)
    {        
        $data=array('txtUserName'=>$number,'txtPassword'=>$password,'txtValiCode'=>$vcode);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, SS_URL);
        $this_header =array('Referer'=>SS_URL);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); 
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, document_root."/tmp/cookie_".session_id());
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);

        $content=curl_exec($ch);
        
        phpQuery::newDocument($content);
        if(trim(pq("title")->text())=="登录"){
            curl_close($ch);
            return 0;
        }
        else {
            $this->number=$number;
            $this->password=$password;
            curl_close($ch);
            return 1;
        }
    }
    
    private function get_info($number)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,SS_TABLE_URL);
        $this_header =array(
            'Referer'=>SS_TABLE_REFERER_URL);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_COOKIEFILE,document_root."/tmp/cookie_".session_id());
        curl_setopt($ch, CURLOPT_POSTFIELDS,array('studentNo'=>$number));
        $content=curl_exec($ch);
        curl_close($ch);
        
        $info['number']=$this->number;
        $info['password']=$this->password;
        
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
            
            $sub_num=pq('.tbllist:first>tr' )->length-4;
            for($i=0;$i<$sub_num;$i++){
                $sub_row=pq('.tbllist:first>tr')->eq($i+3);
                for($j=0;$j<11;$j++){
                    $sub[$j]=$sub_row->children('td')->eq($j)->text();
                }
                $info['subject'][$i]=$sub;
            }
        }
        else{
            $info['subject']=null;
        }
        
        return $info;
    }

    public function refresh($number,$password)
    {
        $info=$this->get_info($number);
        
        $db=new mysqli(mysql_server,mysql_user,mysql_pwd,mysql_default_db);
        if ($db->connect_error) {
            die("连接服务器数据库失败!");
        }
        $db->query("SET NAMES utf8;");
        $exist=$db->query("SELECT COUNT(number) FROM student WHERE number=".$number)->fetch_assoc();
        $exist=$exist['COUNT(number)']; 
        
        if($exist){
            $db->close();
        }
        else {
            $sql="INSERT INTO student VALUES(?,?,?,?,?)";
            $stmt=$db->prepare($sql);
            $stmt->bind_param("sssss",$info['number'],$info['name'],$info['password'],$info['academy'],$info['location']);
            $stmt->execute();
            $db->close();
        }
    }
    
    public function get_student($number,$password)
    {
        $db=new mysqli(mysql_server,mysql_user,mysql_pwd,mysql_default_db);
        if ($db->connect_error) {
            die("连接服务器数据库失败!");
        }
        
        $sql="SELECT number,name,password,academy,location FROM student WHERE number=?";
        $stmt=$db->prepare($sql);
        $stmt->bind_param('s',$number);
        $stmt->execute();
        $stmt->bind_result($db_number,$db_name,$db_password,$db_academy,$db_location);
        $stmt->fetch();
        
        if(!isset($db_number)){
            $db->close();
            return 01;
        }
        
        if($db_password!=$password){
            $db->close();
            return 02;
        }
        
        $this->number=$db_number;
        $this->name=$db_name;
        $this->password=$db_password;
        $this->academy=$db_academy;
        $this->location=$db_location;
        $this->info=$this->get_info($number);
        $db->close();
        return 1;
    }
    
    public function output_info()
    {
        return $this->info;
    }


}