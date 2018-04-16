<?php
    include 'handler/string.php';

    $verification = $site->bdd->query('SELECT * FROM salon WHERE id_salon = "'.$_GET['salon'].'"');
    if($verification->rowCount() == 1)
    {
        $query = $site->bdd->query('SELECT * FROM salon WHERE id_salon = "'.$_GET['salon'].'"');
        $fetch = $query->fetch();
        $update = $site->bdd->query('UPDATE utilisateurs SET position = "'.$_GET['salon'].'" WHERE username = "'.$_SESSION['username'].'"');
        $_SESSION['salon']  = $_GET['salon'];
    }
    else
    {
        header('Location: ?salon=50855206');
    }

    if($_SESSION['start_login'] != 1){
        header('location: login.php');
        die;
    } else {
        $get_info = $site->bdd->query('SELECT * FROM utilisateurs WHERE username = "'.$site->security($_SESSION['username']).'"');
        $get_info = $get_info->fetch();
    }
    $_SESSION['arrivage'] = time();
    $query = $site->bdd->query('SELECT * FROM writing WHERE username = "'.$site->security($_SESSION['username']).'"');
    if($query->rowCount() != 0)
    {
        $site->bdd->query('UPDATE writing SET writing = 0 WHERE username = "'.$site->security($_SESSION['username']).'"');
    }
    else
    {
        $prepare = $site->bdd->prepare('INSERT INTO writing (username, writing, date_at) VALUES (:username, :writing, :date_at)');
        $prepare->execute(array(
            'username'      => $site->security($_SESSION['username']),
            'writing'       => 0,
            'date_at'       => time()
        ));
    }

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="ressources/stylesheets/application.css">
    <link rel="stylesheet" href="ressources/stylesheets/responsive.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <title><?= $site->get_config('name_app'); ?></title>
</head>
<body>
    <?php require 'controllers/devenir_vip.php'; ?>
    <div class="masque_color"></div>
    <div class="menu__logo"></div>
	<header class="header">
		Teufeurs.eu
	</header>
    <?php include 'files/navigation.php'; ?>
    <section class="view">
        <div id="alerte_notificate" class="alert__users"></div>
        <!-- <div class="alerte_maintenance">
            <i class="fas fa-info"></i> Le tchat est actuellement en travaux. <strong>Envoie de message désactiver.</strong>
        </div> -->
        <section class="list">
            <!-- <div class="title-list">
                Liste des connectés
            </div> -->
            <div id="listing">
            <?php
                $calcul = time() - 2;
                $query = $site->bdd->query('SELECT * FROM connected WHERE date_at > "'.$calcul.'"');
                if($query->rowCount() != 0)
                {
                    $fetch = $query->fetchAll();
                    for ($i = 0; $i < count($fetch); $i++)
                        // Recupere le nom de l'utilisateur pour recuperer son avatar
                    $name   = $fetch[$i]['username'];
                        // Je recupere l'avatar par rapport a la variable $name
                    $data_user = $site->bdd->query('SELECT avatar FROM utilisateurs WHERE username = "'.$name.'"');
                    $data_user = $data_user->fetch();
                    $avatar = $data_user['avatar'];
                    {
                        echo '<li class="list_user_connected"><img class="avatar_list" src="'.$avatar.'">'.$name.'<font style="margin-top:7px; float: right;color: #76FF03;">◕</font></li><i style="position: absolute; margin-left:45px; margin-top:-15px; font-size:12px;"></i>';
                    }
                }
            ?>  
            </div>
            <div class="devenir__vip">
                Devenir VIP            
            </div>
        </section>
        <section class="channel">
            <div class="information_profil">
                <div class="pics_profil">
                    <img class="pics_profil_avatar" src="<?= $get_info['avatar']; ?>" alt="">
                    <div class="information__connect">
                        <p><?= $get_info['username'] ?></p>
                        <p class="icon_profil">
                            <i class="icon_profil fas fa-cog"></i>
                            <i onclick="window.location.href='?deconnexion'" class="icon_profil fas fa-sign-out-alt"></i>
                            <i class="icon_profil fas fa-pen-square"></i>
                        </p>
                        <p>
                            <li><input name="webcam_activ" type="checkbox"> Activer la webcam</li>
                        </p>
                    </div>
                </div>
                <div class="list__salon__active">
                    <?php
                        $list_salon = $site->bdd->query('SELECT * FROM salon');
                        $list_salon = $list_salon->fetchAll();
                        foreach($list_salon as $data_list):
                    ?>
                    <li onclick="window.location.href='?salon=<?= $data_list['id_salon']; ?>'" class="name__salon <?php if($_GET['salon'] == $data_list['id_salon']){ echo 'active__salon'; } ?>">#<?= $data_list['name']; ?></li>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section id="scroll" class="message">
            <?php 
                $message = $site->bdd->query('SELECT * FROM messages WHERE salon = "'.$_GET['salon'].'"');
                $message = $message->fetchAll();

                for ($i=0; $i < count($message) ; $i++) {
                    $information = $site->bdd->query('SELECT * FROM utilisateurs WHERE username = "'.$message[$i]['username'].'"');
                    $information = $information->fetch();
                    $preg = preg_replace('#(?:https?|ftp)://[\w%?=,:;&+\#@./-]+#', '<a href="$0">$0</a>', $message[$i]['message']);
            ?>
            <li style="color: <?= $information['color']; ?>" id_msg="<?= $message[$i]['id']; ?>" class="<?php if($message[$i]['username'] == $_SESSION['username']){ echo 'right'; } else { echo 'left'; } ?>">
                <p><b><?php if($message[$i]['username'] != $_SESSION['username']) { echo $message[$i]['username']; } else { echo $message[$i]['username']; } ?> :</b> <?= $preg; ?></p>
                
            </li>
            <?php } ?>
        </section>
        <?php if($get_info['rank'] == 1): ?>
        <i id="execut_clear" class="clear fas fa-times"></i>
        <?php endif; ?>
    </section>
	<section class="send">
		<form id="loginForm">
            <input name="content" type="text" autocomplete="off" placeholder="Votre message..." autofocus="autofocus" onfocus="this.select()">
            <input name="salon" type="hidden" value="<?= $_GET['salon']; ?>">
            <button type="submit" name="submit"><i class="fa fa-paper-plane"></i></button>      
        </form>
    </section>
<audio id='myAudio' autoplay='autoplay'></audio>
</body>
<script src="ressources/javascript/jquery-3.3.1.js"></script>
<script src="ressources/javascript/app.js"></script>
</html>