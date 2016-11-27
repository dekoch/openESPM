<?php  

	if($_POST['add'] == 'true')
	{
		if($_POST['devicename'] != '')
		{
			$uniqid = uniqid();

			if(mkdir('devices/'.$uniqid, 0777, true))
			{
				$newfile = fopen('devices/'.$uniqid.'/name.'.$_POST['devicename'], 'w');
				fclose($newfile);

$data = ';<?php
;die(); // For further security
;/*

ip = ""
lastseen = ""

;*/

;?>';
				file_put_contents('devices/'.$uniqid.'/info.ini.php', $data, FILE_APPEND);


				$newfile = fopen('devices/'.$uniqid.'/application.'.$_POST['app'], 'w');
				fclose($newfile);

				copy('app/'.$_POST['app'].'/app.ini.php', 'devices/'.$uniqid.'/app.ini.php');


				$id = $uniqid;
				header("Location: ?id=".$uniqid);
			}
			else
			{
				die('error: can not create directory...');
			}
		}
	}


	$apps = list_applications();

?>

<form action="" method="post">
	Application: <select id="cmbApp" name="app" >
					<?php
						foreach($apps as $app)
						{
							echo '<option value="'.$app.'">'.$app.'</option>';
						}
					?>
				</select>

	Devicename: <input type="text" name="devicename" />
	
	<button type="submit" name="add" value="true" class="btn btn-success">
		<i class="fa fa-check-square" aria-hidden="true"></i> add
	</button>
</form>

Devices:</br>

<?php

	$devices = list_devices();
	//print devices
	foreach($devices as $dev)
	{
		echo '<a href="?id='.$dev->id.'" title=""><b>'.$dev->name.'</b> (ID: '.$dev->id.')</a></br>';
	}

	echo '<br>';


	if($id != '')
	{
		//echo $device.'<br>';

		if(is_dir('devices/'.$id))
		{
			$obj = new struDevice();
			$obj = get_device_info($id);

			echo '<h3 class="page-header">'.$obj->name.' (ID: '.$id.')</h3>';	

			echo '<!-- app/'.$obj->app.'/settings.php -->';
			include 'app/'.$obj->app.'/settings.php';

			echo '<hr>';

			echo '<!-- content/settings/deviceinfo.php -->';
			include 'deviceinfo.php';
		}
	}

?>
