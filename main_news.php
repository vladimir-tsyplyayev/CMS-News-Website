<?
$read = file_get_contents("http://www.partyofregions.org.ua/");


preg_match_all('!\<a\shref\=\"([\w\d\-\/]*)\"\sclass\=\"ann01\"\>!',$read,$tmp_lnk);
preg_match_all('!class\=\"ann01\"\>(.*?)\<\/a\>!',$read,$tmp_name);

print('
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding:29 0 5 20; background-repeat:no-repeat; background-position:bottom left;" background="images/title_short.jpg">
            <a class="title" style="line-height:normal;">¬—≈” –¿»Õ— »≈ ÕŒ¬Œ—“»</a></td>
          </tr>
        </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:20px;">');
foreach($tmp_name[1] as $i => $v){
print('            <tr>
              <td style="padding-top:8px;">
			  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                	<tr>
	                  <td background="images/arrow.jpg" style="background-repeat:no-repeat; background-position:right top;">&nbsp;</td>
    	            </tr>
        	    </table>
        	  </td>
              <td style="line-height:normal;">
              	<a href="?nav=main_news&n='.$tmp_lnk[1][$i].'"><b>'.$v.'</b></a>
              </td>
            </tr>

            <tr>
              <td>&nbsp;</td>
              <td style=" padding:17 0 7 0">
              <table width="80%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td background="images/points.gif" style="background-repeat:repeat-x">&nbsp;</td>
                </tr>
              </table>
              </td>
            </tr>');
}


print('          </table>




          </td>
'); ?>