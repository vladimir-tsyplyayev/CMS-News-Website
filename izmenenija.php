<?
$user_founded=0;
if(isset($_COOKIE["user_id"])){
if($_COOKIE["user_id"]!='0'){

	$data_r = file_get_contents("../data/access2.txt");
	$users = explode('
',decode($data_r));

   if (strcmp(trim($_COOKIE["user_id"]),trim($users[2]))==0){
		$user_founded=1;
   }

}
}

if($user_founded==1 && strcmp(trim($_SERVER["REMOTE_ADDR"]),trim($users[4]))==0){
ini_set('memory_limit','99999M');

// ������ ��� �������

function read_all_news(){
	if(file_exists("../data")){
		if(file_exists("../data/news")){
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
      ($time1[2]==$time2[2] && $time1[1] > $time2[1]) ||
      ($time1[2]==$time2[2] && $time1[1] == $time2[1] && $time1[0] > $time2[0])
	    ) ? 1 : -1;
	    }
	if(count($array)>1){
	usort($array, "sort_by_data");
    }
	for($j=0;$j<=count($array);$j++){
		$news_files_data[$i] = file_get_contents($array[$j]);
		$news_files_names[$i] = $array[$j];
		if($news_files_data[$i]{0}==0){
			$i++;
		}
	}
	if($news_files_data[$i]{0}==1){
		unset($news_files_data[$i]);
	}
		}
	}
}


