<?php

ini_set('display_errors', 'Off');

$ip  = $_SERVER["REMOTE_ADDR"];
$ref = $_SERVER['HTTP_REFERER'];
$today = getdate();
$country=strtoupper(file_get_contents("http://geoip.wtanaka.com/cc/".$ip));

if(!file_exists('../data_stat')){mkdir('../data_stat');}
if(!file_exists('../data_stat/'.$today[year])){mkdir('../data_stat/'.$today[year]);}
if(!file_exists('../data_stat/'.$today[year].'/'.$today[mon])){mkdir('../data_stat/'.$today[year].'/'.$today[mon]);}

$min = $today[minutes];
if($min<10){$min='0'.$min;}

if(isset($a)){
	$from='admin_a='.$a;
    if(isset($user)){$from.='_login='.$user;}
    if(isset($pass)){$from.='_pass='.$pass;}
}else{
	$from = $nav;
	if(strlen($id)>0){$from.='&id='.$id;}
	if($page>1){$from.='&page='.$page;}
	if($wtd>0){$from.='&wtd='.$wtd;}
	if(isset($message)){$from.='&message='.$message;}
}

     $file = fopen('../data_stat/'.$today[year].'/'.$today[mon].'/'.$today[mday].'.txt', 'a');
     fwrite($file, $ip." - ".$country." - ".$today[hours].":".$min." - ".$from." - ".$ref."\r\n");
     fclose($file);

?>