{include file='header.tpl'}
{include file='menu.tpl'}
<form id="search_by_id" method="post" action="search.php">
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
		<label for="id">numéro</label> <input type="text" name="id" id="id" value="{$id}" />
		<input type="submit" name="submit" value="Valider" />
	</fieldset>
</form>
<form id="search_by_troll" method="post" action="search.php">
	<fieldset>
		<legend>Recherche de trolls</legend>
		<label for="min_level">Niveau du troll entre</label> <input type="text" name="min_level" id="min_level" />
		<label for="max_level">et</label> <input type="text" name="max_level" id="max_level" />
		<input type="submit" name="submit" value="Valider" />
	</fieldset>
</form>
<form id="search_by_monster" method="post" action="search.php">
	<fieldset>
		<legend>Recherche de monstres</legend>
		<label for="monster">Monstre :</label>
		<select name="monster" id="monster">
			{$monster_options}
		</select>
		<input type="submit" name="submit" value="Valider" />
	</fieldset>
</form>
<form id="search_by_treasure" method="post" action="search.php">
	<fieldset>
		<legend>Recherche de trésors</legend>
		<label for="treasure">Trésor :</label>
		<select name="treasure" id="treasure">
			{$treasure_options}
		</select>
		<input type="submit" name="submit" value="Valider" />
	</fieldset>
</form>
<form id="search_by_place" method="post" action="search.php">
	<fieldset>
		<legend>Recherche de lieux</legend>
		<label for="place">Lieu :</label>
		<select name="place" id="place">
			{$place_options}
		</select>
		<input type="submit" name="submit" value="Valider" />
	</fieldset>
</form>
{if isset($unique_instance)}
	<table id="search_results" class="tablesorter">
		<thead>
			<tr>
				<th>Id</th><th>Nom</th><th>X</th><th>Y</th><th>N</th><th>Date</th><th>Actions</th>
			</tr>
		</thead>
 		<tbody>
 			{$unique_instance->getTableRow()}
 		</tbody>
	</table>
{/if}
{if isset($multiple_instances)}
	<table id="search_results" class="tablesorter">
		<thead>
			<tr>
				<th>Id</th><th>Nom</th><th>X</th><th>Y</th><th>N</th><th>Date</th><th>Actions</th>
			</tr>
		</thead>
		<tbody>
	 		{foreach from=$multiple_instances item=instance}
	 			{cycle values='odd,even' assign='class'} 
	 			<tr class="{$class}">
					<td>{$instance->getId()}</td>
					<td>{$instance->getFullName()}</td>
					<td>{$instance->getPositionX()}</td>
					<td>{$instance->getPositionY()}</td>
					<td>{$instance->getPositionN()}</td>
					<td>{$instance->getUpdate()}</td>
					<td>{$instance->getLinkToMap()}</td>
				</tr>
	 		{/foreach}
	 	</tbody>
	</table>
{/if}
{include file='footer.tpl'}