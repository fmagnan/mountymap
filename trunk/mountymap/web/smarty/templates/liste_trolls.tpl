<table>
	<thead>
		<tr>
			<th>Nom</th>
			<th>Position</th>
			<th>Date de la dernière mise à jour</th>
			<th>Actions</th>	
		</tr>
	</thead>
	<tbody>
	{section name=numero loop=$trolls}
		{if $smarty.section.numero.index is even}
			<tr class="even">
		{else}
   			<tr class="odd">
		{/if}
		<td>{$trolls[numero].nom} ({$trolls[numero].id})</td>
		<td>{$trolls[numero].position_x} / {$trolls[numero].position_y} / {$trolls[numero].position_n}</td>
		<td>{$trolls[numero].mise_a_jour}</td>
		<td><a href="updata_view.php?troll={$trolls[numero].id}">mettre à jour la vue</a></td>
		</tr>
	{/section}
	</tbody>
</table>