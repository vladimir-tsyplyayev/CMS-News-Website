<?

function decode($str){$d=0;
$i=0;
$t = array();
$f = $str;
while($d==0){    $decl = (int)abs(sin($i/3)*318*cos($i/7)*224)*23+318327;
    $s = explode($decl, $f);
    $t[$i] = chr(trim($s[0]));
    $f = $s[1];
   	if(strlen($f)==0){$d=1;}	$i++;
	unset($s);}
$s='';
foreach($t as $v){	$s .= $v;}
return $s;}

function encode($str){$s1 = str_split($str);
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

?>


