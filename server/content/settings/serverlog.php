
<?php

	if($_SESSION['selecteddate'] == "")
	{
		$_SESSION['selecteddate'] = date('Y').'-'.date('m').'-'.date('d');
	}


	if($_POST['date'] != '')
	{
		if($_POST['show'] == 'true')
		{
			$_SESSION['selecteddate'] = $_POST['date'];	
		}
	}


	$file = 'log/'.
			date('Y', strtotime($_SESSION['selecteddate'])).'/'.
			date('m', strtotime($_SESSION['selecteddate'])).'/'.
			date('d', strtotime($_SESSION['selecteddate'])).'.csv';


	if($_POST['delete'] == 'true')
	{
		if(file_exists($file))
		{
			unlink($file);	
		}
	}

?>

<h3>Log:</h3>

<form action="" method="post">
	<input type="date" name="date" value="<?php echo $_SESSION['selecteddate']; ?>" />
	<button type="submit" name="show" value="true" class="btn btn-success">show</button>
	<?php
		if(file_exists($file))
		{
			echo '<a href="'.$file.'" class="btn btn-info" role="button">Download .csv</a> ';
			echo '<button type="submit" name="delete" value="true" class="btn btn-danger">Delete</button>';
		}
		else
		{
			echo 'no data available for this day';
		}
	?>
</form>

<table class="table">
	<thead>
		<tr>
			<th>Time</th>
			<th>IP</th>
			<th>Device ID</th>
			<th>App</th>
			<th>Error</th>
			<th>Parameter</th>
		</tr>
	</thead>
	<tbody>
		<?php
			include_once './functions/csv.php';

			$array = read_csv($file);

			foreach ($array as $set)
			{
				if($set[0] != 0)
				{
					echo '<tr>';
					// time
					echo '<td>'.date('H:i:s', $set[0]).'</td>';
					// ip
					echo '<td>'.$set[1].'</td>';
					// app
					echo '<td>'.$set[2].'</td>';
					// device id
					echo '<td>'.htmlspecialchars($set[3]).'</td>';
					// error
					echo '<td>'.$set[4].'</td>';
					// parameter
					echo '<td>'.htmlspecialchars($set[5]).'</td>';
					echo '</tr>';
				}
			}
		?>
	</tbody>
</table>

