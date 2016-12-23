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
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Devicename</th>
				<th>Application</th>
				<th>ID</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				//print devices
				foreach($devices as $dev)
				{
					echo '<tr><td>'.$dev->name.'</td><td>'.$dev->app.'</td><td>'.$dev->id.'</td>';
					echo '<td><a href="?id='.$dev->id.'" title="edit"><i class="fa fa-wrench" aria-hidden="true"></i></a></td></tr>';
				}
			?>
		</tbody>

		<thead>
			<tr>
				<th>API Devicename</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$apidevices = list_api_devices();

				//print API devices
				foreach($apidevices as $dev)
				{
					echo '<tr><td>'.$dev->name.'</td><td>'.$dev->app.'</td><td>'.$dev->id.'</td>';
					echo '<td><a href="?id='.$dev->id.'" title=""><i class="fa fa-wrench" aria-hidden="true"></i></a></td></tr>';
				}
			?>
		</tbody>

		<thead>
			<tr>
				<th>new Devicename</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" name="devicename" /></td>
				<td>
					<select id="cmbApp" name="app" >
						<?php
							foreach($apps as $app)
							{
								echo '<option value="'.$app.'">'.$app.'</option>';
							}
						?>
					</select>
				</td>
				<td></td>
				<td>
					<button type="submit" name="add" value="true" title="add">
						<i class="fa fa-plus" aria-hidden="true"></i>
					</button>
				</td>
			</tr>
		</tbody>
	</table>
</form>

<?php

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
