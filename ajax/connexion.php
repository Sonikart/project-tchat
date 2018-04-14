<?php

	include '../handler/string.php';

	$verification 	= array('username', 'password');
	$error 			= '';

	for ($i = 0; $i < count($verification); $i++)
	{
		if(empty($_POST[$verification[$i]]))
		{
			$error .= $verification[$i].', ';
		}

		if(!isset($_POST[$verification[$i]]))
		{
			$error .= $verification[$i].', ';
		}
	}

	if(empty($error))
	{
		$verification = $site->bdd->query('SELECT * FROM utilisateurs WHERE username = "'.$site->security($_POST['username']).'" AND password = "'.md5($_POST['password']).'"');
		if($verification->rowCount() != 0)
		{
			$_SESSION['start_login']    = 1;
            $_SESSION['username']       = $site->security($_POST['username']);
            $_SESSION['arrivage']       = time();

			$status		= 'success';
			$message	= 'Vous êtes connecté, redirection en cours... <META http-equiv="refresh" content="3; URL=index.php">';

			$verif_writing_exist = $site->bdd->query('SELECT * FROM writing WHERE username = "'.$site->security($_SESSION['username']).'"');
			if($verif_writing_exist->rowCount() != 1)
			{
				$add_writing = $site->bdd->prepare('INSERT INTO writing (username, messaging, date_at) VALUES (:username, :messaging, :date_at)');
				$add_writing->execute(array(
					'username'	=> $site->security($_SESSION['username']),
					'messaging'	=> '0',
					'date_at'	=> time()
				));
			}
		}
		else
		{
			$status		= 'error';
			$message	= 'La combinaison username / password est incorrecte.';
		}
	}
	else
	{
		$status		= 'error';
		$message	= 'Veuillez remplir les champs: '.substr($error, 0, -2).'.';
	}

	die(json_encode(array('status' => $status, 'message' => $message)));

?>