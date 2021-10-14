<?php
include "securite.php";
?>

<div>
	<?php 
	$login = $_SESSION['login'];
	$minlogin=strtolower($login);
	$login=ucfirst($minlogin);
	echo "Bienvenue $login !";
	?>
	<br><br>
	<?=anchor("utilisateur/mesSondages","<button>Mes sondages</button>");?>
	<?=anchor("utilisateur/sondage1","<button>Créer un sondage</button>");?>
	<br>
	<?=anchor("utilisateur/desinscription","<button>Se désinscrire</button>");?>
</div>