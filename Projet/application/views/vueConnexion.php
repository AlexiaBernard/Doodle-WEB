<?=form_open('Utilisateur/connexion',array())?>
	<p>Connexion</p>

	<fieldset>
	    <label  for="login">Login</label>
		<input value="<?=set_value('login')?>" id="login" name="login" placeholder="Login"  required type="text">
	    <?=form_error('login')?><br>

	    <label for="mdp">Mot de passe </label>
		<input  name="mdp" id="mdp" placeholder="Mot de passe" required type="password">
	    <?=form_error('mdp')?><br>					
	      
		<button type="submit" id="envoyer" name="envoyer">Se connecter</button>
	</fieldset>
</form>