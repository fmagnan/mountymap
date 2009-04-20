{include file='header.tpl'}
<table>
	<thead>
		<tr>
			<th>Nom</th>
			<th>Position</th>
			<th>Dernière MAJ</th>
			<th>Actions</th>	
		</tr>
	</thead>
	<tbody>
	{section name=numero loop=$membres}
		{if $smarty.section.numero.index is even}
			<tr class="even">
		{else}
   			<tr class="odd">
		{/if}
			<td>{$membres[numero].nom} ({$membres[numero].id})</td>
			<td>{$membres[numero].position_x} / {$membres[numero].position_y} / {$membres[numero].position_n}</td>
			<td>{$membres[numero].mise_a_jour}</td>
			<td><a href="update_view.php?membre={$membres[numero].id}">mettre à jour la vue</a></td>
		</tr>
	{/section}
	</tbody>
</table>
{include file='footer.tpl'}