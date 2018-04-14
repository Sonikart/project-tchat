<?php
	
	include '../handler/string.php';

	if(isset($_SESSION['start_login']))
	{
		$verif = $site->bdd->query('SELECT * FROM connected WHERE username = "'.$site->security($_SESSION['username']).'"');
		if($verif->rowCount() != 0)
		{
			$update = $site->bdd->query('UPDATE connected SET date_at = '.time().' WHERE username = "'.$site->security($_SESSION['username']).'"');

			$status		= 'update';
		}
		else
		{
			$data = $site->bdd->query('SELECT * FROM utilisateurs WHERE username = "'.$site->security($_SESSION['username']).'"');
			$data = $data->fetch();
			$prepare = $site->bdd->prepare('INSERT INTO connected (username, date_at, rank) VALUES (:username, :date_at, :rank)');
			$prepare->execute(array(
				'username'	=> $site->security($_SESSION['username']),
				'date_at'	=> time(),
				'rank'		=> $data['rank']
			));

			$status		= 'added';
		}
	}

	die($status);

?>