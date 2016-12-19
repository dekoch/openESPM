
<?php

	$contentini = parse_ini_file('config/content.ini.php', true);

	if($_POST['homeapply'] == 'true')
	{
		for ($i = 0; $i < count($contentini['home']); $i++)
		{
			$contentini['home'][$i] = $_POST['ContentLine'.$i];
		}

		write_php_ini($contentini, 'config/content.ini.php');
	}


	$buttontargets = '';

	for ($i = 0; $i < count($contentini['home']); $i++)
	{
		$buttontargets = $buttontargets.',#homeline'.$i;
	}

?>

<div class="container-fluid">
	<form action="" method="post">
		<div class="row">
			<div class="pull-right">
				<table>
  					<tr>
						<th>
							<div id="homeapply" class="collapse">
								<button type="submit" name="homeapply" value="true" class="btn btn-success">apply</button>
							</div>
						</th>
						<th>
							<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#homeapply<?php echo $buttontargets; ?>">
								<i class="fa fa-wrench" aria-hidden="true"></i>
							</button>
						</th>
					</tr>
				</table>
			</div>
		  	<div>
				<?php
					$homeLine = 0;

					foreach($contentini['home'] as $content)
					{
						echo '<div id="homeline'.$homeLine.'" class="collapse">';
							echo '<select id="cmbContentLine'.$homeLine.'" name="ContentLine'.$homeLine.'">';

								echo '<option value="" ';
								if($content == '')
								{
									echo 'selected';
								}
								echo '></option>';

								echo '<option value="serverstats" ';
								if($content == 'serverstats')
								{
									echo 'selected';
								}
								echo '>Server Statistics</option>';

								foreach($devices as $dev)
								{
									// list devices
									echo '<option value="'.$dev->id.'" ';
									if($content == $dev->id)
									{
										echo 'selected';
									}
									echo '>'.$dev->name.' (ID: '.$dev->id.')</option>';
								}

							echo '</select>';
						echo '</div><br>';

						if($content == 'serverstats')
						{  
							include 'content/home/serverstats.php';
						}
						else
						{
							if($content != '')
							{
								$id = $content;

								if(is_dir('devices/'.$id))
								{
									$obj = new struDevice();
									$obj = get_device_info($id);

									echo '<h3 class="page-header">'.$obj->name.' (ID: '.$obj->id.')</h3>';
									echo '<!-- app/'.$obj->app.'/control.php -->';
									include 'app/'.$obj->app.'/control.php';
								}
							}
						}

						if($content != '')
						{
							echo '<hr>';
						}

						$homeLine += 1;
					}
				?>
			</div>
	  	</div>
	</form>
</div>

