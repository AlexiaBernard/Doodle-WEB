<?php
include "securite.php";
?>

<?=form_open('Utilisateur/sondage1',array())?>
	<fieldset>

		<legend>ETAPE 1 SUR 4</legend>
		<h1>Pour quelle occasion ? </h1>

		<input value="<?=set_value('titre')?>" id="titre" name="titre" placeholder="Saisissez le Titre"  required type="text">
	    <?=form_error('titre')?><br><br>

		<select id="" name="lieu">
			<option selected value="A définir">A définir</option>
			<option value="Conférence Téléphonique">Conférence Téléphonique</option>
			<option value="Téléphone">Téléphone</option>
			<option value="Skype">Skype</option>
			<option value="En ligne">En ligne</option>
			<option value="WebEx">WebEx</option>
			<option value="Google Hangouts">Google Hangouts</option>
			<option value="Zoom">Zoom</option>
		</select> facultatif<?=form_error('lieu')?><br><br>
	      
		<input value="<?=set_value('note')?>" id="note" name="note" placeholder="Ajouter une note "  type="text"> facultatif<?=form_error('note')?><br><br>

		<button type="submit" id="envoyer" name="envoyer">Continuer</button>

	</fieldset>
</form>