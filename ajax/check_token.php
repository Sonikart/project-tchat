<?php 
require '../handler/string.php';
if(!empty($_POST['token'])){
    $type   = 'success';
    $error  = "Ont continue.";
} else {
    $type   = 'danger';
    $error  = "Votre champs est vide.";
}
die(json_encode(array('error' => $error, 'type' => $type)));