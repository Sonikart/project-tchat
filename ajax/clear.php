<?php 
require '../handler/string.php';
if(isset($_SESSION['start_login']) && $_SESSION['start_login'] == 1){
    $get_info = $site->bdd->query('SELECT * FROM utilisateurs WHERE username = "'.$site->security($_SESSION['username']).'"');
    $get_info = $get_info->fetch();
    if($get_info['rank'] == 1){
        $delete = $site->bdd->query('TRUNCATE TABLE messages');
        $error  = "Le tchat a ete nettoyer.";
    } else {
        $error = 'Action impossible pour un utilisateurs.';
    }
} else {
    $error  = "Vous devez etre connecter";
}
die(json_encode(array('error' => $error)));