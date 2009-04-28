{include file='header.tpl'}
{if is_array($map) && count($map) > 0}
	nombre de cases par ligne : {$row_size}
	<table id="map">
		{section name=numero loop=$map}
			{if ($smarty.section.numero.index mod $row_size) eq 0}<tr>{/if}
			<td><img src="/images/ico_troll_16.png" /><img src="/images/ico_monstre_16.png" /><img src="/images/ico_tresor_16.png" /><img src="/images/ico_champignon_16.png" /></td>
			{if ($smarty.section.numero.index mod $row_size) eq ($row_size - 1)}</tr>{/if}
		{/section}
	</table>
{/if}
{include file='footer.tpl'}