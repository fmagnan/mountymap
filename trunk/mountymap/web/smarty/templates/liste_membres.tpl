{include file='header.tpl'}
{include file='menu.tpl'}
<table class="tablesorter">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Position</th>
			<th>Dernière mise à jour de sa vue</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	{section name=numero loop=$membres}
		{assign var=current_member value=$membres[numero]}
		{if $smarty.section.numero.index is even}
			<tr class="even">
		{else}
   			<tr class="odd">
		{/if}
			<td>{$current_member->getName()} ({$current_member->getId()})</td>
			<td>{$current_member->getFormattedPosition()}</td>
			<td>{$current_member->getUpdate()}</td>
			<td><a href="update_view.php?id={$current_member->getId()}">mettre la vue à jour</a></td>
		</tr>
	{/section}
	</tbody>
</table>
<div><a href="update_view.php">Mettre à jour la vue la plus ancienne</a> [Attention, 1 seul appel au script public de la vue n'est autorisé pour chacun des membres du table ci-dessus]</div>
{include file='footer.tpl'}