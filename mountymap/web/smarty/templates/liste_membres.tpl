{include file='header.tpl'}
<ul>
	<li><a href="update_public_guild.php">mettre à jour les infos publiques sur les guildes</a></li>
	<li><a href="update_public_trolls.php">mettre à jour les infos publiques sur les trolls</a></li>
	<li><a href="map.php">afficher la carte</a></li>
</ul>
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
		{assign var=current_member value=$membres[numero]}
		{if $smarty.section.numero.index is even}
			<tr class="even">
		{else}
   			<tr class="odd">
		{/if}
			<td>{$current_member->getName()} ({$current_member->getId()})</td>
			<td>{$current_member->getFormattedPosition()}</td>
			<td>{$current_member->getUpdate()}</td>
			<td><a href="update_view.php?membre={$current_member->getId()}">mettre à jour la vue</a></td>
		</tr>
	{/section}
	</tbody>
</table>
{include file='footer.tpl'}