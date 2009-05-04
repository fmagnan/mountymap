{include file='header.tpl'}

<form name="search_by_id" id="search_by_id" method="post">
	<fieldset>
		<legend>Recherche par numéro</legend>
		<select name="type_entite">
			<option value="troll">Troll</option>
			<option value="guild">Guilde</option>
			<option value="monster">Monstre</option>
			<option value="treasure">Trésor</option>
			<option value="mushroom">Champignon</option>
			<option value="place">Lieu</option>
		</select>
		<label for="id">numéro :</label><input type="text" name="id" value="{$id}" /><br />
		<input type="submit" name="submit" value="Valider" />
	</fieldset>
</form>
{if isset($unique_instance)}
	{$unique_instance->output()}
{/if}
{include file='footer.tpl'}