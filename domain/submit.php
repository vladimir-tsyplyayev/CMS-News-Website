<?

$recipient = "saitPR@yandex.ru";
if(isset($_POST['subject'])){
	$subject = substr($_POST['subject'],0,1024);
}else{$subject = 'Анонимный посетитель';}
if(isset($_POST['mail'])){
	$mail = substr($_POST['mail'],0,1024);
}else{$mail = 'Без обратного адреса';}
if(isset($_POST['message'])){
	if(strcmp($_POST['message'],'Текст сообщения')==0){
		print('<center><br><br><br>Ошибка! Сообщение не отправлено.</center>');
	}else{
	$message = substr($_POST['message'],0,1024);
//	$message=convert_cyr_string($message, 'w', 'k');
	$nmessage = "Сообщение отправлено с сатйта Партии регионов NikPartRegion.mk.ua от: ".$subject." \r\nE-mail: ".$mail."\r\nТекст сообщения:\r\n---------\r\n".$message;

$headers = 'From: '.$subject.' <'.$mail.'>' . "\r\n" .
    'Reply-To: '.$subject.' <'.$mail.'>' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


if(mail($recipient, 'NikPartRegion.mk.ua - Сообщение от: '.$subject , $nmessage, $headers)){
print('<center><br><br><br>Ваше сообщение успешно отправлено.</center>');
}else{
print('<center><br><br><br>Ошибка! Сообщение не отправлено.</center>');
}
}
}

?>