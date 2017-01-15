<?php

	// types and functions
	include 'functions/types.php';
	include 'functions/ini.php';
	include 'functions/functions.php';
	

	$id = $_GET['id'];

	$error = '';

	for ($i = 0; $i <= 10; $i++)
	{
		if($error == '')
		{
			switch ($i)
			{
				case 0:
					if($id == '')
					{
						$error = 'ID is not set. Please add "?id=device id" to url.';
						header("HTTP/1.0 470 ID not set");
					}
					break;

				case 2:
					if(is_dir('devices/'.$id) == false)
					{
						$error = 'Device configuration for "'.$id.'" is not present! Please check your configuration.';
						header("HTTP/1.0 472 Device configuration not present");
					}
					break;

				case 4:
					$protectionIniPath = 'devices/'.$id.'/protection.ini.php';

					if(file_exists($protectionIniPath) == true)
					{
						$protectionIni = parse_ini_file($protectionIniPath);

						if($protectionIni['protection'] == 'on')
						{
							if($protectionIni['key'] != $_GET['key'])
							{
								$error = 'Wrong private key "'.$_GET['key'].'"! Please check your configuration.';
								header("HTTP/1.0 474 Wrong private key");
							}
						}
					}
					break;

				case 6:
					$serverIni = parse_ini_file('config/server.ini.php');

					$serverini = $serverIni;

					if($serverIni['logrequest'] == 'on')
					{
						write_deviceinfo_ini($id);
					}					
					break;
						
				case 8:
					$obj = new struDevice();
					$obj = get_device_info($id);
					break;

				case 10:
					if(is_dir('app/'.$obj->app))
					{
						$appIniPath = 'devices/'.$id.'/app.ini.php';
						$appIni = parse_ini_file($appIniPath);

						$appinipath = $appIniPath;
						$appini = $appIni;

						include 'app/'.$obj->app.'/request.php';
					}
					else
					{
						$error = 'App "'.$obj->app.'" is not present! Please check your configuration.';
						header("HTTP/1.0 480 App not present");
					}			
					break;

			}
		}
	}


	if($error != '')
	{
		echo $error;

		include_once 'functions/log.php';
		write_error_log($id, 'server (request.php)', $error, $_SERVER['REQUEST_URI']);
	}

	
?>
