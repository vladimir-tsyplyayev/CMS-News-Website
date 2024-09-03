<?

if(isset($_GET['lo'])){setcookie("user_id",'0');$user_founded=0;}

require_once('../captcha/recaptchalib.php');

function decode($str){
$d=0;
$i=0;
$t = array();
$f = $str;

while($d==0){
    $decl = (int)abs(sin($i/3)*318*cos($i/7)*224)*23+318327;
    $s = explode($decl, $f);
    $t[$i] = chr(trim($s[0]));
    $f = $s[1];
   	if(strlen($f)==0){$d=1;}
	$i++;
	unset($s);
}
$s='';
foreach($t as $v){
	$s .= $v;
}
return $s;
}

function encode($str){
$s1 = str_split($str);
$s = '';
$i=0;
foreach($s1 as $v){
	$s .= ord($v);
	$decl = (int)abs(sin($i/3)*318*cos($i/7)*224)*23+318327;
	$s .= $decl;
	$i++;
}
return $s;
}

$publickey = "6LeXiwgAAAAAAMSacs18kLhfKv143gT64OW10p9f ";
$privatekey = "6LeXiwgAAAAAAKgszevTNaJnaWlA6DbDnE4ILOoP";

function generateDCode($length) {
	$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
      $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

$user_founded=0;//1;
if(isset($_POST["user"]) && isset($_POST["pass"])){
	$user = $_POST["user"];
	$pass = $_POST["pass"];

	$resp = null;
	$error = null;
	if ($_POST["recaptcha_response_field"]) {
		$resp = recaptcha_check_answer ($privatekey,
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]);
		if ($resp->is_valid) {
			if(isset($_POST["code"])){
				$code1 = $_POST["code"];
//				if(strcmp(trim($code1),$users[count($users)-1])==0){

					if ($user && $pass){

							$data_r = file_get_contents("../data/access2.txt");
							$users = explode('
',decode($data_r));

						   if (strcmp(trim($user),trim($users[0]))==0 && strcmp(trim($pass),trim($users[1]))==0){
						    $user_founded=1;
						    $users[2] = generateDCode(50);
							setcookie("user_id",$users[2], time()+3600);
							setcookie("user_id",$users[2], time()+3600, "/");

					        $file = fopen("../data/access2.txt",'w');
					        $data_to_write = '';
							for($i=0;$i<=5;$i++){
								$data_to_write .= trim($users[$i])."
";
							}
							fwrite($file, encode($data_to_write));
							fclose($file);

						   }
					}
//				}  // sms
			}
		}  // recaptcha
	}  // recaptcha
}else{
if(isset($_COOKIE["user_id"])){
if($_COOKIE["user_id"]!='0'){

	$data_r = file_get_contents("../data/access2.txt");
	$users = explode('
',decode($data_r));

	   if (strcmp(trim($_COOKIE["user_id"]),trim($users[2]))==0){
		$user_founded=1;
	   }

}
}

}

if(isset($_GET['lo'])){setcookie("user_id",'0');$user_founded=0;}
//$users[4] = $_SERVER["REMOTE_ADDR"];
if($user_founded==1 && strcmp(trim($_SERVER["REMOTE_ADDR"]),trim($users[4]))==0){

if(isset($_POST['action'])){
	$action = $_POST['action'];
	if(isset($_POST['date'])){$date = $_POST['date'];}else{$date = '';}
	if(isset($_POST['title'])){$title = $_POST['title'];}else{$title = '';}
	if(isset($_POST['news'])){$news = $_POST['news'];}else{$news = '';}
	if(isset($_POST['num'])){$num = $_POST['num'];}else{$num = 0;}
	if(isset($_POST['comment'])){$comment = $_POST['comment'];}else{$comment = 0;}
	if(isset($_POST['email'])){$email = $_POST['email'];}else{$email = 0;}
	if(isset($_POST['desc'])){$desc = $_POST['desc'];}else{$desc = 0;}
	if(isset($_POST['check'])){$check = $_POST['check'];}else{$ckeck = 0;}
	if(isset($_POST['page'])){$page = $_POST['page'];}else{$page = 1;}

require_once('../izmenenija.php');

}else{

if(isset($_GET['a'])){$a = $_GET['a'];}
if(isset($_GET['page'])){$page = $_GET['page'];}else{$page=1;}

// защита 3 пароля, капча, задержка между попытками.

$today = getdate();

// Functions -------------------------------------------------------------------

function pages_script($page, $total_pages, $lines_on_page, $link_text1, $link_text2){
print('Страницы: ');

$first_page=$page-2;
if($first_page<1){$first_page=1;}
$total_of_pages = ceil($total_pages/$lines_on_page);

if($first_page+4<$total_of_pages){$total_of_pages=$first_page+4;}
if($page>3){print('<a href="'.$link_text1.'1'.$link_text2.'">&lt;&lt;</a>');}
if($page>1){print('<a href="'.$link_text1.''.($page-1).''.$link_text2.'">&lt;</a> ');}
for($pgs=$first_page;$pgs<=$total_of_pages;$pgs++){
	print(' ');
	if($pgs!=$page){print('<a href="'.$link_text1.''.$pgs.''.$link_text2.'" style="text-decoration:underline">');}
	print($pgs);
	if($pgs!=$page){print('</a>');}
	print(' ');
if($pgs!=$total_of_pages){print('-');}
}
if($page<round($total_pages/$lines_on_page)){print('<a href="'.$link_text1.''.($page+1).''.$link_text2.'">&gt;</a>');}
if(round($total_pages/$lines_on_page)-3>$page){print('<a href="'.$link_text1.''.round($total_pages/$lines_on_page).''.$link_text2.'">&gt;&gt;</a>');}
}

// Читаем все новости

function read_all_news(){
	if(file_exists("../data")){
		if(file_exists("../data/news")){

			global $news_files_data;
			$news_files_data = array();
			global $i;
			$i=0;

			$array = glob("../data/news/*.txt");
			function sort_by_data($file1,$file2) {
				$temp_array = explode('@#%',file_get_contents($file1));
			    $time1 = explode('-',$temp_array[1]);
			    $temp_array = explode('@#%',file_get_contents($file2));
			    $time2 = explode('-',$temp_array[1]);
			    if ($time1 == $time2) {return 0;}
				return ($time1[2] > $time2[2] ||
			      ($time1[2]==$time2[2] && $time1[1] > $time2[1]) ||
			      ($time1[2]==$time2[2] && $time1[1] == $time2[1] && $time1[0] > $time2[0])
			    ) ? 1 : -1;
			    }
			if(count($array)>1){
				usort($array, "sort_by_data");
            }
			for($j=0;$j<count($array);$j++){
				$news_files_data[$i] = file_get_contents($array[$j]);
				if($news_files_data[$i]{0}==0){
					$i++;
				}
			}
			if($news_files_data[$i]{0}==1){
				unset($news_files_data[$i]);
			}

		}
	}
}

// Functions -------------------------------------------------------------------


$global_new_comments=0;
read_all_news();
foreach(array_reverse($news_files_data) as $value){
	$news_data = explode('@#%',$value);
    if(count($news_data)>5){
    	for($q=4;$q<count($news_data)-1;$q++){
    		$temp_value = trim($news_data[$q]);
    		if($temp_value{0}==0){$global_new_comments++;}
    	}
    }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Партия Регионов - Николаев - Администрация сайта</title>
<LINK href="style.css" type="text/css" rel="stylesheet">
<link rel="shortcut icon" href="favicon.ico" type="image/png" />
<link rel="stylesheet" type="text/css" media="all" href="js/calendar-blue.css" title="win2k-cold-1" />
<style> td{line-height:normal;}</style>
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/calendar-en.js"></script>
<script type="text/javascript" src="js/calendar-setup.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="777" height="106" background="images/img1.jpg" style="padding:0 0 0 0;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="color:#FFFFFF; padding:7 0 0 340;">
				Добро пожаловать <b><? print($users[0]); ?> &nbsp;&nbsp;<a href="?lo=1" style="color:#FFFFFF;text-decoration:underline;">Выйти</a></b>
				</td>
			</tr>
		</table>
	</td>
    <td background="images/img3.jpg" height="106">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="330" height="266" background="images/img2.jpg" style="padding:70 0 0 45; background-position:top left; background-repeat:no-repeat;"><font color="#013977"><ul>
<li><a class="nav" href="?a=1">Статистика</a></li>
<li><a class="nav" href="?a=2">Новости (<? print($global_new_comments);?>)</a></li>
<li><a class="nav" href="?a=3">Фотоархив</a></li>
<li><a class="nav" href="?a=4">Доступ</a></li>
</ul></font></td>
    <td style="padding-bottom:100px;">

<?
switch ($a){
case 1:

// Статистика ------------------------------------------------------------------

if(isset($_GET['start_date'])){$start_date=$_GET['start_date'];
	if($start_date){$start_date=explode('-',$start_date);}
}else{$start_date[0]=$today[mday];$start_date[1]=$today[mon];$start_date[2]=$today[year];}

if(isset($_GET['end_date'])){$end_date=$_GET['end_date'];
	if($end_date){$end_date=explode('-',$end_date);}
}else{$end_date[0]=$today[mday];$end_date[1]=$today[mon];$end_date[2]=$today[year];}

if(isset($_GET['sort'])){$sort=$_GET['sort'];}else{$sort=0;}

if(isset($_GET['dbl'])){$dbl=$_GET['dbl'];}else{$dbl=1;}

if(isset($_GET['byip'])){$byip=$_GET['byip'];}else{$byip=0;}

$link='start_date='.$start_date[0].'-'.$start_date[1].'-'.$start_date[2].'&end_date='.$end_date[0].'-'.$end_date[1].'-'.$end_date[2].'&byip='.$byip.'&ref='.$refer.'&dbl='.$dbl;

$fdata = array();
for($i=$start_date[2];$i<=$end_date[2];$i++){
	for($q=$start_date[1];$q<=$end_date[1];$q++){
		for($w=$start_date[0];$w<=$end_date[0];$w++){
			$q*=1;
			if(file_exists('../data_stat/'.$i.'/'.$q.'/'.$w.'.txt')){
				$read = file('../data_stat/'.$i.'/'.$q.'/'.$w.'.txt');
				foreach($read as $fn => $v){
					$get_time = explode(" - ", $v);
					$this_time = explode(":", $get_time[2]);
					if($this_time[0]<10){$this_time[0]='0'.$this_time[0];}
					$w1=$w;
					if($w<10){$w1='0'.$w;}
					$q1=$q;
					if($q<10){$q1='0'.$q;}
					$read[$fn]=$w1.'.'.$q1.'.'.$i.'.'.$this_time[0].'.'.$this_time[1].' - '.$w.'.'.$q.'.'.$i.' - '.$v;
				}
				$fdata = array_merge($fdata, $read);
			}
		}
	}
}

$data = array();
$i=0;
$unic=0;
foreach($fdata as $value){
	$data[$i] = explode(" - ", $value);
	$no=0;
	if($i>0){
	for($q=0;$q<$i;$q++){
		if(strcmp(trim($data[$i][2]),trim($data[$q][2]))==0){$no=1;}
	}
	if($no==0){$unic++;}
	}else{$unic++;}
	$i++;
}

if(count($data)>0){
	foreach($data as $temp_list){
		$sort_aux[] = $temp_list[$sort];
	}
	array_multisort($sort_aux, $data);
}


$show_news_per_page = 30;

$sort_of = count($data);
if($byip!=0){
	$sort_of=0;
	foreach($data as $value){
		if(strcmp($byip,trim($value[2]))==0){
			$sort_of++;
		}
	}
}

print('
    <b style="color:#013977; text-decoration:underline; padding-left:10px;">Статистика посещения сайта</b><br><br>
	<form method="get" style="padding-left:10px;">с: <input name="start_date" type="text" class="loginform" id="startdate" value="'.$start_date[0].'-'.$start_date[1].'-'.$start_date[2].'">
по: <input name="end_date" type="text" class="loginform" id="enddate" value="'.$end_date[0].'-'.$end_date[1].'-'.$end_date[2].'">
<input type="hidden" name="a" value="1">
<input type="hidden" name="dbl" value="'.$dbl.'">
<input type="submit" value="" style="border:0; background:url(images/show.jpg); width:77px; height:16px;">
</form><input type=checkbox ');
if($dbl!=0){$sort_of = $unic; print('checked onChange="window.location.replace(\'?a=1&'.$link.'&dbl=0\');">');}
else{print('onChange="window.location.replace(\'?a=1&'.$link.'&dbl=1\');">');}
print('Показывать только уникальных по IP посетителей.
<br><br>
');pages_script($page, $sort_of, $show_news_per_page, '?start_date='.$start_date[0].'-'.$start_date[1].'-'.$start_date[2].'&end_date='.$end_date[0].'-'.$end_date[1].'-'.$end_date[2].'&byip='.$byip.'&dbl='.$dbl.'&a=1&page=', '');print('
<br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ADBFCE;">
  <tr bgcolor="#E4E9EE" style="font-weight:bold; border-bottom:1 solid #ADBFCE;" align="center">
    <td style="border-bottom:1 solid #ADBFCE;">#</td>
    <td style="border-bottom:1 solid #ADBFCE;">Дата</td>
    <td style="border-bottom:1 solid #ADBFCE;">Время</td>
    <td style="border-bottom:1 solid #ADBFCE;">IP адрес</td>
    <td style="border-bottom:1 solid #ADBFCE;">Страна</td>
    <td style="border-bottom:1 solid #ADBFCE;">Что смотрел?</td>
    <td style="border-bottom:1 solid #ADBFCE;">Откуда пришел?</td>
  </tr>');
$i=count($data);
$n=0;
$hit=0;
foreach(array_reverse($data) as $value){
	$i--;
	$hit++;
	if($dbl==1){
		$no=0;
		for($j=count($data);$j>$i;$j--){
			if(strcmp(trim($data[$j][2]),trim($value[2]))==0){$no=1;}
		}
	}

 if(($dbl==1 && $no==0)||$dbl==0){
  if($byip==0||(strcmp($byip,trim($value[2]))==0)){
 	$n++;
	if($n<=$page*$show_news_per_page && $n>($page-1)*$show_news_per_page){
print('<tr align="center">
    <td>'.$n.'</td>
    <td>'.$value[1].'</td>
    <td>'.$value[4].'</td>
    <td><a href="?a=1&'.$link.'&dbl=0&byip='.$value[2].'" class="link">'.$value[2].'</a></td>
    <td>'.$value[3].'</td>
    <td>');if(strlen(trim($value[5]))>0){print('<a href="index.php?nav='.$value[5].'" class="link" target="_blank">'.substr($value[5],0,40).'</a>');};print('</td>
    <td>');if(strlen(trim($value[6]))>0){print('<a href="'.$value[6].'" class="link" target="_blank">'.substr($value[6],0,40).'</a>');};print('</td>
  </tr>');
	}
  }
 }
}
print('</table>
<br>
');pages_script($page, $sort_of, $show_news_per_page, '?start_date='.$start_date[0].'-'.$start_date[1].'-'.$start_date[2].'&'.$end_date[0].'-'.$end_date[1].'-'.$end_date[2].'=19-8-2009&byip='.$byip.'&dbl='.$dbl.'&a=1&page=', '');print('
<br><br>
Всего: <b>'.$unic.'</b> посетителей, '.$hit.' просмотров страниц.

<script type="text/javascript">
Calendar.setup({inputField:"startdate",ifFormat:"%d-%m-%Y",showsTime:false,timeFormat:"24"});
Calendar.setup({inputField:"enddate",ifFormat:"%d-%m-%Y",showsTime:false,timeFormat:"24"});
</script>
');
break;



case 2:

// Новости ---------------------------------------------------------------------



if(!isset($_GET['comment'])){

print('
<script language="JavaScript" type="text/javascript" src="js/richtext.js"></script>
<script language="JavaScript" type="text/javascript">

function submitForm() {
	updateRTEs();
	document.add.news.value;
	document.add.rte2.value;
	document.add.rte3.value;
	return false;
}
initRTE("js/images/", "js/", "");
</script>

<b style="color:#013977; text-decoration:underline; padding-left:10px;">Новости</b><br><br>
<b style="padding-left:10px;">Добавить новость</b><br><br>
<form name="add" method="POST" style="padding-left:10px;" action="partyadmin.php" onSubmit="return submitForm();">
Дата:
<input name="date" id="date" type="text" class="loginform" value="'.$today[mday].'-'.$today[mon].'-'.$today[year].'">
Заголовок
<input name="title" type="text" class="title" size="85"><br><br>
<input name="action" type="hidden" value="1">
<script>writeRichText("news", "Текст новости", 740, 200, true, false);</script>
<br><br>
<input type="submit" value="" style="border:0; background:url(images/add.jpg); width:75px; height:16px;">
</form>
<br><br>
');
$show_news_per_page = 5;
pages_script($page, $i, $show_news_per_page, '?a=2&page=', '');print('
<br><br>
<script>
function postwith (p) {
  var myForm = document.createElement("form");
  myForm.method="post" ;
  myForm.action = "partyadmin.php" ;
  for (var k in p) {
    var myInput = document.createElement("input") ;
    myInput.setAttribute("name", k) ;
    myInput.setAttribute("value", p[k]);
    myForm.appendChild(myInput) ;
  }
  document.body.appendChild(myForm) ;
  myForm.submit() ;
  document.body.removeChild(myForm) ;
}
</script>
<table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ADBFCE;">
  <tr bgcolor="#E4E9EE" style="font-weight:bold; border-bottom:1 solid #ADBFCE;" align="center">
    <td style="border-bottom:1 solid #ADBFCE;">Дата/Заголовок</td>
    <td style="border-bottom:1 solid #ADBFCE;">Текст новости</td>
    <td style="border-bottom:1 solid #ADBFCE;">Действие</td>
  </tr>
');
$i=0;
foreach(array_reverse($news_files_data) as $value){
	$i++;
	if($i<=$page*$show_news_per_page && $i>($page-1)*$show_news_per_page){
	$news_data = explode('@#%',$value);
print('
  <form method="POST" action="partyadmin.php">
  <input name="action" type="hidden" value="2">
  <input name="num" type="hidden" value="'.(count($news_files_data)-$i).'">
  <tr align="center">
    <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td><input name="date" id="date'.$i.'" type="text" class="loginform" size="30" value="'.$news_data[1].'" size="10"></td>
		  </tr>
		  <tr>
		    <td><input name="title" type="text" class="loginform" style="font-weight:bold" size="25" value="'.$news_data[2].'"></td>
		  </tr>
		  <tr>
		    <td><a href="?a=2&comment='.(count($news_files_data)-$i).'" class="link">Комментарии ['.(count($news_data)-5).']<br>');
    if(count($news_data)>5){
    	$new_comments=0;
    	for($q=4;$q<count($news_data)-1;$q++){
    		$temp_value = trim($news_data[$q]);
    		if($temp_value{0}==0){$new_comments++;}
    	}
    	if($new_comments!=0){print('<br><font style="color:#006600;font-weight:bold;font-size:18px;">Новых ['.$new_comments.']</font>');}
    }
    print('</a><br><br></td>
		  </tr>
		</table>
    </td>
    <td style="padding-bottom:20px;">
    <textarea name="news" rows="10" cols="90" style="font-family:Tahoma; font-size:11px;">'.$news_data[3].'</textarea></td>
    <td><input type="submit" value="" style="border:0; background:url(images/save.jpg); width:75px; height:16px; margin-top:1px;"><br>
	<input type="button" onClick="if(confirm(\'Вы уверены, что хотите удалить данную новость? \r\n'.trim($news_data[2]).'\r\n от '.trim($news_data[1]).' \')){postwith({num:\''.(count($news_files_data)-$i).'\',action:\'3\'})};" value="" style="border:0; background:url(images/delete.jpg); width:75px; height:16px; margin-top:5px;">
	</td>
  </tr>
  </form>
');
	}
}
print('
</table>
<br>
');pages_script($page, $i, $show_news_per_page, '?a=2&page=', '');print('


<script type="text/javascript">
Calendar.setup({inputField:"date",ifFormat:"%d-%m-%Y",showsTime:false,timeFormat:"24"});
');
$i=0;
foreach(array_reverse($news_files_data) as $value){
	$i++;
	if($i<=$page*$show_news_per_page && $i>($page-1)*$show_news_per_page){
		print('Calendar.setup({inputField:"date'.$i.'",ifFormat:"%d-%m-%Y",showsTime:false,timeFormat:"24"});');
	}
}
print('
</script>
');

}else{

// Комментарии -----------------------------------------------------------------

$comment = $_GET['comment'];
$news_data = explode('@#%',$news_files_data[$comment]);

if(count($news_data)>5){
   	$new_comments=0;
   	for($q=4;$q<count($news_data)-1;$q++){
   		$temp_value = trim($news_data[$q]);
   		if($temp_value{0}==0){$new_comments++;}
   	}

print('Комментарии к новости:<br><b>'.$news_data[2].'</b><br>от '.$news_data[1].'<br><br>
<script>
function open_close(a){
if(a==0){
	document.getElementById(\'text\').innerHTML=\'\';
}else{
	document.getElementById(\'text\').innerHTML=\''.str_replace('
','<br>',$news_data[3]).'\';}
}
</script>
<a class="nav" href="#" onClick="if(this.innerHTML==\'Свернуть содержание новости\'){this.innerHTML=\'Развернуть содержание новости\';open_close(0);}else{this.innerHTML=\'Свернуть содержание новости\';open_close(1);};">Развернуть содержание новости</a>
<br><br>
<div id="text"></div>
<br><br>
<table width="95%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ECF0F4">
  <tr>
    <td style="color:#006600; font-size:18px; line-height:normal;">');
if($new_comments>0){print('<b>Новых комментариев: '.$new_comments.'</b>');}else{print('&nbsp;');}
print('</td>
    <td align="right"><a href="admin.php?a=2" class="link"><img src="images/back.gif" width="12" height="11" border="0" align="absmiddle" style="padding-right:7px;">вернуться к списку новостей</a></td>
  </tr>
</table><br><br><br>
');
$show_news_per_page = 5;
pages_script($page, (count($news_data)-5), $show_news_per_page, '?a=2&comment='.$comment.'&page=', '');
print('<br><br>
<script>
function postwith (p) {
  var myForm = document.createElement("form");
  myForm.method="post" ;
  myForm.action = "partyadmin.php" ;
  for (var k in p) {
    var myInput = document.createElement("input") ;
    myInput.setAttribute("name", k) ;
    myInput.setAttribute("value", p[k]);
    myForm.appendChild(myInput) ;
  }
  document.body.appendChild(myForm) ;
  myForm.submit() ;
  document.body.removeChild(myForm) ;
}
</script>
<table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ADBFCE;">
  <tr bgcolor="#E4E9EE" style="font-weight:bold; border-bottom:1 solid #ADBFCE;" align="center">
    <td style="border-bottom:1 solid #ADBFCE;">&nbsp;</td>
    <td style="border-bottom:1 solid #ADBFCE;">Комментарий</td>
    <td style="border-bottom:1 solid #ADBFCE;">Действие</td>
  </tr>');
for($q=4;$q<count($news_data)-1;$q++){
if($q<=($page*$show_news_per_page+3) && $q>($page-1)*$show_news_per_page+3){
$comments_data = explode('#@%',$news_data[$q]);
print('
  <form method="POST" action="partyadmin.php">
  <input name="action" type="hidden" value="4">
  <input name="num" type="hidden" value="'.$q.'">
  <input name="comment" type="hidden" value="'.$comment.'">
  <tr align="left"');if($comments_data[0]==0){print(' bgcolor="#BCE9AB" ');}print('>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Дата</td>
    <td><input name="date" id="date'.$i.'" type="text" class="loginform" value="'.$comments_data[1].'" size="10"></td>
  </tr>
  <tr>
    <td>Автор</td>
    <td><input name="title" type="text" class="loginform" size="20" value="'.$comments_data[2].'"></td>
  </tr>
  <tr>
    <td>E-mail</td>
    <td><input name="email" type="text" class="loginform" size="20" value="'.$comments_data[3].'"></td>
  </tr>
</table>
    <br>
    ');if($comments_data[0]==0){print('<b style="color:#006600; font-size:18px;">НОВЫЙ</b>');}print('
    </td>
    <td style="padding-bottom:20px;"><textarea name="news" rows="4" cols="90" style="font-family:Tahoma; font-size:11px;">'.$comments_data[4].'</textarea></td>
    <td><input type="submit" value="" style="border:0; background:url(images/save.jpg); width:75px; height:16px; margin-top:1px;"><br>
	<input type="button" onClick="if(confirm(\'Вы уверены, что хотите удалить данный комментарий к новости? \r\n Автор: '.trim($comments_data[2]).'\r\n от '.trim($comments_data[1]).' \')){postwith({num:\''.$q.'\',action:\'5\',comment:\''.$comment.'\'})};" value="" style="border:0; background:url(images/delete.jpg); width:75px; height:16px; margin-top:5px;"><br>
	');if($comments_data[0]==0){print('
	<input type="button" onClick="postwith({num:\''.$q.'\',action:\'6\',comment:\''.$comment.'\'});" value="" style="border:0; background:url(images/approved.jpg); width:75px; height:16px; margin-top:5px;">');}print('
	</td>
  </tr>
  </form>
');
}
}
print('
</table><br>
');pages_script($page, (count($news_data)-5), $show_news_per_page, '?a=2&comment='.$comment.'&page=', '');
}else{print('Комментариев к этой новости нет.');}
print('
<br><br>
<table width="95%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ECF0F4">
  <tr>
    <td align="right"><a href="admin.php?a=2" class="link"><img src="images/back.gif" width="12" height="11" border="0" align="absmiddle" style="padding-right:7px;">вернуться к списку новостей</a></td>
  </tr>
</table><br><br><br>');
}

break;

case 3:

// Фотоархив -------------------------------------------------------------------

print('<b style="color:#013977; text-decoration:underline; padding-left:10px;">Фотоархив</b><br><br>
<script>
function postwith (p) {
  var myForm = document.createElement("form");
  myForm.method="post" ;
  myForm.action = "partyadmin.php" ;
  for (var k in p) {
    var myInput = document.createElement("input") ;
    myInput.setAttribute("name", k) ;
    myInput.setAttribute("value", p[k]);
    myForm.appendChild(myInput) ;
  }
  document.body.appendChild(myForm) ;
  myForm.submit() ;
  document.body.removeChild(myForm) ;
}
function postsavewith (i, p) {
  v = document.getElementById(\'desc\'+i).value;
  c=0;
  pg='.$page.';
  if(document.getElementById(\'check\'+i).checked){  c = 1;}
  var myForm = document.createElement("form");
  myForm.method="post" ;
  myForm.action = "partyadmin.php" ;
  for (var k in p) {
    var myInput = document.createElement("input") ;
    myInput.setAttribute("name", k) ;
    myInput.setAttribute("value", p[k]);
    myForm.appendChild(myInput) ;
  }
  var myInput = document.createElement("input") ;
    myInput.setAttribute("name", "desc") ;
    myInput.setAttribute("value", v);
    myForm.appendChild(myInput) ;
  var myInput = document.createElement("input") ;
    myInput.setAttribute("name", "check") ;
    myInput.setAttribute("value", c);
    myForm.appendChild(myInput) ;
  var myInput = document.createElement("input") ;
    myInput.setAttribute("name", "page") ;
    myInput.setAttribute("value", pg);
    myForm.appendChild(myInput) ;
  document.body.appendChild(myForm) ;
  myForm.submit() ;
  document.body.removeChild(myForm) ;
}
</script>
');

print('<br><br>
<form action="partyadmin.php" method="POST" ENCTYPE="multipart/form-data">
Добавить фотографию: <input name="srs" id="srs" type="file" size="38"> <input name="action" type="hidden" value="8"> <input type="submit" value="  Загрузить  "/>
</form>
<br><br>');
$show_news_per_page = 15;
$photos_files = glob("gallery/*.*");
pages_script($page, count($photos_files), $show_news_per_page, '?a=3&page=', '');

print('<br><br><table width="95%" border="0" cellspacing="0" cellpadding="0" style="line-height:normal;">
<tr bgcolor="#ECF0F4"><td>&nbsp;</td><td>Имя файла изображения</td><td>Описание изображения</td><td>Отображать</td><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="5">&nbsp;</td></tr>');
$i=0;
if(strlen($photos_files[0])>0){
for($j=0;$j<count($photos_files);$j++){
	$news_file = $photos_files[$j];
	$desc='';
	$check=0;
	if(file_exists('../gallery_data/'.$news_file)){
          $sd = file('../gallery_data/'.$news_file);
          $check=trim($sd[0]);
          $desc=trim($sd[1]);
	}

	$i++;
	if($i<=($page*$show_news_per_page) && $i>($page-1)*$show_news_per_page){
		if(!file_exists('temp/'.$news_file)){
			$img = ImageCreateFromJpeg($news_file);
			$resize = (100*imagesy($img))/Imagesx($img);
			$img_small = imagecreatetruecolor(100, $resize);
			Imagecopyresampled($img_small, $img, 0, 0, 0, 0, 100, $resize, Imagesx($img), imagesy($img));
			ImageJpeg($img_small, 'temp/'.$news_file,80);
        }
print('<tr bgcolor="#ECF0F4"><td>'.$i.'</td><td><a class="link" href="'.$news_file.'" target="_blank">
<img border="0" src="temp/'.$news_file.'" /><br>
'.$news_file.'</a></td><td><input type="text" id="desc'.$i.'" value="'.$desc.'" size="60" /></td><td><input type="checkbox" ');
if($check==1){print('checked="checked" ');}
print('id="check'.$i.'" /></td><td><a href="#" class="link" onClick="postsavewith('.$i.',{num:\''.$news_file.'\',action:\'9\'})">Сохранить</a></td><td><a href="#" class="link" onClick="if(confirm(\'Вы уверены, что хотите удалить данную Фотографию? \r\n'.$news_file.'\')){postwith({num:\''.$news_file.'\',action:\'7\'})};">Удалить</a></td></tr>
<tr><td colspan="5">&nbsp;</td></tr>
');
	}
}
}print('</table>');
pages_script($page, count($photos_files), $show_news_per_page, '?a=3&page=', '');

break;

case 4:

// Доступ ----------------------------------------------------------------------


/*
$gzdata = gzdeflate('admin^^temp123^^sdacn89324fd2m43184325702357s90874325908d35fc4325', 7);

print($gzdata);
print(gzinflate($gzdata));



   	$file = fopen("images/logo_little2.jpg","r");
	$image='';
	while(!feof($file)){
	$image.=fgets($file);
	}
	fclose ($file);
	$a = explode('@#%@@#22%#@',$image);
	print(gzgets($a[1]));
*/

print('
<form method="post" style="padding-top:7px; padding-right:25px;">
<table width="500" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ADBFCE;">
  <tr bgcolor="#E4E9EE" style="font-weight:bold; border-bottom:1 solid #ADBFCE;" align="center">
    <td style="border-bottom:1 solid #ADBFCE;">&nbsp;</td>
    <td style="border-bottom:1 solid #ADBFCE;">&nbsp;</td>
  </tr>
  <tr>
    <td>Логин:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td><input name="date" type="text" class="loginform" value="'.trim($users[0]).'"></td>
  </tr>
  <tr>
    <td>Пароль:</td>
    <td><input name="title" type="password" class="loginform" value="'.trim($users[1]).'"></td>
  </tr>
  <tr>
    <td>Новый пароль:</td>
    <td><input name="news" type="password" class="loginform" value=""></td>
  </tr>
  <tr>
    <td>Номер мобильного телефона для отсылки кода доступа:</td>
    <td><input name="num" type="text" class="loginform" value="'.trim($users[3]).'"></td>
  </tr>
  <tr>
    <td>IP адрес админимстратора:</td>
    <td><input name="check" type="text" class="loginform" value="'.trim($users[4]).'"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <input name="action" type="hidden" value="10">
    <input type="submit" value="" style="border:0; background:url(images/save.jpg); width:75px; height:16px; margin-top:1px;"></td>
  </tr>
</table>
</form>
');


break;

default:

$unic=0;
if(file_exists('../data_stat/'.$today[year].'/'.$today[mon].'/'.$today[mday].'.txt')){
	$fdata = file('../data_stat/'.$today[year].'/'.$today[mon].'/'.$today[mday].'.txt');
	$data = array();
	$i=0;
	foreach($fdata as $value){
		$data[$i] = explode(" - ", $value);
		$no=0;
		if($i>0){
		for($q=0;$q<$i;$q++){
			if(strcmp(trim($data[$i][0]),trim($data[$q][0]))==0){$no=1;}
		}
		if($no==0){$unic++;}
		}else{$unic++;}
		$i++;
	}
}

print('Новых комментариев: '.$global_new_comments.'<br>');
print('Уникальных посетителей за сегодня: '.$unic.'<br>');
break;
}





print('
	</td>
  </tr>
</table>
</body>

</html>');


}

}else{

		$data_r = file_get_contents("../data/access2.txt");
$data_in = explode('
',decode($data_r));

        $file = fopen("../data/access2.txt",'w');
        $data_to_write = '';
		for($i=0;$i<=4;$i++){
			$data_to_write .= trim($data_in[$i])."
";
		}
		$data_to_write .= generateDCode(5);
		fwrite($file, encode($data_to_write));
		fclose($file);

print('<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Партия Регионов - Николаев - Администрация сайта</title>
<LINK href="style.css" type="text/css" rel="stylesheet">
<link rel="shortcut icon" href="favicon.ico" type="image/png" />
<style> td{line-height:normal;}</style>
</head>
<body>
<center>
<form action="partyadmin.php" method="post" style="padding-top:7px; padding-right:25px;">
<table width="500" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ADBFCE;">
  <tr bgcolor="#E4E9EE" style="font-weight:bold; border-bottom:1 solid #ADBFCE;">
    <td style="border-bottom:1 solid #ADBFCE;">&nbsp;</td>
    <td style="border-bottom:1 solid #ADBFCE;">Админ зона</td>
  </tr>
  <tr>
    <td>Логин:</td>
    <td><input type="text" name="user" class="loginform"></td>
  </tr>
  <tr>
    <td>Пароль:</td>
    <td><input name="pass" type="password" class="loginform"></td>
  </tr>
  <tr>
    <td>Код доступа:</td>
    <td><input name="code" type="text" class="loginform"> выслать по <a href="sendsms.php" class="link" target="_blank">СМС</a></td>
  </tr>
  <tr>
    <td>Капча:</td>
    <td>'.recaptcha_get_html($publickey, $error).'
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="a" type="hidden" value="0"><input type="submit" value="" style="border:0; background:url(images/signin.jpg); width:75px; height:16px; margin-top:1px;"></td>
  </tr>
</table>
</form>
</center>
</body>
</html>');
}

require_once('../count.php');

?>


