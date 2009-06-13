{include file='header.tpl'}
{include file='menu.tpl'}
<form id="preferences" method="post" action="preferences.php">
	<fieldset>
		<legend>Préférences</legend>
		<label for="diplomacy">Diplomatie :</label>{$diplomacy_options}<br/>
		<span>Position de référence :</span>
		<label>X = </label><input type="text" value="{$position_x}" name="position_x" id="position_x" />
		<label>Y = </label><input type="text" value="{$position_y}" name="position_y" id="position_y" />
		<label>N = </label><input type="text" value="{$position_n}" name="position_n" id="position_n" />
	</fieldset>
	<div>
		<input type="submit" name="submit" value="Valider" />
	</div>
</form>
{include file='user_info.tpl'}
{include file='footer.tpl'}