switch ($action){

// ���������� �������
case 1:
	if(file_exists("../data")){
		if(file_exists("../data/news")){			$file_name = '../data/news/'.(count(glob("../data/news/*.txt"))+1).'.txt';
			$file = fopen($file_name,'w');
			fwrite($file, "0@#%\r\n");				// �������� ������������ ������� �� �������
			fwrite($file, $date."@#%\r\n");
			fwrite($file, $title."@#%\r\n");
			fwrite($file, trim($news)."@#%\r\n");
			fclose($file);
			chmod($file_name,0777);
			print('<script>window.location.replace("partyadmin.php?a=2");</script>');
		}else{print('���������� /data/<b>news</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
	}else{print('���������� /<b>data</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
break;

// ���������� ��������� � �������
case 2:
	if(file_exists("../data")){
		if(file_exists("../data/news")){
		read_all_news();
	// ��������� ���������
			$news_data = explode('@#%',$news_files_data[$num]);
			$file = fopen($news_files_names[$num],'w');
			fwrite($file, "0@#%\r\n");
			fwrite($file, $date."@#%\r\n");
			fwrite($file, str_replace("\'","'",$title)."@#%\r\n");
			fwrite($file, str_replace("\'","'",$news)."@#%\r\n");
			if(count($news_data)>5){
				for($q=4;$q<count($news_data)-1;$q++){
                	fwrite($file, trim($news_data[$q])."@#%\r\n");
				}
			}
			fclose($file);
			print('<script>window.location.replace("partyadmin.php?a=2");</script>');
		}else{print('���������� /data/<b>news</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
	}else{print('���������� /<b>data</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
break;

// �������� �������
case 3:
	if(file_exists("../data")){
		if(file_exists("../data/news")){
		read_all_news();
	// ��������� ���������
			$news_data = explode('@#%',$news_files_data[$num]);
			$file = fopen($news_files_names[$num],'w');
			fwrite($file, "1@#%\r\n");
			for($q=1;$q<count($news_data)-1;$q++){
               	fwrite($file, trim($news_data[$q])."@#%\r\n");
			}
			fclose($file);
			print('<script>window.location.replace("partyadmin.php?a=2");</script>');
		}else{print('���������� /data/<b>news</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
	}else{print('���������� /<b>data</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
break;

// ���������� ��������� � �����������
case 4:
	if(file_exists("../data")){
		if(file_exists("../data/news")){
		read_all_news();
	// ��������� ���������
			$news_data = explode('@#%',$news_files_data[$comment]);
			$file = fopen($news_files_names[$comment],'w');
			for($q=0;$q<count($news_data)-1;$q++){
				if($q!=$num){
               		fwrite($file, trim($news_data[$q])."@#%\r\n");
               	}else{
               		fwrite($file, "1#@%".$date."#@%".$title."#@%".$email."#@%".$news."@#%\r\n");
               	}
			}
			fclose($file);
			print('<script>window.location.replace("partyadmin.php?a=2&comment='.$comment.'");</script>');
		}else{print('���������� /data/<b>news</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
	}else{print('���������� /<b>data</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
break;

// �������� �����������
case 5:
	if(file_exists("../data")){
		if(file_exists("../data/news")){
		read_all_news();
	// ��������� ���������
			$news_data = explode('@#%',$news_files_data[$comment]);
			$file = fopen($news_files_names[$comment],'w');
			for($q=0;$q<count($news_data)-1;$q++){
				if($q!=$num){
               		fwrite($file, trim($news_data[$q])."@#%\r\n");
               	}
			}
			fclose($file);
			print('<script>window.location.replace("partyadmin.php?a=2&comment='.$comment.'");</script>');
		}else{print('���������� /data/<b>news</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
	}else{print('���������� /<b>data</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
break;

// �������� ������ �����������
case 6:
	if(file_exists("../data")){
		if(file_exists("../data/news")){
		read_all_news();
	// ��������� ���������
			$news_data = explode('@#%',$news_files_data[$comment]);
			$file = fopen($news_files_names[$comment],'w');
            $news_data[$num] = '1'.substr(trim($news_data[$num]),1,strlen(trim($news_data[$num])));
			for($q=0;$q<count($news_data)-1;$q++){
           		fwrite($file, trim($news_data[$q])."@#%\r\n");
			}
			fclose($file);
			print('<script>window.location.replace("partyadmin.php?a=2&comment='.$comment.'");</script>');
		}else{print('���������� /data/<b>news</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
	}else{print('���������� /<b>data</b>/ �� ������� �� �������<br><br><a href="javascript:history.back()">&lt;&lt;��������� �����</a>');}
break;

// �������� ���������� �� ����������
case 7:
	if(file_exists($num)){
		unlink($num);
		if(file_exists('../gallery_data/'.$num)){
			unlink('../gallery_data/'.$num);
		}
		if(file_exists('temp/'.$num)){
			unlink('temp/'.$num);
		}
		print('<script>window.location.replace("partyadmin.php?a=3");</script>');
	}
break;

// �������� ���������� � ���������
case 8:
	$link = 'gallery/';
	if(isset($_FILES["srs"]["tmp_name"])){
function imTranslite($str){
	static $tbl= array(
		'�'=>'a', '�'=>'b', '�'=>'v', '�'=>'g', '�'=>'d', '�'=>'e', '�'=>'g', '�'=>'z',
		'�'=>'i', '�'=>'y', '�'=>'k', '�'=>'l', '�'=>'m', '�'=>'n', '�'=>'o', '�'=>'p',
		'�'=>'r', '�'=>'s', '�'=>'t', '�'=>'u', '�'=>'f', '�'=>'i', '�'=>'e', '�'=>'A',
		'�'=>'B', '�'=>'V', '�'=>'G', '�'=>'D', '�'=>'E', '�'=>'G', '�'=>'Z', '�'=>'I',
		'�'=>'Y', '�'=>'K', '�'=>'L', '�'=>'M', '�'=>'N', '�'=>'O', '�'=>'P', '�'=>'R',
		'�'=>'S', '�'=>'T', '�'=>'U', '�'=>'F', '�'=>'I', '�'=>'E', '�'=>"yo", '�'=>"h",
		'�'=>"ts", '�'=>"ch", '�'=>"sh", '�'=>"sch", '�'=>"", '�'=>"", '�'=>"yu", '�'=>"ya",
		'�'=>"YO", '�'=>"H", '�'=>"TS", '�'=>"CH", '�'=>"SH", '�'=>"SHCH", '�'=>"", '�'=>"",
		'�'=>"YU", '�'=>"YA"
	);
    return strtr($str, $tbl);
}

function ifTranslite($str){
	static $tbl= array(
		'�', '�', '�', '�', '�', '�', '�', '�',
		'�', '�', '�', '�', '�', '�', '�', '�',
		'�', '�', '�', '�', '�', '�', '�', '�',
		'�', '�', '�', '�', '�', '�', '�', '�',
		'�', '�', '�', '�', '�', '�', '�', '�',
		'�', '�', '�', '�', '�', '�', '�', '�',
		'�', '�', '�', '�', '�', '�', '�', '�',
		'�', '�', '�', '�', '�', '�', '�', '�',
		'�', '�'
	);
	$here = 0;
	foreach($tbl as $v){
		if(eregi($v,$str)){$here = 1;}
	}
    return $here;
}

		move_uploaded_file($_FILES["srs"]["tmp_name"], $link.$_FILES["srs"]["name"]);
        $image_file_name = imTranslite($_FILES["srs"]["name"]);
		$img = ImageCreateFromJpeg($link.$_FILES["srs"]["name"]);
		if(Imagesx($img)>640){
		$resize = (640*imagesy($img))/Imagesx($img);
		$img_small = imagecreatetruecolor(640, $resize);
		Imagecopyresampled($img_small, $img, 0, 0, 0, 0, 640, $resize, Imagesx($img), imagesy($img));
		ImageJpeg($img_small, $link.$image_file_name,80);
		}

		if(file_exists('temp/gallery/'.$image_file_name)){unlink('temp/gallery/'.$image_file_name);}
		$img = ImageCreateFromJpeg($link.$image_file_name);
		$resize = (100*imagesy($img))/Imagesx($img);
		$img_small = imagecreatetruecolor(100, $resize);
		Imagecopyresampled($img_small, $img, 0, 0, 0, 0, 100, $resize, Imagesx($img), imagesy($img));
		ImageJpeg($img_small, 'temp/gallery/'.$image_file_name,80);

		if(ifTranslite($_FILES["srs"]["name"])){unlink($link.$_FILES["srs"]["name"]);}
	}
	print('<script>window.location.replace("partyadmin.php?a=3");</script>');
break;

// ���������� ���������� ����������
case 9:
//    print($check."@#%\r\n".$desc);
	$file = fopen('../gallery_data/'.$num,'w');
	fwrite($file, $check."@#%\r\n".$desc);
	fclose($file);
	print('<script>window.location.replace("partyadmin.php?a=3&page='.$page.'");</script>');
break;

// ���������� ���������� �������
case 10:
	$file = fopen("../data/access2.txt",'w');
	$data_to_write = $date.'
';
	if($news==''){
		$data_to_write .= $title.'
';
	}else{
		$data_to_write .= $news.'
';
	}
	$data_to_write .= generateDCode(50).'
';
	$data_to_write .= $num.'
';
	$data_to_write .= $check.'
';
	$data_to_write .= generateDCode(5).'
';
	fwrite($file, encode($data_to_write));
	fclose($file);
	print('<script>window.location.replace("partyadmin.php?a=4");</script>');
break;

}



}else{    print('<script>window.location.replace("http://nikpartregion.mk.ua");</script>');}

?>