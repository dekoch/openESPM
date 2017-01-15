<?php  

	if($id != '')
	{
		$obj = new struDevice();
		$obj = get_device_info($id);

		$deviceini = parse_ini_file('devices/'.$id.'/info.ini.php');


		$protectionIniPath = 'devices/'.$id.'/protection.ini.php';

		if(file_exists($protectionIniPath) == true)
		{
			$protectionIni = parse_ini_file($protectionIniPath);

			$protection = $_GET['protection'];

			if($protection != '')
			{
				if($protection == 'on')
				{  
					$protectionIni['protection'] = 'on';
				} 
				else if($protection == 'off')
				{  
					$protectionIni['protection'] = 'off';
				}

				write_php_ini($protectionIni, $protectionIniPath);
			}
		}
		else
		{
			$protectionIni['protection'] = 'off';

			$bytes = openssl_random_pseudo_bytes(16, $cstrong);
			$hex   = bin2hex($bytes);
			$protectionIni['key'] = $hex;

			write_php_ini($protectionIni, $protectionIniPath);
		}



		if($protectionIni['protection'] == 'on')
		{
			$protectionText = 'on';

			$protectionButton = '<a href="?protection=off"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></a>';
		}
		else
		{
			$protectionText = 'off';

			$protectionButton = '<a href="?protection=on"><i class="fa fa-toggle-off fa-2x" aria-hidden="true"></i></a>';
		}



		switch ($_POST['btnDeviceInfo'])
		{
			case 'rename':
				if($_POST['newdevicename'] != '')
				{
					rename('devices/'.$id.'/name.'.$obj->name, 'devices/'.$id.'/name.'.$_POST['newdevicename']);	

					$_SESSION['refresh'] = true;		
				}
				break;

			case 'renewKey':
				$bytes = openssl_random_pseudo_bytes(16, $cstrong);
				$hex   = bin2hex($bytes);

				$protectionIni['key'] = $hex;

				write_php_ini($protectionIni, $protectionIniPath);
				break;

			case 'delete':
				rm_rf('devices/'.$id);

				$_SESSION['refresh'] = true;
				break;
		}
	}

?>

<form action="" method="post">

	Devicename: <input type="text" name="newdevicename" value="<?php echo $obj->name; ?>" />
	
	<button type="submit" name="btnDeviceInfo" value="rename" class="btn btn-success">
		<i class="fa fa-check-square" aria-hidden="true"></i> rename
	</button>

	<button type="submit" name="btnDeviceInfo" value="delete" class="btn btn-danger">delete</button>
</form>
<br>
Protection:
<table>
	<tr>
		<td width="30"><h4><p class="text-right"><?php echo $protectionText; ?></p></h4></td>
		<td width="10"></td>
		<td>
			<?php echo $protectionButton; ?>
		</td>
	</tr>
</table>

<table>
	<tr>
		<td>Private Key:</td>
		<td width="10"></td>
		<td>
			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#showPrivateKey,#showRenewKey" title="show">
				<i class="fa fa-eye" aria-hidden="true"></i>
			</button>
		</td>
		<td width="30"></td>
		<td>
			<div id="showPrivateKey" class="collapse">
				<?php echo $protectionIni['key']; ?>
			</div>
		</td>
		<td width="30"></td>
		<td>
			<div id="showRenewKey" class="collapse">
				<form action="" method="post">
					<button type="submit" name="btnDeviceInfo" value="renewKey" title="renew key" class="btn btn-danger">
						<i class="fa fa-refresh" aria-hidden="true"></i>
					</button>
				</form>
			</div>
		</td>
	</tr>
</table>
<br>
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



