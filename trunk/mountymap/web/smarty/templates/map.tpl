{include file='header.tpl'}

<form id="customize-map">
	<fieldset>
		<legend>Paramétrer la vue</legend>
		<div>Origine de la vue</div>
		<label for="start_x">X :</label><input type="text" name="start_x" value="{$start_x}" /><br />
		<label for="start_y">Y :</label><input type="text" name="start_y" value="{$start_y}" /><br />
		<label for="start_n">N :</label><input type="text" name="start_n" value="{$start_n}" />
		<div>Portée</div>
		<label for="range">Portée :</label><input type="text" name="range" value="{$range}" />
		<input type="submit" value="Valider" />
	</fieldset>
</form>

{if is_array($map) && count($map) > 0}
	<table id="map">
		{section name=numero loop=$map}
			{assign var=num_cell value=$smarty.section.numero.index}
			{assign var=trolls value=$map[$num_cell].info_trolls}
			{assign var=monstres value=$map[$num_cell].info_monstres}
			{assign var=tresors value=$map[$num_cell].info_tresors}
			{assign var=champignons value=$map[$num_cell].info_champignons}
			{assign var=lieux value=$map[$num_cell].info_lieux}
			{if $trolls || $monstres || $tresors || $champignons || $lieux}
				{assign var=is_content value=true}
				{assign var=cell_class value='cell'}
			{else} 
				{assign var=is_content value=false}
				{assign var=cell_class value=''}
			{/if}
			
			{if $lieux}
				{assign var=type_lieu value='lieu'}
			{else}
				{assign var=type_lieu value=''}
			{/if}
			
			{if ($num_cell mod $row_size) eq 0}<tr>{/if}
			<td class="{$cell_class} {$type_lieu}">{if $is_content}<div class="tooltip">{$trolls}{$monstres}{$tresors}{$champignons}{$lieux}</div>{/if}{if $trolls }<img src="/images/ico_troll_16.png" />{/if}{if $monstres }<img src="/images/ico_monstre_16.png" />{/if}{if $tresors }<img src="/images/ico_tresor_16.png" />{/if}{if $champignons }<img src="/images/ico_champignon_16.png" />{/if}</td>
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
     					hide: { delay: 200, fixed: true	},
     					style: { padding: '5px 15px', width: '500px' } });
				});
			});
		{/literal}
	</script>
{/if}
{include file='footer.tpl'}