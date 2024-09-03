<?
if(isset($_GET['nav'])){$nav = $_GET['nav'];}else{$nav = '';}

require_once('../count.php');
$foo = array('bar' => 'baz');

$titles = array(
'news' 		=> 'Новости.',
'princip' 	=> 'Газета "Принцип".',
'results'	=> 'Цифры и показатели. Официальная статистика.',
'contact'	=> 'Контактная информация.',
'gallery'	=> 'Фотоархив.',
'signup'	=> 'Вступление в партию.',
'program'	=> 'Программа партии.',
'ustav'		=> 'Устав партии.',
'history'	=> 'История.',
'joke'		=> 'Политическая карикатура.',
'oblsovet'	=> 'Список депутатов фракции Партии регионов Николаевского областного совета.',
'gorsovet'	=> 'Список депутатов фракции Партии регионов Николаевского горсовета.',
'leading_obl'	=> 'Керуючий склад "Партії регіонів" у Миколаївській області',
'nato'	=> 'Правда и вымысел - НАТО',
'lica'	=> 'Правда и вымысел - Лица в словах и фактах',
'nac'	=> 'Правда и вымысел - Национальные вопросы',
'hist'	=> 'Правда и вымысел - Наша история',
'religion'	=> 'Правда и вымысел - Религия',
'reestr'	=> 'Государственный реестр избирателей Николаевской области',
'events'	=> 'События',
'message'	=> 'Тема дня',
'nam_pishut'	=> 'Нам пишут',
'main_news'	=> 'Всеукраинские новости Партии регионов',
'prdvibornajaprogramma'	=> 'ПЕРЕДВИБОРНА ПРОГРАМА КАНДИДАТА НА ПОСТ ПРЕЗИДЕНТА УКРАЇНИ ЯНУКОВИЧА В.Ф. «УКРАЇНА – ДЛЯ ЛЮДЕЙ!»'
);


print('<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-site-verification" content="rb7NFMGfDN0HWKsKrBuyW6eO1UdPxrwjL0ynCaSFlzg" />
<title>Партия Регионов - Николаев');
if($nav!=''){print(' - '.$titles[$nav]);}
print('</title>
<LINK href="style.css" type="text/css" rel="stylesheet">
<link rel="shortcut icon" href="favicon.ico" type="image/png" />
<style>#dhtmlgoodies_listMenu ul{display:none;}</style>
<script type="text/javascript" src="js/menu.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/logo_bg.jpg" style="background-repeat:no-repeat; background-position:left top">');
// Хедер (шапка сайта) ---------------------------------------------------------
require_once('../header.php');
if($nav==''){require_once('../intro.php');}
print('
  <tr>
    <td style="padding:0 0 0 0;"><table width="1200" border="0" cellspacing="0" cellpadding="0">
      <tr>');
// Навигация сайта -------------------------------------------------------------
require_once('../navigation.php');
print('
        <td style="padding:0 0 0 0;" width="4" bgcolor="#E3E9F1">&nbsp;</td>');
// Страницы --------------------------------------------------------------------
switch ($nav):
case news:
	require_once('../pages/news.php');
break;
case results:
	require_once('../pages/results.php');
break;
case contact:
	require_once('../pages/contact.php');
break;
case gallery:
	require_once('../pages/gallery.php');
break;
case signup:
	require_once('../pages/signup.php');
break;
case program:
	require_once('../pages/program.php');
break;
case ustav:
	require_once('../pages/ustav.php');
break;
case history:
	require_once('../pages/history.php');
break;
case joke:
	require_once('../pages/joke.php');
break;
case princip:
	require_once('../pages/princip.php');
break;
case oblsovet:
	require_once('../pages/oblsovet.php');
break;
case gorsovet:
	require_once('../pages/gorsovet.php');
break;
case leading_obl:
	require_once('../pages/leading_obl.php');
break;
case nato:
	require_once('../pages/pravda/nato.php');
break;
case lica:
	require_once('../pages/pravda/lica.php');
break;
case nac:
	require_once('../pages/pravda/nac.php');
break;
case hist:
	require_once('../pages/pravda/hist.php');
break;
case religion:
	require_once('../pages/pravda/religion.php');
break;
case prdvibornajaprogramma:
	require_once('../pages/prdvibornajaprogramma.php');
break;
case events:
	require_once('../pages/events.php');
break;
case reestr:
	require_once('../pages/reestr.php');
break;
case message:
	require_once('../pages/message.php');
break;
case nam_pishut:
	require_once('../pages/nam_pishut.php');
break;
case main_news:
	require_once('../pages/main_news.php');
break;
default:
	require_once('../pages/home.php');
	require_once('../links.php');
endswitch;
print('
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>');
// Футер -----------------------------------------------------------------------
require_once('../footer.php');
print('
</table>
</body>
</html>
'); ?>