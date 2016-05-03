<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//推荐开发者加入cookies支持

//查询题分
//返回样例:{"err_no":0,"err_str":"OK","tifen":821690,"tifen_lock":0}
  function CJY_GetScore($user,$pass){
	$url = 'http://code.chaojiying.net/Upload/GetScore.php' ; 
	$fields = array( 
	  'user'=>$user ,
	  'pass2'=>$pass ,
	); 
	
	$ch = curl_init() ;  
	curl_setopt($ch, CURLOPT_URL,$url) ;  
	curl_setopt($ch, CURLOPT_POST,count($fields)) ;   
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
	curl_setopt($ch, CURLOPT_REFERER,'') ; 
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3') ;
	$result = curl_exec($ch); 
	curl_close($ch) ;
		
    return $result ;
  }
	
//识别验证码
//返回样例:{"err_no":0,"err_str":"OK","pic_id":1662228516102,"pic_str":"8vka","md5":"35d5c7f6f53223fbdc5b72783db0c2c0","str_debug":""}
  function CJY_RecognizeBytes($user,$pass,$softid,$codetype,$userfile){
	$url = 'http://upload.chaojiying.net/Upload/Processing.php' ; 
	$fields = array( 
	  'user'=>$user ,
	  'pass2'=>$pass ,
	  'softid'=>$softid ,
	  'codetype'=>$codetype ,
	  'userfile'=>"@$userfile" ,  //注意,当PHP版本高于5.5后，此行可能无效要改为下一行 参考 http://www.tantengvip.com/2015/08/php5-6-curl/
	  //'userfile'=> new CURLFile(realpath($userfile)),
	); 
	
	$ch = curl_init() ;  
	curl_setopt($ch, CURLOPT_URL,$url) ;  
	curl_setopt($ch, CURLOPT_POST,count($fields)) ;   
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
	curl_setopt($ch, CURLOPT_REFERER,'') ; 
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3') ;
	$result = curl_exec($ch); 
	curl_close($ch) ;
		
    return $result ;
  }
	
//报告错误,只在验证码识别错误的时候使用该函数
//返回样例:{"err_no":0,"err_str":"OK"}
  function CJY_ReportError($user,$pass,$PicId,$SoftId){
	$url = 'http://code.chaojiying.net/Upload/ReportError.php' ; 
	$fields = array( 
	  'user'=>$user ,
	  'pass2'=>$pass ,
	  'id'=>$PicId ,
	  'softid'=>$SoftId ,
	); 
	
	$ch = curl_init() ;  
	curl_setopt($ch, CURLOPT_URL,$url) ;  
	curl_setopt($ch, CURLOPT_POST,count($fields)) ;   
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
	curl_setopt($ch, CURLOPT_REFERER,'') ; 
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3') ;
	$result = curl_exec($ch); 
	curl_close($ch) ;
		
    return $result ;
  }
  /*
//超级鹰账号信息
	$user		= '';			//超级鹰用户账号
	$pass		= md5('');	//经过md5加密的密码
	$softid		= '96001';			//软件ID,作者必填自己的软件id,以保证分成收入 进入开发者中心后添加软件可查看软件ID和软件KEY
	$codetype	= '1104' ;			//图片类型,官方网站的API接口中可查找更多的类型 1004,代表4位中数英混合的图片
	$userfile	= 'img.jpg' ;
	
	
//查询帐号信息
	echo '----帐号信息----<br />';
	$info = CJY_GetScore($user,$pass);
	$infoArray = json_decode($info,true);
	var_dump($infoArray);

//识别验证码
	echo '<br />----识别验证码----<br />';
	$result = CJY_RecognizeBytes($user,$pass,$softid,$codetype,$userfile);
	$reArray = json_decode($result,true);
	if($reArray["err_no"] == 0)
	{
		echo "识别结果:".$reArray["pic_str"].",验证码ID:".$reArray["pic_id"]."<br />";
	}
	else
	{
		echo '识别失败,错误代码:'.$reArray["err_no"].',错误信息:'.$reArray["err_str"].'<br />';
	}
	echo '<br />识别完成...<br />';
	

	//报告错误,只有识别成功并且验证码错误时,调用此函数才有效
	if($reArray["err_no"] != 0)
	{
		CJY_ReportError($user,$pass,$reArray["pic_id"],$softid);
		echo "已报告错误";
	}
	*/
?>