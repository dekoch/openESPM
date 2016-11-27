
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
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
				<li><a href="?page=control" title="">Control</a></li>
				<li><a href="?page=settings" title="">Settings</a></li>
				<li><a href="?menu=logout" title="">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>
