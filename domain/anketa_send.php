<?
if(isset($_POST['surname'])){$surname = $_POST['surname'];}else{$surname = '';}
if(isset($_POST['name'])){$name = $_POST['name'];}else{$name = '';}
if(isset($_POST['patronymic'])){$patronymic = $_POST['patronymic'];}else{$patronymic = '';}
if(isset($_POST['day'])){$day = $_POST['day'];}else{$day = '';}
if(isset($_POST['month'])){$month = $_POST['month'];}else{$month = '';}
if(isset($_POST['year'])){$year = $_POST['year'];}else{$year = '';}
if(isset($_POST['education'])){$education = $_POST['education'];}else{$education = '';}
if(isset($_POST['qualification'])){$qualification = $_POST['qualification'];}else{$qualification = '';}
if(isset($_POST['science'])){$science = $_POST['science'];}else{$science = '';}
if(isset($_POST['address'])){$address = $_POST['address'];}else{$address = '';}
if(isset($_POST['home_phone'])){$home_phone = $_POST['home_phone'];}else{$home_phone = '';}
if(isset($_POST['work_phone'])){$work_phone = $_POST['work_phone'];}else{$work_phone = '';}
if(isset($_POST['mail'])){$mail = $_POST['mail'];}else{$mail = '';}
if(isset($_POST['ocupation'])){$ocupation = $_POST['ocupation'];}else{$ocupation = '';}
if(isset($_POST['election'])){$election = $_POST['election'];}else{$election = '';}
if(isset($_POST['election2'])){$election2 = $_POST['election2'];}else{$election2 = '';}
if(isset($_POST['series'])){$series = $_POST['series'];}else{$series = '';}
if(isset($_POST['number'])){$number = $_POST['number'];}else{$number = '';}
if(isset($_POST['whom_given'])){$whom_given = $_POST['whom_given'];}else{$whom_given = '';}
if(isset($_POST['when_given'])){$when_given = $_POST['when_given'];}else{$when_given = '';}
if(isset($_POST['additional_information'])){$additional_information = $_POST['additional_information'];}else{$additional_information = '';}

$wrong = '';
if($surname==''){$wrong.='* ������� ���� �������.<br>';}
if(ereg("[0-9]+",$surname)){$wrong.='* ������� �� ������ ��������� ����.<br>';}
if($name==''){$wrong.='* ������� ���� ���.<br>';}
if(ereg("[0-9]+",$name)){$wrong.='* ��� �� ������ ��������� ����.<br>';}
if($patronymic==''){$wrong.='* ������� ���� ��������.<br>';}
if(ereg("[0-9]+",$patronymic)){$wrong.='* �������� �� ������ ��������� ����.<br>';}
if($day==''){$wrong.='* ������� ���� ������ ��������.<br>';}
if($month==''){$wrong.='* ������� ����� ������ ��������.<br>';}
if($year==''){$wrong.='* ������� ��� ������ ��������.<br>';}
if(strlen($year)!=4 && ereg("[0-9]+", $year)){$wrong.='* ��� ������ ���������.<br>';}
if($home_phone==''){$wrong.='* ������� �������� �������.<br>';}
if($work_phone==''){$wrong.='* ������� ������� �������.<br>';}
if($series==''){$wrong.='* ������� ����� ������ ��������.<br>';}
if(ereg("[0-9]+", $series)){$wrong.='* ����� �������� �� ������ ��������� ����.<br>';}
if(strlen($series)!=2){$wrong.='* ����� �������� ������ �������� �� ���� ��������.<br>';}
if($number==''){$wrong.='* ������� ����� ������ ��������.<br>';}
if(ereg("[a-zA-Z]+", $number)){$wrong.='* ����� �������� �� ������ ��������� ����.<br>';}
if(strlen($number)!=6){$wrong.='* ����� �������� ������ �������� �� ����� ����.<br>';}
if($whom_given==''){$wrong.='* ������� ���������� � ���, ��� ����� ��� �������.<br>';}
if(strlen($whom_given)<27){$wrong.='* ���������� � ���, ��� ����� ��� ������� ������� ��������.<br>';}
if($when_given==''){$wrong.='* ������� ���������� � ���, ����� ����� ��� �������.<br>';}
if(strlen($when_given)<8){$wrong.='* ���������� � ���, ����� ����� ��� ������� ������ ���� � ������� (DD/MM/YY).<br>';}

if($wrong != ''){
	print('<center><br><br>��������� ��� ������������ ���� � ��������� ������������ �� ����������.<br><br>
	<font color="red">'.$wrong.'</font><br><br>
    <input onClick="javascript:window.history.back();" type="button" value="��������� �����" /></center>
	');

}else{


$tomail = "xway@mksat.net";

$email = substr($HTTP_POST_VARS['email'],0,1024);

$header  = "From: website";

mail($tomail, "New User Mail", $email, $header) or die ("Mistake");

print('
<HTML>
<BODY>
<script>
window.location.replace("index.html");
</script>
</BODY>
</HTML>
');

}
?>