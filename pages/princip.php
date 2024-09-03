<?
// Газета принцип

$array = glob("princip/*.jpg");
$princip = array();
foreach($array as $i => $v){	$d = explode(')',$v);	$princip[$d[0]] = trim($d[1]);}

print('
<td style="padding:0 0 0 0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding:29 0 5 35; background-repeat:no-repeat; background-position:bottom left;" background="images/title_long.png"><a class="title" style="line-height:normal;">Газета "Принцип".</a></td>
          </tr>
        </table>
		  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-bottom:350px;">
            <tr>
              <td style="padding:20 30 20 30; line-height:normal;">
			   <table width="90%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ADBFCE; line-height:normal;" align="center">
                <tr bgcolor="#E4E9EE" style="font-weight:bold; border-bottom:1 solid #ADBFCE;"  >
                  <td>Выпуск</td>
                  <td>Формат</td>
                  <td>Размер</td>
                </tr>');
foreach($princip as $i => $v){	$value = $princip[$i];
print('                <tr>
                  <td><a href="'.$value.'" class="link" target="_blank">'.str_replace('princip/','',$value).'</a></td>
                  <td>.jpg</td>
                  <td>'.((int)(filesize($value)/10000)/100).' Mb</td>
                </tr>');
 }
print('               </table>
			  </td>
            </tr>
          </table>


        </td>
');

?>