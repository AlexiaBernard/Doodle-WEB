<?php
include "securite.php";
?>

<?=form_open('Utilisateur/sondage3',array())?>
	<fieldset>
		<legend>ETAPE 3 SUR 4</legend>
		<h1>Quelles est la plage horaire ?</h1>

		<?php
		$date = date('Y-m-d');
		if ($_SESSION['dateDebut']==$date){

			list($heure,$min) = explode(":",date('H:i'));
			$Heure = $heure.":".$min;
?>
			<label for="appt-time"> Veuillez choisir une heure de début du rendez-vous <input id="appt-time" type="time" name="heureDebut" min="<?=$Heure?>"> </label>

		<?php
		} else {
			?>
			<label for="appt-time"> Veuillez choisir une heure de début du rendez-vous <input id="appt-time" type="time" name="heureDebut"> </label>
		<?php
		}
		?>

		<label for="appt-time"> Veuillez choisir une heure de fin du rendez-vous <input id="appt-time" type="time" name="heureFin"> </label>

		<button type="submit" id="envoyer" name="envoyer">Continuer</button>
	</fieldset>
</form>