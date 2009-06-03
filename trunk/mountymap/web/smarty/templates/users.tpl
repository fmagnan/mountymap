{include file='header.tpl'}
{include file='menu.tpl'}
<table class="tablesorter">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Statut</th>
			<th>Code d'activation</th>
			<th colspan="4">Actions</th>
		</tr>
	</thead>
	<tbody>
	{section name=numero loop=$users}
		{assign var=current_user value=$users[numero]}
		{assign var=user_id value=$current_user->getId()}
		{if $smarty.section.numero.index is even}
			<tr class="even">
		{else}
   			<tr class="odd">
		{/if}
			<td>{$current_user->getName()} ({$current_user->getId()})</td>
			<td>
				{if $current_user->isActive()}
					<img title="actif" alt="actif" src="images/ok.png"></img>
				{else}
					<img title="désactivé" alt="désactivé" src="images/ko.png"></img>
				{/if}
			</td>
			<td>{$current_user->getActivationCode()}</td>
			<td>
				{if $current_user->isActive()}
					<a href="users.php?id={$user_id}&amp;action=deactivate">
						<img title="désactiver" alt="désactiver" src="images/ko.png"></img>
					</a>
				{else}
					<a href="users.php?id={$user_id}&amp;action=activate">
						<img title="activer" alt="activer" src="images/ok.png"></img>
					</a>
				{/if}
			</td>
			<td>
				<a href="users.php?id={$user_id}&amp;action=delete" onclick="return openConfirmationDialog('Etes-vous sûr de vouloir supprimer cet utilisateur ?');">
					<img title="supprimer" alt="supprimer" src="images/delete.png"></img>
				</a>
			</td>
		</tr>
	{/section}
	</tbody>
</table>
{include file='footer.tpl'}