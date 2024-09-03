<?

// http://127.0.0.1/party_demo/gimmeaccess.php

$data_in[0]='admin';
$data_in[1]='temp123';
$data_in[2]='sdacn89324fd2m43184325702357s90874325908d35fc4325';
$data_in[3]='380939966255';
//$data_in[4]='127.0.0.1';
$data_in[4]=trim(file_get_contents('http://nikpartregion.mk.ua/ip.php'));

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

function generateDCode($length) {
	$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
      $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

        $file = fopen("../data/access2.txt",'w');
        $data_to_write = '';
		for($i=0;$i<=4;$i++){
			$data_to_write .= trim($data_in[$i])."
";
		}
		$data_to_write .= generateDCode(5);
		fwrite($file, encode($data_to_write));
		fclose($file);

print('access2.txt создан успешно!<br>Ваш IP адрес: '.$data_in[4]);

?>