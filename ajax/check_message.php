<?php

	include '../handler/string.php';

	if(isset($_SESSION['arrivage']))
	{
		$array = array();

		$query = $site->bdd->query('SELECT * FROM messages WHERE date_at > '.$_SESSION['arrivage'].' AND username != "'.$_SESSION['username'].'" AND salon = "'.$_SESSION['salon'].'" ORDER BY id DESC');
		if($query->rowCount() != 0)
		{
			$fetch = $query->fetchAll();

			for ($i = 0; $i < count($fetch) ; $i++)
			{
				$data_user = $site->bdd->query('SELECT * FROM utilisateurs WHERE username = "'.$fetch[$i]['username'].'"');
				$data_user = $data_user->fetch();
				$message = preg_replace('#(?:https?|ftp)://[\w%?=,:;&+\#@./-]+#', '<a target="_blank" href="$0">$0</a>', $fetch[$i]['message']);
				array_push($array, array('id' => $fetch[$i]['id'], 'username' => $fetch[$i]['username'], 'message' => $message, 'date' => $site->date($fetch[$i]['date_at'], "all"), 'color' => $data_user['color']));
			}

			die(json_encode($array));
		}

	}

	die(json_encode(array('status' => 'error')));
