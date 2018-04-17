<?php 
require '../handler/string.php';
if(!empty($_POST['token'])){
    if(isset($_SESSION['start_login']) && $_SESSION['start_login'] === 1){
        $check_exist = $site->bdd->query('SELECT * FROM token_vip WHERE token = "'.$site->security($_POST['token']).'"');
        if($check_exist->rowCount() === 1){
            $check_exist = $check_exist->fetch();
            if($check_exist['validate'] != 1){
                $get_info = $site->bdd->query('SELECT * FROM utilisateurs WHERE username = "'.$_SESSION['username'].'"');
                $get_info = $get_info->fetch();
                if($get_info['rank'] > 1){
                    $update = $site->bdd->query('UPDATE token_vip SET validate = 1 WHERE token = "'.$site->security($_POST['token']).'"');
                    $update_rank = $site->bdd->query('UPDATE utilisateurs SET rank = 3 WHERE username = "'.$_SESSION['username'].'"');
                    $type   = 'success';
                    $error  = "Félicitation, vous êtes maintenant VIP.";
                } else {
                    $type   = 'warning';
                    $error  = "Votre rang administrateur ne vous permet pas d'utiliser une clef VIP.";
                }
            } else {
                $type   = 'danger';
                $error  = "Attention, ce token à déjà été activer.";
            }
        } else {
            $type   = 'danger';
            $error  = "Ce token n'est pas valide.";
        }
    } else {
        $type   = 'danger';
        $error  = "Vous devez être connecter pour valider votre clef.";
    }
} else {
    $type   = 'danger';
    $error  = "Votre champs est vide.";
}
die(json_encode(array('error' => $error, 'type' => $type)));