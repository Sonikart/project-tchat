<?php require_once('handler/string.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administration simple</title>
</head>
<?php 
	if(isset($_POST['submit'])){
		if(!empty($_POST['name_salon'])){
			$verif = $site->bdd->query('SELECT * FROM salon WHERE name = "'.$site->security($_POST['name_salon']).'"');
			if($verif->rowCount() != 1){
				$id_salon = "";
				for ($i=0; $i < 8; $i++) { 
					$id_salon .= rand(0,9);
				}
				$insert = $site->bdd->prepare('INSERT INTO salon (id_salon, name) VALUES (:id_salon, :name)');
				$insert->execute(array(
					'id_salon'	=> $id_salon,
					'name'		=> $_POST['name_salon']
				));
			}else{
				$error 	 = "Ce salon existe deja dans la base de données.";
			}
		}else{
			$error = "Veuillez remplir le champs 'salon'";
		}
	}
	
	$token = bin2hex(openssl_random_pseudo_bytes(16));
?>
<body>
	<form method="POST">
		<?php if(isset($error)){ echo $error; } ?>
		<input type="text" name="name_salon" placeholder="Nom du salon">
		<button name="submit" type="submit">Ajouter le salon</button>
	</form>
	<ul>
		<?php 
			$list = $site->bdd->query('SELECT * FROM salon');
			$list = $list->fetchAll();
			foreach($list as $salon){
		?>
		<li>Numeros du salon : <b><?= $salon['id_salon']; ?></b> | Nom du salon : <b><a target="_blank" href="http://localhost/tchat/index.php?salon=<?= $salon['id_salon'] ?>"><?= $salon['name']; ?></a></b></li>
		<?php } ?>
	</ul>
	<p>
		Token generé : <?= $token; ?>
	</p>
</body>
</html>