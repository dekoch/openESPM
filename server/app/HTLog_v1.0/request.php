<?php

	$date = getdate();
	$unixtime = $date['0'];


	if($appini['interval'] == $appini['lastinterval'])
	{
		$difseen = $unixtime - $appini['lastseen'];
		//echo $difseen.'\r\n';

		$difinterval = $appini['lastseen'] + $appini['interval'] * 60;
		$difinterval = $unixtime - $difinterval;
		//echo $difinterval.'\r\n';

		if($difinterval < 0)
		{
			$appini['intervaloffset'] += 1;
		}
		else
		{
			$appini['intervaloffset'] -= 1;
		}


		$newinterval = $appini['interval'] * 60;

		$newinterval = $newinterval + $appini['intervaloffset'];
	}
	else
	{
		$appini['lastinterval'] = $appini['interval'];
		$newinterval = $appini['interval'] * 60;
	}

	// json
	echo '{"interval":"'.$newinterval.'"}';

	if(($_GET['ctemp'] == '') || ($_GET['ftemp'] == '') || ($_GET['humidity'] == ''))
	{
		include_once 'functions/log.php';
		write_error_log($id, $obj->app, 'One parameter is not set', $_SERVER['REQUEST_URI']);
	}
	else
	{
		$serverini = parse_ini_file('config/server.ini.php');
		date_default_timezone_set($serverini['timezone']);

		$dir = 'devices/'.$id.'/log/'.date('Y').'/'.date('m');

		if(is_dir($dir) == false)
		{
			mkdir($dir, 0777, true);
		}

		$cTemp = str_replace(',', '.', $_GET['ctemp']);
		$fTemp = str_replace(',', '.', $_GET['ftemp']);
		$humidity = str_replace(',', '.', $_GET['humidity']);

		$data = $unixtime.','.$cTemp.','.$fTemp.','.$humidity."\r\n";

		$file = fopen($dir.'/'.date('d').'.csv', 'a') or die("can't open file");
		fwrite($file, $data);
		fclose($file);
	}

	$appini['lastseen'] = $unixtime;

	write_php_ini($appini, $appinipath);

?>
