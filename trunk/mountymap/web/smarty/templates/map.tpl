{include file='header.tpl'}
{if is_array($map) && count($map) > 0}
	nombre de cases par ligne : {$row_size}
	<table id="map">
		{section name=numero loop=$map}
			{assign var=num_cell value=$smarty.section.numero.index}
			{assign var=trolls value=$map[$num_cell].info_trolls}
			{assign var=monstres value=$map[$num_cell].info_monstres}
			{assign var=tresors value=$map[$num_cell].info_tresors}
			{assign var=champignons value=$map[$num_cell].info_champignons}
			
			{if $trolls ne ''}<div id="cell_info_troll_{$num_cell}" class="cell-info">{$trolls}</div>{/if}
			{if $monstres ne ''}<div id="cell_info_monstre_{$num_cell}" class="cell-info">{$monstres}</div>{/if}
			{if $tresors ne ''}<div id="cell_info_tresor_{$num_cell}" class="cell-info">{$tresors}</div>{/if}
			{if $champignons ne ''}<div id="cell_info_champignon_{$num_cell}" class="cell-info">{$champignons}</div>{/if}
			
			{if ($num_cell mod $row_size) eq 0}<tr>{/if}
			<td>{if $trolls ne ''}<img src="/images/ico_troll_16.png" onmouseover="toggleInfo('cell_info_troll_{$num_cell}', false)" onmouseout="toggleInfo('cell_info_troll_{$num_cell}', true)" />{/if}{if $monstres ne ''}<img src="/images/ico_monstre_16.png" onmouseover="toggleInfo('cell_info_monstre_{$num_cell}', false)" onmouseout="toggleInfo('cell_info_monstre_{$num_cell}', true)" />{/if}{if $tresors ne ''}<img src="/images/ico_tresor_16.png" onmouseover="toggleInfo('cell_info_tresor_{$num_cell}', false)" onmouseout="toggleInfo('cell_info_tresor_{$num_cell}', true)" />{/if}{if $champignons ne ''}<img src="/images/ico_champignon_16.png" onmouseover="toggleInfo('cell_info_champignon_{$num_cell}', false)" onmouseout="toggleInfo('cell_info_champignon_{$num_cell}', true)" />{/if}</td>
			{if ($num_cell mod $row_size) eq ($row_size - 1)}</tr>{/if}
		{/section}
	</table>
{/if}
{include file='footer.tpl'}