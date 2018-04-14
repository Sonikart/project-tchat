<?php

	session_start();
	include 'config.php';
	$site = new configuration();

	if(isset($_GET['deconnexion']))
	{
		session_unset();
		session_destroy();
		header('Location: index.php');
	}

?>
