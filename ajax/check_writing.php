<?php

	include '../handler/string.php';

	if(isset($_SESSION['start_login']))
	{
		if(!isset($_GET['no']))
		{
			$query = $site->bdd->query('SELECT * FROM writing WHERE username = "'.$site->security($_SESSION['username']).'"');

			if($query->rowCount() != 0)
			{
				$site->bdd->query('UPDATE writing SET messaging = 1 WHERE username = "'.$site->security($_SESSION['username']).'"');
			}
		}
		else
		{
			$site->bdd->query('UPDATE writing SET messaging = 0 WHERE username = "'.$site->security($_SESSION['username']).'"');
		}	
	}

?>