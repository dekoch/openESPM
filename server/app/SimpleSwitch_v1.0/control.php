<?php  

	$appinipath = 'devices/'.$id.'/app.ini.php';
	$appini = parse_ini_file($appinipath);


	$switch = $_GET['switch'];

	if($switch == 'on')
	{  
		$appini['switch'] = 'on';
	} 
	else if($switch == 'off')
	{  
		$appini['switch'] = 'off';
	}

	write_php_ini($appini, $appinipath);

?>

<form action="" method="post">
	<a href="?switch=on" class="btn btn-success btn-block btn-lg">Turn On</a>
	<br>
	<a href="?switch=off" class="led btn btn-danger btn-block btn-lg">Turn Off</a>
	<br>
	<div class="light-status well" style="margin-top: 5px; text-align:center">
		<?php
			if($appini['switch'] == 'on')
			{
				echo 'ON';
			}
			else if ($appini['switch'] == 'off')
			{
				echo 'OFF';
			}
			else
			{
				echo 'Do something.';
			}
		?>
	</div>

</form>	



