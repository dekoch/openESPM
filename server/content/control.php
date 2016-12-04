<?php  

	if($id != '')
	{
		$appinipath = 'devices/'.$id.'/app.ini.php';
		$appini = parse_ini_file($appinipath);

		$obj = new struDevice();
		$obj = get_device_info($id);
	}

?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<?php
					//print devices
					foreach($devices as $dev)
					{
						echo '<li><a href="?id='.$dev->id.'" title=""><b>'.$dev->name.'</b> '.$dev->app.'<br>'.
								'(ID: '.$dev->id.')</a></li>';
					}

				?>
			</ul> 
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" <?php if($id == ''){echo 'style="visibility:hidden"';} ?>>
			<?php
				if($id != '')
				{
					if(is_dir('devices/'.$id))
					{
						echo '<h3 class="page-header">'.$obj->name.' (ID: '.$obj->id.')</h3>';
						echo '<!-- app/'.$obj->app.'/control.php -->';
						include 'app/'.$obj->app.'/control.php';
					}
				}
			?>
		</div>
	</div>
</div>


