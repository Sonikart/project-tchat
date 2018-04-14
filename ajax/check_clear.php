<?php

	include '../handler/string.php';

	$query = $site->bdd->query('SELECT * FROM messages');

	if($query->rowCount() == 0)
	{
		die(json_encode(array('status' => 'success')));
	}
	else
	{
		die(json_encode(array('status' => 'error')));
	}

?>