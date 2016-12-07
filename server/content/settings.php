
<?php

	$contentPath = 'content/settings/';

	$buttonApply = false;


	if($content == 'server')
	{  
		$contentPath = $contentPath.'server.php';
		$contentTitle = 'Server';
		$buttonApply = true;
	}
	else if($content == 'applications')
	{
		$contentPath = $contentPath.'applications.php';
		$contentTitle = 'Applications';
	}
	else if($content == 'about')
	{
		$contentPath = $contentPath.'about.php';
		$contentTitle = 'About';
	}
	else
	{  
		$contentPath = $contentPath.'devices.php';
		$contentTitle = 'Devices';
	}

?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li><a href="?content=devices" title="">Devices</a></li>
				<li><a href="?content=applications" title="">Applications</a></li>
				<li><a href="?content=server" title="">Server</a></li>
				<li><a href="?content=about" title="">About</a></li>
			</ul> 
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<form action="" method="post">
				<h3 class="page-header">
					Settings  :  <?php echo $contentTitle; ?>
					<?php
						if($buttonApply == true)
						{ 
							echo 	
								'<br><br>
								<button type="submit" name="settingsapply" value="true" class="btn btn-success">
									<i class="fa fa-check-square" aria-hidden="true"></i> apply
							 	</button>';
						}
					?>
				</h3>
		
				<?php
					echo '<!-- '.$contentPath.' -->';
					include $contentPath;
				?>

			</form>	
		</div>
	</div>
</div>

