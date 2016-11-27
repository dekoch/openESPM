<?php  

	function read_csv($file)
	{
		$array = array();

		if(file_exists($file))
		{
			$csvData = file_get_contents($file);
			$lines = explode(PHP_EOL, $csvData);
			
			foreach ($lines as $line)
			{
				$array[] = str_getcsv($line, ',');
			}
		}

		return $array;
	}

?>



