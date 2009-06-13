{include file='header.tpl'}
{include file='menu.tpl'}
<div class="left-column">
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
	<div id="navigator">
		<a href="{$up_link}"><img id="up" src="/images/arrow_up.png" /></a>
		<div id="left_and_right">
			<a href="{$left_link}"><img src="/images/arrow_left.png" /></a><a href="{$right_link}"><img id="right" src="/images/arrow_right.png" /></a>
		</div>
		<a href="{$down_link}"><img id="down" src="/images/arrow_down.png" /></a>
	</div>
</div>	
{if is_array($map) && count($map) > 0}
	<table id="map">
		{section name=numero loop=$map}
			{assign var=num_cell value=$smarty.section.numero.index}
			{assign var=cell value=$map[$num_cell]}
			
			{if $cell}
				{assign var=cell_class value=$cell.classes}
			{else}
				{assign var=cell_class value=''}
			{/if}
			
			{if ($num_cell mod $row_size) eq 0}<tr>{/if}
			<td class="{$cell_class}">{if $cell}<div class="tooltip">{$cell.content}</div>{/if}</td>
			{if ($num_cell mod $row_size) eq ($row_size - 1)}</tr>{/if}
		{/section}
	</table>
	
	<div class="map-cell-content">&nbsp;</div>
	
	<script type="text/javascript" src="/js/jquery/jquery.qtip.js"></script>
	<script type="text/javascript">
		{literal}
			$(document).ready(function() {
				$('td.cell').each(function() {
					$(this).qtip({
						content: $(this).children('.tooltip'),
						position: { type: 'static', container: $('div.map-cell-content') },
     					hide: { when: { event: 'unfocus' } },
     					style: { 'width': '500px', border: { width: 2 } }
					});
				});
			});
		{/literal}
	</script>
{/if}
{include file='footer.tpl'}