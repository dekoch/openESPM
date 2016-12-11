<?php

	if(!empty($_GET['width']))
	{
		session_start();

		$_SESSION['width'] = $_GET['width'];;
	}

?>
