<?php
include "securite.php";
?>

<?=form_open('Utilisateur/sondage4',array())?>
	<fieldset>
		<legend>ETAPE 4 SUR 4</legend>
		<h1>Dites à vos participants qui vous êtes</h1>

		<input value="<?=set_value('Nom')?>" id="nom" name="nom" placeholder="Votre nom"  required type="text">
	    <?=form_error('nom')?><br>

	    <input value="<?=set_value('email')?>" id="email" name="email" placeholder="Votre email"  required type="email">
	    <?=form_error('email')?><br>

		<button type="submit" id="envoyer" name="envoyer">Continuer</button>
	</fieldset>
</form>

<!--A Faire : nom et email soient prerempli grace à la BD-->