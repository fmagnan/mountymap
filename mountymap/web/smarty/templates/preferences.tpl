{include file='header.tpl'}
{include file='menu.tpl'}
<form id="preferences" method="post" action="preferences.php">
	<fieldset>
		<legend>Choisir votre diplomatie</legend>
		<label for="diplomacy">Diplomatie :</label>{$diplomacy_options}
	</fieldset>
	<div>
		<input type="submit" name="submit" value="Valider" />
	</div>
</form>
{include file='user_info.tpl'}
{include file='footer.tpl'}