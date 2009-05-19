{include file='header.tpl'}
<div class="disclaimer">
	<h3>Vous avez oublié votre mot de passe</h3>
	Veuillez saisir dans le formulaire qui suit le numéro de votre troll et l'adresse email que vous avez renseignée lors de votre inscription.
	Un nouveau mot de passe va être généré et envoyé dans votre boîte aux lettres.
</div>
<form method="post" action="forgot_password.php">
	<fieldset>
		<legend>Oubli de mot de passe</legend>
		<label for="login">Identifiant (votre numéro Troll) : </label>
		<input id="login" type="text" name="login" value="{$login}" /><br/>
		<label for="email">Adresse mail : </label>
		<input id="email" type="text" name="email" value="{$email}" />
		<div class="buttons">
			<input id="submit" type="submit" name="submit" value="Valider" />
		</div>
	</fieldset>
	{if isset($erreur_globale)}
		<div class="erreur">{$erreur_globale}</div>
	{/if}
</form>
{include file='footer.tpl'}