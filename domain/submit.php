<?

$recipient = "saitPR@yandex.ru";
if(isset($_POST['subject'])){
	$subject = substr($_POST['subject'],0,1024);
}else{$subject = '��������� ����������';}
if(isset($_POST['mail'])){
	$mail = substr($_POST['mail'],0,1024);
}else{$mail = '��� ��������� ������';}
if(isset($_POST['message'])){
	if(strcmp($_POST['message'],'����� ���������')==0){
		print('<center><br><br><br>������! ��������� �� ����������.</center>');
	}else{
	$message = substr($_POST['message'],0,1024);
//	$message=convert_cyr_string($message, 'w', 'k');
	$nmessage = "��������� ���������� � ������ ������ �������� NikPartRegion.mk.ua ��: ".$subject." \r\nE-mail: ".$mail."\r\n����� ���������:\r\n---------\r\n".$message;

$headers = 'From: '.$subject.' <'.$mail.'>' . "\r\n" .
    'Reply-To: '.$subject.' <'.$mail.'>' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();


if(mail($recipient, 'NikPartRegion.mk.ua - ��������� ��: '.$subject , $nmessage, $headers)){
print('<center><br><br><br>���� ��������� ������� ����������.</center>');
}else{
print('<center><br><br><br>������! ��������� �� ����������.</center>');
}
}
}

?>