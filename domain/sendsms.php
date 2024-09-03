<?

if(file_exists("../data/access2.txt")){
	$data_r = file_get_contents("../data/access2.txt");
	$users = explode('
',decode($data_r));
	if(strcmp(trim($_SERVER["REMOTE_ADDR"]),trim($users[4]))==0){
		$page = file_get_contents('http://api.clickatell.com/http/sendmsg?user=partyofregions&password=PASSWORD_HERE&api_id=3196628&to='.trim($users[3]).'&text='.trim($users[5]));
    }
}

print('ÑÌÑ ñ êîäîì äîñòóðïà óñïåøíî îòïðàâëåí.');

?>


