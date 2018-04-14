<?php 
    
    include '../handler/string.php';

    if(!empty($_POST['content']))
    {
        if($site->get_config('maintenance') != 1)
        {
            $insert = $site->bdd->prepare('INSERT INTO messages (username, message, date_at, salon) VALUES (:username, :message, :date_at, :salon)');
            $insert->execute([
                'username'  => $_SESSION['username'],
                'message'   => $site->security($_POST['content']),
                'date_at'   => time(),
                'salon'     => $_SESSION['salon']
            ]);

            $get_info = $site->bdd->query('SELECT * FROM utilisateurs WHERE username = "'.$site->security($_SESSION['username']).'"');
            $get_info = $get_info->fetch();

            $status         = 'success';
            $message        = preg_replace('#(?:https?|ftp)://[\w%?=,:;&+\#@./-]+#', '<a target="_blank" href="$0">$0</a>', $site->security($_POST['content']));
            $date           = $site->date(time(), 'all');
            $salon          = $_SESSION['salon'];
            $pseudo         = $_SESSION['username'];
            $color          = $get_info['color'];

            die(json_encode(array('status' => $status, 'message' => $message, 'date' => $date, 'salon' => $salon, 'pseudo' => $pseudo, 'color' => $color)));
        }
        else
        {
            $status     = "Le site est en maintenance.";
        }
    }

    die(json_encode(array('status' => $status)));

?>