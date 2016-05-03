<?php
include_once 'config.php' ;
include_once document_root.'/class/phpQuery/phpQuery.php';

class user
{
    private $number;
    private $name;
    private $academy;
    private $password;
    private $subject;
    private $cookie;
    
    private function login($number,$password,$vcode)
    {
        set_time_limit(60);
        $this->cookie=document_root."/tmp/cookie_".session_id();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, OOAA);
        $this_header =array(
            'Referer'=>OOAA,
            'Content-Length'=>OOAA_CONTENT_LENGTH
        );
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); 
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
        array( 'txtUserNo'=>$number, 'txtPassword'=>$password,'txtValidateCode'=>$vcode )
        );
        
        $content=curl_exec($ch);
        if(strlen($content)<=5000)
        {
            curl_close($ch);
            return 0;
        }
        else 
        {
            $this->number=$number;
            $this->password=$password;
            curl_close($ch);
            return 1;
        }
    }
    
    private function get_info()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, OOAA_SUB_LIST);
        $this_header =array('Referer'=>OOAA_SUB_LIST);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
        curl_setopt($ch, CURLOPT_POSTFIELDS,array('academicTermID'=>20153));
        phpQuery::newDocument(curl_exec($ch));
        curl_close($ch);
        
        echo pq("th:first")->text();
        
        $temp=explode("：",pq("th:first")->text());

        $this->name=substr($temp[2],0,-7);
        $this->academy=$temp[3];

        
        echo $this->subject_info;

    }

    private function check_cache($number,$password)
    {
        
    }
    
    private function get_cache($number)
    {
        
    }
    
    public function start($number,$password,$vcode)
    {
        
    }
    
    public function output_info()
    {
        
    }
    

}