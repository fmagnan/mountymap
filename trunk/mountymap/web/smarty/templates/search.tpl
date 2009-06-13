{include file='header.tpl'}
{include file='menu.tpl'}
<script type="text/javascript">
	{literal}
	$(document).ready(function() { 
		$('#search_results').tablesorter({ 
			widgets: ['zebra'],
    	    stripingRowClass: ['odd','even'],
  			stripRowsOnStartUp: true
	    }); 
	});
	{/literal}
</script>
<div>Position de référence : {$position_x_reference} / {$position_y_reference} / {$position_n_reference}</div>
<div id="search_forms">
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
			<span>Niveau du troll</span><br/>
			<label for="troll_min_level">entre</label> <input type="text" name="troll_min_level" id="troll_min_level" value="{$troll_min_level}" />
			<label for="troll_max_level">et</label> <input type="text" name="troll_max_level" id="troll_max_level" value="{$troll_max_level}" /><br/>
			<label for="troll_race">Race :</label> {$troll_race_options}
			<input type="submit" name="search_by_troll" value="Valider" />
		</fieldset>
	</form>
	<fieldset>
		<legend>Recherche de monstres</legend>
		<form id="search_by_monster" method="post" action="search.php">
			<label for="monster">Monstre :</label>
			{$monster_options}
			<input type="submit" name="submit" value="Valider" />
		</form>
		<form id="search_by_monster_family" method="post" action="search.php">
			<label for="monster_family">Famille :</label>
			{$monster_family_options}
			<input type="submit" name="submit" value="Valider" />
		</form>
		<form id="search_by_monster_level" method="post" action="search.php">
			<span>Niveau du monstre</span><br/>
			<label for="monster_min_level">entre</label> <input type="text" name="monster_min_level" id="monster_min_level" value="{$monster_min_level}" />
			<label for="monster_max_level">et</label> <input type="text" name="monster_max_level" id="monster_max_level" value="{$monster_min_level}" />
			<input type="submit" name="submit" value="Valider" />
		</form>
	</fieldset>
	<form id="search_by_treasure" method="post" action="search.php">
		<fieldset>
			<legend>Recherche de trésors</legend>
			<label for="treasure">Trésor :</label>
			{$treasure_options}
			<input type="submit" name="submit" value="Valider" />
		</fieldset>
	</form>
	<form id="search_by_place" method="post" action="search.php">
		<fieldset>
			<legend>Recherche de lieux</legend>
			<label for="place">Lieu :</label>
			{$place_options}
			<input type="submit" name="submit" value="Valider" />
		</fieldset>
	</form>
</div>
{if isset($unique_instance)}
	<table id="search_results" class="tablesorter">
		<thead>
			<tr>
				{foreach from=$table_headers key=header item=function}
					<th>{$header}</th>
				{/foreach}
			</tr>
		</thead>
 		<tbody>
 			{foreach from=$table_headers key=header item=function}
				<td>{$unique_instance->$function()}</td>
			{/foreach}
 		</tbody>
	</table>
{/if}
{if isset($multiple_instances)}
	<table id="search_results" class="tablesorter">
		<thead>
			<tr>
				{foreach from=$table_headers key=header item=function}
					<th>{$header}</th>
				{/foreach}
			</tr>
		</thead>
		<tbody>
	 		{foreach from=$multiple_instances item=instance}
	 			{cycle values='odd,even' assign='class'} 
	 			<tr class="{$class}">
	 				{foreach from=$table_headers key=header item=function}
						<td>{$instance->$function()}</td>
					{/foreach}
				</tr>
	 		{/foreach}
	 	</tbody>
	</table>
{/if}
{include file='footer.tpl'}