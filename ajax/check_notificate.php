<?php 
require '../handler/string.php';
if(isset($_SESSION['start_login']) && $_SESSION['start_login'] == 1){
    $recup_notification = $site->bdd->query('SELECT * FROM notificate');
    if($recup_notification->rowCount() == 1){
        $recup_notification = $recup_notification->fetch();

        $error  = $recup_notification['message'];
        $type   = 'success';
    } else {
        $error =  "Aucune notification.";
        $type   = 'danger';
    }
} else {
    $error  = "Vous devez etre connecter.";
    $type   = 'danger';
}
die(json_encode(array('error' => $error, 'type' => $type)));