<?php
include "securite.php";
?>

<?=form_open('Utilisateur/sondage2',array())?>
	<fieldset>
		<legend>ETAPE 2 SUR 4</legend>
		<h1>Quelles sont les disponibilités ?</h1>

		<?php
		list($jour,$mois,$annee) = explode("/",date('d/m/Y'));
		$date = $annee."-".$mois."-".$jour;
		?>

		<label for="dateDebut">Date de début </label>
		<input value="<?=set_value('dateDebut')?>" id="dateDebut" name="dateDebut" placeholder="Date de Début"  required type="date" min="<?=$date?>" >
	    <?=form_error('dateDebut')?><br>

	    <label for="dateFin">Date de fin </label>
	    <input value="<?=set_value('dateFin')?>" id="dateFin" name="dateFin" placeholder="Date de Fin"  required type="date" min="<?=$date?>">
	    <?=form_error('dateFin')?><br>

		<button type="submit" id="envoyer" name="envoyer">Continuer</button>
	</fieldset>
</form>