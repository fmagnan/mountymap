{include file='header.tpl'}
<div class="disclaimer">
	<h3>Inscription à la Mountyvision</h3>
	Vous devez disposer d'une adresse mail pour vous inscrire au site. Un compte va être créé et un e-mail sera envoyé
	à l'adresse que vous allez indiquer. Cet e-mail contiendra un code d'activation que vous devez envoyer par MP <span class="surbrillance">
	in-game</span> au troll Herb' (6807). En envoyant ce MP, vous indiquez à Herb' que vous êtes bien le possesseur de l'adresse mail associée
	au compte que vous venez de créer. Il faudra ensuite patienter jusqu'à ce qu'un administrateur du site active votre compte manuellement.
	Vous recevrez un e-mail vous indiquant que votre compte a été activé et vous pourrez vous connecter au site.<br />
	Le mot de passe demandé est le mot de passe que vous choisissez pour ce site. Evitez de choisir un mot de passe trop simple et
	évitez de choisir le même mot de passe que le mot de passe de votre troll <span class="surbrillance">in-game</span>.
</div>
<form method="post" action="register.php" name="register" id="register">
	<fieldset>
		<legend>Inscription</legend>
		<label for="login">Identifiant (votre numéro de troll) : </label>
		<input id="login" type="text" name="login" value="{$login}" /><br/>
		<label for="password">Mot de passe : </label>
		<input id="password" type="password" name="password" value="{$password}" /><br/>
		<label for="confirmation">Confirmation : </label>
		<input id="confirmation" type="password" name="confirmation" value="{$confirmation}" /><br/>
		<label for="email">Adresse mail : </label>
		<input id="email" type="text" name="email" value="{$email}" />
		<div class="buttons">
			<input id="submit" type="submit" name="submit" value="Valider" />
		</div>
	</fieldset>
	{if isset($erreur_globale)}
		<div id="register-erreur" class="erreur">{$erreur_globale}</div>
	{/if}
</form>
{include file='footer.tpl'}