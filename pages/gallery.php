<?
// ÑÒÐÀÍÈÖÀ ÔÎÒÎÀÐÕÈÂ

if(isset($_GET['wtd'])){$wtd = $_GET['wtd'];}else{$wtd = 0;}
if(isset($_GET['page'])){$page = $_GET['page'];}else{$page=1;}
if(isset($_GET['id'])){$id = $_GET['id'];}else{$id = '';}

// Functions -------------------------------------------------------------------

function pages_script($page, $total_pages, $lines_on_page, $link_text1, $link_text2){
print('Ñòðàíèöû: ');

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

print('
<td style="padding:0 0 0 0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding:29 0 5 35; background-repeat:no-repeat; background-position:bottom left;" background="images/title_long.png"><a class="title" style="line-height:normal;">ÔÎÒÎÀÐÕÈÂ</a><br><br><br><br></td>
          </tr>
          <tr>
          <td style="line-height:normal; padding-top:30px; padding-left:20px;" valign="top">
        ');

$photos_files = glob("gallery/*.*");
$photo_file = array();
$photo_desc = array();
$check = array();
$photos_on_page=0;
$j=0;
foreach($photos_files as $news_file){
	$desc='';
	$check[$j]=0;
	if(file_exists('../gallery_data/'.$news_file)){
          $sd = file('../gallery_data/'.$news_file);
          $check[$j]=trim($sd[0]);
          $desc=trim($sd[1]);
	}
	if($check[$j]==1){		$photo_desc[$photos_on_page]=$desc;
		$photo_file[$photos_on_page]=$news_file;
        $photos_on_page++;	}
	$j++;
}
$photos_on_page--;

if($wtd==0){

$show_news_per_page = 15;
$lines_on_page = 5;

pages_script($page, $photos_on_page, $show_news_per_page, '?nav=gallery&page=', '');
print('<table width="90%" border="0" cellspacing="0" cellpadding="0" style="padding-left:40px;"><tr>');
$j=0;
for($i=0;$i<=$photos_on_page;$i++){	if($i<($page*$show_news_per_page) && $i>(($page-1)*$show_news_per_page-1)){		$j++;
		if($j>$lines_on_page){$j=1;print('</tr><tr>');}
		print('<td style="padding-right:15px; padding-left:15px; padding-top:25px; padding-bottom:20px; line-height:normal;" valign="top">');
		print('<a href="?nav=gallery&wtd=1&id='.$i.'&page='.$page.'"><img border="0" src="temp/'.$photo_file[$i].'" alt="'.$photo_desc[$i].'" /></a></td>');
	}
}
print('</tr></table>');
pages_script($page, $photos_on_page, $show_news_per_page, '?nav=gallery&page=', '');

}else{


if(eregi('.jpg',$id) || eregi('.JPG',$id) || eregi('.gif',$id) || eregi('.GIF',$id)){

$j=0;
$g=0;
foreach($photos_files as $news_file){
	if($check[$j]==1){		if(strcmp($news_file,'gallery/'.$id)==0){
    	   	$id=$g;
    		break;
    	}
        $g++;
	}
	$j++;

}
}

$dsize = GetImageSize($photo_file[$id]);
$spacer=$dsize[1]-200;
$next_url=$id+1;
$prev_url=$id-1;
if(($photos_on_page+1)<=$next_url){$next_url=0;}
if($prev_url<0){$prev_url=$photos_on_page;}

print('

		  <table width="80%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:30px;">
            <tr>
              <td style="vertical-align:middle; padding-left:20px;"><a href="?nav=gallery&wtd=1&id='.$prev_url.'&page='.$page.'" class="link"><img border="0" src="images/arrow_left.jpg" /></a></td>
              <td style="padding:20 30 20 30;" align="center">
								<a href="?nav=gallery&wtd=1&id='.$next_url.'&page='.$page.'">');
if($check[$id]==1){print('<img border="0" src="'.$photo_file[$id].'"');
if($dsize[0]>640){print('width="640"');}
print(' alt="'.$photo_desc[$id].'" />');
}else{print('<img border="0" src="images/photo_not_found.jpg" alt="Ôîòî íå íàéäåíî" />');
};print('</a></td>
              <td style="vertical-align:middle; padding-left:20px;"><a href="?nav=gallery&wtd=1&id='.$next_url.'&page='.$page.'" class="link"><img border="0" src="images/arrow_right.jpg" /></a></td>
            </tr>
          </table>

<table width="80%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ECF0F4" style="margin-bottom:50px;">
  <tr>
    <td align="center"><a href="?nav=gallery&page='.$page.'" class="link"><img src="images/back.gif" width="12" height="11" border="0" align="absmiddle" style="padding-right:7px;">âåðíóòüñÿ â ôîòîàðõèâ</a></td>
  </tr>
</table>

');

}

print('</td></tr>
</table></td>');

?>