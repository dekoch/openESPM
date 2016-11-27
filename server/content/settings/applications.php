<?php

	$apps = list_applications();

	$count = 0;

	foreach($apps as $app)
	{
		echo '<h3>'.$app.'</h3>';

		echo '<!-- app/'.$app.'/description.php -->';
		include 'app/'.$app.'/description.php';
		echo $appDescriptionSimple;
		echo '<br>';
		echo '<br>';
		echo $appDescriptionFull;
		echo '<br>';
		echo '<br>';
		echo 'Website: <a href="'.$appUrl.'" target="_blank">'.$appUrl.'</a>';
		echo '<br>';
		echo 'Developer: '.$appDeveloper;
		echo '<br>';

?>

		<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#changelog<?php echo $count; ?>">Changelog</button>
		<div id="changelog<?php echo $count; ?>" class="collapse">
			<?php echo $appChangelog; ?>
		</div>
		<hr>

<?php
		$count += 1;
	}
?>

