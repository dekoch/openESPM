
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
          	</button>
			<a class="navbar-brand" href="./index.php?page=home"><?php echo $serverini['servername'] ?></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="?page=home" title="">Home</a></li>
				<!-- Control -->
				<li class="hidden-xs"><a href="?page=control" title="">Control</a></li>
				<li class="dropdown visible-xs">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Control<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="?page=control" title="">...</a></li>
						<li role="separator" class="divider"></li>
						<?php
							//print devices
							foreach($devices as $dev)
							{
								echo '<li><a href="?page=control&id='.$dev->id.'" title="">'.$dev->name.' (ID:'.$dev->id.')</a></li>';
							}
						?>
					</ul>
				</li>
				<!-- Settings -->
				<li class="hidden-xs"><a href="?page=settings" title="">Settings</a></li>
				<li class="dropdown visible-xs">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="?page=settings&content=devices" title="">Devices</a></li>
						<li><a href="?page=settings&content=applications" title="">Applications</a></li>
						<li><a href="?page=settings&content=server" title="">Server</a></li>
						<li><a href="?page=settings&content=about" title="">About</a></li>
					</ul>
				</li>
				<li><a href="?menu=logout" title="">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>
