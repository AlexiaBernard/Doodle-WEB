<?=form_open('Utilisateur/inscription',array())?>

	<h2>Inscription</h2>

	<fieldset>
		<label  for="nom">Nom</label>
		<input value="<?=set_value('nom')?>" id="nom" name="nom" placeholder="Nom"  required type="text">
	    <?=form_error('nom')?><br>

		<label  for="prenom">Prénom</label>
		<input value="<?=set_value('prenom')?>" id="prenom" name="prenom" placeholder="Prénom"  required type="text">
	    <?=form_error('prenom')?><br>
	      
	    <label  for="login">Login</label>
		<input value="<?=set_value('login')?>" id="login" name="login" placeholder="Login"  required type="text">
	    <?=form_error('login')?><br>

		<label  for="email">Email</label>
		<input value="<?=set_value('email')?>" id="email" name="email" placeholder="Adresse Mail" required type="email">
	    <?=form_error('email')?><br>

		 <label for="mdp">Mot de passe </label>
		 <input  name="mdp" id="mdp" placeholder="Mot de passe" required type="password" >
		 <?=form_error('mdp')?><br>

		 <label for="mdp2">Confirmer le mot de passe </label>
		 <input  name="mdp2" id="mdp2" placeholder="Mot de passe" required type="password" >
		 <?=form_error('mdp2')?><br>							
	      
		<button type="submit" id="envoyer" name="envoyer">S'inscrire</button>
	</fieldset>
</form>