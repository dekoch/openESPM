<?php  

	$appinipath = 'devices/'.$id.'/app.ini.php';
	$appini = parse_ini_file($appinipath);

	if($id == $_GET['id'])
	{
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
	}


	if($appini['switch'] == 'on')
	{
		$switchtext = 'on';

		$switchbutton = '<a href="?id='.$id.'&switch=off"><i class="fa fa-toggle-on fa-2x" aria-hidden="true"></i></a>';
	}
	else
	{
		$switchtext = 'off';

		$switchbutton = '<a href="?id='.$id.'&switch=on"><i class="fa fa-toggle-off fa-2x" aria-hidden="true"></i></a>';
	}


?>

<table>
  <tr>
	<td width="30"><h4><p class="text-right"><?php echo $switchtext; ?></p></h4></td>
	<td width="10"></td>
	<td>
		<form action="" method="post">
			<?php echo $switchbutton; ?>
		</form>
	</td>
  </tr>
</table>


