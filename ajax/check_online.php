<?php

	include '../handler/string.php';

	$calcul = time() - 2;

	$array = array();

    $query = $site->bdd->query('SELECT * FROM connected WHERE date_at > "'.$calcul.'" ORDER BY rank DESC');

    if($query->rowCount() != 0)
    {
        $fetch = $query->fetchAll();
        for ($i = 0; $i < count($fetch); $i++)
        {
        	$verif_writing = $site->bdd->query('SELECT * FROM writing WHERE username = "'.$site->security($fetch[$i]['username']).'"');
            $writing = $verif_writing->fetch();
            
            $data_user = $site->bdd->query('SELECT * FROM utilisateurs WHERE username = "'.$fetch[$i]['username'].'"');
            $data_user = $data_user->fetch();

            $data_salon = $site->bdd->query('SELECT * FROM salon WHERE id_salon = "'.$data_user['position'].'"');
            $data_salon = $data_salon->fetch();

            $rank = $site->bdd->query('SELECT * FROM rank WHERE id = "'.$data_user['rank'].'"');
            $rank = $rank->fetch();

           	array_push($array, array('username' => $fetch[$i]['username'], 'writing' => $writing['messaging'], 'avatar' => $data_user['avatar'], 'position' => $data_salon['name'], 'icon_rank' => $rank['icon']));
        }
    }

    die(json_encode($array));

?>