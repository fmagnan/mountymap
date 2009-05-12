{include file='header.tpl'}

<form id="customize-map" method="post">
	<fieldset id="coordonnees">
		<legend>Origine de la vue</legend>
		<label for="position_x">X :</label><input type="text" name="position_x" value="{$position_x}" />
		<label for="position_y">Y :</label><input type="text" name="position_y" value="{$position_y}" /><br />
		<span>Profondeur :</span><br />
		<label for="start_n">entre</label> <input type="text" name="start_n" value="{$start_n}" />
		<label for="end_n">et</label> <input type="text" name="end_n" value="{$end_n}" /><br />
		<label for="range">Portée :</label><input type="text" name="range" value="{$range}" /><br />
	</fieldset>
	<fieldset>
		<legend>Enlever</legend>
		<input type="checkbox" name="exclude_trolls" {$exclude_trolls} /><label for="trolls">les trolls</label><br />
		<input type="checkbox" name="exclude_monsters" {$exclude_monsters} /><label for="monsters">les monstres</label><br />
		<input type="checkbox" name="exclude_treasures" {$exclude_treasures} /><label for="treasures">les trésors</label><br />
		<input type="checkbox" name="exclude_places" {$exclude_places} /><label for="places">les lieux</label><br />
		<input type="checkbox" name="exclude_mushrooms" {$exclude_mushrooms} /><label for="mushrooms">les champignons</label><br />
	</fieldset>
	<input type="submit" value="Valider" />
</form>

{if is_array($map) && count($map) > 0}
	<table id="map">
		{section name=numero loop=$map}
			{assign var=num_cell value=$smarty.section.numero.index}
			{assign var=cell value=$map[$num_cell]}
			
			{if $cell}
				{assign var=cell_class value='cell'}
			{else}
				{assign var=cell_class value=''}
			{/if}
			
			{if $cell.lieu}
				{assign var=place_type value='lieu'}
			{else}
				{assign var=place_type value=''}
			{/if}
			
			{if ($num_cell mod $row_size) eq 0}<tr>{/if}
			<td class="{$cell_class} {$place_type}">{if $cell}<div class="tooltip">{$cell.content}</div>{/if}{if $cell.troll_position }<img src="/images/ico_troll_16.png" />{/if}{if $cell.monstre }<img src="/images/ico_monstre_16.png" />{/if}{if $cell.tresor }<img src="/images/ico_tresor_16.png" />{/if}{if $cell.champignon }<img src="/images/ico_champignon_16.png" />{/if}</td>
			{if ($num_cell mod $row_size) eq ($row_size - 1)}</tr>{/if}
		{/section}
	</table>
	
	<script type="text/javascript" src="/js/qTip/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="/js/qTip/jquery.qtip.js"></script>
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