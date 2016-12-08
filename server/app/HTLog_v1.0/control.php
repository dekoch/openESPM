<?php

	if($_SESSION['selecteddate'] == "")
	{
		$_SESSION['selecteddate'] = date('Y').'-'.date('m').'-'.date('d');
	}


	if($_POST['show'] == 'true')
	{
		if($_POST['date'] != '')
		{
			$_SESSION['selecteddate'] = $_POST['date'];
		}	
	}

	$file = 'devices/'.$id.'/log/'.
			date('Y', strtotime($_SESSION['selecteddate'])).'/'.
			date('m', strtotime($_SESSION['selecteddate'])).'/'.
			date('d', strtotime($_SESSION['selecteddate'])).'.csv';

?>

<form action="" method="post">
	<input type="date" name="date" value="<?php echo $_SESSION['selecteddate']; ?>" />
	<button type="submit" name="show" value="true" class="btn btn-success">show</button>
	<?php
		if(file_exists($file))
		{
			echo '<a href="'.$file.'" class="btn btn-info" role="button">Download .csv</a>';
		}
		else
		{
			echo 'no data available for this day';
		}
	?>
</form>
<!-- content/chart.php -->
<?php include 'content/chart.php'; ?>



