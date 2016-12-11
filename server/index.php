<?php

	$title = 'openESPM';

	session_start();

	// types and functions
	include 'functions/types.php';
	include 'functions/ini.php';
	include 'functions/functions.php';
	

	// load server config to RAM
 	if(empty($_SESSION['serverini'])) 
	{
		$_SESSION['serverini'] = parse_ini_file('config/server.ini.php');
		//echo 'read server.ini.php';
	}

	$serverini = $_SESSION['serverini'];


	// set start page
	if(empty($_SESSION['page'])) 
	{
	  	$_SESSION['page'] = 'login';
	}

	// set start content
	if(empty($_SESSION['content'])) 
	{
  		$_SESSION['content'] = '';
	}	

	// set id
	if(empty($_SESSION['id'])) 
	{
  		$_SESSION['id'] = '';
	}


	if(empty($_SESSION['signedin'])) 
	{
  		$_SESSION['signedin'] = 'false';
	}	


	$page = $_GET['page'];

	if($page == '')
	{  
		// get last page parameter from session
		// if no page parameter is set
		$page = $_SESSION['page'];
	}
	else
	{
		// remember page parameter
		$_SESSION['page'] = $page;
	}


	$content = $_GET['content'];

	if($content == '')
	{  
		// get last content parameter from session
		// if no content parameter is set
		$content = $_SESSION['content'];
	}
	else
	{
		// remember content parameter
		$_SESSION['content'] = $content;
	}


	$id = $_GET['id'];

	if(isset($id))
	{
		$_SESSION['id'] = $id;
	}
	else
	{
		$id = $_SESSION['id'];
	}


	if($_GET['menu'] == 'logout')
	{
		if((empty($_SESSION['serverini']) == false) && ($page != 'login')) 
		{
			$serverini['lastpage'] = $page;			
			$serverini['lastcontent'] = $content;
			$serverini['lastid'] = $id;

			write_php_ini($serverini, 'config/server.ini.php');
		}

		session_destroy();

		header("Location: ?page=login");
	}


	if($_SESSION['signedin'] == 'false') 
	{
  		$page = 'login';
	}


	$title = $serverini['servername'].' - ';

	$pagepath = '';

	if($page == 'home')
	{  
		$pagepath = 'content/home.php';
		$title = $title.'Home';
	}
	else if($page == 'control')
	{  
		$pagepath = 'content/control.php';
		$title = $title.'Control';
	}
	else if($page == 'settings')
	{  
		$pagepath = 'content/settings.php';
		$title = $title.'Settings';
	}
	else
	{
		$pagepath = 'content/login.php';
		$title = $title.'Login';
	}

	$devices = list_devices();


	date_default_timezone_set($serverini['timezone']);

?>

<html>  
	<head>      
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo $title ?></title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/font-awesome.min.css">

    	<link href="css/sidebar.css" rel="stylesheet">

  	</head>
	<body>

		<?php
			echo '<!-- content/menu.php -->';
			include 'content/menu.php';

			// show PAGE and CONTENT
			echo '<!-- '.$pagepath.' -->';
			include $pagepath;
		?>

		<script type="text/javascript">
			var width = window.innerWidth;
			document.write('<iframe src="functions/interface.php?width='+width+'" style="width:0; height:0; visibility:hidden;"></iframe>');
		</script>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>

<?php

	// refresh the whole page
	if($_SESSION['refresh'] == true)
	{
		$_SESSION['refresh'] = false;

		echo '<meta http-equiv="refresh" content="0">';
	}

?>


