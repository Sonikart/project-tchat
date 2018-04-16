<?php 

	include '../handler/string.php';

	if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['re-password']))
	{
		$verif_username = $site->bdd->query('SELECT * FROM utilisateurs WHERE username = "'.$site->security($_POST['username']).'"');
		if($verif_username->rowCount() != 1)
		{
			$verif_email = $site->bdd->query('SELECT * FROM utilisateurs WHERE email = "'.$site->security($_POST['email']).'"');
			if($verif_email->rowCount() != 1)
			{
				$add_user = $site->bdd->prepare('INSERT INTO utilisateurs (username, password, email, rank, avatar, position, color) VALUES (:username, :password, :email, :rank, :avatar, :position, :color)');
				$add_user->execute(array(
					'username'	=> $site->security($_POST['username']),
					'password'	=> md5($site->security($_POST['password'])),
					'email'		=> $site->security($_POST['email']),
					'rank'		=> 2,
					'avatar'	=> 'https://upload.wikimedia.org/wikipedia/commons/f/f4/User_Avatar_2.png',
					'position'	=> '0',
					'color'		=> '#FFF'
				));

				$status		= 'success';
				$message 	= 'Enregistrer correctement effectuer.';
				
			}
			else
			{
				$status 	= 'error';
				$message 	= "Cette adresse email n'est pas disponible.";
			}
		} 
		else
		{
			$status 		= 'error';
			$message 		= 'Ce pseudonyme n\'est pas disponible.';
		}
	}
	else
	{
		$status 	= 'error';
		$message 	= 'Certain champs sont vides, Veuillez reessayer.';
	}
	die(json_encode(array('status' => $status, 'message' => $message)));
?>