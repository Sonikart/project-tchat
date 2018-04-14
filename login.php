<?php include 'handler/string.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $site->get_config('name_app'); ?> | Chat</title>
	<link rel="stylesheet" href="ressources/stylesheets/hover.css">
	<link rel="stylesheet" href="ressources/stylesheets/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div id="alert">
		<font id="status"></font><br />
		<font id="message"></font>
	</div>
	<form id="loginForm">
		<div id="form-control">
			<div id="icon">
				<i class="fa fa-user"></i>
			</div>
			<input placeholder="Insérez votre pseudonyme." type="text" name="username">
		</div>
		<div id="form-control">
			<div id="icon">
				<i class="fa fa-lock"></i>
			</div>
			<input placeholder="Insérez votre mot de passe." type="password" name="password">
		</div>
		<button type="submit">Se connecter</button>
		<p>
			<a href="register.php">Vous n'avez pas encore de compte ?</a>
		</p>
	</form>
	<script src="ressources/javascript/jquery-3.2.1.min.js"></script>
	<script src="ressources/javascript/jquery-ui.js"></script>
	<script src="ressources/javascript/login.js"></script>
</body>
</html>