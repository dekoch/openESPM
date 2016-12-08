<?php

	$error = '';

	for ($i = 0; $i <= 4; $i++)
	{
		if($error == '')
		{
			switch ($i)
			{
				case 0:
					if(($_GET['outputformat'] == '') || ($_GET['value'] == ''))
					{
						$error = 'One parameter is not set';
					}
					break;

				case 1:
					if(is_dir('devices/'.$appini['device']) == false)
					{
						$error = 'Mapped device "'.$appini['device'].'" not found';
					}
					break;

				case 2:
				  	// check device app
					$objdev = new struDevice();
					$objdev = get_device_info($appini['device']);

					if($objdev->app != 'HTLog_v1.0')
					{
						$error = 'Unsupported app "'.$objdev->app.'"';
					}
					break;

				case 3:
					// search latest CSV
					$date = getdate();
					$unixtime = $date['0'];

					$serverini = parse_ini_file('config/server.ini.php');
					date_default_timezone_set($serverini['timezone']);

					$file = 'devices/'.$appini['device'].'/log/'.
							date('Y', $unixtime).'/'.
							date('m', $unixtime).'/'.
							date('d', $unixtime).'.csv';

					if(file_exists($file) == false)
					{
						$error = 'Requested date "'.$file.'" is not available';
					}
					break;

				case 4:
					// output
					include_once './functions/csv.php';

					$array = read_csv($file);

					$index = count($array) - 2;


					if(($_GET['outputformat'] == 'text') || $_GET['outputformat'] == 'html')
					{
						if($_GET['outputformat'] == 'html')
						{
							echo '<html><body>';
						}


						if($_GET['value'] == 'all')
						{
							print $array[$index][0].',';
							print $array[$index][1].',';
							print $array[$index][2].',';
							print $array[$index][3].',';
							print date('H:i:s', $array[$index][0]);
						}
						else if($_GET['value'] == 'unixtime')
						{
							print $array[$index][0];
						}
						else if($_GET['value'] == 'time')
						{
							print date('H:i:s', $array[$index][0]);
						}
						else if($_GET['value'] == 'ctemp')
						{
							print $array[$index][1];
						}
						else if($_GET['value'] == 'ftemp')
						{
							print $array[$index][2];
						}
						else if($_GET['value'] == 'humidity')
						{
							print $array[$index][3];
						}


						if($_GET['outputformat'] == 'html')
						{
							echo '</body></html>';
						}
					}
					else
					{
						$error = 'Unsupported format "'.$_GET['outputformat'].'"';
					}
					break;

			}
		}
	}

	if($error != '')
	{
		echo $error;

		include_once 'functions/log.php';
		write_error_log($id, $obj->app, $error, $_SERVER['REQUEST_URI']);
	}

?>
