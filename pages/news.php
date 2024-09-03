<?
// НОВОСТИ

if(isset($_GET['id'])){$id = $_GET['id'];}else{$id = '';}
if(isset($_GET['page'])){$page = $_GET['page'];}else{$page=1;}
if(isset($_GET['message'])){$message = $_GET['message'];}else{$message='';}

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

// Functions -------------------------------------------------------------------

// Читаем все новости
$news_files_data = array();
$news_files_names = array();
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
usort($array, "sort_by_data");

foreach($array as $news_file){
	$news_files_data[$i] = file_get_contents($news_file);
	$news_files_names[$i] = $news_file;
	if($news_files_data[$i]{0}==0){
		$i++;
	}
}


print('
<td style="padding:0 0 0 0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding:29 0 5 35; background-repeat:no-repeat; background-position:bottom left;" background="images/title_long.png"><a class="title" style="line-height:normal;">НОВОСТИ</a></td>
          </tr>
        </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td style="padding:20 30 20 30; line-height:normal;">');

if($id == ''){ // Все новости --------------------------------------------------

$show_news_per_page = 5;
pages_script($page, $i, $show_news_per_page, '?nav=news&page=', '');
print('<br>');

$i=0;
foreach(array_reverse($news_files_data) as $value){
	$i++;
	if($i<=$page*$show_news_per_page && $i>($page-1)*$show_news_per_page){
		$news_data = explode('@#%',$value);
	    $news_date = explode('-',$news_data[1]);
	    preg_match_all('!\[img\]([\d\w\/\.\-]*)\[\/img\]!',$news_data[3],$tmp1);
    	if(strlen($news_date[1])<2){$news_date[1]='0'.$news_date[1];}
print('<br><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ECF0F4" style="line-height:normal;">
<tr><td width="110">'.$news_date[0].'.'.$news_date[1].'.'.$news_date[2].'</td><td><a href="?nav=news&id='.(count($news_files_data)-$i).'" class="link"><b>'.str_replace("\'","'",$news_data[2]).'</b></a></td></tr>');
print('<tr><td>');
$news_data[3] = strip_tags($news_data[3]);
if(strlen($tmp1[1][0])>0){print('<a href="?nav=news&id='.(count($news_files_data)-$i).'" class="link"><img border="0" src="temp/'.$tmp1[1][0].'"></a>');}
$news_data[3] = preg_replace('!\[img\]([\d\w\/\.\-\:\_\(\)\s]*)\[\/img\]!','',$news_data[3]);
$news_data[3] = preg_replace('!\[youtube\]([\d\w\/\.\-\[\]]*)\[\/youtube\]!','',$news_data[3]);
$news_data[3] = str_replace("\'","'",$news_data[3]);
print('</td><td>'.substr($news_data[3],0,400).'</td></tr>');
$no_comment=0;
for($q=4;$q<count($news_data)-1;$q++){
	if($news_data[$q]{2}==1){
		$no_comment++;
	}
}
print('<tr><td>&nbsp;</td><td><a href="?nav=news&id='.(count($news_files_data)-$i).'" class="link">Комментарии ['.$no_comment.']</a></td></tr></table><br>');

	}
}

pages_script($page, $i, $show_news_per_page, '?nav=news&page=', '');

}else{   // Новость в отдельности с комментариями ------------------------------
	$news_data = explode('@#%',$news_files_data[$id]);
	$news_date = explode('-',$news_data[1]);
	if(strlen($news_date[1])<2){$news_date[1]='0'.$news_date[1];}

print('<b style="font-size:14px;">'.str_replace("\'","'",$news_data[2]).'</b><br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ECF0F4">
  <tr>
    <td style="font-size:10px; color:#013977; line-height:normal;">'.$news_date[0].'.'.$news_date[1].'.'.$news_date[2].'</td>
    <td align="right"><a href="?nav=news" class="link"><img src="images/back.gif" width="12" height="11" border="0" align="absmiddle" style="padding-right:7px;">вернуться в раздел</a></td>
  </tr>
</table>
<br>
'.str_replace('
','<br><dd>',
str_replace('[img]','<br><br><center><img src="',
str_replace('[/img]','" border="0" /></center><br>',
str_replace('[youtube]','<br><br><center><object width="560" height="340"><param name="movie" value="http://www.youtube.com/v/',
str_replace('[/youtube/]','"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/',
str_replace('[/youtube]','" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="560" height="340"></embed></object></center><br>',
str_replace("\'","'",$news_data[3])
)))))
).'
<br><br>
<hr align="left" width="100%" size="1" noshade color="#CED5DC" />
<br>');
if(eregi('sent',$message)){print('<br>Ваш комментарий добавлен и будет доступен к просмотру после модерации.<br><br><br>');}
if(eregi('error',$message)){print('<br>Не корректно введены данные.<br><br><br>');}
if(eregi('captcha',$message)){print('<br>Не правильно введена капча.<br><br><br>');}
	if((count($news_data)-5)>0){
		print('<b>Комментарии</b><br><br>');
        $no_comment=0;
		for($q=4;$q<count($news_data)-1;$q++){
			if($news_data[$q]{2}==1){
				$no_comment=1;
				$comments_data = explode('#@%',$news_data[$q]);
				print('<br>'.$comments_data[1].' ');
				if(strlen($comments_data[3])>0){print('<a href="mailto:'.$comments_data[3].'" class="link">');}
				print('<b>'.$comments_data[2].'</b>');
				if(strlen($comments_data[3])>0){print('</a>');}
print('<br>
<table width="90%" border="0" cellspacing="0" cellpadding="0" style="margin-left:30px;margin-top:5px;">
  <tr>
    <td style="color:#6D6D6D; line-height:normal;">'.str_replace('
','<br>',$comments_data[4]).'</td>
  </tr>
</table><br>');
			}
		}

	}else{
		print('Комментариев нет.');
	}
	if($no_comment==0){print('Комментариев нет.');}

print('
<br><br>
<hr align="left" width="100%" size="1" noshade color="#CED5DC" />
<br>
<b style="line-height:normal;">Добавить комментарий:<br><br></b>
<form action="posting_comment.php" method="post" style="line-height:normal;">
Имя <em>(обязательное поле)</em><br>
<input type="text" name="author" id="author" value="" tabindex="1" /><br>
E-mail<br>
<input type="text" name="email" id="email" value="" tabindex="2" /><br>
Комментарий<br>
<textarea name="comment" id="comment" cols="55" rows="10" tabindex="4"></textarea><br>');

require_once('../captcha/recaptchalib.php');

// Get a key from http://recaptcha.net/api/getkey
$publickey = "6LeXiwgAAAAAAMSacs18kLhfKv143gT64OW10p9f";
$privatekey = "6LeXiwgAAAAAAKgszevTNaJnaWlA6DbDnE4ILOoP";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

# was there a reCAPTCHA response?
if ($_POST["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {
                echo "You got it!";
        } else {
                # set the error code so that we can display it
                $error = $resp->error;
        }
}
echo recaptcha_get_html($publickey, $error);

print('<br>
<input type="hidden" name="id" value="'.$id.'">
<input type="submit" name="submit" value="Разместить" class="button" tabindex="5" />
</form>




');

}

print('


                </td>
            </tr>
          </table>
');

?>