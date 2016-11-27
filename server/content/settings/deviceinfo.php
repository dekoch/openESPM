<?php  

	if($id != '')
	{
		$obj = new struDevice();
		$obj = get_device_info($id);


		if($_POST['rename'] == 'true')
		{
			if($_POST['newdevicename'] != '')
			{
				rename('devices/'.$id.'/name.'.$obj->name, 'devices/'.$id.'/name.'.$_POST['newdevicename']);			
			}
		}

		if($_POST['delete'] == 'true')
		{
			rm_rf('devices/'.$id);
		}

		if($_POST)
		{
			// refresh page
			header("Location: ?id=".$id);
		}


		$deviceini = parse_ini_file('devices/'.$id.'/info.ini.php');
	}

?>

<form action="" method="post">

	Devicename: <input type="text" name="newdevicename" value="<?php echo $obj->name; ?>" />
	
	<button type="submit" name="rename" value="true" class="btn btn-success">
		<i class="fa fa-check-square" aria-hidden="true"></i> rename
	</button>

	<button type="submit" name="delete" value="true" class="btn btn-danger">delete</button>
</form>

Info:
<br>
<!-- collapse info, if logrequest is off -->
<div <?php if($serverini['logrequest'] == 'off'){echo 'class="collapse"';}?>>
	<?php
		echo 'Last seen: '.date('Y-m-d H:i:s', $deviceini['lastseen']).'<br>';
		echo 'IP: '.$deviceini['ip'].'<br>';
	?>
</div>

<?php 
	$requesturl = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/request.php?id='.$id;
	echo 'Request URL: ';	
	echo '<a href='.$requesturl.' target="_blank">'.$requesturl.'</a><br>';

	echo 'Application: '.$obj->app.'<br>';
	echo 'Description: ';
	echo '<!-- app/'.$obj->app.'/description.php -->';
	include 'app/'.$obj->app.'/description.php';
	echo $appDescriptionSimple;
	echo '<br>';
?>



