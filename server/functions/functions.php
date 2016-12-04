<?php  

	function begins_with($haystack, $needle)
	{
		return strpos($haystack, $needle) === 0;
	}


	function rm_rf($path)
	{
		if (@is_dir($path) && is_writable($path))
		{
		    $dp = opendir($path);
		    while ($ent = readdir($dp))
			{
		        if ($ent == '.' || $ent == '..')
				{
		            continue;
		        }
		        $file = $path . DIRECTORY_SEPARATOR . $ent;
		        if (@is_dir($file))
				{
		            rm_rf($file);
		        }
				elseif (is_writable($file))
				{
		            unlink($file);
		        }
				else
				{
		            echo $file.'is not writable and cannot be removed. Please fix the permission or select a new path.';
		        }
		    }
		    closedir($dp);
		    return rmdir($path);
		}
		else
		{
		    return @unlink($path);
		}
	}


	function list_devices()
	{
		//path to directory to scan
		$directory = 'devices/';
 
		//get all files in specified directory
		$dirs = glob($directory . '*');

		$res = array();
		//print devices
		foreach($dirs as $dir)
		{
			//check to see if the file is a directory
			if(is_dir($dir))
			{
				$dir = str_replace('devices/', '', $dir);

				$obj = new struDevice();
				$obj = get_device_info($dir);

				$res[] = $obj;
			}
		}

		return $res;
	}


	function list_applications()
	{
		//path to directory to scan
		$directory = 'app/';
		 
		//get all files in specified directory
		$dirs = glob($directory . '*');

		$res = array();
		//print devices
		foreach($dirs as $dir)
		{
			//check to see if the file is a directory
			if(is_dir($dir))
			{
				$dir = str_replace('app/', '', $dir);

				$res[] = $dir;
			}
		}

		return $res;
	}


	function get_device_info($id)
	{
		$obj = new struDevice();
		$obj->id = $id;

		$dir = 'devices/'.$id;
		$files = scandir($dir, 1);

		foreach($files as $file)
		{
			if(begins_with($file, 'name.'))
			{
				$obj->name = str_replace('name.', '', $file);
			}

			if(begins_with($file, 'application.'))
			{
				$obj->app = str_replace('application.', '', $file);
			}

			if(begins_with($file, 'category.'))
			{
				$obj->category = str_replace('category.', '', $file);
			}
		}

		return $obj;
	}


	function write_deviceinfo_ini($id)
	{
		$ini = parse_ini_file('devices/'.$id.'/info.ini.php');

		$ini['ip'] = $_SERVER['REMOTE_ADDR'];
		$date = getdate();
		$ini['lastseen'] = $date['0'];

		write_php_ini($ini, 'devices/'.$id.'/info.ini.php');
	}


	function get_layout($width)
	{
		if($width < 768)
		{
			return 'xs';
		}
		else if($width <= 991)
		{
			return 'sm';
		}
		else if($width <= 1199)
		{
			return 'md';
		}
		else
		{
			return 'ld';
		}
	}

?>
