<?

if($comment != ''){
if($author == ''){$author = 'Анонимный пользователь';}

$author = strip_tags($author);
$comment = strip_tags($comment);
if(!preg_match('|([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is', $email)){$email='';}
$comment = strip_tags($comment);

$today = getdate();
$date = $today[mday].'-'.$today[mon].'-'.$today[year];

// Читаем все новости

function read_all_news(){
	global $news_files_data;
	$news_files_data = array();
	global $news_files_names;
	$news_files_names = array();
	global $i;
	$i=0;

	$array = glob("../data/news/*.txt");
	function sort_by_data($file1,$file2) {
		$temp_array = explode('@#%',file_get_contents($file1));
	    $time1 = explode('-',$temp_array[1]);
	    $temp_array = explode('@#%',file_get_contents($file2));
	    $time2 = explode('-',$temp_array[1]);
	    if ($time1 == $time2) {return 0;}
		return ($time1[2] > $time2[2] ||
	      ($time1[2]==$time2[2] && $time1[0] > $time2[0]) ||
	      ($time1[2]==$time2[2] && $time1[0] == $time2[0] && $time1[1] > $time2[1])
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
}

// Добавляем новый комментарий

	if(file_exists("../data")){
		if(file_exists("../data/news")){
			if(file_exists("../data/news/".$news_files_names[$id])){
				read_all_news();
				$news_data = explode('@#%',$news_files_data[$id]);
				$file = fopen($news_files_names[$id],'w');
				for($q=0;$q<count($news_data)-1;$q++){
            	   		fwrite($file, trim($news_data[$q])."@#%\r\n");
               	}
	            fwrite($file, "0#@%".$date."#@%".$author."#@%".$email."#@%".$comment."@#%\r\n");
				fclose($file);
				print('<script>window.location.replace("index.php?nav=news&id='.$id.'&message=sent");</script>');
			}
		}else{print('Директория /data/<b>news</b>/ не найдена на сервере<br><br><a href="javascript:history.back()">&lt;&lt;Вернуться назад</a>');}
	}else{print('Директория /<b>data</b>/ не найдена на сервере<br><br><a href="javascript:history.back()">&lt;&lt;Вернуться назад</a>');}

}else{
	print('<script>window.location.replace("index.php?nav=news&id='.$id.'&message=error");</script>');
}




?>