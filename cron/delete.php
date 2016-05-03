<?php
    include_once 'config.php' ;
    $path=document_root."/tmp/*";
    
    if($_POST['command_code']!="123000000z")
        header("location:".web_location);
    
    foreach(glob($path) as $file){
        if($file==document_root."/tmp/delete.php")
            continue;
        
        if(time()-filectime($file)>86400)
            unlink($file);
    }
?> 