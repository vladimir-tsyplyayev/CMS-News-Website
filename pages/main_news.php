<?
// Всеукраинские новости

print('
<td style="padding:0 0 0 0;">');


if (isset($_GET['n'])){$n = $_GET['n'];


$reads = file_get_contents("http://www.partyofregions.org.ua".$n);


preg_match_all('!endb\"\>(.*?)\<\/div!s',$reads,$tmp_name);
preg_match_all('!big0\"\>(.*?)\<span!s',$reads,$tmp_title);
preg_match_all('!bluedate\"\>(.*?)\<\/span!s',$reads,$tmp_time);

print('<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding:29 0 5 35; background-repeat:no-repeat; background-position:bottom left;" background="images/title_long.png"><a class="title" style="line-height:normal;">'.$tmp_title[1][0].'</a></td>
          </tr>
        </table>

		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td style="padding:20 30 20 30; line-height:normal;">'.$tmp_time[1][0].'<br><br>'.str_replace('src="/images/','src="http://www.partyofregions.org.ua/images/',$tmp_name[1][0]).'
			</td>
            </tr>
          </table>





			');

 }

print('        </td>
');


?>