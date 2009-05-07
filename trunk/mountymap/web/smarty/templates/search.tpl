{include file='header.tpl'}

<ul>
	<li><a href="map.php">afficher la carte</a></li>
</ul>

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
		<label for="id">numéro :</label><input type="text" name="id" value="{$id}" />
		<input type="submit" name="submit" value="Valider" />
	</fieldset>
</form>
<form name="search_by_monster" id="search_by_monster" method="post">
	<fieldset>
		<legend>Recherche par monstre</legend>
		<label for="monster">Monstre :</label>
		<select name="monster">
			{$monsters_option}
		</select>
		<input type="submit" name="submit" value="Valider" />
	</fieldset>
</form>
{if isset($unique_instance)}
	<ul>
		{$unique_instance->output()}
	</ul>
{/if}
{include file='footer.tpl'}