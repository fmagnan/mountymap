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
			<td>{$membres[numero]->getName()} ({$membres[numero]->getId()})</td>
			<td>{$membres[numero]->getFormattedPosition()}</td>
			<td>{$membres[numero]->getUpdate()}</td>
			<td><a href="update_view.php?membre={$membres[numero]->getId()}">mettre à jour la vue</a></td>
		</tr>
	{/section}
	</tbody>
</table>
{include file='footer.tpl'}