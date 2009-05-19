{include file='header.tpl'}
<div class="disclaimer" id="login">
	<h3>Bienvenue sur la Mountyvision</h3>
</div>
<form method="post" action="login.php">
	<fieldset>
		<legend>Saisissez vos identifiants</legend>
		<label for="login">Identifiant : </label>
		<input id="login" type="text" name="login" value="{$login}" /><br/>
		<label for="password">Mot de passe : </label>
		<input id="pass" type="password" name="password" value="{$password}" />
		<div class="buttons">
			<input id="submit" type="submit" name="submit" value="Valider" />
		</div>
	</fieldset>
	{if isset($message)}
		<h3>{$message}</h3>
	{/if}
	<div class="liens">
		<a href="register.php">S'inscrire</a> | <a href="forgot_password.php">Récupérer son mot de passe</a>
	</div>
</form>
{include file='footer.tpl'}