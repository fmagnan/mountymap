{include file='header.tpl'}
{include file='menu.tpl'}
<form id="customize-map" method="post" action="map.php">
	<fieldset id="coordonnees">
		<legend>Origine de la vue</legend>
		<label for="position_x">X :</label><input type="text" name="position_x" id="position_x" value="{$position_x}" />
		<label for="position_y">Y :</label><input type="text" name="position_y" id="position_y" value="{$position_y}" /><br />
		<span>Profondeur :</span><br />
		<label for="start_n">entre</label> <input type="text" name="start_n" id="start_n" value="{$start_n}" />
		<label for="end_n">et</label> <input type="text" name="end_n" id="end_n" value="{$end_n}" /><br />
		<label for="range">Portée :</label><input type="text" name="range" id="range" value="{$range}" /><br />
	</fieldset>
	<fieldset>
		<legend>Enlever</legend>
		<input type="checkbox" name="exclude_trolls" id="exclude_trolls" {$exclude_trolls} />
		<label for="exclude_trolls">les trolls</label><br />
		<input type="checkbox" name="exclude_monsters" id="exclude_monsters" {$exclude_monsters} />
		<label for="exclude_monsters">les monstres</label><br />
		<input type="checkbox" name="exclude_treasures" id="exclude_treasures" {$exclude_treasures} />
		<label for="exclude_treasures">les trésors</label><br />
		<input type="checkbox" name="exclude_places" id="exclude_places" {$exclude_places} />
		<label for="exclude_places">les lieux</label><br />
		<input type="checkbox" name="exclude_mushrooms" id="exclude_mushrooms" {$exclude_mushrooms} />
		<label for="exclude_mushrooms">les champignons</label><br />
	</fieldset>
	<div>
		<input type="submit" value="Valider" />
	</div>
</form>

{if is_array($map) && count($map) > 0}
	<table id="map">
		{section name=numero loop=$map}
			{assign var=num_cell value=$smarty.section.numero.index}
			{assign var=cell value=$map[$num_cell]}
			
			{if $cell}
				{assign var=cell_class value='cell'}
				{assign var=extra_class value=$cell.class}
			{else}
				{assign var=cell_class value=''}
				{assign var=extra_class value=''}
			{/if}
			
			{if ($num_cell mod $row_size) eq 0}<tr>{/if}
			<td class="{$cell_class} {$extra_class}">{if $cell}<div class="tooltip">{$cell.content}</div>{/if}{if $cell.trolls }<img src="/images/ico_troll_16.png" alt="troll" />{/if}{if $cell.monsters }<img src="/images/ico_monstre_16.png" alt="monstre" />{/if}{if $cell.treasures }<img src="/images/ico_tresor_16.png" alt="tresor" />{/if}{if $cell.mushrooms }<img src="/images/ico_champignon_16.png" alt="champignon" />{/if}</td>
			{if ($num_cell mod $row_size) eq ($row_size - 1)}</tr>{/if}
		{/section}
	</table>
	
	<script type="text/javascript" src="/js/jquery/jquery.qtip.js"></script>
	<script type="text/javascript">
		{literal}
			$(document).ready(function() {
				$('td.cell').each(function() {
					$(this).qtip({ content: $(this).children('.tooltip'),
     					show: { solo: true },
     					hide: { delay: 400, fixed: true	},
     					style: { padding: '5px 15px', width: '500px' } });
				});
			});
		{/literal}
	</script>
{/if}
{include file='footer.tpl'}