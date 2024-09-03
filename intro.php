<?
// Читаем все новости
$news_files_data = array();
$news_files_names = array();
$i=0;

$array = glob("../data/news/*.txt");
function sort_by_data($file1,$file2) {	$temp_array = explode('@#%',file_get_contents($file1));
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
if($news_files_data[$i]{0}==1){
	unset($news_files_data[$i]);
}
$news_data1 = explode('@#%',$news_files_data[($i-1)]);
$news_data2 = explode('@#%',$news_files_data[($i-2)]);

 print('
  <tr>
    <td style="padding:0 0 0 0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="padding:0 0 0 0;" width="81" height="257">&nbsp;</td>
        <td style="padding:0 0 0 0; vertical-align:bottom;" background="images/bg_intro.jpg" width="600" height="257"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="600" height="235">
          <param name="movie" value="flash/intro.swf">
          <param name="quality" value="high">
          <embed src="flash/intro.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="600" height="235"></embed>
        </object></td>
        <td style="padding:0 0 0 0; vertical-align:bottom;" width="419" height="235"><table  width="419" height="235" border="0" cellspacing="0" cellpadding="0" background="images/news.jpg">
          <tr>
            <td style="padding:0 0 0 0;"></td>
          </tr>
          <tr>
            <td style="padding:52 30 0 50; line-height:normal;"><a style="text-decoration:underline; color:#FFFFFF; font-weight:bold;" href="?nav=news&id='.($i-1).'">'.str_replace('-','.',$news_data1[1]).'</a><br>
<a href="?nav=news&id='.($i-1).'" style="color:#FFFFFF">'.substr($news_data1[2],0,115).'</a><br>
<a href="?nav=news&id='.($i-1).'" class="comm">Комментарии ['.(count($news_data1)-5).']</a>
			</td>
          </tr>
          <tr>
            <td style="padding:0 30 10 50; line-height:normal;"><a style="text-decoration:underline; color:#FFFFFF; font-weight:bold;" href="?nav=news&id='.($i-2).'">'.str_replace('-','.',$news_data2[1]).'</a><br>
<a href="?nav=news&id='.($i-2).'" style="color:#FFFFFF">'.substr($news_data2[2],0,115).'</a><br>
<a href="?nav=news&id='.($i-2).'" class="comm">Комментарии ['.(count($news_data2)-5).']</a>
			</td>
          </tr>
          <tr>
            <td style="padding:0 0 10 0;line-height:normal;" align="right">
				<a href="?nav=news" class="comm" style="color:#FFFFFF">Читать все новоcти >></a>
			</td>
          </tr>
        </table>
		</td>
        <td style="padding:0 0 0 0; vertical-align:bottom;" height="235"><table width="100%" height="235" border="0" cellspacing="0" cellpadding="0" background="images/bg_news.jpg" bgcolor="#152F6C">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
'); ?>