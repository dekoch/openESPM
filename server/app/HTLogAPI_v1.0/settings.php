<?php  

	if($id != '')
	{
		$appinipath = 'devices/'.$id.'/app.ini.php';

		$appini = parse_ini_file($appinipath);

		if($_POST['apply'] == 'true')
		{
			$appini['device'] = $_POST['selecedDevice'];

			write_php_ini($appini, $appinipath);
		}
	}

?>

Settings:
<form action="" method="post">
	Device mapping: <select id="cmbDevices" name="selecedDevice" >
						<?php
							echo '<option value="" ';
							if($appini['device'] == '')
							{
								echo 'selected';
							}
							echo '></option>';

							foreach($devices as $dev)
							{
								// list compatible devices
								if(strlen(stristr($dev->app, 'HTLog_v1.0')) > 0)
								{
									echo '<option value="'.$dev->id.'" ';
									if($appini['device'] == $dev->id)
									{
										echo 'selected';
									}
									echo '>'.$dev->name.' (ID: '.$dev->id.')</option>';
								}
							}
						?>
					</select>
	<br>
	<br>
	<button type="submit" name="apply" value="true" class="btn btn-success">apply</button>
</form>


