<?php  

	function write_error_log($id, $app, $error, $text)
	{
		$date = getdate();
		$unixtime = $date['0'];

		$serverini = parse_ini_file('config/server.ini.php');
		date_default_timezone_set($serverini['timezone']);

		$dir = 'log/'.date('Y').'/'.date('m');

		if(is_dir($dir) == false)
		{
			mkdir($dir, 0777, true);
		}


		$id = htmlspecialchars($id);
		$id = str_replace(',', '.', $id);

		$app = str_replace(',', '.', $app);

		$error = str_replace(',', '.', $error);

		$text = htmlspecialchars($text);
		$text = str_replace(',', '.', $text);

		$data = $unixtime.','.$_SERVER['REMOTE_ADDR'].','.$id.','.$app.','.$error.','.$text."\r\n";

		$file = fopen($dir.'/'.date('d').'.csv', 'a') or die("can't open file");
		fwrite($file, $data);
		fclose($file);
	}

?>



