<?php

	// types and functions
	include 'functions/types.php';
	include 'functions/ini.php';
	include 'functions/functions.php';
	

	$id = $_GET['id'];

	if($id != '')
	{
		if(is_dir('devices/'.$id))
		{
			$serverini = parse_ini_file('config/server.ini.php');

			if($serverini['logrequest'] == 'on')
			{
				write_deviceinfo_ini($id);
			}


			$appinipath = 'devices/'.$id.'/app.ini.php';
			$appini = parse_ini_file($appinipath);

			$obj = new struDevice();
			$obj = get_device_info($id);

			include 'app/'.$obj->app.'/request.php';
		}
		else
		{
			echo 'Device "'.$id.'" is not present!
			Please check your configuration.';

			include_once 'functions/log.php';
			write_error_log($id, 'server', 'Device is not present', $_SERVER['REQUEST_URI']);
		}
	}
	else
	{
		echo 'ID is not set.
		Please add "?id=device id" to url.';

		include_once 'functions/log.php';
		write_error_log($id, 'server', 'ID is not set', $_SERVER['REQUEST_URI']);
	}
	
?>
