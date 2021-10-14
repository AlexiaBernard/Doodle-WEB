<?php
include "securite.php";
?>

<div>
	Création du sondage terminé, inviter les participants !
	<br><br>
	Toute personne disposant du lien pourra voter, pas de compte requis.
	<br><br>
	<?php
	echo anchor("utilisateur/cle/$cle","https://dwarves.iut-fbleau.fr/~cunsolo/WIM/Projet/index.php/utilisateur/cle/$cle",array());
	?>
	<br><br>
	
	<h2>Récapitulatif :</h2>
	<?php
	$mintitre=strtolower($titre);
	$titre=ucfirst($mintitre);
	?>
	<ul>Titre : <?= $titre?></ul>
	<ul>Lieu : <?=$lieu?></ul>
	<?php		  
	if ($note!="")
		echo'<ul>Note : '.$note.'</ul>';
	if ($dateDebut===$dateFin)
		echo '<ul> Date : '.$dateDebut.'</ul>';
	else{
		$dateDebutDiv = explode('-',$dateDebut);
        $dateFinDiv = explode('-',$dateFin);

		echo '<ul>Date de début : '.$dateDebutDiv[2].'/'.$dateDebutDiv[1].'/'.$dateDebutDiv[0].'</ul>';
		echo '<ul>Date de fin : '.$dateFinDiv[2].'/'.$dateFinDiv[1].'/'.$dateFinDiv[0].'</ul>';	
	}  	
	if ($heureFin===$heureDebut)
		echo '<ul>Horaire : '.$heureDebut.'</ul>';
	else echo '<ul>Plage horaire : '.$heureDebut.' à '.$heureFin.'</ul>';

	?>
	<ul>Votre nom : <?=$nom?></ul>
	<ul>Votre email : <?=$email?></ul>
</div>