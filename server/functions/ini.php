<?php  

	function write_php_ini($array, $file)
	{
		//echo $file;

		$res = array();
		foreach($array as $key => $val)
		{
		    if(is_array($val))
		    {
		        $res[] = "[$key]";
		        foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
		    }
		    else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
		}

		$str = implode("\r\n", $res);

		//echo $str;

$str = ";<?php
;die(); // For further security
;/*\r\n\r\n" . 
$str .
"\r\n
;*/\r\n
;?>";

		safefilerewrite($file, $str);
	}


	function safefilerewrite($fileName, $dataToSave)
	{    
		if ($fp = fopen($fileName, 'w'))
		{
		    $startTime = microtime(TRUE);
		    do
		    {            $canWrite = flock($fp, LOCK_EX);
		       // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
		       if(!$canWrite) usleep(round(rand(0, 100)*1000));
		    } while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

		    //file was locked so now we can store information
		    if ($canWrite)
			{
             	fwrite($fp, $dataToSave);
		        flock($fp, LOCK_UN);
		    }
		    fclose($fp);
		}
	}

?>



