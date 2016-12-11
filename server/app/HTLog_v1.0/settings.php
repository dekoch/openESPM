<?php  

	if($id != '')
	{
		$appinipath = 'devices/'.$id.'/app.ini.php';

		$appini = parse_ini_file($appinipath);

		if($_POST['apply'] == 'true')
		{
			if($_POST['interval'] != '')
			{
				$interval = $_POST['interval'];
				$interval = htmlspecialchars($interval);

				if(ctype_digit($interval))
				{
					$appini['interval'] = $interval;
				}	
			}

			if($_POST['tempUnit'] != '')
			{
				$appini['tempunit'] = $_POST['tempUnit'];
			}

			write_php_ini($appini, $appinipath);
		}
	}

?>

Settings:
<form action="" method="post">
	Interval:
	<input type="text" name="interval" value="<?php echo $appini['interval'] ?>" />
	<br>
	Temperature Unit:
	<select id="cmbTempUnit" name="tempUnit">
		<option <?php if($appini['tempunit'] == '°C'){echo 'selected'; }?>>°C</option>
		<option <?php if($appini['tempunit'] == 'F'){echo 'selected'; }?>>F</option>
	</select>
	<br>
	<br>
	<button type="submit" name="apply" value="true" class="btn btn-success">apply</button>
</form>


