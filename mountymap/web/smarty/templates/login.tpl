{include file='header.tpl'}
<div class="disclaimer">
	<h3>Bienvenue sur la Mountyvision</h3>
</div>
<form method="post" action="login.php">
	<fieldset>
		<legend>Saisissez vos identifiants</legend>
		<label for="login">Identifiant : </label>
		<input type="text" name="login" id="login" value="{$login}" /><br/>
		<label for="password">Mot de passe : </label>
		<input type="password" name="password" id="password" value="{$password}" />
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