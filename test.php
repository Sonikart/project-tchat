<?php

require 'handler/string.php';

$select = $site->bdd->query('SELECT * FROM messages');
$select = $select->fetchAll();
foreach($select as $data){
    $texte = preg_replace('#(?:https?|ftp)://[\w%?=,:;&+\#@./-]+#', '<a href="$0">$0</a>', $data['message']);
?>

    <p><?= $texte; ?></p>

<?php } ?>