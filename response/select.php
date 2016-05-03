<?php
    include_once 'config.php' ;
    include_once document_root.'/class/phpQuery/phpQuery.php';
    
    $subject_position=explode(',', $_POST['subject_position']);
    $subj_no_list=explode(',', $_POST['subj_no_list']);
    $teac_no_list=explode(',', $_POST['teac_no_list']);
    
    $subject_loading_html='';
    
    $data=array(
        'CourseNo'=>'',
        'TeachNo'	=>'',
        'Campus'=>'0',
        'DataCount'=>'0',
        'PageIndex'=>'1',
        'PageSize'	=>'20',
        'FunctionString'=>'InitPage'
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,SUBJECT_INFO_URL);
    $this_header =array(
        'Referer'=>SUBJECT_INFO_REFERER_URL);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch, CURLOPT_COOKIEFILE,document_root."/tmp/cookie_".session_id());
    
    $sub_info_position=array(0,1,3,4,5,6);
    foreach ($subject_position as $key=>$value){
            $subject_loading_html.='<tr><td>'.chr(65+$key).'</td>';
            $data['CourseNo']=$subj_no_list[$value];
            $data['TeachNo']=$teac_no_list[$value];
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
            $content=curl_exec($ch);
            phpQuery::newDocument($content);
            
            $sub_row=pq('tr#0' ); 
            for($j=0;$j<5;$j++){
            $subject_loading_html.='<td>';
            $subject_loading_html.=$sub_row->children('td')->eq($sub_info_position[$j])->text();
            $subject_loading_html.='</td>';
        }
        $subject_loading_html.='<td id="status'.$key.'">等待通信...</td></tr>';
    }
    curl_close($ch);
    
    echo $subject_loading_html;
?>