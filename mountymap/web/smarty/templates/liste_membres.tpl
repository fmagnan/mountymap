{include file='header.tpl'}
{include file='menu.tpl'}
<table class="tablesorter">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Position</th>
			<th>Dernière mise à jour de sa vue</th>
			{if $is_admin}
				<th>Actions</th>
			{/if}
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
			{if $is_admin}
				<td><a href="update_view.php?id={$current_member->getId()}">mettre la vue à jour</a></td>
			{/if}
		</tr>
	{/section}
	</tbody>
</table>
{include file='footer.tpl'}