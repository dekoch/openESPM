
<?php

	$contentini = parse_ini_file('config/content.ini.php', true);

	if($_POST['dashboardapply'] == 'true')
	{
		for ($i = 0; $i < count($contentini['dashboard_id']); $i++)
		{
			$contentini['dashboard_id'][$i] = $_POST['ContentLineID'.$i];
			$contentini['dashboard_text'][$i] = $_POST['ContentLineText'.$i];
		}

		write_php_ini($contentini, 'config/content.ini.php');
	}


	$buttontargets = '';

	for ($i = 0; $i < count($contentini['dashboard_id']); $i++)
	{
		$buttontargets = $buttontargets.',#dashboardline'.$i;
	}

?>

<div class="container-fluid">
	<form action="" method="post">
		<div class="row">
			<div class="pull-right">
				<table>
  					<tr>
						<th>
							<div id="dashboardapply" class="collapse">
								<button type="submit" name="dashboardapply" value="true" class="btn btn-success">apply</button>
							</div>
						</th>
						<th>
							<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#dashboardapply<?php echo $buttontargets; ?>">
								<i class="fa fa-wrench" aria-hidden="true"></i>
							</button>
						</th>
					</tr>
				</table>
			</div>
		  	<div>
				<?php
					$dashboardline = 0;

					foreach($contentini['dashboard_id'] as $content)
					{
						if($contentini['dashboard_text'][$dashboardline] != '')
						{
							echo '<h3 class="page-header">'.$contentini['dashboard_text'][$dashboardline].'</h3>';
						}

						echo '<div id="dashboardline'.$dashboardline.'" class="collapse">';
							echo '<input type="text" name="ContentLineText'.$dashboardline.'" value="'.$contentini['dashboard_text'][$dashboardline].'" /><br>';

							echo '<select id="cmbContentLineID'.$dashboardline.'" name="ContentLineID'.$dashboardline.'">';

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

						// show selected content
						if($content == 'serverstats')
						{  
							include 'content/dashboard/serverstats.php';
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

									echo '<h4>'.$obj->name.' (ID: '.$obj->id.')</h4>';
									echo '<!-- app/'.$obj->app.'/control.php -->';
									include 'app/'.$obj->app.'/control.php';
								}
							}
						}

						$dashboardline += 1;
					}
				?>
			</div>
	  	</div>
	</form>
</div>

