{include file='header.tpl'}
<div id="flash-player">
	<object type="application/x-shockwave-flash" data="flashs/player_flv.swf" width="640" height="480">
    	<param name="movie" value="flashs/player_flv.swf" />
    	<param name="FlashVars" value="flv=/flashs/mountyvision.flv&amp;autoplay=1&amp;loop=1&amp;buffer=9" />
	</object>
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